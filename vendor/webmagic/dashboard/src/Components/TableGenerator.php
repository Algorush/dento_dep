<?php

namespace Webmagic\Dashboard\Components;

use Closure;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\Cache;
use Webmagic\Core\ResourceUrls\ResourceUrlsAbleContract;
use Webmagic\Core\ResourceUrls\ResourceUrlsGeneratorContract;
use Webmagic\Core\ResourceUrls\ResourceUrlsGeneratorGenerator;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Core\Renderable;
use Webmagic\Dashboard\Core\Utils;
use Webmagic\Dashboard\Elements\Buttons\DefaultButton;
use Webmagic\Dashboard\Elements\Factories\ElementsFactory;
use Webmagic\Dashboard\Elements\Forms\Elements\FormGroup;
use Webmagic\Dashboard\Elements\Forms\Form;
use Webmagic\Dashboard\Elements\Links\LinkButton;
use Webmagic\Dashboard\Elements\Links\LinkJSDelete;
use Webmagic\Dashboard\Elements\Tables\Table;
use Webmagic\Dashboard\Elements\Tables\TableCell;
use Webmagic\Dashboard\Elements\Tables\TableRowsCollection;
use Webmagic\Dashboard\Elements\Tables\TableTitle;

class TableGenerator implements Renderable
{
    /** @var Table */
    protected $table;

    /** @var callable */
    protected $editLinkClosure;

    /** @var callable */
    protected $destroyLinkClosure;

    /** @var callable */
    protected $showLinkClosure;

    /** @var array */
    protected $toolsCollection = [];

    /** @var ResourceUrlsGeneratorGenerator */
    protected $resourceUrlsGeneratorGenerator;

    /** @var array */
    protected $onlyFields;

    /** @var array */
    protected $allFields;

    /** @var array */
    protected $config;

    /** @var array */
    protected $items = [];

    /** @var string Key for gettion unique item identifier from array */
    protected $itemUniqIdKey = 'id';

    /** @var array */
    protected $titles = [];

    /** @var Form */
    protected $filter;

    /** @var bool Define if the Create and Edit functionality should work with Modal and Ajax */
    protected $toolsInModal = false;

    /** @var Table block identifier */
    protected $tableBlockIdentifier;
    /**
     * @var TableFilterGenerator
     */
    protected $filterGenerator;

    /** @var [Closure] */
    protected $rowsClosures = [];

    /** @var TableCell */
    protected $controlTableCell;

    /**
     * TablePageGenerator constructor.
     */
    public function __construct()
    {
        $this->table = (new ElementsFactory())->table();

        $this->setRowIdentifiersClosure();
        $this->setTableBlockIdentifier();
    }

    /**
     * Prepare and set uniq identifier for the table
     */
    protected function setTableBlockIdentifier()
    {
        $this->tableBlockIdentifier = 'js_table_block_' . uniqid();
        $this->table->addWrapperClasses($this->tableBlockIdentifier);
    }

    /**
     * Return table block identifier
     *
     * @return string
     */
    protected function getTableBlockIdentifier()
    {
        if (empty($this->tableBlockIdentifier)) {
            $this->setTableBlockIdentifier();
        }

        return $this->tableBlockIdentifier;
    }

    /**
     * Set if creat and edit will be with modal window
     *
     * @param bool $status
     *
     * @return $this
     */
    public function toolsInModal(bool $status = true)
    {
        $this->toolsInModal = $status;

        $this->updateTable();

        return $this;
    }

    /**
     * You can set custom closure for generation row class based on item
     *
     * @param callable $closure
     *
     * @return $this
     */
    public function addRowClassClosure(callable $closure)
    {
        $this->rowsClosures[] = $closure;
        $this->setRowIdentifiersClosure();

        return $this;
    }

    /**
     * Set row unique id generation closure and apply custom closure for row calsses
     */
    protected function setRowIdentifiersClosure()
    {
        $tableGenerator = $this;

        $this->table->element('rows')->tableRows()->classes(function ($item) use ($tableGenerator) {
            $id = array_get($item, $this->itemUniqIdKey, array_first($item));

            $customClasses = '';

            foreach ($tableGenerator->rowsClosures as $closure){
                $customClasses = ' ' . $closure($item);
            }

            return "js_item_$id " . $customClasses;
        });
    }

