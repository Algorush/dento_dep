<?php


namespace Webmagic\Dashboard\Pages;

use Exception;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Webmagic\Dashboard\Elements\Breadcrumbs\Breadcrumbs;
use Webmagic\Dashboard\Elements\Menus\MainMenu\MainMenu;
use Webmagic\Dashboard\Elements\Menus\MainMenu\TopSidebarMenu\TopSidebarMenu;
use Webmagic\Dashboard\Elements\Menus\NavBarMenu\NavBarMenu;
use Webmagic\Dashboard\Elements\Boxes\Box;
use Webmagic\Dashboard\Elements\Links\LinkButton;
use Webmagic\Dashboard\Elements\Special\LogoLinkElement;

class PagesFactory
{
    /**
     * Path for config
     * @var string
     */
    protected $configPath = 'webmagic.dashboard.dashboard';

    /**
     * @param null $content
     *
     * @return Page
     * @throws Exception
     */
    public function prepareDefaultPage($content = null)
    {
        $page = $this->preparePage();
        $page->content($content);

        return $page;
    }

    /**
     * @param array $tableData
     *
     * @return Page
     * @throws Exception
     */
    public function prepareTablePage(array $tableData)
    {
        $box = app()->make(Box::class);

        //Prepare add button
        if (isset($tableData['addButton'])) {
            $box = $this->prepareAddButton($tableData['addButton'], $box);
            unset($tableData['addButton']);
        }

        $table = app()->makeWith(Table::class, ['content' => $tableData]);
        $box->content($table);

        $page = $this->preparePage();
        $page->content($box);

        return $page;
    }

    /**
     * Prepare and add Add button to box
     *
     * @param     $link
     * @param Box $box
     *
     * @return Box
     * @throws Exception
     */
    protected function prepareAddButton($link, Box $box)
    {
        $addButton = new LinkButton([
            'content' => 'Add',
            'icon' => 'fas fa-plus',
            'class' => 'btn-success',
            'link' => $link
        ]);

        $box->param('box_tools', $addButton);

        return $box;
    }

    /**
     * Real creation
     *
     * @return Page
     * @throws Exception
     */
    protected function preparePage()
    {
        $defaultParams = $this->prepareDefaultParams();

        $pageClass = $this->chooseBasePage();

        $page = app()->makeWith($pageClass, ['content' => $defaultParams]);

        return $page;
    }

    /**
     * @return string
     */
    protected function chooseBasePage(): string
    {
        if ($this->isEnableTopMenuPresentationMode()) {
            return BasePageTopSidebar::class;
        }

        if ($this->enableTopSidebar()) {
            return BasePageTopSidebar::class;
        }

        return BasePage::class;
    }

    /**
     * @return string
     */
    protected function chooseMenuClass(): string
    {
        if ($this->isEnableTopMenuPresentationMode()) {
            return TopSidebarMenu::class;
        }

        if ($this->enableTopSidebar()) {
            return TopSidebarMenu::class;
        }

        return MainMenu::class;
    }

    /**
     * @return bool
     */
    protected function enableTopSidebar(): bool
    {
        return (bool) config("$this->configPath.enable_top_sidebar");
    }

    /**
     * @return bool
     */
    protected function isEnableTopMenuPresentationMode(): bool
    {
        return strpos(request()->url(), 'top-menu/presentation-mode');
    }

    /**
     * Preparing default params for configuring page
     *
     * @return array
     * @throws Exception
     */
    protected function prepareDefaultParams(): array
    {
        return [
            'header_logo' => $this->createLogoElement(),
            'header_nav' => $this->prepareHeaderNav(),
            'main_sidebar' => $this->prepareMainMenu(),
            'breadcrumbs'   => $this->prepareBreadcrumbs(),
            'content_header' => '',
            'data' => '',
            'footer' => '',
            'title' => $this->prepareTitle(),
            'class' => $this->prepareBodyClass(),
            'header_nav_style' => $this->prepareNavBarClass(),
            'footer_class' => $this->prepareFooterClass(),
            'aside_class' => $this->prepareAsideClass(),
            'is_auto_close_notification' => $this->prepareIsAutoCloseNotification(),
            'close_notification_in_seconds' => $this->prepareCloseNotificationInSeconds(),
        ];
    }

    /**
     * @return ?int
     */
    protected function prepareCloseNotificationInSeconds(): ?int
    {
        return config("$this->configPath.notification_auto_close_after");
    }

    /**
     * @return string
     */
    protected function prepareIsAutoCloseNotification(): string
    {
        $isAutoClose = config("$this->configPath.notification_auto_close_enable");

        if ($isAutoClose) {
            return 'true';
        }

        return 'false';
    }

    /**
     * Prepare breadcrumbs for displaying
     *
     * @return mixed
     */
    protected function prepareBreadcrumbs()
    {
        return app()->make(Breadcrumbs::class);
    }


