<?php

namespace EldoMagan\BagistoArcade\Providers;

use EldoMagan\BagistoArcade\Actions\CreateCustomer;
use EldoMagan\BagistoArcade\ArcadeManager;
use EldoMagan\BagistoArcade\Components;
use EldoMagan\BagistoArcade\Facades\Arcade;
use EldoMagan\BagistoArcade\Facades\ThemeEditor;
use EldoMagan\BagistoArcade\Middlewares\StorefrontTheme;
use EldoMagan\BagistoArcade\Sections;
use EldoMagan\BagistoArcade\Sections\SectionDataCollector;
use EldoMagan\BagistoArcade\Sections\SectionRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Shop\Http\Middleware\Currency;
use Webkul\Shop\Http\Middleware\Locale;

class CoreServiceProvider extends ServiceProvider
{
    protected static $bladeComponents = [
        'account-menu' => Components\AccountMenu::class,
        'currency-switcher' => Components\CurrencySwitcher::class,
        'products-grid' => Components\ProductsGrid::class,
        'product' => Components\Product::class,
    ];

    protected static $livewireComponents = [
        'mini-cart' => Components\MiniCart::class,
        'login-customer' => Components\LoginCustomer::class,
        'register-customer' => Components\RegisterCustomer::class,
    ];

    protected $sections = [
        Sections\Hero::class,
        Sections\Header::class,
        Sections\AnnouncementBar::class,
        Sections\FeaturedCategory::class,
        Sections\FeaturedProducts::class,
        Sections\CustomerLogin::class,
        Sections\CustomerRegistration::class,
    ];

    protected function templates()
    {
        $templates = [
            'shop.home.index' => [
                'icon' => 'home-outline',
                'label' => 'Home page',
                'template' => 'index',
                'url' => url()->to('/'),
            ],
        ];

        // add category template if any category exists
        {
            $category = app(CategoryRepository::class)
                ->where('parent_id', core()->getCurrentChannel()->root_category_id)
                ->first();

            if (null !== $category) {
                $templates['shop.categories.index'] = [
                    'icon' => 'tag-multiple-outline',
                    'label' => 'Category Page',
                    'template' => 'category',
                    'url' => url()->to($category->translations->first()->url_path),
                ];
            }
        }

        // add product template if any product exists
        {
            $product = app(ProductRepository::class)->first();
            if (null !== $product) {
                $templates['shop.products.index'] = [
                    'icon' => 'tag-outline',
                    'label' => 'Product Page',
                    'template' => 'product',
                    'url' => route(
                        'shop.productOrCategory.index',
                        $product->url_key // @phpstan-ignore-line
                    ),
                ];
            }
        }

        $templates['shop.checkout.cart.index'] = [
            'icon' => 'cart-outline',
            'label' => 'Cart Page',
            'template' => 'cart',
            'url' => route('shop.checkout.cart.index'),
        ];

        $templates['shop.checkout.onepage.index'] = [
            'icon' => 'cart-outline',
            'label' => 'Checkout Page',
            'template' => 'checkout',
            'url' => route('shop.checkout.onepage.index'),
        ];

        $templates['shop.checkout.success'] = [
            'icon' => 'cart-check',
            'label' => 'Checkout success Page',
            'template' => 'checkout-success',
            'url' => route('shop.checkout.success'),
        ];

        return $templates;
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/shop.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'arcade');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/theme', 'shop');

        $this->registerBladeComponents();
        $this->registerLivewireComponents();
        $this->registerMiddlewaresForLivewire();

        Arcade::createCustomerUsing(CreateCustomer::class);
        Arcade::registerSections($this->sections, 'arcade');

        $this->app->booted(function () {
            Route::getRoutes()->refreshNameLookups();

            foreach ($this->templates() as $route => $template) {
                ThemeEditor::registerTemplateForRoute($route, $template);
            }
        });

        if ($this->app->runningInConsole()) {
            $this->publishViews();
        }
    }

    public function register()
    {
        $this->registerConfigs();

        $this->app->singleton(SectionRepository::class, function ($app) {
            return new SectionRepository();
        });

        $this->app->singleton(SectionDataCollector::class, function ($app) {
            return new SectionDataCollector($app['files']);
        });

        $this->app->singleton(ArcadeManager::class, function ($app) {
            return new ArcadeManager($app[SectionDataCollector::class]);
        });
    }

    protected function publishViews()
    {
        $this->publishes([
            __DIR__ . '/../../resources/views/theme' => resource_path('themes/arcade/views'),
        ], 'arcade-views');
    }

    protected function registerConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/arcade.php', 'arcade');
    }

    protected function registerBladeComponents()
    {
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            foreach (self::$bladeComponents as $name => $component) {
                $blade->component($component, $name);
            }
        });
    }

    protected function registerLivewireComponents()
    {
        foreach (self::$livewireComponents as $name => $component) {
            Livewire::component($name, $component);
        }
    }

    protected function registerMiddlewaresForLivewire()
    {
        Livewire::addPersistentMiddleware([
            Locale::class,
            StorefrontTheme::class,
            Currency::class,
        ]);
    }
}
