<?php

namespace Webmagic\Dashboard\Elements\Forms\MultifieldsElements;

use Illuminate\Support\Arr;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Core\DataExtractor;
use Webmagic\Dashboard\Elements\Buttons\DefaultButton;
use Webmagic\Dashboard\Elements\Forms\Elements\FormGroup;
use Webmagic\Dashboard\Elements\WrapperDiv;

class MultifieldsComplexElement extends MultifieldsSimpleElement
{
    protected $view = 'dashboard::components.form.multifields_complex';

    /** @var string */
    protected $addButtonUrl = '';

    /** @var string */
    protected $addButtonMethod = 'POST';

    /** @var string */
    protected $removeButtonUrl = '';

    /** @var string */
    protected $removeButtonMethod = 'DELETE';

    /** @var string */
    protected $entity_name = '';

    protected $available_fields = [
        'add_button' => [
            'type' => DefaultButton::class
        ],
        'remove_button' => [
            'type' => DefaultButton::class
        ],
    ];

    /** @var string */
    protected $idKey = 'id';

    /**
     * @param array $preparedFields
     * @param string $idKey
     * @return $this
     */
    public function setData(array $preparedFields, string $idKey = 'id')
    {
        $this->fieldsData = $preparedFields;
        $this->idKey = $idKey;

        return $this;
    }

    /**
     * ContentFieldsUsable constructor.
     *
     * @param null $content
     *
     * @throws NoOneFieldsWereDefined
     */
    public function __construct(string $entityName, $content = null)
    {
        $this->entity_name = $entityName;

        if (!is_null($content)) {
            $this->content($content);
        }
    }

    /**
     * @param DefaultButton $button
     *
     * @return self
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareRemoveButton(DefaultButton $button)
    {
        $button
            ->addClass('js_clone-multi-remove')
            ->dataAttr('url', $this->removeButtonUrl)
            ->dataAttr('method', 'DELETE')
        ;

        $this->remove_button = (new WrapperDiv($button))
            ->addClass('form-group clearfix');

        return $this;
    }

    /**
     * @param string $url
     * @param string $method
     * @return $this
     */
    public function setAddButtonUrl(string $url, string $method = 'POST'): self
    {
        $this->addButtonUrl = $url;
        $this->addButtonMethod = $method;

        return $this;
    }

    /**
     * @param string $url
     * @param string $method
     * @return $this
     */
    public function setRemoveButtonUrl(string $url, string $method = 'DELETE'): self
    {
        $this->removeButtonUrl = $url;
        $this->removeButtonMethod = $method;

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
            ->addClass('js_clone-multi-add')
            ->attr('data-max-count', $this->max_copy_count)
            ->dataAttr('url', $this->addButtonUrl)
            ->dataAttr('method', $this->addButtonMethod);

        $this->add_button = (new WrapperDiv($button))
            ->addClass('form-group clearfix');
    }

    /**
     * @param MultifieldsAvailable $field
     * @param $value
     * @return FormGroup
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareMultiField(MultifieldsAvailable $field, $value, $fieldId): FormGroup
    {
        $this->increaseCountElements();

        $preparedField = clone $field;

        $this->setContent($preparedField, $value);

        $preparedField->name("$this->entity_name[$fieldId][$field->name]")
            ->addClass('js_clone-multi-el')
            ->id("field_$this->count_id");

        return new FormGroup($preparedField);
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
            ->name("$this->entity_name[0][$field->name]")
            ->addClass('js_clone-multi-el')
            ->attr('disabled', 'disabled');

        return new FormGroup($field);
    }

    /**
     * Set or get max copy  count
     *
     * @param int|null $max_copy_count
     *
     * @return $this|int
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function maxCopyCount(int $max_copy_count = null)
    {
        if($max_copy_count) {
            $this->max_copy_count = $max_copy_count;
        }

        return $this->max_copy_count;
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
            $id = $row[$this->idKey];
            $fieldsRow = $this->prepareMultiFieldsRow($id, $row);

            $preparedFieldsRows[] = $fieldsRow;

        }

        return $preparedFieldsRows;
    }

    /**
     * @param array $row
     * @return WrapperDiv
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareMultiFieldsRow($fieldId, array $row): WrapperDiv
    {
        $this->increaseCountBlocks();

        $fieldsRow = new WrapperDiv();
        $fieldsRow->addClass('d-flex align-items-start js_clone-multi-blk');
        $fieldsRow->dataAttr('entity', $this->entity_name);

        foreach ($this->rawFields as $field) {
            $fieldValue = (new DataExtractor($row))->get($field->name, []);

            $fieldsRow->addContent($this->prepareMultiField($field, $fieldValue, $fieldId));
        }

        $fieldsRow->addContent($this->getRemoveButton());

        return $fieldsRow;
    }

    public function render(): string
    {
        $this->prepareDefaultAddButton();
        $this->prepareDefaultRemoveButton();
        $this->prepared_fields = $this->prepareRows();
        $this->addDynamicField('max_copy_count', [$this->max_copy_count]);
        $this->addDynamicField('entity_name', Arr::wrap($this->entity_name));
        $this->addDynamicField('prepared_fields', $this->prepared_fields);
        $this->addDynamicField('count_name', [$this->count_name]);
        $this->addDynamicField('count_id', [$this->count_id]);
        $this->addDynamicField('template_fields', [$this->template_fields]);

        $view = $this->getViewName();
        $content = $this->getViewData();

        return view($view, $content);
    }
}