    /**
     * Set key for gettin unique item identifier from the collection
     */
    public function setKeyForItemUniqIdentifier(string $key)
    {
        $this->itemUniqIdKey = $key;

        return $this;
    }

    /**
     * Manual sorting activate
     *
     * @param string            $requestUrl  Url which will be used for request
     * @param callable|string   $itemsIds
     *                          Function for getting ID from items. Item from collection will be put in this function
     *                          or string with key which will be used for getting identifier from the item attributes
     *
     * @param string            $method      Method for request. POST as default
     *
     * @return $this
     * @throws \Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable
     * @throws \Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined
     */
    public function manualSorting(string $requestUrl, $itemsIds = 'id', string $method = 'POST')
    {
        // Configure table
        $this->table->manualSorting($requestUrl, $method);

        // Prepare bulk actions id closure
        if (is_string($itemsIds)) {
            $itemsIdsClosure = function ($item) use ($itemsIds) {
                return data_get($item, $itemsIds);
            };
        } elseif (is_callable($itemsIds)) {
            $itemsIdsClosure = function ($item) use ($itemsIds) {
                return $itemsIds($item);
            };
        } else {
            throw new \Exception("\$$itemsIds should be string or callable");
        }

        // Configure rows
        $this->getTableRows()->param('manual_sorting_closure', $itemsIdsClosure);

        $this->updateTable();

        return $this;
    }

    /**
     * Add bulk actions to table
     *
     * @param array $actionsList
     * @param       $itemsIds
     *
     * @return $this
     * @throws \Exception
     */
    public function bulkActions(array $actionsList, $itemsIds)
    {
        // Prepare bulk actions id closure
        if (is_string($itemsIds)) {
            $itemsIdsClosure = function ($item) use ($itemsIds) {
                return data_get($item, $itemsIds);
            };
        } elseif (is_callable($itemsIds)) {
            $itemsIdsClosure = function ($item) use ($itemsIds) {
                return $itemsIds($item);
            };
        } else {
            throw new \Exception("\$$itemsIds should be string or callable");
        }

        $bulkActionsElId = $this->getTable()->param('bulk_actions_id');
        $bulkActionsElClass = ".js_select-el-$bulkActionsElId";
        $tableIdentifier = $this->tableBlockIdentifier;

        $this->getTableRows()
            ->bulkActionClosure($itemsIdsClosure)
            ->bulkActionsId($bulkActionsElId);

        // Bulk actions form preparing
        $this->getTable()
            ->element('bulk_actions_area')
            ->form([
                'method'    => 'POST',
                'class'     => 'd-flex flex-nowrap',
                'ajax_form' => true,
            ])
            ->attrs([
                'data-additional-el'     => $bulkActionsElClass,
                'data-action-from-child' => ".js_ajax-form-action",
            ])
            ->addElement()
            ->selectJS()
            ->options($actionsList)
            ->addClass('js_ajax-form-action')
            ->parent('form')->addElement()
            ->button()
            ->addClass('ml-3')
            ->type('submit')->content('Apply')
            ->js()->activityController()->addDisabilityController(".$tableIdentifier $bulkActionsElClass");

        $this->updateTable();

        return $this;
    }

    /**
     *  Add filtering fot table
     *
     * @return TableFilterGenerator
     * @throws \Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable
     * @throws \Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined
     */
    public function addFiltering()
    {
        $filterGenerator = (new TableFilterGenerator($this, '.' . $this->getTableBlockIdentifier()));

        $this->filter = $filterGenerator->getForm();
        $this->filterGenerator = $filterGenerator;
        // Add form to table
        $this->getTable()
            ->addWrapperClasses(' margin ')
            ->filterArea($this->filter);

        return $filterGenerator;
    }

    /**
     * @return TableFilterGenerator
     */
    public function getFilterGenerator(): TableFilterGenerator
    {
        return $this->filterGenerator;
    }

