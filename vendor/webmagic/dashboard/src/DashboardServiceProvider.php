<?php

namespace Webmagic\Dashboard;

use GrahamCampbell\Markdown\MarkdownServiceProvider;
use Illuminate\Config\Repository;
use PackageVersions\Versions;
use View;
use Webmagic\Dashboard\Console\Commands\ComponentsMetaMethodsGenerate;
use Webmagic\Dashboard\Console\Commands\GenerateComponent;
use Webmagic\Dashboard\Console\Commands\UpdateAssetData;
use Webmagic\Dashboard\Elements\Breadcrumbs\Breadcrumbs;
use Webmagic\Dashboard\Elements\Menus\MainMenu\MainMenu;
use Webmagic\Dashboard\Elements\Menus\MainMenu\TopSidebarMenu\TopSidebarMenu;
use Webmagic\Dashboard\Elements\Menus\NavBarMenu\NavBarMenu;
use Webmagic\Dashboard\NotificationService\NotificationService;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Webmagic\Dashboard\Api\Http\Middleware\Locale;

class DashboardServiceProvider extends BaseServiceProvider
{
    /**
     * Path for config
     * @var string
     */
    protected $configPath = 'webmagic.dashboard.dashboard';

    /**
     * Boot
     */
    public function boot()
    {
        //Load Views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard');

        $this->registerPublishes();

        $this->registerCommands();

        $this->loadTranslations();

        $this->prepareDashboardVersion();

        $this->registerLocaleMiddleware();

        // Load presentation routs
        if (config('webmagic.dashboard.dashboard.presentation_mode')) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');
            $this->app->register(MarkdownServiceProvider::class);
        }

        // Load API routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    /**
     * Set language
     */
    protected function registerLocaleMiddleware()
    {
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', Locale::class);
    }

    /**
     * Prepare variable with current dashboard package version
     */
    protected function prepareDashboardVersion()
    {
        $version = Versions::getVersion('webmagic/dashboard');
        $version = preg_replace('/\@.*/', '', $version);

        View::share('webmagicDashboardVersion', $version);
    }

