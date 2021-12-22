<?php

namespace EldoMagan\BagistoArcade\Middlewares;

use Closure;
use EldoMagan\BagistoArcade\Facades\Arcade;
use EldoMagan\BagistoArcade\Facades\Sections;
use EldoMagan\BagistoArcade\Sections\SectionDataCollector;
use EldoMagan\BagistoArcade\ThemeEditor;
use Illuminate\Support\Facades\Route;

class InjectThemeEditorScript
{
    protected $themeEditor;

    protected $sectionDataCollector;

    public function __construct(ThemeEditor $themeEditor, SectionDataCollector $sectionDataCollector)
    {
        $this->themeEditor = $themeEditor;
        $this->sectionDataCollector = $sectionDataCollector;
    }

    public function handle($request, Closure $next)
    {
        if (! $request->inDesignMode() && ! $request->inPreviewMode()) {
            return $next($request);
        }

        $response = $next($request);

        if ($this->themeEditor->active()) {
            $renderedSections = collect($this->themeEditor->renderedSections());

            $themeData = [
                'url' => $request->fullUrl(),
                'template' => $this->themeEditor->getTemplateForRoute(Route::currentRouteName()),

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

                'sections' => Arcade::sectionDataCollector()
                    ->getSectionsData()
                    ->pluck('section')
                    ->groupBy(function ($section) {
                        return $section->id;
                    })
                    ->map(function ($items) {
                        return $items[0];
                    }),
            ];

            $editorContent = view('arcade::admin.partials.theme-editor-injected-script', [
                'theme' => $this->themeEditor->editorTheme(),
                'themeData' => $themeData,
                'sections' => Sections::all(),
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
}
