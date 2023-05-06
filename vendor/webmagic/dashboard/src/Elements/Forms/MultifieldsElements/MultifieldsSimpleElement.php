<?php

namespace Webmagic\Dashboard\Elements\Forms\MultifieldsElements;

use Webmagic\Dashboard\Core\ComplexElement;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Core\DataExtractor;
use Webmagic\Dashboard\Elements\Buttons\DefaultButton;
use Webmagic\Dashboard\Elements\Forms\Elements\Checkbox;
use Webmagic\Dashboard\Elements\Forms\Elements\FormGroup;
use Webmagic\Dashboard\Elements\Forms\Elements\Select;
use Webmagic\Dashboard\Elements\Forms\Elements\SelectJS;
use Webmagic\Dashboard\Elements\WrapperDiv;

class MultifieldsSimpleElement extends ComplexElement
{
    protected $view = 'dashboard::components.form.multifields_simple';
    
    /** @var int Max counts for copying */
    protected $max_copy_count = 5;

    /** @var array [MultifieldsAvailable] */
    protected $rawFields = [];

    /** @var  array */
    protected $fieldsData = [];

    /** @var int count elements on form */
    protected $count_name = 0;

    /** @var int count rows on form */
    protected $count_id = 0;

    /** @var [MultifieldsAvailable] */
    protected $template_fields;

    protected $prepared_fields;

    protected $available_fields = [
        'add_button' => [
            'type' => DefaultButton::class
        ],
        'remove_button' => [
            'type' => DefaultButton::class
        ],
    ];

    protected $default_field = 'fields';

    /**
     * @param MultifieldsAvailable ...$fields
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function addFields(MultifieldsAvailable ... $fields): self
    {
        foreach ($fields as $field) {
            $this->rawFields[$field->name] = clone $field;

            $this->template_fields[] = $this->prepareTemplateField($field);
        }

        return $this;
    }

    /**
     * @param MultifieldsAvailable $field
     * @return FormGroup
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareTemplateField(MultifieldsAvailable $field): FormGroup
    {
        $field
            ->name("$field->name[0]")
            ->addClass('js_clone-el')
            ->attr('disabled', 'disabled');

        return new FormGroup($field);
    }

    /**
     * @param array $preparedFields
     * @return $this
     */
    public function setData(array $preparedFields)
    {
        $this->fieldsData = $preparedFields;

        return $this;
    }

    /**
     * Add count blocks on form
     */
    protected function increaseCountBlocks()
    {
        $this->count_name++;
    }

    /**
     * @param array $row
     * @return WrapperDiv
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareFieldsRow(array $row): WrapperDiv
    {
        $this->increaseCountBlocks();

        $fieldsRow = new WrapperDiv();
        $fieldsRow->addClass('d-flex align-items-start js_clone-blk');

        foreach ($this->rawFields as $field) {
            $fieldValue = (new DataExtractor($row))->get($field->name, []);

            $fieldsRow->addContent($this->prepareField($field, $fieldValue));
        }

        $fieldsRow->addContent($this->getRemoveButton());

        return $fieldsRow;
    }

    /**
     * Add count elements on form
     */
    protected function increaseCountElements()
    {
        $this->count_id++;
    }

    /**
     * @param MultifieldsAvailable $field
     * @param $value
     * @return FormGroup
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareField(MultifieldsAvailable $field, $value): FormGroup
    {
        $this->increaseCountElements();

        $preparedField = clone $field;

        $this->setContent($preparedField, $value);

        $preparedField->name("$field->name[$this->count_name]")
            ->addClass('js_clone-el')
            ->id("field_$this->count_id");

        return new FormGroup($preparedField);
    }

    /**
     * @param MultifieldsAvailable $field
     * @param $value
     */
    protected function setContent(MultifieldsAvailable $field, $value)
    {
        if($this->isElementSelectType($field)) {
            $field->options($value);
            return;
        }

        if($this->isElementCheckboxType($field)) {
            $field->checked($value);
            return;
        }

        $field->content = $value;
        $field->value = $value;
    }

    /**
     * @param MultifieldsAvailable $field
     * @return bool
     */
    protected function isElementCheckboxType(MultifieldsAvailable $field): bool
    {
        return $field instanceof Checkbox;
    }

