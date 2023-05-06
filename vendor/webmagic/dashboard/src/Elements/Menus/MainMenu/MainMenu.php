<?php


namespace Webmagic\Dashboard\Elements\Menus\MainMenu;

use Illuminate\Support\Collection;
use Webmagic\Dashboard\Elements\Menus\Menu;

class MainMenu extends Menu
{
    /** @var string View */
    protected $view = 'dashboard::components.menus.main_menu.main_menu';

    /** @var string Item */
    protected $itemClass = Item::class;

    /** @var string Header */
    protected $headerItemClass = Header::class;

    protected $activeItem;

    protected $available_fields = [
        'class',
        'search_show' => [
            'type' => 'bool',
            'default' => true,
        ],
        'search_action' => [
            'type' => 'string',
            'default' => '/',
        ],
        'search_attr_name' => [
            'type' => 'string',
            'default' => 'search_str',
        ]
    ];

    /**
     * MainMenu constructor.
     *
     * @param array|null $items_array
     */
    public function __construct(array $items_array = null)
    {
        $this->items = new Collection();

        if ($items_array) {
            $this->addMenuItems($items_array);
        }

        $this->showUserPanel = config("webmagic.dashboard.dashboard.admin_panel_style.show_user_panel");
    }

    /**
     * Recursively creating items and sub items
     *
     * @param $items_config
     */
    public function addMenuItems($items_config)
    {
        $items = $this->prepareItems($items_config);

        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    /**
     * Prepare items
     *
     * @param array $items_config
     * @return array
     */
    protected function prepareItems(array $items_config)
    {
        $items = [];

        //TODO try to optimize this and get respect ++
        // check if we get already one element it should be associate array and
        // we have no ability to check is it associate array and check for first element
        // because php have no tools for it, so first element of associate array will get error
        // and will not isset.
        // !!! don't try to check is first element is array because it can be!
        if (!isset($items_config[0])) {
            $items = $this->prepareOneItem($items_config);
            return array($items);
        };

        foreach ($items_config as $item_config) {
            $items[] = $this->prepareOneItem($item_config);
        }
        // sorting by rank
        return $items;
    }

    /**
     * Prepare Item
     *
     * @param array $item_config
     * @return Item
     */
    protected function prepareOneItem(array $item_config)
    {
        if (isset($item_config['header'])) {
            //Header or block items
            $item = new $this->headerItemClass($item_config);
        } else if (empty($item_config['subitems'])) {
            //Item has no subitems
            unset($item_config['subitems']);
            $item = new $this->itemClass($item_config);
        } else {
            //We know that we have subitems and prepare them
            $sub_items = $this->prepareItems($item_config['subitems']);
            unset($item_config['subitems']);

            $item = new $this->itemClass($item_config);
            foreach ($sub_items as $sub_item) {
                $item->addSubItem($sub_item);
            }
        }

        // Save active Item
        if($item->isActive()){
            $this->activeItem = $item;
        }

        return $item;
    }

    /**
     * Get Item
     * @param $item
     * @return Collection
     */
    public function getActiveItem()
    {
        return $this->activeItem;
    }

    /**
     * @param bool   $show
     * @param string $action
     * @param string $attr_name
     *
     * @return MainMenu
     */
    public function showSearch(bool $show, string $action, string $attr_name = 'search_str'): MainMenu
    {
        return $this->searchShow($show)
            ->searchAction($action)
            ->searchAttrName($attr_name);
    }
}
