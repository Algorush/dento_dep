<?php


namespace Webmagic\Dashboard\Elements\Forms\Elements;

use ArrayAccess;
use Webmagic\Dashboard\Core\ComplexElement;
use Webmagic\Dashboard\Core\Content\ContentFieldsUsable;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;

/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method FormGroup class($valueOrConfig)
 * @method FormGroup addClass($valueOrConfig)
 * @method FormGroup labelId($valueOrConfig)
 * @method FormGroup addLabelId($valueOrConfig)
 * @method FormGroup labelTxt($valueOrConfig)
 * @method FormGroup addLabelTxt($valueOrConfig)
 * @method FormGroup formGroupContent($valueOrConfig)
 * @method FormGroup addFormGroupContent($valueOrConfig)
 * @method FormGroup wrapField($valueOrConfig)
 * @method FormGroup addWrapField($valueOrConfig)
 *
 *******************************************************************************************************************
 * @property ContentFieldsUsable|Input form_group_content
 */

class FormGroup extends ComplexElement
{
    /**
     * @var string
     */
    protected $view = 'dashboard::elements.forms.elements.form_group';

    /**
     * @var string[]
     */
    protected $available_fields = [
        'class',
        'label_id',
        'label_txt',
        'form_group_content',
        'wrap_field'
    ];

    /** @var  string Default section for current component */
    protected $default_field = 'form_group_content';

