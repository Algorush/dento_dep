<?php

namespace Webmagic\Dashboard\Elements\Forms\MultifieldsElements;

use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Core\DataExtractor;
use Webmagic\Dashboard\Elements\Forms\Elements\FormGroup;

class MultifieldFormGroup extends FormGroup
{
    /** @var array */
    protected $elements = [];

    /** @var null  */
    protected $dataSource = null;

    public function __construct($content = null)
    {
        parent::__construct($content);

        // Remove input added as default
        $this->form_group_content = '';
    }


    /**
     * @param $dataSource
     * @return self
     */
    public function setDataSource($dataSource): MultifieldFormGroup
    {
        $this->dataSource = $dataSource;

        return $this;
    }

    /**
     * @param        $element
     * @param string $identifier
     * @param string $labelTxt
     *
     * @throws NoOneFieldsWereDefined
     */
    protected function addInputElement($element, string $identifier = '', string $labelTxt = ''): void
    {
        $element
            ->name("$element->name[0]")
            ->addClass('mr-2')
            ->addClass('js_clone-el');

        $this->elements[] = $element;

        $this->labelTxt($labelTxt)->labelId($identifier)->addContent($element);
    }
}