<?php


namespace Webmagic\Dashboard\Elements\Forms\Elements;



use Exception;
use Throwable;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Docs\Services\SelectWithAutocompleteResponseFormatter;
use Webmagic\Dashboard\Elements\Forms\MultifieldsElements\MultifieldsAvailable;

/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS id($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS addId($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS name($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS addName($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS class($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS addClass($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS multiple(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS addMultiple(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS placeholder($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS addPlaceholder($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS options(array $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS addOptions(array $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS selectedKey($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS addSelectedKey($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS selectedKeys(array $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS addSelectedKeys(array $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS required(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS addRequired(bool $valueOrConfig)
 *
 ********************************************************************************************************************/

class SelectJS extends Select implements MultifieldsAvailable
{
    /**
     * SelectJS constructor.
     *
     * @param null $content
     *
     * @throws NoOneFieldsWereDefined
     */
    public function __construct($content = null)
    {
        parent::__construct($content);

        $this->addClass('js-select2');
    }

    /**
     * Activate autocomplete mode
     *
     * @param string $requestUrl
     * @param string $placeholder
     *
     * @return $this
     * @throws NoOneFieldsWereDefined
     * @throws FieldUnavailable
     */
    public function addAutocomplete(string $requestUrl, string $placeholder = 'Search')
    {
        // Remove old and add new class
        $this->replaceClass('js-select2', 'js-select2-ajax');

        $this->placeholder($placeholder);

        $this->attrs([
            'data-url' => $requestUrl
        ]);

        return $this;
    }

    /**
     * @param $items
     * @return array
     * @throws Throwable
     */
    public function prepareResponseForAutocomplete($items): array
    {
        throw_unless(is_iterable($items), new Exception('Variable $items MUST be iterable'));

        $responseFormatter = new SelectWithAutocompleteResponseFormatter();
        foreach ($items as $itemId => $itemTitle) {
            $responseFormatter->addResultRow($itemId, $itemTitle);
        }

        return $responseFormatter->get();
    }
}
