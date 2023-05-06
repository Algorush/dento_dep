<?php


namespace Webmagic\Dashboard\Elements;

use Illuminate\Pagination\AbstractPaginator;
use Webmagic\Dashboard\Core\ComplexElement;
use Webmagic\Dashboard\Core\Utils;

/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method Paginator paginatedItems(Illuminate\Pagination\AbstractPaginator $valueOrConfig)
 * @method Paginator addPaginatedItems(Illuminate\Pagination\AbstractPaginator $valueOrConfig)
 * @method Paginator perPage($valueOrConfig)
 * @method Paginator addPerPage($valueOrConfig)
 * @method Paginator resultBlockClass($valueOrConfig)
 * @method Paginator addResultBlockClass($valueOrConfig)
 * @method Paginator addAction($valueOrConfig)
 * @method Paginator stepsChange(bool $valueOrConfig)
 * @method Paginator paginationStepParam($valueOrConfig)
 *
 ********************************************************************************************************************/

class Paginator extends ComplexElement
{
    /** @var  StringElement Component view name */
    protected $view = 'dashboard::components._pagination';

    /** @var string  */
    protected $originalAction = '';

    /** @var  array Sections available in page */
    protected $available_fields = [
        'paginated_items' => [
            'type' => AbstractPaginator::class
        ],
        'per_page' => [
            'default' => 10
        ],
        'result_block_class',
        'action',
        'step_update_action',
        'available_steps' => [
            'type' => 'array'
        ],
        'steps_change' => [
            'type' => 'bool',
            'default' => false
        ],
        'pagination_step_param',
    ];

    /** @var  StringElement Default section for current component */
    protected $default_field = 'paginated_items';

    /**
     * Add action for sending request
     *
     * @param string $action
     * @param bool   $includeRequestQuery
     *
     * @return $this|Paginator
     */
    public function action(string $action, bool $includeRequestQuery = true)
    {
        $this->originalAction = $action;

        if($includeRequestQuery){
            $action = Utils::appendsAllRequestToURL($action, ['_token', 'page', '_method']);
        }

        $this->action = $action;

        return $this;
    }

    /**
     * Per page value defining
     *
     * @return int
     */
    protected function getPerPage(): int
    {
        return $this->per_page ?? $this->paginatedItems()->perPage();
    }

    /**
     * @param array $availableSteps
     * @return $this
     */
    public function availableSteps(array $availableSteps = [])
    {
        $paginatorPerPage = $this->paginatedItems()->perPage();

        if (!is_null($paginatorPerPage) && !in_array($paginatorPerPage, $availableSteps)) {
            $availableSteps[] = $paginatorPerPage;
            $availableSteps = array_sort($availableSteps);
        }

        $this->available_steps = array_combine($availableSteps, $availableSteps);
        $this->steps_change = true;

        return $this;
    }

    /**
     * @param string|null $action
     * @return $this
     */
    public function stepUpdateAction(string $action = null, bool $includeRequestQuery = true)
    {
        $action = $action ?? $this->originalAction;

        if($includeRequestQuery){
            $action = Utils::appendsAllRequestToURL($action, ['_token', 'per_page', 'page']);
        }

        $this->step_update_action = $action;
        $this->steps_change = true;

        return $this;
    }
}
