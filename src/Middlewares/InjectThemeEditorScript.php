<?php

namespace EldoMagan\BagistoArcade\Middlewares;

use Closure;
use EldoMagan\BagistoArcade\Facades\Sections;
use EldoMagan\BagistoArcade\ThemeDataCollector;
use EldoMagan\BagistoArcade\ThemeEditor;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Product\Repositories\ProductRepository;

class InjectThemeEditorScript
{
    protected $themeEditor;

    protected $themeDataCollector;

    protected $categoryRepository;

    protected $productRepository;

    public function __construct(ThemeEditor $themeEditor, ThemeDataCollector $themeDataCollector, CategoryRepository $categoryRepository, ProductRepository $productRepository)
    {
        $this->themeEditor = $themeEditor;
        $this->themeDataCollector = $themeDataCollector;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    public function handle($request, Closure $next)
    {
        if (! $request->inDesignMode() && ! $request->inPreviewMode()) {
            return $next($request);
        }

        $response = $next($request);

        if ($response instanceof StreamedResponse || $response instanceof BinaryFileResponse || Route::currentRouteName() === 'imagecache') {
            return $response;
        }

        if ($this->themeEditor->inDesignMode()) {
            $renderedSections = collect($this->themeEditor->renderedSections());

            $themeData = [
                'url' => $request->fullUrl(),
                'template' => $this->themeEditor->getTemplateForRoute(
                    $this->fixCategoryOrProductRoute(Route::currentRouteName())
                ),

                'hasStaticContent' => $renderedSections->filter(function ($item) {
                    return in_array($item['group'], ['beforeContent', 'afterContent']);
                })->count() > 0,

                'beforeContentSectionsOrder' => $renderedSections
                    ->where('group', 'beforeTemplate')
                    ->merge($renderedSections->where('beforeContent'))
                    ->pluck('id'),

                'afterContentSectionsOrder' => $renderedSections
                    ->where('group', 'afterContent')
                    ->merge($renderedSections->where('group', 'afterTemplate'))
                    ->pluck('id'),

                'sectionsOrder' => $renderedSections->where('group', 'content')->pluck('id'),

                'settings' => $this->themeDataCollector->getThemeSettings(),
                'sections' => $this->themeDataCollector
                    ->getSectionsData()
                    ->pluck('section')
                    ->groupBy(function ($section) {
                        return $section->id;
                    })
                    ->map(function ($items) {
                        return $items[0];
                    }),
            ];

            $theme = themes()->find($this->themeEditor->editorTheme());

            $editorContent = view('arcade::admin.partials.theme-editor-injected-script', [
                'theme' => $this->themeEditor->editorTheme(),
                'themeData' => $themeData,
                'sections' => Sections::all(),
                'templates' => array_values($this->themeEditor->getTemplates()),
                'themeSettings' => $theme->settings,
                'initialState' => $this->themeDataCollector->getEditorInitialStore(),
            ]);
        } else {
            $editorContent = "<script type='text/javascript'>
    if (window.Livewire) {
        window.Livewire.addHeaders({
            'X-ARCADE-PREVIEW-THEME': '{$this->themeEditor->editorTheme()}'
        });
    }
</script>";
        }

        $content = str_replace('</body>', sprintf("%s</body>", $editorContent), $response->getContent());
        $response->setContent($content);

        return $response;
    }

    protected function fixCategoryOrProductRoute($routeName)
    {
        if ('shop.productOrCategory.index' === $routeName) {
            $slug = request()->route('fallbackPlaceholder');

            if (null !== $this->categoryRepository->findByPath($slug)) {
                return 'shop.categories.index';
            } elseif (null !== $this->productRepository->findBySlug($slug)) {
                return 'shop.products.index';
            } else {
                return 'shop.home.index';
            }
        }

        return $routeName;
    }
}
