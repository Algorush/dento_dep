# Top Menu Element
To switch menu from side to top, it is enough in config file
**{config_directory}/webmagic/dashboard/dashboard.php**
set *true* value for key *enable_top_sidebar*  
  
For display top menu used special component **\Webmagic\Dashboard\Elements\Menus\MainMenu\TopSidebarMenu\TopSidebarMenu**  
As menu items used **\Webmagic\Dashboard\Elements\Menus\MainMenu\TopSidebarMenu\Item**
  
TopSidebarMenu extends *Webmagic\Dashboard\Components\Menus\MainMenu\MainMenu* and has the same features ([see docs about MainMenu](/dashboard/tech/main-menu)), apart from:
- highlighting the active element
- automatic list expansion (to indicate the active current element)
- no way to set **Headers for menu**