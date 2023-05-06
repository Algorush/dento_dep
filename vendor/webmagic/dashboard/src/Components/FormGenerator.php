<?php


namespace Webmagic\Dashboard\Components;

use ArrayAccess;
use Webmagic\Dashboard\Core\Renderable;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Elements\Buttons\DefaultButton;
use Webmagic\Dashboard\Elements\Factories\ElementsFactory;
use Webmagic\Dashboard\Elements\Forms\Elements\ClearButton;
use Webmagic\Dashboard\Elements\Forms\Elements\FormGroup;
use Webmagic\Dashboard\Elements\Forms\Form;

class FormGenerator implements Renderable
{
    /** @var Form */
    protected $form;

    /** @var FormGroup */
    protected $submitButtonsGroup;

    /**
     * FormGenerator constructor.
     *
     * @param Form|null $form
     *
     * @throws NoOneFieldsWereDefined
     */
    public function __construct(Form $form = null)
    {
        if (is_null($form)) {
            $form = $this->initNewForm();
        }

        $this->form = $form;
    }

    /**
     * Init new form and set it
     *
     * @throws NoOneFieldsWereDefined
     *
     * @return Form
     */
    protected function initNewForm()
    {
        return (new Form())->ajax();
    }

    /**
     * Set form ajax
     *
     * @param bool $status
     * @param string $resultBlockClass
     * @param string $resultReplaceBlkClass
     * @param bool $successNotification
     * @param bool $errorNotification
     * @param bool $doNotHidePopup
     * @param string|null $successNotificationTitle
     * @param string|null $successNotificationText
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function ajax(
        bool $status = true,
        string $resultBlockClass = '',
        string $resultReplaceBlkClass = '',
        bool $successNotification = true,
        bool $errorNotification = true,
        bool $doNotHidePopup = false,
        string $successNotificationTitle = null,
        string $successNotificationText = null
    ) {
        $this->getForm()->ajax(
            $status,
            $resultBlockClass,
            $resultReplaceBlkClass,
            $successNotification,
            $errorNotification,
            $successNotificationTitle,
            $successNotificationText
        );

        $this->dontHideModalOnSubmit($doNotHidePopup);

        return $this;
    }

    /**
     * Add possibility to not hide the popup on submit
     * For the situation when form submits in a popup
     *
     * @param bool $doNotHidePopup
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function dontHideModalOnSubmit(bool $doNotHidePopup = false)
    {
        $this->getForm()->doNotHidePopupOnSubmit($doNotHidePopup);

        return $this;
    }

    /**
     * Return form
     *
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Set method
     *
     * @param $method
     * @return $this
     */
    public function method($method)
    {
        $this->getForm()->method($method);

        return $this;
    }

    /**
     * Set block for ajax form result
     *
     * @param string $elementClass
     * @return FormGenerator
     */
    public function resultBlockClass(string $elementClass)
    {
        $this->getForm()->resultBlockClass($elementClass);

        return $this;
    }

    /**
     * Set block for ajax form result
     *
     * @param string $elementClass
     * @return FormGenerator
     */
    public function replaceBlockClass(string $elementClass)
    {
        $this->getForm()->resultReplaceBlockClass($elementClass);

        return $this;
    }

    /**
     * Set form action
     *
     * @param $action
     * @return $this
     */
    public function action($action)
    {
        $this->getForm()->action($action);

        return $this;
    }

    /**
     * Add submit button
     *
     * @param string $title
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function submitButton(string $title = null)
    {
        $title = $title ?? trans('dashboard::common.forms.submit');

        $this->addSubmitButton([], $title, ' btn btn-primary float-right ml-2');

        return $this;
    }

    /**
     * Add additional configurable submit button
     *
     * @param array  $attributes
     * @param string $title
     * @param string $class
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function addSubmitButton(
        array $attributes = [],
        string $title = '',
        string $class = ' btn btn-default float-right ml-2'
    ) {
        $btn = (new DefaultButton($title))->type('submit')->class($class);

        foreach ($attributes as $name => $val) {
            $btn->attr($name, $val);
        }

        $this->getSubmitButtonGroup()->addContent($btn);

        return $this;
    }

    /**
     * @param string $title
     *
     * @return FormGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function clearButton(string $title = null)
    {
        $title = $title ?? trans('dashboard::common.forms.clear');

        return $this->addClearButton([], $title);
    }

    /**
     * Add clear button
     *
     * @param array  $attributes
     * @param string $title
     * @param string $class
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function addClearButton(
        array $attributes = [],
        string $title = '',
        string $class = ' btn  btn-danger float-right ml-2'
    ) {
        $btn = (new ClearButton())->value($title)->class($class);

        foreach ($attributes as $name => $val) {
            $btn->attr($name, $val);
        }

        $this->getSubmitButtonGroup()->addContent($btn);

        return $this;
    }

    /**
     * Add link button
     *
     * @param string $link
     * @param string $title
     * @param string $class
     *
     * @param array  $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function addLinkButton(
        string $link,
        string $title = '',
        string $class = ' btn btn-default ml-2',
        array $attributes = []
    ) {
        $this->getSubmitButtonGroup()->addElement()
            ->linkButton($title)
            ->class($class)
            ->link($link)
            ->attrs($attributes);

        return $this;
    }

    /**
     * Generate submit button group
     *
     * @return FormGroup
     * @throws NoOneFieldsWereDefined
     */
    protected function getSubmitButtonGroup() : FormGroup
    {
        if (empty($this->submitButtonsGroup)) {
            $this->submitButtonsGroup = $this->prepareNextFormGroup();
        }

        return $this->submitButtonsGroup;
    }

