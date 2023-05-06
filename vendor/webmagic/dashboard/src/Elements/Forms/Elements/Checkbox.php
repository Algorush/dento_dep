<?php


namespace Webmagic\Dashboard\Elements\Forms\Elements;

use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Elements\Forms\MultifieldsElements\MultifieldsAvailable;
use Webmagic\Dashboard\Core\ComplexElement;

/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method Checkbox id($valueOrConfig)
 * @method Checkbox class($valueOrConfig)
 * @method Checkbox addClass($valueOrConfig)
 * @method Checkbox checked(bool $valueOrConfig)
 * @method Checkbox required(bool $valueOrConfig)
 * @method Checkbox value($valueOrConfig)
 * @method Checkbox name($valueOrConfig)
 * @method Checkbox text($valueOrConfig)
 * @method Checkbox addText($valueOrConfig)
 *
 ********************************************************************************************************************/

class Checkbox extends ComplexElement implements MultifieldsAvailable
{
    protected $view = 'dashboard::components.form.elements.checkbox';

    protected $available_fields = [
        'id',
        'class',
        'checked' => [
            'type' => 'bool',
            'default' => false
        ],
        'required' => [
            'type' => 'bool',
            'default' => false
        ],
        'value' => [
            'default' => 'true'
        ],
        'name',
        'text'
    ];

    /** @var  string Default section for current component */
    protected $default_field = 'text';

    /**
     * Input constructor.
     *
     * @param null $content
     *
     * @throws NoOneFieldsWereDefined
     */
    public function __construct($content = null)
    {
        parent::__construct($content);

        $this->id = uniqid();
    }

    /**
     * Name field validation
     *
     * @param $value
     * @return bool
     */
    public function isValidNameFieldValue($value)
    {
        return strlen($value) > 0;
    }
}
