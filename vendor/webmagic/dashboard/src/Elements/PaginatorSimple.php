<?php


namespace Webmagic\Dashboard\Elements;

use Illuminate\Pagination\AbstractPaginator;
use Webmagic\Dashboard\Core\ComplexElement;
use Webmagic\Dashboard\Core\Utils;

/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method \Webmagic\Dashboard\Elements\PaginatorSimple paginatedItems(\Illuminate\Pagination\AbstractPaginator $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\PaginatorSimple resultBlockClass($valueOrConfig)
 *
 ********************************************************************************************************************/

class PaginatorSimple extends ComplexElement
{
    /** @var  StringElement Component view name */
    protected $view = 'dashboard::components._pagination_simple';

    /** @var string  */
    protected $originalAction = '';

    /** @var  array Sections available in page */
    protected $available_fields = [
        'paginated_items' => [
            'type' => AbstractPaginator::class
        ],
        'result_block_class',
        'action',
    ];

    /** @var  StringElement Default section for current component */
    protected $default_field = 'paginated_items';

    /**
     * Add action for sending request
     *
     * @param string $action
     * @param bool   $includeRequestQuery
     *
     * @return $this|self
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
}
