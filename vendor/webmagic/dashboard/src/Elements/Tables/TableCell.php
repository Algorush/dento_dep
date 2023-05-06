<?php

namespace Webmagic\Dashboard\Elements\Tables;

use Exception;
use Webmagic\Dashboard\Core\ComplexElement;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Elements\StringElement;

class TableCell extends ComplexElement
{
    /** @var  StringElement Component view name */
    protected $view = 'dashboard::elements.table-cell';

    protected $itemData;

    /** @var  array Sections available in page */
    protected $available_fields = [
        'value',
        'class'
    ];

    /** @var  StringElement Default section for current component */
    protected $default_field = 'value';

    /**
     * @param $itemData
     * @return $this
     */
    public function setItemData($itemData): self
    {
        $this->itemData = $itemData;

        return $this;
    }

    /**
     * Get field value
     *
     * @param string $name
     *
     * @return string
     * @throws NoOneFieldsWereDefined
     * @throws Exception
     */
    protected function getFieldValue(string $name): string
    {
        //Result of method if exists
        $method = $this->prepareAttributeGetMethod($name);
        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        if (empty($this->{$name})) {
            return $this->getFieldDefaultValue($name);
        }

        if (is_callable($this->{$name})) {
            $closure = $this->{$name};

            return $closure($this->itemData, $this);
        }

        return $this->{$name};
    }
}