    /**
     * Return table filter
     *
     * @return Form
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Fully update items config
     *
     * @param array $config
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        $this->updateTable();

        return $this;
    }

    /**
     * Add config item
     *
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function addToConfig($key, $value)
    {
        $this->config[$key] = $value;

        $this->updateTable();

        return $this;
    }

    /**
     * Add table titles
     *
     * @param array $fields
     *
     * @return $this
     */
    public function showOnly(... $fields)
    {
        if (is_array($fields[0])) {
            $this->onlyFields = $fields[0];
        } else {
            $this->onlyFields = $fields;
        }
        
        $this->allFields = $this->onlyFields;

        $this->updateTable();

        return $this;
    }


    /**
     * Add items
     *
     * @param $items
     *
     * @return $this
     */
    public function items($items)
    {
        $this->items = $items;

        $this->updateTable();

        return $this;
    }

    /**
     * Prepare pagination
     *
     * @param AbstractPaginator $paginator
     * @param string $action
     * @param bool $stepsChange
     * @param array $availableSteps
     * @param string $paginationStepParam
     * @param string|null $stepUpdateAction
     * @return $this
     */
    public function withPagination(
        AbstractPaginator $paginator,
        string $action,
        bool $stepsChange = false,
        array $availableSteps = [25, 50, 100, 200],
        string $paginationStepParam = 'per_page',
        string $stepUpdateAction = null
    ): self {
        $table = $this->getTable();

        $table->element('pagination_area')
            ->paginator($paginator)
            ->action($action)
            ->stepUpdateAction($stepUpdateAction)
            ->availableSteps($availableSteps)
            ->paginationStepParam($paginationStepParam)
            ->stepsChange($stepsChange)
            ->resultBlockClass('.' . $this->getTableBlockIdentifier());

        return $this;
    }

    /**
     * Prepare simple pagination
     *
     * @param AbstractPaginator $paginator
     * @param string $action
     * @return $this
     */
    public function withSimplePagination(
        AbstractPaginator $paginator,
        string $action
    ): self {
        $table = $this->getTable();

        $table->element('pagination_area')
            ->paginatorSimple($paginator)
            ->action($action)
            ->resultBlockClass('.' . $this->getTableBlockIdentifier());

        return $this;
    }

    /**
     * Update table with new configs
     *
     */
    protected function updateTable()
    {
        $rows = $this->getTableRows();

        $config = $this->config ? $this->config : [];

        if ($this->shouldToolsColumnBeGenerated()) {
            $config['table_tools_column'] = $this->prepareControlButtonsGenerationClosure();

            !$this->onlyFields ?: $this->onlyFields[] = 'table_tools_column';
        }

        if ($this->onlyFields) {
            $rows->only($this->onlyFields);
        }

        $rows->config($config);

        $rows->items($this->items);

        // Expand table titles if not enough set
        $titlesCount = count($this->titles);
        if ($titlesCount == 0) {
            return;
        }


//        $rowItemsCount = count($rows->items());
//        $onlyFieldsCount = count($this->onlyFields);
//        $fieldsCount = $onlyFieldsCount > $rowItemsCount ? $onlyFieldsCount : $rowItemsCount;
//        if($titlesCount < $fieldsCount) {
//
//            $this->titles = array_pad($this->titles, $fieldsCount, '');
//
//        } elseif ($titlesCount > $fieldsCount){
//            foreach ($this->titles as $key => $title) {
//                if(!$title) {
//                    unset($this->titles[$key]);
//                }
//
//                if(count($this->titles) == $fieldsCount) {
//                    break;
//                }
//            }
//        }

        $this->getTable()->param('titles', $this->titles);
    }

    /**
     * Check if tools column should be generated
     *
     * @return bool
     */
    protected function shouldToolsColumnBeGenerated()
    {
        // Generate for resource URL generator
        if (array_first($this->items) instanceof ResourceUrlsAbleContract) {
            return true;
        }

        if ($this->resourceUrlsGeneratorGenerator) {
            return true;
        }

        // Generate for custom or default tools\
        return count($this->toolsCollection) > 0;
    }

