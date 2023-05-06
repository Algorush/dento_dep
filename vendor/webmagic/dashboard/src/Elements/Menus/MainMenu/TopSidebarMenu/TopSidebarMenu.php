<?php


namespace Webmagic\Dashboard\Elements\Menus\MainMenu\TopSidebarMenu;

use Webmagic\Dashboard\Elements\Menus\MainMenu\MainMenu;

class TopSidebarMenu extends MainMenu
{
    /** @var string View */
    protected $view = 'dashboard::components.menus.main_menu.top_sidebar_menu.top_sidebar_menu';

    /** @var string Item */
    protected $itemClass = Item::class;
}
