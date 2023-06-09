<?php


namespace Webmagic\Dashboard\Elements\Menus\MainMenu;

use Webmagic\Dashboard\Elements\Menus\MenuItem;

class Header extends MenuItem
{
    protected $available_fields = [
        'text',
        'class',
        'link',
        'icon',
        'rank',
        'gates',
        'header'
    ];

    protected $view = 'dashboard::components.menus.main_menu.header';
}