    /**
     * FormGroup constructor.
     *
     * @param null $content
     *
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function __construct($content = null)
    {
        parent::__construct($content);

        //Set default input, if did not set
        if (empty($this->form_group_content)) {
            $this->setInput(new Input);
        }
    }

    /**
     * Set input param
     *
     * @param Input $input
     *
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function setInput(Input $input)
    {
        $id = $input->param('id');
        $this->param('label_id', $id);
        $this->form_group_content = $input;
    }

    /**
    * Add select
    *
    * @param string $name
    * @param array $options
    * @param string $selectedKeys
    * @param string $labelTxt
    * @param bool $required
    * @param bool $multiple
    * @param array $attributes
    *
    * @return $this
    * @throws FieldUnavailable
    * @throws NoOneFieldsWereDefined
    */
    public function select(
        string $name,
        array $options,
        $selectedKeys = '',
        string $labelTxt = '',
        bool $required = false,
        bool $multiple = false,
        array $attributes = []
    ): self {

        /// Get one selected key value if not multiple mode activated
        ///  or $selectedKeys doesn't look like array with selected keys
        if(!$multiple || !is_array($selectedKeys) || key_exists($name, $selectedKeys)){
            $selectedKeys = $this->getData($selectedKeys, $name);
            $selectedKeys = array_wrap($selectedKeys);
        }

        $identifier = uniqid();

        $element = $this->element()->select()
            ->name($name)
            ->options($options)
            ->id($identifier)
            ->required($required)
            ->multiple($multiple)
            ->selectedKeys($selectedKeys)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add select implemented with js
     *
     * @param string $name
     * @param array  $options
     * @param string $selectedKeys
     * @param string $labelTxt
     * @param bool   $required
     * @param bool   $multiple
     *
     * @param array  $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function selectJS(
        string $name,
        array $options,
        $selectedKeys = '',
        string $labelTxt = '',
        bool $required = false,
        bool $multiple = false,
        array $attributes = []
    ): FormGroup
    {
        $selectedKeys = $this->getData($selectedKeys, $name);
        $selectedKeys = array_wrap($selectedKeys);
        $identifier = uniqid();

        $element = $this->element()->selectJS()
            ->name($name)
            ->options($options)
            ->id($identifier)
            ->required($required)
            ->multiple($multiple)
            ->selectedKeys($selectedKeys)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add select implemented with js with autocomplete
     *
     * @param string $name
     * @param string $requestUrl
     * @param array $options
     * @param string $selectedKeys
     * @param string $labelTxt
     * @param bool $required
     * @param bool $multiple
     *
     * @param array $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function selectWithAutocomplete(
        string $name,
        string $requestUrl,
        array $options = [],
        $selectedKeys = '',
        string $labelTxt = '',
        bool $required = false,
        bool $multiple = false,
        array $attributes = []
    ): FormGroup
    {
        $selectedKeys = $this->getData($selectedKeys, $name);
        $selectedKeys = array_wrap($selectedKeys);
        $identifier = uniqid();

        $element = $this->element()->selectJS()
            ->addAutocomplete($requestUrl)
            ->name($name)
            ->options($options)
            ->id($identifier)
            ->required($required)
            ->multiple($multiple)
            ->selectedKeys($selectedKeys)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add text input
     *
     * @param string $name
     * @param null   $valueOrDataSource
     * @param string $labelTxt
     * @param bool   $required
     * @param array  $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function textInput(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = []
    ): FormGroup
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = $this->element()->input()
            ->name($name)
            ->required($required)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add text input
     *
     * @param string $name
     * @param string $sourceName
     * @param null   $valueOrDataSource
     * @param string $labelTxt
     * @param bool   $required
     * @param string $separator
     * @param string $transformRule - possible options: 'lowercase', 'uppercase', 'false'
     * @param array  $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function slugInput(
        string $name,
        string $sourceName,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        string $separator = '-',
        string $transformRule = 'lowercase',
        array $attributes = []
    ): FormGroup
    {
        // Add simple text input if slug was set before
        if (!is_null($valueOrDataSource)) {
            return $this->textInput($name, $valueOrDataSource, $labelTxt, $required, $attributes);
        }

        $identifier = uniqid();
        $element = $this->element()->input()
            ->addClass('js_get-slug')
            ->attr('data-source-name', $sourceName)
            ->attr('data-separator', $separator)
            ->attr('data-transformer', $transformRule)

            ->name($name)
            ->required($required)
            ->id($identifier)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add email input
     *
     * @param string $name
     * @param null   $valueOrDataSource
     * @param string $labelTxt
     * @param bool   $required
     * @param array  $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function emailInput(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = []
    ): FormGroup
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = $this->element()->input()
            ->name($name)
            ->required($required)
            ->id($identifier)
            ->type('email')
            ->value($value)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add password input
     *
     * @param string $name
     * @param null   $valueOrDataSource
     * @param string $labelTxt
     * @param bool   $required
     * @param array  $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function passwordInput(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = []
    ): FormGroup
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = $this->element()->input()
            ->name($name)
            ->required($required)
            ->id($identifier)
            ->type('password')
            ->value($value)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add date input
     *
     * @param string $name
     * @param null   $valueOrDataSource
     * @param string $labelTxt
     * @param bool   $required
     * @param array  $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function dateInput(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = []
    ): self {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = $this->element()->dateInput()
            ->name($name)
            ->required($required)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add date picker JS
     *
     * @param string $name
     * @param null $valueOrDataSource
     * @param string $labelTxt
     * @param bool $required
     * @param array $attributes
     * @param bool $defaultRanges
     * @param bool $showMonthsYearsDropdown
     * @param int|null $minYearForDropdown
     * @param int|null $maxYearForDropdown
     * @param bool $autoApplyDate
     * @param bool $showDropdownsDown
     * @param string|null $format
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function datePickerJS(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = [],
        bool $defaultRanges = false,
        bool $showMonthsYearsDropdown = false,
        int $minYearForDropdown = null,
        int $maxYearForDropdown = null,
        bool $autoApplyDate = false,
        bool $showDropdownsDown = true,
        string $format = null
    ): self {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = $this->element()->dateTimePicker();

        if ($format) {
            $element->setDateFormat($format);
        }

        $element
            ->name($name)
            ->required($required)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes)
            ->defaultRanges($defaultRanges)
            ->showMonthsYearsDropdown($showMonthsYearsDropdown)
            ->minYearForDropdown($minYearForDropdown)
            ->maxYearForDropdown($maxYearForDropdown)
            ->autoApplyDate($autoApplyDate)
            ->showDropdownsDown($showDropdownsDown);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Date picker flex
     *
     * @param string $name
     * @param $valueOrDataSource
     * @param string $labelTxt
     * @param bool $required
     * @param array $attributes
     * @param string $verticalPosition
     * @param string $horizontalPosition
     * @param bool $showWeekNumber
     * @param string $toolbarPosition
     * @param int|null $minYear
     * @param int|null $maxYear
     * @param string $viewMode
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function datePickerFlex(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = [],
        string $verticalPosition = 'bottom',
        string $horizontalPosition = 'right',
        bool $showWeekNumber = false,
        string $toolbarPosition = 'top',
        int $minYear = null,
        int $maxYear = null,
        string $viewMode = 'months'
    ): self {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = $this->element()->flexibleDateTimePicker()
            ->name($name)
            ->required($required)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes)
            ->verticalPosition($verticalPosition)
            ->horizontalPosition($horizontalPosition)
            ->showWeekNumber($showWeekNumber)
            ->toolbarPosition($toolbarPosition)
            ->viewMode($viewMode);

        if ($minYear) {
            $element->minYear($minYear);
        }

        if ($maxYear) {
            $element->maxYear($maxYear);
        }

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add number input
     *
     * @param string     $name
     * @param null       $valueOrDataSource
     * @param string     $labelTxt
     * @param bool       $required
     * @param float      $step
     * @param float|null $min
     * @param float|null $max
     *
     * @param array      $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function numberInput(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        float $step = 1,
        float $min = null,
        float $max = null,
        array $attributes = []
    ): self
    {
        $identifier = uniqid();
        $value = $this->getData($valueOrDataSource, $name);

        $element = $this->element()->numberInput()
            ->name($name)
            ->required($required)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes);

        $element->step($step);

        if (!is_null($min)) {
            $element->min($min);
        }

        if (!is_null($max)) {
            $element->max($max);
        }

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add custom input
     *
     * @param string $name
     * @param null $valueOrDataSource
     * @param string $labelTxt
     * @param string $type
     * @param bool $required
     * @param string|null $placeholder
     * @param array|null $attributes
     * @param string $class
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function input(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        string $type = 'text',
        bool $required = false,
        string $placeholder = null,
        array $attributes = [],
        string $class = ' form-control '
    ): FormGroup
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = $this->element()->input()
            ->name($name)
            ->value($value)
            ->type($type)
            ->required($required)
            ->id($identifier)
            ->placeholder($placeholder)
            ->class($class)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add hidden input
     *
     * @param string $name
     * @param null   $valueOrDataSource
     *
     * @return $this
     * @throws NoOneFieldsWereDefined
     */
    public function hiddenInput(
        string $name,
        $valueOrDataSource = null
    ): FormGroup
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $this->element()->input()
            ->name($name)
            ->id($identifier)
            ->value($value)
            ->type('hidden');

        return $this;
    }

    /**
     * Date range picker
     *
     * @param string $name
     * @param string $endName
     * @param null $valueOrDataSource
     * @param null $endValueOrDataSource
     * @param string $labelTxt
     * @param bool $required
     * @param bool $endRequired
     * @param array $attributes
     * @param bool $defaultRanges
     * @param bool $showMonthsYearsDropdown
     * @param int|null $minYearForDropdown
     * @param int|null $maxYearForDropdown
     * @param bool $autoApplyDate
     * @param bool $showDropdownsDown
     * @param string|null $format
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function dateRangePicker(
        string $name,
        string $endName,
        $valueOrDataSource = null,
        $endValueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        bool $endRequired = false,
        array $attributes = [],
        bool $defaultRanges = false,
        bool $showMonthsYearsDropdown = false,
        int $minYearForDropdown = null,
        int $maxYearForDropdown = null,
        bool $autoApplyDate = false,
        bool $showDropdownsDown = true,
        string $format = null
    ): FormGroup
    {
        $value = $this->getData($valueOrDataSource, $name);
        $endValue = $this->getData($endValueOrDataSource, $endName);
        $identifier = uniqid();

        $element = $this->element()->dateTimePicker();

        if ($format) {
            $element->setDateFormat($format);
        }

        $element
            ->name($name)
            ->nameEnd($endName)
            ->required($required)
            ->requiredEnd($endRequired)
            ->id($identifier)
            ->value($value)
            ->range(true)
            ->valueEnd($endValue)
            ->attrs($attributes)
            ->defaultRanges($defaultRanges)
            ->showMonthsYearsDropdown($showMonthsYearsDropdown)
            ->minYearForDropdown($minYearForDropdown)
            ->maxYearForDropdown($maxYearForDropdown)
            ->autoApplyDate($autoApplyDate)
            ->showDropdownsDown($showDropdownsDown);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add time input
     *
     * @param string $name
     * @param null   $valueOrDataSource
     * @param string $labelTxt
     * @param bool   $required
     * @param array  $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function timeInput(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = []
    ): FormGroup
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = $this->element()->timeInput()
            ->name($name)
            ->required($required)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * @param string $name
     * @param $valueOrDataSource
     * @param string $labelTxt
     * @param bool $required
     * @param array $attributes
     * @param string $format
     * @param string $verticalPosition
     * @param string $horizontalPosition
     * @param string $toolbarPosition
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function timeOnlyPickerJS(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = [],
        string $format = 'H:i:s',
        string $verticalPosition = 'bottom',
        string $horizontalPosition = 'right',
        string $toolbarPosition = 'top'
    ): FormGroup {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = $this->element()->flexibleDateTimePicker()
            ->name($name)
            ->required($required)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes)
            ->verticalPosition($verticalPosition)
            ->horizontalPosition($horizontalPosition)
            ->toolbarPosition($toolbarPosition);

        $element->setDateFormat($format);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add time input
     *
     * @param string $name
     * @param null $valueOrDataSource
     * @param string $labelTxt
     * @param bool $required
     * @param array $attributes
     * @param bool $time24Format
     * @param bool $showSeconds
     * @param bool $showMonthsYearsDropdown
     * @param int|null $minYearForDropdown
     * @param int|null $maxYearForDropdown
     * @param bool $showDropdownsDown
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function timePickerJS(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = [],
        bool $time24Format = true,
        bool $showSeconds = true,
        bool $showMonthsYearsDropdown = false,
        int $minYearForDropdown = null,
        int $maxYearForDropdown = null,
        bool $showDropdownsDown = true
    ): FormGroup
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = $this->element()->dateTimePicker()
            ->name($name)
            ->required($required)
            ->time(true)
            ->date(false)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes)
            ->time24format($time24Format)
            ->seconds($showSeconds)
            ->showMonthsYearsDropdown($showMonthsYearsDropdown)
            ->minYearForDropdown($minYearForDropdown)
            ->maxYearForDropdown($maxYearForDropdown)
            ->showDropdownsDown($showDropdownsDown);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Date and time range picker
     *
     * @param string $name
     * @param string $endName
     * @param null $valueOrDataSource
     * @param null $endValueOrDataSource
     * @param string $labelTxt
     * @param bool $required
     * @param bool $endRequired
     *
     * @param array $attributes
     * @param bool $time24Format
     * @param bool $showSeconds
     * @param bool $defaultRanges
     * @param bool $showMonthsYearsDropdown
     * @param int|null $minYearForDropdown
     * @param int|null $maxYearForDropdown
     * @param bool $showDropdownsDown
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function dateTimeRangePicker(
        string $name,
        string $endName,
        $valueOrDataSource = null,
        $endValueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        bool $endRequired = false,
        array $attributes = [],
        bool $time24Format = true,
        bool $showSeconds = true,
        bool $defaultRanges = false,
        bool $showMonthsYearsDropdown = false,
        int $minYearForDropdown = null,
        int $maxYearForDropdown = null,
        bool $showDropdownsDown = true
    ): FormGroup
    {
        $value = $this->getData($valueOrDataSource, $name);
        $endValue = $this->getData($endValueOrDataSource, $endName);
        $identifier = uniqid();

        $element = $this->element()
            ->dateTimePicker()->name($name)->nameEnd($endName)
            ->required($required)
            ->requiredEnd($endRequired)
            ->id($identifier)
            ->value($value)
            ->time(true)
            ->range(true)
            ->valueEnd($endValue)
            ->attrs($attributes)
            ->time24format($time24Format)
            ->seconds($showSeconds)
            ->defaultRanges($defaultRanges)
            ->showMonthsYearsDropdown($showMonthsYearsDropdown)
            ->minYearForDropdown($minYearForDropdown)
            ->maxYearForDropdown($maxYearForDropdown)
            ->showDropdownsDown($showDropdownsDown);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add time input
     *
     * @param string $name
     * @param null   $valueOrDataSource
     * @param string $labelTxt
     * @param bool   $required
     * @param array  $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function dateTimeInput(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = []
    ): FormGroup
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = $this->element()->dateTimeInput()
            ->name($name)
            ->required($required)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Prepare date time picker
     *
     * @param string $name
     * @param null $valueOrDataSource
     * @param string $labelTxt
     * @param bool $required
     * @param array $attributes
     * @param bool $time24Format
     * @param bool $showSeconds
     * @param bool $defaultRanges
     * @param bool $showMonthsYearsDropdown
     * @param int|null $minYearForDropdown
     * @param int|null $maxYearForDropdown
     * @param bool $showDropdownsDown
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function dateTimePickerJS(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = [],
        bool $time24Format = true,
        bool $showSeconds = true,
        bool $defaultRanges = false,
        bool $showMonthsYearsDropdown = false,
        int $minYearForDropdown = null,
        int $maxYearForDropdown = null,
        bool $showDropdownsDown = true
    ): FormGroup
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = $this->element()->dateTimePicker()
            ->name($name)
            ->required($required)
            ->id($identifier)
            ->time(true)
            ->value($value)
            ->attrs($attributes)
            ->time24format($time24Format)
            ->seconds($showSeconds)
            ->defaultRanges($defaultRanges)
            ->showMonthsYearsDropdown($showMonthsYearsDropdown)
            ->minYearForDropdown($minYearForDropdown)
            ->maxYearForDropdown($maxYearForDropdown)
            ->showDropdownsDown($showDropdownsDown)
        ;

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add file input
     *
     * @param string $name
     * @param null   $valueOrDataSource
     * @param string $labelTxt
     * @param bool   $required
     * @param array  $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function fileInput(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = []
    ): FormGroup
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = $this->element()->input()
            ->name($name)
            ->type('file')
            ->required($required)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Image upload and remove area
     *
     * @param string $name
     * @param array $images
     * @param string $labelTxt
     * @param bool $required
     * @param bool $multiple
     * @param string|null $requestUrl
     * @param string|null $deleteUrl
     * @param array $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function imageArea(
        string $name,
        array $images = [],
        string $labelTxt = '',
        bool $required = false,
        bool $multiple = true,
        string $requestUrl = null,
        string $deleteUrl = null,
        array $attributes = []
    ): FormGroup
    {
        $identifier = uniqid();
        if($multiple) {
            $attributes['multiple'] = 'multiple';
        }

        $requestUrl = $requestUrl ?? route('dashboard.api.image.upload', $name);
        $deleteUrl = $deleteUrl ?? route('dashboard.api.image.delete');

        $element = $this->element()->photoUploader()
            ->name($name)
            ->type('file')
            ->required($required)
            ->id($identifier)
            ->requestUrl($requestUrl)
            ->deleteUrl($deleteUrl)
            ->images(... $images)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add color picker input
     *
     * @param string $name
     * @param null   $valueOrDataSource
     * @param string $labelTxt
     * @param bool   $required
     * @param array  $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function colorInput(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = []
    ): FormGroup
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = $this->element()->color()
            ->name($name)
            ->required($required)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add visual editor
     *
     * @param string $name
     * @param null $valueOrDataSource
     * @param string $labelTxt
     * @param bool $required
     * @param array $attributes
     *
     * @param string|null $imageUploadUrl
     * @param string|null $urlOnChange
     * @param string $methodOnChange
     * @param bool $showSuccessMessage
     * @param bool $showErrorMessage
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function visualEditor(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = [],
        string $imageUploadUrl = null,
        string $urlOnChange = null,
        string $methodOnChange = 'POST',
        bool $showSuccessMessage = false,
        bool $showErrorMessage = true,
        bool $showSpinnerOnBlur = true
    ): FormGroup
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $editor = $this->element()->visualEditor();
        $editor->name($name)
            ->required($required)
            ->id($identifier)
            ->content($value)
            ->attrs($attributes)
            ->showSpinnerOnBlur($showSpinnerOnBlur);

        // Turn on upload URL if needed
        if($imageUploadUrl){
            $editor->turnOnFileUpload($imageUploadUrl);
        }

        if ($urlOnChange) {
            $editor->urlOnBlur($urlOnChange);
        }

        if ($methodOnChange) {
            $editor->methodOnBlur($methodOnChange);
        }

        if ($showSuccessMessage) {
            $editor->showSuccessMessage($showSuccessMessage);
        }

        if ($showErrorMessage) {
            $editor->showErrorMessage($showErrorMessage);
        }

        $this->labelTxt($labelTxt)->labelId($identifier)->content($editor);

        return $this;
    }

    /**
     * Add textarea
     *
     * @param string $name
     * @param null   $valueOrDataSource
     * @param string $labelTxt
     * @param bool   $required
     * @param array  $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function textarea(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = []
    ): FormGroup
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = $this->element()->textarea()
            ->name($name)
            ->required($required)
            ->id($identifier)
            ->content($value)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add checkbox
     *
     * @param string $name
     * @param bool   $checkedOrDataSource
     * @param string $labelTxt
     * @param bool   $required `
     * @param array  $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function checkbox(
        string $name,
        $checkedOrDataSource = false,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = []
    ): FormGroup
    {
        $checked = data_get($checkedOrDataSource, $name, false);
        $identifier = uniqid();

        $element = $this->element()->checkbox()
            ->name($name)
            ->id($identifier)
            ->required($required)
            ->checked((bool) $checked)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }

    /**
     * Add switcher
     *
     * @param string $name
     * @param bool   $checkedOrDataSource
     * @param string $labelTxt
     * @param bool   $required
     * @param array  $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function switcher(
        string $name,
        $checkedOrDataSource = false,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = []
    ): FormGroup
    {
        $checked = data_get($checkedOrDataSource, $name, false);
        $identifier = uniqid();

        $element = $this->element()->switcher()
            ->name($name)
            ->id($identifier)
            ->required($required)
            ->checked((bool) $checked)
            ->attrs($attributes);

        $this->labelTxt($labelTxt)->labelId($identifier)->content($element);

        return $this;
    }


    /**
     * Add dateRange based on select
     *
     * @param string $name
     * @param string $labelTxt
     * @param string $dateFormat
     * @param bool $required
     * @param bool $emptyValue
     * @param array $customRange
     * @param array $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function dateRange(
        string $name,
        string $labelTxt = '',
        string $dateFormat = '',
        bool $required = false,
        bool $emptyValue = true,
        array $customRange = [],
        array $attributes = []
    ) : self {
        $identifier = uniqid();

        $dateRangeElement = $this->element()->dateRange();

        $dateRangeElement
            ->setDateFormat($dateFormat)
            ->name($name)
            ->id($identifier)
            ->required($required)
        ;

        if ($emptyValue) {
            $dateRangeElement->addEmptyLine();
        }

        $dateRangeElement->attrs($attributes);

        foreach ($customRange as $key => $v) {
            $title = $customRange[$key][0];
            $dateStart = $customRange[$key][1];
            $dateEnd = $customRange[$key][2] ?? $dateStart;

            $dateRangeElement->addRange($title, $dateStart, $dateEnd);
        }

        $this->labelTxt($labelTxt)->labelId($identifier)->content($dateRangeElement);

        return $this;
    }

    /**
     * set or add attribute value
     *
     * @param ComplexElement $el
     * @param array $attributes
     */
    protected function setAttributes(ComplexElement $el, array $attributes) {
        foreach ($attributes as $name => $val) {
            $el->$name($val);
        }
    }

    /**
     * @param $source
     * @param $key
     * @return mixed
     */
    protected function getData($source, $key)
    {
        return is_array($source) || $source instanceof ArrayAccess ? data_get($source, $key, '') : $source;
    }

}