    /**
     * Prepare closure for render item control buttons
     *
     * @return Closure
     */
    protected function prepareControlButtonsGenerationClosure()
    {
        $this->controlTableCell = $this->getControlTableCell();

        return function ($item) {
            $width = count($this->toolsCollection) * 50;
            $tableCell = clone $this->controlTableCell;

            if (!$tableCell->attr('style')) {
                $tableCell->attr('style', "min-width:{$width}px");
            }

            foreach ($this->toolsCollection as $callable) {
                $tableCell->addValue($callable($item));
            }

            return $tableCell;
        };
    }

    /**
     * @return TableCell
     */
    public function getControlTableCell(): TableCell
    {
        if (!$this->controlTableCell) {
            $this->controlTableCell = new TableCell();
        }

        return $this->controlTableCell;
    }

    /**
     * Add element to tools collection
     *
     * @param callable $toolsItemClosure
     *
     * @return $this
     */
    public function addElementsToToolsCollection(callable $toolsItemClosure)
    {
        $this->toolsCollection[] = $toolsItemClosure;

        return $this;
    }

    /**
     * @param $item
     *
     * @return string
     */
    protected function prepareEditLink($item)
    {
        if (isset($this->editLinkClosure)) {
            return ($this->editLinkClosure)($item);
        }

        if ($item instanceof ResourceUrlsAbleContract) {
            return $item->resourceUrls()->editUrl();
        }

        return '';
    }

    /**
     * @param $item
     *
     * @return string
     */
    protected function prepareShowLink($item)
    {
        if (isset($this->showLinkClosure)) {
            return ($this->showLinkClosure)($item);
        }

        if ($item instanceof ResourceUrlsAbleContract) {
            return $item->resourceUrls()->showUrl();
        }

        return '';
    }

    /**
     * @param $item
     *
     * @return string
     */
    protected function prepareDestroyLink($item)
    {
        if (isset($this->destroyLinkClosure)) {
            return ($this->destroyLinkClosure)($item);
        }

        if ($item instanceof ResourceUrlsAbleContract) {
            return $item->resourceUrls()->destroyUrl();
        }

        return '';
    }

    /**
     * Add table titles
     *
     * @param array $titles
     *
     * @return $this
     * @throws NoOneFieldsWereDefined
     */
    public function tableTitles(... $titles)
    {
        if (is_array($titles[0])) {
            $titles = $titles[0];
        }
        $this->titles = $this->prepareTitles($titles);
        $this->updateTable();

        return $this;
    }

    /**
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareTitles(array $titles = []): array
    {
        $preparedTitles = [];
        foreach ($titles as $title) {
            $preparedTitles[] = $this->prepareTitle($title);
        }

        return $preparedTitles;
    }

    /**
     * @param TableTitle|string $title
     * @return TableTitle
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareTitle($title): TableTitle
    {
        if (is_string($title)) {
            $title = new TableTitle($title);
        }
        return $title->sortAvailable(false);
    }

    /**
     * Add one table title
     *
     * @param TableTitle|string $title
     * @return $this
     * @throws NoOneFieldsWereDefined
     */
    public function addTableTitle($title)
    {
        $this->titles[] = $this->prepareTitle($title);

        return $this;
    }

    /**
     * @param string      $title
     * @param string      $sortBy
     * @param string      $currentSort
     * @param bool        $notSortedAvailable
     * @param string|null $action
     * @param string      $method
     *
     * @return TableGenerator
     */
    public function addTitleWithSorting(
        string $title,
        string $sortBy,
        string $currentSort = '',
        bool $notSortedAvailable = true,
        string $action = '',
        string $method = 'GET'
    ) {
        $title = (new TableTitle())->title($title)->sortBy($sortBy)
            ->currentSort($currentSort)
            ->action($action)
            ->method($method)
            ->resultReplaceBlockClass('.' . $this->getSortingBlockIdentifier())
            ->noneSortingAvailable($notSortedAvailable);

        $this->titles[] = $title;

        return $this;
    }

    /**
     * Return sorting identifier
     *
     * @return string
     */
    protected function getSortingBlockIdentifier()
    {
        return $this->getTableBlockIdentifier();
    }

