<?php

namespace Webmagic\Dashboard\Elements\Forms\Elements;

use Exception;
use Illuminate\Support\Carbon;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Core\PHPDatesFormatHelper;


/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\FlexibleDateTimePicker id($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\FlexibleDateTimePicker class($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\FlexibleDateTimePicker addClass($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\FlexibleDateTimePicker required(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\FlexibleDateTimePicker value($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\FlexibleDateTimePicker name($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\FlexibleDateTimePicker verticalPosition($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\FlexibleDateTimePicker horizontalPosition($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\FlexibleDateTimePicker showWeekNumber(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\FlexibleDateTimePicker toolbarPosition($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\FlexibleDateTimePicker maxYear($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\FlexibleDateTimePicker minYear($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Forms\Elements\FlexibleDateTimePicker viewMode($valueOrConfig)
 *
 ********************************************************************************************************************/

class FlexibleDateTimePicker extends Input
{
    /** @var  string Component view name */
    protected $view = 'dashboard::elements.forms.elements.flexible_date_time_picker';

    protected $available_fields = [
        'id',
        'class' => [
            'default' => 'form-control'
        ],
        'required' => [
            'type' => 'bool',
            'default' => false
        ],
        'value',
        'name',
        'vertical_position' => [
            'acceptable_values' => [
                'top',
                'bottom'
            ],
            'default' => 'bottom'
        ],
        'horizontal_position' => [
            'acceptable_values' => [
                'left',
                'right'
            ],
            'default' => 'right'
        ],
        'show_week_number' => [
            'type' => 'bool',
            'default' => false
        ],
        'toolbar_position' => [
            'acceptable_values' => [
                'top',
                'bottom'
            ],
            'default' => 'top'
        ],
        'max_year' => [
            'default' => null
        ],
        'min_year' => [
            'default' => null
        ],
        'view_mode' => [
            'acceptable_values' => [
                'decades',
                'years',
                'months',
                'days'
            ],
            'default' => 'months'
        ],
    ];

    /** @var string */
    protected $js_date_format;

    /** @var string */
    protected $php_date_format = 'Y/m/d H:i:s';

    /** @var  string Default section for current component */
    protected $default_field = 'value';

    /**
     * @param null $content
     *
     * @throws NoOneFieldsWereDefined
     */
    public function __construct($content = null)
    {
        $this->setDateFormat($this->php_date_format);

        parent::__construct($content);
    }

    /**
     * Set date format with converting from PHP format to JS format
     *
     * @param $format
     *
     * @return $this
     */
    public function setDateFormat($format)
    {
        $this->js_date_format = PHPDatesFormatHelper::convertPHPFormatToMomentJSFormat($format);
        $this->php_date_format = $format;

        return $this;
    }

    /**
     * @return string
     * @throws NoOneFieldsWereDefined
     */
    public function getValue()
    {
        if(isset($this->value)){
            return Carbon::parse($this->value)->format($this->php_date_format);
        }

        return $this->getFieldDefaultValue('value');
    }

    /**
     * @return array|void
     * @throws NoOneFieldsWereDefined
     */
    protected function prepareContentsForFields()
    {
        parent::prepareContentsForFields();

        $this->prepareFieldValue('js_date_format');
    }


    /**
     * Set view mode for selection years
     *
     * @return $this
     */
    public function startViewYears(): self
    {
        $this->view_mode = 'years';

        return $this;
    }

    /**
     * Set view mode for selection months
     *
     * @return $this
     */
    public function startViewMonths(): self
    {
        $this->view_mode = 'months';

        return $this;
    }

    /**
     * Set view mode for selection decades
     *
     * @return $this
     */
    public function startViewDecades(): self
    {
        $this->view_mode = 'decades';

        return $this;
    }

    /**
     * Set view mode for selection days
     *
     * @return $this
     */
    public function startViewDays(): self
    {
        $this->view_mode = 'days';

        return $this;
    }
    
    /**
     * Set max year for selection
     *
     * @param $value
     *
     * @return $this
     * @throws Exception
     */
    public function setMaxYear($value): self
    {
        // Validation
        try {
            $this->isCorrectYearFormat($value);
        } catch (Exception $e) {
            throw new Exception('Max year format is not right. Please, use the next format Y');
        }

        $this->max_year = $value;

        return $this;
    }

    /**
     * Set max year for selection
     *
     * @param $value
     *
     * @return $this
     * @throws Exception
     */
    public function setMinYear($value): self
    {
        // Validation
        try {
            $this->isCorrectYearFormat($value);
        } catch (Exception $e) {
            throw new Exception('Min year format is not right. Please, use the next format Y');
        }

        $this->min_year = $value;

        return $this;
    }

    /**
     * Check year format
     *
     * @param string $value
     *
     * @return bool
     */
    protected function isCorrectYearFormat(string $value)
    {
        // Try to create Carbon. If it works, year format is right
        $date = Carbon::createFromFormat('Y', $value);

        return true;
    }

    /**
     * Set toolbar position on bottom
     *
     * @return $this
     */
    public function toolbarBottom(): self
    {
        $this->toolbar_position = 'bottom';

        return $this;
    }

    /**
     * Display week numbers
     *
     * @return $this
     */
    public function showWeekNumbers(): self
    {
        $this->show_week_number = true;

        return $this;
    }

    /**
     * Show calendar on top
     *
     * @return $this
     */
    public function positionTop(): self
    {
        $this->vertical_position = 'top';

        return $this;
    }

    /**
     * Show calendar on bottom
     *
     * @return $this
     */
    public function positionBottom(): self
    {
        $this->vertical_position = 'bottom';

        return $this;
    }

    /**
     * Show calendar on left
     *
     * @return $this
     */
    public function positionLeft(): self
    {
        $this->horizontal_position = 'left';

        return $this;
    }

    /**
     * Show calendar on right
     *
     * @return $this
     */
    public function positionRight(): self
    {
        $this->horizontal_position = 'right';

        return $this;
    }
}