    /**
     * Add select
     *
     * @param string $name
     * @param array  $options
     * @param string $selectedKeys
     * @param string $labelTxt
     * @param bool   $required
     * @param bool   $multiple
     * @param array  $attributes
     *
     * @return self
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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->select($name, $options, $selectedKeys, $labelTxt, $required, $multiple, $attributes);

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->selectJS($name, $options, $selectedKeys, $labelTxt, $required, $multiple, $attributes);

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->selectWithAutocomplete($name, $requestUrl, $options, $selectedKeys, $labelTxt, $required, $multiple, $attributes);

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->textInput($name, $valueOrDataSource, $labelTxt, $required, $attributes);

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->slugInput($name, $sourceName, $valueOrDataSource, $labelTxt, $required, $separator, $transformRule, $attributes);

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->emailInput($name, $valueOrDataSource, $labelTxt, $required, $attributes);

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->passwordInput($name, $valueOrDataSource, $labelTxt, $required, $attributes);

        return $this;
    }

    /**
     * Add text input
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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->numberInput($name, $valueOrDataSource, $labelTxt, $required, $step, $min, $max, $attributes);

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->input($name, $valueOrDataSource, $labelTxt, $type, $required, $placeholder, $attributes, $class);

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->hiddenInput($name, $valueOrDataSource);

        return $this;
    }

    /**
     * Return content part for adding elements
     *
     * @return Form|null
     */
    protected function getContentPart()
    {
        return $this->form;
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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->dateInput($name, $valueOrDataSource, $labelTxt, $required, $attributes);

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
     * @param string $format
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
        string $format = ''
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->datePickerJS(
                $name,
                $valueOrDataSource,
                $labelTxt,
                $required,
                $attributes,
                $defaultRanges,
                $showMonthsYearsDropdown,
                $minYearForDropdown,
                $maxYearForDropdown,
                $autoApplyDate,
                $showDropdownsDown,
                $format
            );

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
        $this->getContentPart()->addElement()
            ->formGroup()
            ->datePickerFlex(
                $name,
                $valueOrDataSource,
                $labelTxt,
                $required,
                $attributes,
                $verticalPosition,
                $horizontalPosition,
                $showWeekNumber,
                $toolbarPosition,
                $minYear,
                $maxYear,
                $viewMode
            );

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
     * @param bool $showTimeInField
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
        string $format = ''
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->dateRangePicker(
                $name,
                $endName,
                $valueOrDataSource,
                $endValueOrDataSource,
                $labelTxt,
                $required,
                $endRequired,
                $attributes,
                $defaultRanges,
                $showMonthsYearsDropdown,
                $minYearForDropdown,
                $maxYearForDropdown,
                $autoApplyDate,
                $showDropdownsDown,
                $format
            );

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->timeInput($name, $valueOrDataSource, $labelTxt, $required, $attributes);

        return $this;
    }