    /**
     * Define item edit route
     *
     * @param callable $editLinkClosure
     *
     * @return $this
     */
    public function setEditLinkClosure(callable $editLinkClosure)
    {
        $this->editLinkClosure = $editLinkClosure;

        $editBtnClosure = function ($item) {
            $btn = (new LinkButton())
                ->icon('fas fa-edit')
                ->link($this->prepareEditLink($item))
                ->class('')
                ->js()->tooltip()->regular('Edit');

            if ($this->toolsInModal) {
                $btn->js()->openInModalOnClick()
                    ->regular($this->prepareEditLink($item), 'GET', 'Editing');
            }

            return $btn->render();
        };

        $this->addElementsToToolsCollection($editBtnClosure);

        $this->updateTable();

        return $this;
    }

    /**
     * Route for remove item
     *
     * @param callable    $destroyLinkClosure
     *
     * @param string|null $modalTitle
     * @param string|null $modalContent
     *
     * @return $this
     */
    public function setDestroyLinkClosure(
        callable $destroyLinkClosure,
        string $modalTitle = null,
        string $modalContent = null
    ) {
        $this->destroyLinkClosure = $destroyLinkClosure;

        $destroyBtnClosure = function ($item) use ($modalTitle, $modalContent) {
            $btn = (new LinkJSDelete())
                ->js()->tooltip()->regular('Delete')
                ->icon('fas fa-trash-alt')
                ->classes('text-red')
                ->itemClass($this->prepareItemDeleteIdentifier($item))
                ->requestUri($this->prepareDestroyLink($item))
                ->method('DELETE');

            if($modalTitle !== null){
                $btn->setModalTitle($modalTitle);
            }

            if($modalContent !== null){
                $btn->setModalContent($modalContent);
            }

            return $btn->render();
        };

        $this->addElementsToToolsCollection($destroyBtnClosure);

        $this->updateTable();

        return $this;
    }

    /**
     * Route for remove item
     *
     * @param callable $showLinkClosure
     *
     * @return $this
     */
    public function setShowLinkClosure(callable $showLinkClosure)
    {
        $this->showLinkClosure = $showLinkClosure;

        $showBtnClosure = function ($item) {
            return (new LinkButton())
                ->icon('fas fa-eye')
                ->class('')
                ->link($this->prepareShowLink($item))
                ->js()->tooltip()->regular('View details')
                ->render();
        };

        $this->addElementsToToolsCollection($showBtnClosure);

        $this->updateTable();

        return $this;
    }


    /**
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return Table|TableRowsCollection
     */
    protected function getTableRows()
    {
        return $this->getTable()->rows();
    }

    /**
     * Prepare identifier for mark delete item
     *
     * @param $item
     *
     * @return string
     */
    protected function prepareItemDeleteIdentifier($item)
    {
        return 'js_item_' . $item[$this->itemUniqIdKey];
    }

    /**
     *
     * @param ResourceUrlsGeneratorContract $urlsGenerator
     *
     * @return $this
     */
    public function setEntityResourceUrlsGenerator(ResourceUrlsGeneratorContract $urlsGenerator)
    {
        // Set show link generation closure
        $this->setShowLinkClosure(function($item) use ($urlsGenerator) {
            return $urlsGenerator->setEntity($item)->showUrl();
        });

        // Set edit link generation closure
        $this->setEditLinkClosure(function($item) use ($urlsGenerator) {
            return $urlsGenerator->setEntity($item)->editUrl();
        });

        // Set destroy link generation closure
        $this->setDestroyLinkClosure(function($item) use ($urlsGenerator){
            return $urlsGenerator->setEntity($item)->destroyUrl();
        });

        // Save for crate button generation
        $this->resourceUrlsGeneratorGenerator = $urlsGenerator;

        $this->updateTable();

        return $this;
    }

    /**
     * Render current component and return result string
     *
     * @return string
     */
    public function render(): string
    {
        return $this->getTable()->render();
    }