    /**
     * Register
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/dashboard.php',
            $this->configPath
        );

        $this->registerDashboardAndMenus();
    }

    /**
     * Register console commands
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                UpdateAssetData::class,
                ComponentsMetaMethodsGenerate::class,
                GenerateComponent::class
            ]);
        }
    }

    /**
     * Register all publishes
     */
    protected function registerPublishes()
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/webmagic/dashboard'),
            __DIR__ . '/../public' => public_path('webmagic/dashboard'),
            __DIR__ . '/../config' => config_path('webmagic/dashboard'),
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/webmagic/dashboard'),
        ], 'webmagic/dashboard::all');

        $this->publishes([
            __DIR__ . '/../public' => public_path('webmagic/dashboard'),
            __DIR__ . '/../config' => config_path('webmagic/dashboard'),
        ], 'webmagic/dashboard::min');
    }

    /**
     * @return string
     */
    protected function getMenuClass(): string
    {
        if ($this->isEnableTopMenuPresentationMode()) {
            return TopSidebarMenu::class;
        }

        if (config("$this->configPath.enable_top_sidebar")) {
            return TopSidebarMenu::class;
        }

        return MainMenu::class;
    }

    /**
     * @return bool
     */
    protected function isEnableTopMenuPresentationMode(): bool
    {
        return strpos(request()->url(), 'top-menu/presentation-mode');
    }

    /**
     * Prepare dashboard
     */
    protected function registerDashboardAndMenus()
    {
        // Register Dashboard
        $this->app->singleton(Dashboard::class, function (){
            $dashboard = new Dashboard();
            $dashboard->setMenuClass($this->getMenuClass());

            if(config("$this->configPath.admin_panel_style.side_bar.collapsed")){
                $dashboard->page()->makeSidebarCollapsed();
            }

            return $dashboard;
        });

        // Register Notification Service
        $this->app->singleton(NotificationService::class, NotificationService::class);

        // Prepare Main Menu
        $this->app->singleton($this->getMenuClass(), function () {
            $className = $this->getMenuClass();
            $menuConfig = $this->prepareDashboardMenuConfig();
            $mainMenu = new $className($menuConfig);
            $mainMenu->addClass($this->prepareSideBarClass());

            // Turn on search if needed
            $mainMenu->showSearch(
                config("$this->configPath.search.show", true),
                config("$this->configPath.search.action", "/"),
                config("$this->configPath.search.attr_name", "search_str")
            );

            return $mainMenu;
        });

        // Prepare Nav Bar Menu
        $this->app->singleton(NavBarMenu::class, function () {
            $menuConfig = config('webmagic.dashboard.dashboard.header_navigation');

            if(!auth()) {
                $this->removeLogoutItem($menuConfig);
            }

            return new NavBarMenu($menuConfig);
        });

        //Prepare breadcrumbs
        if(config('webmagic.dashboard.dashboard.breadcrubs.generate_automatically')){
            $this->app->singleton(Breadcrumbs::class, function () {
                return $this->prepareBreadcrumbs();
            });
        }

    }

    /**
     * @param $menuConfig
     */
    private function removeLogoutItem(&$menuConfig)
    {
        foreach ($menuConfig as $k => $item) {
            if (isset($item['link']) && $item['link'] == 'logout') {
                unset($menuConfig[$k]);
            }
        }

        $menuConfig = array_values($menuConfig);
    }

    /**
     * Prepare config for main manu
     *
     * @return Repository|mixed
     */
    protected function prepareDashboardMenuConfig()
    {
        // Load main config
        $menuConfig = config('webmagic.dashboard.dashboard.menu');

        // Optional loading presentation menu config
        if (config('webmagic.dashboard.dashboard.presentation_mode')) {
            $presentMenuConf = require __DIR__ . '/../config/presentation-menu-config.php';
            $menuConfig = array_merge($menuConfig, $presentMenuConf);
        }

        return $menuConfig;
    }

    /**
     * @return Breadcrumbs
     */
    protected function prepareBreadcrumbs(): Breadcrumbs
    {
        $breadCrumbs = new Breadcrumbs();
        if(config('webmagic.dashboard.dashboard.breadcrubs.add_home_link')) {
            $breadCrumbs->add(
                $link = config('webmagic.dashboard.dashboard.breadcrubs.home_link.link'),
                $text = config('webmagic.dashboard.dashboard.breadcrubs.home_link.text'),
                $icon = config('webmagic.dashboard.dashboard.breadcrubs.add_icons') ? 'fa-tachometer-alt' : ''
            );
        }

        // Add active Item if available
        $activeItem = app($this->getMenuClass())->getActiveItem();
        if($activeItem) {
            $breadCrumbs->add(
                $activeItem->link,
                $activeItem->text,
                config('webmagic.dashboard.dashboard.breadcrubs.add_icons') ? $activeItem->icon : ''
            );
        }

        return $breadCrumbs;
    }

    /**
     * Load dashboard translations
     */
    protected function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'dashboard');
    }

    /**
     * prepare class for sidebar
     * @return string
     */
    protected function prepareSideBarClass(): string
    {
        $class = '';
        $itemConf = config("$this->configPath.admin_panel_style.side_bar");

        $class .= isset($itemConf['small_text']) && $itemConf['small_text'] ? ' text-sm ' : '';
        $class .= isset($itemConf['flat']) && $itemConf['flat'] ? ' nav-flat ' : '';
        $class .= isset($itemConf['legacy']) && $itemConf['legacy'] ? ' nav-legacy ' : '';
        $class .= isset($itemConf['compact']) && $itemConf['compact'] ? ' nav-compact ' : '';
        $class .= isset($itemConf['child_indent']) && $itemConf['child_indent'] ? ' nav-child-indent ' : '';

        return $class;
    }
}