    /**
     * Detect is belong element to "Select" elements like Select, SelectJS
     *
     * @param MultifieldsAvailable $field
     * @return bool
     */
    protected function isElementSelectType(MultifieldsAvailable $field): bool
    {
        $fieldClass = get_class($field);
        $selectTypes = [SelectJS::class, Select::class];

        return in_array($fieldClass, $selectTypes);
    }

    /**
     * @param $what
     * @param $where
     * @return bool
     */
    protected function isNotFound($what, $where): bool
    {
        return !data_get($where, $what);
    }

    /**
     * @return string
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function render(): string
    {
        $this->prepared_fields = $this->prepareRows();

        $this->addDynamicField('prepared_fields', $this->prepared_fields);
        $this->addDynamicField('count_name', [$this->count_name]);
        $this->addDynamicField('count_id', [$this->count_id]);
        $this->addDynamicField('template_fields', [$this->template_fields]);

        return parent::render();
    }

    /**
     * @return array
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareRows(): array
    {
        $preparedFieldsRows = [];

        /** @var array $row */
        foreach ($this->fieldsData as $row) {
            $fieldsRow = $this->prepareFieldsRow($row);

            $preparedFieldsRows[] = $fieldsRow;

        }

        return $preparedFieldsRows;
    }

    /**
     * Get remove button block for each block with fields
     *
     * @return WrapperDiv
     */
    protected function getRemoveButton(): WrapperDiv
    {
        return clone $this->remove_button;
    }

    /**
     * ContentFieldsUsable constructor.
     *
     * @param null $content
     *
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function __construct($content = null)
    {
        if (!is_null($content)) {
            $this->content($content);
        }

        $this->prepareDefaultAddButton();
        $this->prepareDefaultRemoveButton();
//        $this->prepareDefaultElementsGroup();
    }

//    public function initWithData($dataList)
//    {
//        /** @var MultifieldFormGroup $baseGroup */
//        $baseGroup = $this->fields;
//
//        foreach ($dataList as $item){
//            $group = clone $baseGroup;
//            $this->addPreparedFields($group->applyData($item));
//        }
//    }
//
//    protected function prepareDefaultElementsGroup()
//    {
//        $this->fields = (new MultifieldFormGroup());
//    }
//
//    /**
//     * @param $dataList
//     * @return MultifieldFormGroup
//     */
//    public function addFields($dataList = null): MultifieldFormGroup
//    {
//        if($dataList){
//            $this->fields = (new MultifieldFormGroup())->setDataSource($dataList);
//        }
//
//        return $this->fields;
//    }

    /**
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareDefaultAddButton()
    {
        $this->prepareAddButton((new DefaultButton(__('dashboard::common.multifiedl_element.add')))
            ->icon('fa-plus'));
    }

    /**
     * Prepare default remove button
     */
    protected function prepareDefaultRemoveButton()
    {
        $this->prepareRemoveButton((new DefaultButton())
            ->addClass('btn-danger')
            ->icon('fa-trash'));
    }

    /**
     * Set or get max copy  count
     *
     * @param int|null $maxCopyCount
     *
     * @return $this|int
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function maxCopyCount(int $maxCopyCount = null)
    {
        if($maxCopyCount){
            $this->max_copy_count = $maxCopyCount;

            //Update button if it is set
            if(isset($this->add_button)){
                $this->prepareAddButton($this->add_button);
            }

            return $this;
        }

        return $this->max_copy_count;
    }

    /**
     * @param DefaultButton $button
     *
     * @return MultifieldsSimpleElement
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function setAddButton(DefaultButton $button): MultifieldsSimpleElement
    {
        $this->prepareAddButton($button);

        return $this;
    }

    /**
     * @param DefaultButton $button
     *
     * @return MultifieldsSimpleElement
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareRemoveButton(DefaultButton $button)
    {
        $button->addClass('js_clone-remove');

        $this->remove_button = (new WrapperDiv($button))
            ->addClass('form-group clearfix');

        return $this;
    }

    /**
     * @param DefaultButton $button
     *
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareAddButton(DefaultButton $button)
    {
        $button
            ->addClass('js_clone-add')
            ->attr('data-max-count', $this->max_copy_count);

        $this->add_button = $button;
    }
}