    /**
     * Convert current object to string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Get all columns with titles
     *
     * @return array
     */
    public function getTableColumns(): array
    {
        $fields = [];
        foreach ($this->allFields as $i => $field) {
            $fields[$field] = $this->titles[$i]->title ?? '';
        }

        return $fields;
    }

    /**
     * Show all columns, reset to initial table view
     *
     * @return void
     */
    protected function resetVisibilityColumns()
    {
        $this->onlyFields = $this->allFields;

        foreach ($this->titles as $i => $tableTitle) {
            $tableTitle->show = 1;
            $tableTitle->field_name = $this->allFields[$i] ?? 'table_tools_column';
        }
    }

    /**
     * Set columns for table
     *
     * @return void
     */
    protected function setTableColumns(string $tableUrl)
    {
        // Check that the table in fields and titles exists
        if (empty($this->onlyFields) || empty($this->titles)) {
            return;
        }

        $this->saveSelectedColumns();

        $this->resetVisibilityColumns();

        $key = Utils::generateTableIdKey($this->allFields, $tableUrl);
        if ($chooseColumns = Cache::get($key)) {

            // Checking if incorrect data is accidentally written
            if (!is_array($chooseColumns)) {
                if (request()->ajax()) {
                    abort(400, 'No column selected');
                }
                return;
            }

            $chooseColumns = array_keys($chooseColumns);

            // Leave fields only those that you choose
            $this->onlyFields = array_filter($this->onlyFields, static function ($field) use ($chooseColumns) {
                return $field == 'table_tools_column' || in_array($field, $chooseColumns);
            });

            // Hide Table title they are not choose
            foreach ($this->titles as $tableTitle) {
                if ($tableTitle->field_name == 'table_tools_column') {
                    continue;
                }
                if (!in_array($tableTitle->field_name, $chooseColumns)) {
                    $tableTitle->show = 0;
                }
            }
        }
        $this->updateTable();
    }

    /**
     * Add the ability to select columns for the table
     *
     * @param string|null $tableUrl
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function addChooseColumns(string $tableUrl = null): self
    {
        if (!$this->filter) {
            $this->addFiltering();
        }

        $tableUrl = $this->prepareTableUrl($tableUrl);

        $this->addButtonChooseColumns($tableUrl);

        $this->setTableColumns($tableUrl);

        return $this;
    }

    /**
     * Add button 'choose columns' in filter area of table
     *
     * @param $tableUrl
     * @return void
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function addButtonChooseColumns($tableUrl)
    {
        $onClickButtonUrl = $this->prepareUrlForButtonChooseColumns($tableUrl);

        $btn = (new DefaultButton())
            ->icon('fa-columns')
            ->class('btn-default')
            ->attrs([
                'data-original-title' => 'Choose columns',
                'data-replace-blk' => ".$this->tableBlockIdentifier",
            ])
            ->js()
            ->openInModalOnClick()
            ->regular($onClickButtonUrl, 'POST', 'Choose columns');

        $this->getFilter()->addContent(new FormGroup($btn));
    }

    /**
     * @param $tableUrl
     * @return string
     */
    protected function prepareUrlForButtonChooseColumns($tableUrl): string
    {
        $parameters = [
            'table_fields' => json_encode($this->getTableColumns()),
            'table_url' => $tableUrl,
            'table_identifier' => $this->tableBlockIdentifier,
        ];

        return route('dashboard.api.columns', $parameters);
    }

    /**
     * @param $tableUrl
     * @return mixed|string
     */
    protected function prepareTableUrl($tableUrl)
    {
        return Utils::appendsAllRequestToURL(
            $tableUrl ?? url()->current(),
            ['table_fields', 'choose_columns', '_method', '_token']
        );
    }

    /**
     * Save selected columns to storage
     *
     * @return void
     */
    protected function saveSelectedColumns()
    {
        if (!request()->exists(['table_fields', 'choose_columns', 'table_url'])) {
            return;
        }

        $tableFields = array_keys(json_decode(request()->input('table_fields'), true));
        $key = Utils::generateTableIdKey($tableFields, request()->input('table_url', url()->current()));

        Cache::forever($key, request()->input('choose_columns'));
    }
}
