<?php

namespace Webmagic\Dashboard\Dashboard\Components;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Webmagic\Dashboard\Components\FormGenerator;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Core\Utils;
use Webmagic\Dashboard\Elements\Buttons\DefaultButton;
use Webmagic\Dashboard\Elements\Forms\Elements\FormGroup;
use Webmagic\Dashboard\Elements\WrapperDiv;

class ColumnFormGenerator extends FormGenerator
{
    /**
     * @param array $validated
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function prepare(array $validated): ColumnFormGenerator
    {
        $this->ajax()
            ->replaceBlockClass(Str::start($validated['table_identifier'], '.'))
            ->dontHideModalOnSubmit(true)
            ->method('GET')
            ->action($validated['table_url']);

        $selectedColumns = $this->getSelectedColumns($validated);

        $numberFieldsInColumn = config('webmagic.dashboard.dashboard.number_fields_in_column', 10);
        $tableFields = collect(json_decode($validated['table_fields'], true));
        $fieldsChunk = $tableFields->chunk($numberFieldsInColumn);
        $allCheckboxes = $this->prepareCheckboxes($fieldsChunk, $selectedColumns);

        $this->getForm()->element()
            ->grid($allCheckboxes)
            ->lgRowCount($fieldsChunk->count());

        $this->hiddenInput('table_fields', $validated['table_fields']);
        $this->hiddenInput('table_url', $validated['table_url']);

        $this->getSubmitButtonGroup()->content($this->getModalFooterWrapper()->content([
            (new DefaultButton('Cancel'))->class('btn btn-default')
                ->attrs(['data-dismiss' => 'modal', 'style' => 'margin-right:auto']),
            (new DefaultButton('Update'))->type('submit')->attrs([])
        ]));

        return $this;
    }

    /**
     * @param $fieldsChunk
     * @param $selectedColumns
     * @return array
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareCheckboxes($fieldsChunk, $selectedColumns): array
    {
        $allCheckboxes = [];
        foreach ($fieldsChunk as $fields) {
            $wrapper = new WrapperDiv();
            foreach ($fields as $key => $title) {
                $wrapper->addContent($this->prepareCheckbox($selectedColumns, $key, $title));
            }

            $allCheckboxes[] = $wrapper;
        }

        return $allCheckboxes;
    }

    /**
     * @param $selectedColumns
     * @param $key
     * @param $title
     * @return FormGroup
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareCheckbox($selectedColumns, $key, $title): FormGroup
    {
        return (new FormGroup())->checkbox(
            "choose_columns[$key]",
            ["choose_columns[$key]" => $this->isChecked($selectedColumns, $key)],
                $title,
                false,
                ['style' => 'float:left;padding-right:0.5rem;padding-top:0.3rem']
        );
    }

    /**
     * @param $selectedColumns
     * @param $key
     * @return bool
     */
    protected function isChecked($selectedColumns, $key): bool
    {
        if (empty($selectedColumns)) {
            return true;
        }

        if (isset($selectedColumns[$key])) {
            return (bool) $selectedColumns[$key];
        }

        return false;
    }

    /**
     * Get selected columns from storage
     *
     * @param array $validated
     * @return array
     */
    protected function getSelectedColumns(array $validated): array
    {
        $tableFields = array_keys(json_decode($validated['table_fields'], true));
        $key = Utils::generateTableIdKey($tableFields, $validated['table_url']);

        $selectedColumns = Cache::get($key);

        return is_array($selectedColumns) ? $selectedColumns : [];
    }

    /**
     * @return mixed
     */
    private function getModalFooterWrapper(): WrapperDiv
    {
        return (new WrapperDiv())
            ->addClass('modal-footer pb-0 mt-3')->attr('style', 'margin:0 -20px; padding: 0.75rem');
    }
}