    /**
     * @param string $name
     * @param null $valueOrDataSource
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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->timeOnlyPickerJS(
                $name,
                $valueOrDataSource,
                $labelTxt,
                $required,
                $attributes,
                $format,
                $verticalPosition,
                $horizontalPosition,
                $toolbarPosition
            );

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->timePickerJS(
                $name,
                $valueOrDataSource,
                $labelTxt,
                $required,
                $attributes,
                $time24Format,
                $showSeconds,
                $showMonthsYearsDropdown,
                $minYearForDropdown,
                $maxYearForDropdown,
                $showDropdownsDown
            );

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->dateTimeRangePicker(
                $name,
                $endName,
                $valueOrDataSource,
                $endValueOrDataSource,
                $labelTxt,
                $required,
                $endRequired,
                $attributes,
                $time24Format,
                $showSeconds,
                $defaultRanges,
                $showMonthsYearsDropdown,
                $minYearForDropdown,
                $maxYearForDropdown,
                $showDropdownsDown
            );

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->dateTimeInput($name, $valueOrDataSource, $labelTxt, $required, $attributes);

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->dateTimePickerJS(
                $name,
                $valueOrDataSource,
                $labelTxt,
                $required,
                $attributes,
                $time24Format,
                $showSeconds,
                $defaultRanges,
                $showMonthsYearsDropdown,
                $minYearForDropdown,
                $maxYearForDropdown,
                $showDropdownsDown
            );

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->fileInput($name, $valueOrDataSource, $labelTxt, $required, $attributes);

        return $this;
    }

    /**
     * Image upload and remove area
     *
     * @param string      $name
     * @param string      $requestUrl
     * @param array       $images
     * @param string      $labelTxt
     * @param bool        $required
     * @param bool        $multiple
     * @param string|null $deleteUrl
     * @param array       $attributes
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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->imageArea($name, $images, $labelTxt, $required, $multiple, $requestUrl, $deleteUrl, $attributes);

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->colorInput($name, $valueOrDataSource, $labelTxt, $required, $attributes);

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
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function textarea(
        string $name,
        $valueOrDataSource = null,
        string $labelTxt = '',
        bool $required = false,
        array $attributes = []
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->textarea($name, $valueOrDataSource, $labelTxt, $required, $attributes);

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->visualEditor($name, $valueOrDataSource, $labelTxt, $required, $attributes, $imageUploadUrl, $urlOnChange,
                $methodOnChange, $showSuccessMessage, $showErrorMessage, $showSpinnerOnBlur
            );

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->checkbox($name, $checkedOrDataSource, $labelTxt, $required, $attributes);

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
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->switcher($name, $checkedOrDataSource, $labelTxt, $required, $attributes);

        return $this;
    }

    /**
     * Add image input
     *
     * @param string      $name
     * @param             $imageUrlOrDataSource
     * @param string      $title
     * @param string      $size
     * @param string      $width
     * @param string      $height
     * @param string|null $downloadUrl
     * @param string|null $fileName
     * @param array       $attributes
     *
     * @return $this
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function imageInput(
        string $name,
        $imageUrlOrDataSource,
        string $title = '',
        string $size = '',
        string $width = '',
        string $height = '',
        string $downloadUrl = null,
        string $fileName = null,
        array $attributes = []
    ) {
        $imgUrl = data_get($imageUrlOrDataSource, null);
        $imgBlock = app(ElementsFactory::class)->imageInput([
            'name' => $name,
            'img_url' => $imgUrl,
            'size' => $size,
            'width' => $width,
            'height' => $height,
            'title' => $title,
        ])->attrs($attributes);

        if (!is_null($downloadUrl)) {
            $imgBlock->downloadUrl($downloadUrl);
        }

        if (!is_null($fileName)) {
            $imgBlock->fileName($fileName);
        }
        $this->getContentPart()->addContent($imgBlock);

        return $this;
    }

    /**
     * Set success notification status
     *
     * @param bool $status
     *
     * @return $this
     */
    public function successNotification(bool $status = true)
    {
        $this->getForm()->successNotifications($status);

        return $this;
    }

    /**
     * Set success notification status
     *
     * @param bool $status
     *
     * @return $this
     */
    public function errorNotification(bool $status = true)
    {
        $this->getForm()->errorNotifications($status);

        return $this;
    }

    /**
     * Add new form group
     *
     * @param string $labelTxt
     * @param string $labelId
     *
     * @return FormGroup
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareNextFormGroup(string $labelTxt = '', string $labelId = '', string $class = 'clearfix')
    {
        return $this->getContentPart()->addElement()
            ->formGroup()->labelTxt($labelTxt)->labelId($labelId)->content('')->class($class);
    }

    /**
     * Get data from source
     *
     * @param $source
     * @param $key
     * @return mixed
     */
    protected function getData($source, $key)
    {
        return is_array($source) || $source instanceof ArrayAccess ? data_get($source, $key, '') : $source;
    }

    /**
     * Render current component and return result string
     *
     * @return string
     */
    public function render(): string
    {
        return $this->form->render();
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
     * Add dateRange based on select
     *
     * @param string $name
     * @param string $labelTxt
     * @param string $dateFormat
     * @param bool $required
     * @param array $attributes
     * @param bool $emptyValue
     * @return self
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function dateRange(
        string $name,
        string $labelTxt = '',
        string $dateFormat = '',
        bool $required = false,
        bool $emptyValue = true,
        array $attributes = []
    ) {
        $this->getContentPart()->addElement()
            ->formGroup()
            ->dateRange($name, $labelTxt, $dateFormat, $required, $emptyValue, $attributes);
        return $this;
    }
}