    /**
     * Creating logo based on config settings
     *
     * @return LogoLinkElement
     * @throws Exception
     */
    protected function createLogoElement()
    {
        //Old logo settings
        $oldHeaderLogoSettings = config("$this->configPath.logo_settings");
        $headerLogoSettings = config("$this->configPath.logo");

        //For back compatibility with old configs
        if(isset($oldHeaderLogoSettings['part_one'])){
            $headerLogoSettings['text_logo']['regular_text'] = $oldHeaderLogoSettings['part_one'] . $oldHeaderLogoSettings['part_two'];
        }
        if(isset($headerLogoSettings['text'])){
            $headerLogoSettings['text_logo']['regular_text'] = $headerLogoSettings['text'];
        }

        try {
            $logoElement = new LogoLinkElement([
                'link' => $headerLogoSettings['link'],
                'icon' => $headerLogoSettings['icon'],
                'prefer_image_logo' => $headerLogoSettings['prefer_image_logo'],
                'regular_text' => $headerLogoSettings['text_logo']['regular_text'],
                'collapsed_text' => $headerLogoSettings['text_logo']['collapsed_text']

            ]);
        } catch (Exception $e) {
            throw new Exception(
                'Error in creating LogoLinkElement. Invalid data for setup. Check config "logo_settings" '
            );
        }

        $logoElement->addClass($this->prepareLogoClass());

        return $logoElement;
    }

    /**
     * Creating MainMenu with settings from config
     */
    protected function prepareMainMenu()
    {
        return app()->make($this->chooseMenuClass());
    }

    /**
     * Prepare header navigation
     *
     * @return NavBarMenu
     * @throws BindingResolutionException
     */
    protected function prepareHeaderNav()
    {
        return app()->make(NavBarMenu::class);
    }

    /**
     * prepare class for body element
     * @return string
     */
    protected function prepareBodyClass(): string
    {
        $class = '';
        $itemConf = config("$this->configPath.admin_panel_style.body");

        $class .= isset($itemConf['small_text']) && $itemConf['small_text'] ? ' text-sm ' : '';

        $accent_color = $itemConf['accent_color_variants'] ?? '';
        $colors = ['primary', 'warning', 'info', 'danger', 'success', 'indigo', 'navy', 'purple', 'fuchsia', 'pink', 'maroon', 'orange', 'lime', 'teal', 'olive'];

        if(in_array($accent_color, $colors)) {
            $class .= " accent-$accent_color ";
        }

        return $class;
    }

    /**
     * prepare class for nav bar element
     * @return string
     */
    protected function prepareNavBarClass(): string
    {
        $class = '';
        $itemConf = config("$this->configPath.admin_panel_style.nav_bar");

        $class .= isset($itemConf['no_navbar_border']) && $itemConf['no_navbar_border'] ? ' border-bottom-0 ' : '';
        $class .= isset($itemConf['small_text']) && $itemConf['small_text'] ? 'text-sm ' : '';

        $fontClass = $itemConf['variants']['font_color'] ?? 'dark';
        $fontClass = $fontClass == 'dark' ? 'light' : 'dark';
        $class .= " navbar-$fontClass " ;

        $colors = ['primary', 'secondary', 'info', 'success', 'danger', 'indigo', 'purple', 'pink', 'teal', 'cyan', 'gray-dark', 'gray', 'warning', 'white', 'orange'];
        $themeColor = $itemConf['variants']['theme_color'] ?? '';
        $validColor = in_array($themeColor, $colors) ? $themeColor : 'primary'; // default theme 'primary'
        $class .= " navbar-$validColor ";

        return $class;
    }

    /**
     * prepare class for Footer
     * @return string
     */
    protected function prepareFooterClass(): string
    {
        $itemConf = config("$this->configPath.admin_panel_style.footer");

        return isset($itemConf['small_text']) && $itemConf['small_text'] ? 'text-sm ' : '';
    }

    /**
     * prepare class for aside element
     * @return string
     */
    protected function prepareAsideClass(): string
    {
        $class = '';
        $itemConf = config("$this->configPath.admin_panel_style.aside");

        $class .= isset($itemConf['auto_expand']) && $itemConf['auto_expand'] ? '' : ' sidebar-no-expand ';

        $themeColors = ['dark', 'light'];
        $theme = $itemConf['variants']['theme_color'] ?? '';
        $validThemeStyle = in_array($theme, $themeColors) ? $theme : 'dark'; // default theme 'dark'

        $colors = ['primary', 'warning', 'info', 'danger', 'success', 'indigo', 'navy', 'purple', 'fuchsia', 'pink', 'maroon', 'orange', 'lime', 'teal', 'olive'];
        $backgroundColor = $itemConf['variants']['background_color'] ?? '';
        $validBackgroundColor = in_array($backgroundColor, $colors) ? $backgroundColor : 'primary'; // default color 'primary'

        $class .= " sidebar-$validThemeStyle-$validBackgroundColor ";

        return $class;
    }

    /**
     * prepare class for Logo element
     * @return string
     */
    protected function prepareLogoClass(): string
    {
        $class = '';
        $itemConf = config("$this->configPath.admin_panel_style.logo");

        $class .= isset($itemConf['small_text']) && $itemConf['small_text'] ? ' text-sm ' : '';

        $colors = ['primary', 'secondary', 'info', 'success', 'danger', 'indigo', 'purple', 'pink', 'teal', 'cyan', 'dark', 'gray-dark', 'gray', 'light', 'white', 'orange'];
        $color = $itemConf['color'] ?? '';
        $validColor = in_array($color, $colors) ? $color : 'primary'; // default color 'primary'
        $class .= " navbar-$validColor ";

        return $class;
    }

    /**
     * Prepare title for dashboard
     *
     * @return Repository|mixed
     */
    protected function prepareTitle()
    {
        return config("$this->configPath.title");
    }
}
