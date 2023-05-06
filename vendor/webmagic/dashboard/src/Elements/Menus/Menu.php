<?php


namespace Webmagic\Dashboard\Elements\Menus;

use Illuminate\Support\Collection;
use Webmagic\Dashboard\Core\ComplexElement;
use Webmagic\Dashboard\Core\View\ViewUndefined;
use Webmagic\Dashboard\Core\View\ViewUsable;

abstract class Menu extends ComplexElement
{
    use ViewUsable;

    /** @var  Collection */
    protected $items;

    /** @var bool */
    protected $showUserPanel = true;

    /**
     * Menu constructor.
     */
    public function __construct()
    {
        $this->items = new Collection();
    }

    /**
     * Add item to collection
     *
     * @param MenuItem $menuItem
     */
    public function addItem(MenuItem $menuItem)
    {
        $this->items->push($menuItem);
    }

    /**
     * @return string
     * @throws ViewUndefined
     */
    public function render(): string
    {
        $this->sort();

        $view = $this->getViewName();

        $variables = $this->getViewData();
        $variables['content'] = $this->prepareItemsRender();
        $variables['userTitle'] = $this->prepareUserTitle();
        $variables['userFirstLetter'] = $this->prepareUserFirstLetter();
        $variables['showUserPanel'] = $this->showUserPanel;

        return view($view, $variables);
    }

    /**
     * Prepare rendered menu items string
     *
     * @return string
     */
    protected function prepareItemsRender()
    {
        $content = '';
        foreach ($this->items as $item) {

            if (!$item->checkOnAccess()) {
                continue;
            }

            if ($item->getSubItems()->count()) {
                $this->checkSubItemsMenu($item);
            }

            $content .= $item->render();
        }

        return $content;
    }

    /**
     * @param $item
     * @return void
     */
    protected function checkSubItemsMenu($item)
    {
        foreach ($item->getSubItems() as $subItemKey => $subItem) {
            if (!$item->checkOnAccessSubItem($subItem)) {
                $item->removeSubItem($subItemKey);
            }

            // checking submenus
            if ($subItem->getSubItems()->count()) {
                $this->checkSubItemsMenu($subItem);
            }
        }
    }


    protected function sort()
    {
        $this->items = $this->items->sortByDesc(function ($item) {
            return $item->getItemRank();
        });
    }



    /**
     * Sorting by param rank
     *
     * @param $a
     * @param $b
     * @return int
     */
    protected function compareRank($a, $b)
    {
        if ($a->getItemRank() == $b->getItemRank()) {
            return 0;
        }

        return ($a->getItemRank() < $b->getItemRank()) ? 1 : -1;
    }

    /**
     * Prepare user info for admin sidebar
     * return name|login|email
     *
     * @return string
     */
    protected function prepareUserTitle(): string
    {
        if(!auth()->check()) {
            return '';
        }

        if(auth()->user()->name) {
           return ucwords(auth()->user()->name);
        }

        if(auth()->user()->login) {
            return auth()->user()->login;
        }

        return auth()->user()->email;
    }

    /**
     * Uppercase and return first letter of user title
     *
     * @return string
     */
    protected function prepareUserFirstLetter(): string
    {
        return strtoupper($this->prepareUserTitle()[0] ?? '');
    }
}
