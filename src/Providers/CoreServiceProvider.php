<?php

namespace EldoMagan\BagistoArcade\Providers;

use BladeUI\Icons\Factory;
use EldoMagan\BagistoArcade\Actions\CreateCustomer;
use EldoMagan\BagistoArcade\ArcadeManager;
use EldoMagan\BagistoArcade\Components;
use EldoMagan\BagistoArcade\Facades\Arcade;
use EldoMagan\BagistoArcade\Facades\ThemeEditor;
use EldoMagan\BagistoArcade\Middlewares\StorefrontTheme;
use EldoMagan\BagistoArcade\Sections;
use EldoMagan\BagistoArcade\Sections\SectionDataCollector;
use EldoMagan\BagistoArcade\Sections\SectionRepository;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Core\Tree;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Shop\Http\Middleware\Currency;
use Webkul\Shop\Http\Middleware\Locale;
use Webkul\Theme\ViewRenderEventManager;

class CoreServiceProvider extends ServiceProvider
{
    protected static $bladeComponents = [
        'address-form',
        'account-layout' => Components\AccountLayout::class,
        'account-menu' => Components\AccountMenu::class,
        'currency-switcher' => Components\CurrencySwitcher::class,
        'products-grid' => Components\ProductsGrid::class,
        'product' => Components\Product::class,
        'product-gallery' => Components\ProductGallery::class,
        'product-stock-status' => Components\ProductStockStatus::class,
        'product-buy-buttons' => Components\ProductBuyButtons::class,
        'product-attributes' => Components\ProductAttributes::class,
        'product-filters' => Components\ProductFilters::class,
        'cart-summary' => Components\CartSummary::class,
        'checkout-address-form' => Components\CheckoutAddressForm::class,
    ];

    protected static $livewireComponents = [
        'mini-cart' => Components\MiniCart::class,
        'login-customer' => Components\LoginCustomer::class,
        'register-customer' => Components\RegisterCustomer::class,
        'cart-apply-coupon' => Components\CartApplyCoupon::class,
        'orders-table' => Components\Tables\OrdersTable::class,
    ];

    protected $sections = [
        Sections\Hero::class,
        Sections\Header::class,
        Sections\AnnouncementBar::class,
        Sections\FeaturedCategory::class,
        Sections\FeaturedProducts::class,
        Sections\CustomerLogin::class,
        Sections\CustomerRegistration::class,
        Sections\ProductDetails::class,
        Sections\CategoryPage::class,
        Sections\Cart::class,
        Sections\CheckoutPage::class,
        Sections\CheckoutSuccess::class,
        Sections\CustomerProfile::class,
        Sections\CustomerEditProfile::class,
        Sections\CustomerAddresses::class,
        Sections\CustomerCreateAddress::class,
        Sections\CustomerEditAddress::class,
        Sections\CustomerOrders::class,
        Sections\CustomerOrderDetails::class,
        Sections\CustomerReviews::class,
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

            if (null !== $product && $product->url_key) {
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

        $this->registerBladeComponents();
        $this->registerLivewireComponents();
        $this->registerMiddlewaresForLivewire();
        $this->registerViewRenderEvents();
        $this->registerViewComposers();

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

        $this->callAfterResolving(Factory::class, function (Factory $factory) {
            $factory->add('arcade-icons', [
                'path' => __DIR__. '/../../resources/svg',
                'prefix' => 'ic',
            ]);
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
                if (is_numeric($name)) {
                    $blade->component('shop::components.' . $component, $component);
                } else {
                    $blade->component($component, $name);
                }
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

    protected function registerViewRenderEvents()
    {
        Event::listen('bagisto.shop.checkout.payment.paypal_smart_button', function (ViewRenderEventManager $event) {
            $event->addTemplate('paypal::checkout.onepage.payment');
        });
    }

    protected function registerViewComposers()
    {
        view()->composer('shop::partials.account.side-nav', function ($view) {
            $tree = Tree::create();

            foreach (config('menu.customer') as $item) {
                $tree->add($item, 'menu');
            }

            $tree->items = core()->sortItems($tree->items);

            $view->with('menu', $tree);
        });
    }
}
