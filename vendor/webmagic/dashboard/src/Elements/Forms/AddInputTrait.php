<?php

namespace Webmagic\Dashboard\Elements\Forms;

use Webmagic\Dashboard\Core\ComplexElement;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Core\DataExtractor;
use Webmagic\Dashboard\Core\Renderable;
use Webmagic\Dashboard\Elements\Factories\ElementsFactory;
use Webmagic\Dashboard\Elements\Forms\Elements\FormGroup;

trait AddInputTrait
{
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

        $element = (new ElementsFactory())->select()
            ->name($this->prepareName($name))
            ->options($options)
            ->id($identifier)
            ->required($required)
            ->multiple($multiple)
            ->selectedKeys($selectedKeys)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $selectedKeys = $this->getData($selectedKeys, $name);
        $selectedKeys = array_wrap($selectedKeys);
        $identifier = uniqid();

        $element = (new ElementsFactory())->selectJS()
            ->name($this->prepareName($name))
            ->options($options)
            ->id($identifier)
            ->required($required)
            ->multiple($multiple)
            ->selectedKeys($selectedKeys)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $selectedKeys = $this->getData($selectedKeys, $name);
        $selectedKeys = array_wrap($selectedKeys);
        $identifier = uniqid();

        $element = (new ElementsFactory())->selectJS()
            ->addAutocomplete($requestUrl)
            ->name($this->prepareName($name))
            ->options($options)
            ->id($identifier)
            ->required($required)
            ->multiple($multiple)
            ->selectedKeys($selectedKeys)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = (new ElementsFactory())->input()
            ->name($this->prepareName($name))
            ->required($required)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        // Add simple text input if slug was set before
        if (!is_null($valueOrDataSource)) {
            return $this->textInput($name, $valueOrDataSource, $labelTxt, $required, $attributes);
        }

        $identifier = uniqid();
        $element = (new ElementsFactory())->input()
            ->addClass('js_get-slug')
            ->attr('data-source-name', $sourceName)
            ->attr('data-separator', $separator)
            ->attr('data-transformer', $transformRule)

            ->name($this->prepareName($name))
            ->required($required)
            ->id($identifier)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = (new ElementsFactory())->input()
            ->name($this->prepareName($name))
            ->required($required)
            ->id($identifier)
            ->type('email')
            ->value($value)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = (new ElementsFactory())->input()
            ->name($this->prepareName($name))
            ->required($required)
            ->id($identifier)
            ->type('password')
            ->value($value)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

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

        $element = (new ElementsFactory())->dateInput()
            ->name($this->prepareName($name))
            ->required($required)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

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
        bool $showDropdownsDown = true
    ): self
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = (new ElementsFactory())->dateTimePicker()
            ->name($this->prepareName($name))
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

        $this->addInputElement($element, $identifier, $labelTxt);

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

        $element = (new ElementsFactory())->numberInput()
            ->name($this->prepareName($name))
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

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = (new ElementsFactory())->input()
            ->name($this->prepareName($name))
            ->value($value)
            ->type($type)
            ->required($required)
            ->id($identifier)
            ->placeholder($placeholder)
            ->class($class)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = (new ElementsFactory())->input()
            ->name($this->prepareName($name))
            ->id($identifier)
            ->value($value)
            ->type('hidden');

        $this->addInputElement($element, $identifier);

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
        bool $showDropdownsDown = true
    ): self
    {
        $value = $this->getData($valueOrDataSource, $name);
        $endValue = $this->getData($endValueOrDataSource, $endName);
        $identifier = uniqid();

        $element = (new ElementsFactory())->dateTimePicker()
            ->name($this->prepareName($name))
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

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = (new ElementsFactory())->timeInput()
            ->name($this->prepareName($name))
            ->required($required)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = (new ElementsFactory())->dateTimePicker()
            ->name($this->prepareName($name))
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

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $value = $this->getData($valueOrDataSource, $name);
        $endValue = $this->getData($endValueOrDataSource, $endName);
        $identifier = uniqid();

        $element = (new ElementsFactory())
            ->dateTimePicker()->name($this->prepareName($name))->nameEnd($endName)
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

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = (new ElementsFactory())->dateTimeInput()
            ->name($this->prepareName($name))
            ->required($required)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = (new ElementsFactory())->dateTimePicker()
            ->name($this->prepareName($name))
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
            ->showDropdownsDown($showDropdownsDown);

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = (new ElementsFactory())->input()
            ->name($this->prepareName($name))
            ->type('file')
            ->required($required)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $identifier = uniqid();
        if($multiple) {
            $attributes['multiple'] = 'multiple';
        }

        $requestUrl = $requestUrl ?? route('dashboard.api.image.upload', $name);
        $deleteUrl = $deleteUrl ?? route('dashboard.api.image.delete');

        $element = (new ElementsFactory())->photoUploader()
            ->name($this->prepareName($name))
            ->type('file')
            ->required($required)
            ->id($identifier)
            ->requestUrl($requestUrl)
            ->deleteUrl($deleteUrl)
            ->images(... $images)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = (new ElementsFactory())->color()
            ->name($this->prepareName($name))
            ->required($required)
            ->id($identifier)
            ->value($value)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

        return $this;
    }

    /**
     * Add visual editor
     *
     * @param string      $name
     * @param null        $valueOrDataSource
     * @param string      $labelTxt
     * @param bool        $required
     * @param array       $attributes
     *
     * @param string|null $imageUploadUrl
     *
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
        string $imageUploadUrl = null
    ): self
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $editor = (new ElementsFactory())->visualEditor();
        $editor->name($this->prepareName($name))
            ->required($required)
            ->id($identifier)
            ->content($value)
            ->attrs($attributes);

        // Turn on upload URL if needed
        if($imageUploadUrl){
            $editor->turnOnFileUpload($imageUploadUrl);
        }

        $this->addInputElement($editor, $identifier, $labelTxt);

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
    ): self
    {
        $value = $this->getData($valueOrDataSource, $name);
        $identifier = uniqid();

        $element = (new ElementsFactory())->textarea()
            ->name($this->prepareName($name))
            ->required($required)
            ->id($identifier)
            ->content($value)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $checked = data_get($checkedOrDataSource, $name, false);
        $identifier = uniqid();

        $element = (new ElementsFactory())->checkbox()
            ->name($this->prepareName($name))
            ->id($identifier)
            ->required($required)
            ->checked((bool) $checked)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

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
    ): self
    {
        $checked = data_get($checkedOrDataSource, $name, false);
        $identifier = uniqid();

        $element = (new ElementsFactory())->switcher()
            ->name($this->prepareName($name))
            ->id($identifier)
            ->required($required)
            ->checked((bool) $checked)
            ->attrs($attributes);

        $this->addInputElement($element, $identifier, $labelTxt);

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

        $dateRangeElement = (new ElementsFactory())->dateRange();

        $dateRangeElement
            ->setDateFormat($dateFormat)
            ->name($this->prepareName($name))
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

        $this->addInputElement($dateRangeElement, $identifier, $labelTxt);

        return $this;
    }

    /**
     * Used for rewriting name preparing on other classes
     *
     * @param string $name
     *
     * @return string
     */
    protected function prepareName(string $name): string
    {
        return $name;
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
        return (new DataExtractor($source))->get($key);
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function __call($name, $arguments)
    {
        // Generate exception if addInputElement method is not set
        if($name == 'addInputElement'){
            throw new \Exception('Please, implement addInputElement method before using \Webmagic\Dashboard\Elements\Forms\AddInputTrait');
        }

        return parent::__call($name, $arguments);
    }
}
