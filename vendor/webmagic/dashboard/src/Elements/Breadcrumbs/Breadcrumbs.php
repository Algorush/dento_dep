<?php


namespace Webmagic\Dashboard\Elements\Breadcrumbs;


use Webmagic\Dashboard\Core\ComplexElement;

class Breadcrumbs extends ComplexElement
{
    /** @var string  */
    protected $view = 'dashboard::elements.breadcrumbs.breadcrumbs';

    /** @var [] */
    protected $items = [];

    /** @var  array Sections available in page */
    protected $available_fields = [
        'items' => [
            'type'              => BreadcrumbsItem::class,       // any variable type or class string, bool, renderable, array, collection
            'default'           => [],  // default value for field
            'acceptable_values' => [],       // array of available values
            'array_acceptable'  => true,     // additional show if array field acceptable,
            'dynamic'           => false     //  will set automatically for all dynamic fields
        ],
    ];

    /**
     * @param string $link
     * @param string $text
     * @param string $icon
     *
     * @return $this
     */
    public function add(string $link, string $text, string $icon = ''): Breadcrumbs
    {
        $item = new BreadcrumbsItem($link, $text, $icon);

        $this->addItem($item);

        return $this;
    }

    /**
     * @param BreadcrumbsItem $item
     *
     * @return $this
     */
    public function addItem(BreadcrumbsItem $item): Breadcrumbs
    {
        array_push($this->items, $item);

        return $this;
    }

    /**
     * Remove all items
     *
     * @return $this
     */
    public function clear(): Breadcrumbs
    {
        $this->items = [];

        return $this;
    }

    /***
     * @param BreadcrumbsItem ...$items
     *
     * @return $this
     */
    public function updateItems(BreadcrumbsItem ... $items): Breadcrumbs
    {
        $this->items = $items;

        return $this;
    }
}