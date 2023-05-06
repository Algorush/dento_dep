<?php


namespace Webmagic\Dashboard\Elements\Forms\Elements;

use Carbon\Carbon;
use Webmagic\Dashboard\Core\PHPDatesFormatHelper;
use Webmagic\Dashboard\Elements\Forms\MultifieldsElements\MultifieldsAvailable;

/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker id($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker name($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker nameEnd($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker value($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker valueEnd($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker range(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker required(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker requiredEnd(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker date(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker time(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker format(string $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker time24format(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker seconds(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker defaultRanges(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker showMonthsYearsDropdown(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker autoApplyDate(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker minYearForDropdown($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker maxYearForDropdown($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker showDropdownsDown(bool $valueOrConfig)
 *
 ********************************************************************************************************************/

class DateTimePicker extends Input implements MultifieldsAvailable
{
    /** @var  string Component view name */
    protected $view = 'dashboard::elements.forms.elements.date_time_picker';

    /** @var  array Sections available in page */
    protected $available_fields = [
        'id',
        'name',
        'name_end',
        'value',
        'value_end',
        'range' => [
            'type' => 'bool',
            'default' => false
        ],
        'required' => [
            'type' => 'bool',
            'default' => false

        ],
        'required_end' => [
            'type' => 'bool',
            'default' => false

        ],
        'date' => [
            'type' => 'bool',
            'default' => true
        ],
        'time' => [
            'type' => 'bool',
            'default' => false
        ],
        'js_date_format' => [
            'type' => 'string',
            'default' => 'Y/MM/DD H:mm',
        ],
        'php_date_format' => [
            'type' => 'string',
            'default' => 'Y/m/d H:i:s',
        ],
        'time24format' => [
            'type' => 'bool',
            'default' => true
        ],
        'seconds' => [
            'type' => 'bool',
            'default' => true
        ],
        'default_ranges' => [
            'type' => 'bool',
            'default' => false
        ],
        'show_months_years_dropdown' => [
            'default' => false
        ],
        'auto_apply_date' => [
            'default' => false
        ],
        'min_year_for_dropdown',
        'max_year_for_dropdown',
        'show_dropdowns_down' => [
            'default' => true
        ],
    ];

    protected $php_date_format = 'Y/m/d H:i:s';
    protected $js_date_format = 'Y/MM/DD H:mm';

    /** @var  string Default section for current component */
    protected $default_field = 'value';

    /**
     * Set start date value
     *
     * @param $value
     */
    public function setValue($value)
    {
        $this->value = $this->prepareDate($value);
    }

    /**
     * Set end date value
     *
     * @param Carbon $value
     */
    public function setValueEnd($value)
    {
        $this->value_end = $this->prepareDate($value);
    }

    /**
     * Prepare date format for correct js plugin work
     *
     * @param  $value
     *
     * @return string
     */
    protected function prepareDate($value)
    {
        // Added possibility to set null for date
        if(is_null($value)){
            return null;
        }

        // Temporary solution should be updated in future for the formatting right working
        if (is_string($value)) {
            return $value;
        }

        try {
            return Carbon::parse($value)->format($this->php_date_format);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $this->min_year_for_dropdown = $this->getMinYearForDropDownIfEmpty();
        $this->max_year_for_dropdown = $this->getMaxYearForDropDownIfEmpty();

        $this->setDateFormat($this->php_date_format);

        $this->value = $this->prepareDate($this->value);
        $this->value_end = $this->prepareDate($this->value_end);

        return parent::render();
    }

    /**
     * @return int
     */
    protected function getMinYearForDropDownIfEmpty(): int
    {
        if ($this->min_year_for_dropdown) {
            return $this->min_year_for_dropdown;
        }

        if (empty($this->max_year_for_dropdown)) {
            return now()->year - 10;
        }

        return $this->max_year_for_dropdown - 20;
    }

    /**
     * @return int
     */
    protected function getMaxYearForDropDownIfEmpty(): int
    {
        if ($this->max_year_for_dropdown) {
            return $this->max_year_for_dropdown;
        }

        if (empty($this->min_year_for_dropdown)) {
            return now()->year + 10;
        }

        return $this->min_year_for_dropdown + 20;
    }

    /**
     * Set date format with converting from PHP format to JS format
     *
     * @param string $format
     *
     * @return $this
     */
    public function setDateFormat(string $format)
    {
        $this->js_date_format = PHPDatesFormatHelper::convertPHPFormatToMomentJSFormat($format);
        $this->php_date_format = $format;

        return $this;
    }
}
