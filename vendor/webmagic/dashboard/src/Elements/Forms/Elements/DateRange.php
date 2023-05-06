<?php


namespace Webmagic\Dashboard\Elements\Forms\Elements;

use Carbon\Carbon;
use Webmagic\Dashboard\Core\Content\ContentFieldsUsable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Elements\Forms\MultifieldsElements\MultifieldsAvailable;

/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method Select id($valueOrConfig)
 * @method Select addId($valueOrConfig)
 * @method Select name($valueOrConfig)
 * @method Select addName($valueOrConfig)
 * @method Select class($valueOrConfig)
 * @method Select addClass($valueOrConfig)
 * @method Select placeholder($valueOrConfig)
 * @method Select addPlaceholder($valueOrConfig)
 * @method Select options(array $valueOrConfig)
 * @method Select addOptions(array $valueOrConfig)
 * @method Select selectedKey($valueOrConfig)
 * @method Select addSelectedKey($valueOrConfig)
 * @method Select required(bool $valueOrConfig)
 * @method Select addRequired(bool $valueOrConfig)
 *
 *******************************************************************************************************************
 * @property string id
 * @property array|ContentFieldsUsable options
 */

class DateRange extends Select implements MultifieldsAvailable
{
    /** date format
     * @var string
     */
    protected $dateFormat = 'd/m/Y';

    protected $options = [];

    /**
     * Input constructor.
     *
     * @param null $content
     *
     * @throws NoOneFieldsWereDefined
     */
    public function __construct($content = null)
    {
        $this->id = uniqid();

        $this->init();

        parent::__construct($content);
    }

    /**
     * Init default options of select element
     */
    protected function init()
    {
        $this->addCurrentDay();
        $this->addYesterday();
        $this->addCurrentMonth();
        $this->addPreviousMonth();
        $this->addCurrentQuarter();
        $this->addPreviousQuarter();
        $this->addCurrentYear();
        $this->addPreviousYear();
    }

    /**
     * Add empty line to list
     *
     * @param string $title
     * @return $this
     */
    public function addEmptyLine($title = ''): self
    {
        $this->options[$title] = '';
        return $this;
    }

    /**
     * Formats Carbon's date
     *
     * @param string $title
     * @param $dateCarbon
     * @return string
     */
    protected function formatDate(string $title, $dateCarbon): string
    {
        // remove old key with value (array)
        unset($this->options[$title]);

        // case for empty value
        if(!is_array($dateCarbon)) {
            $this->options = ['' => $title] + $this->options;
            return $dateCarbon;
        }


        $dateStart = $dateCarbon[0];
        $dateEnd = $dateCarbon[1] ?? $dateStart;

        $dateStart = $dateStart->startOfDay()->format($this->dateFormat);
        $dateEnd = $dateEnd->endOfDay()->format($this->dateFormat);

        return "$dateStart-$dateEnd";
    }


    /**
     * add Carbon current date
     *
     * @param $title
     * @return DateRange
     */
    public function addCurrentDay($title = null): self
    {
        $title = $title ?? __('dashboard::common.date_range.today');
        $this->options[$title] = [Carbon::today()];
        return $this;
    }

    /**
     * set Carbon yesterday date
     *
     * @param $title
     * @return DateRange
     */
    public function addYesterday($title = null): self
    {
        $title = $title ?? __('dashboard::common.date_range.yesterday');
        $this->options[$title] = [Carbon::yesterday()];

        return $this;
    }

    /**
     * set Carbon current month date
     *
     * @param $title
     * @return DateRange
     */
    public function addCurrentMonth($title = null): self
    {
        $title = $title ?? __('dashboard::common.date_range.this_month');
        $dayStart = Carbon::now()->startOfMonth();
        $dayEnd = Carbon::now()->endOfMonth();

        $this->options[$title] = [$dayStart, $dayEnd];

        return $this;
    }

    /**
     * set Carbon previous month date
     *
     * @param $title
     * @return DateRange
     */
    public function addPreviousMonth($title = null): self
    {
        $title = $title ?? __('dashboard::common.date_range.previous_month');
        $dayStart = Carbon::now()->subMonth()->startOfMonth();
        $dayEnd = Carbon::now()->subMonth()->endOfMonth();

        $this->options[$title] = [$dayStart, $dayEnd];

        return $this;
    }

    /**
     * set Carbon current quarter date
     *
     * @param $title
     * @return DateRange
     */
    public function addCurrentQuarter($title = null): self
    {
        $title = $title ?? __('dashboard::common.date_range.this_quarter');
        $dayStart = Carbon::now()->startOfQuarter();
        $dayEnd = Carbon::now()->endOfQuarter();

        $this->options[$title] = [$dayStart, $dayEnd];

        return $this;
    }

    /**
     * set Carbon previous quarter date
     *
     * @param $title
     * @return self
     */
    public function addPreviousQuarter($title = null): self
    {
        $title = $title ?? __('dashboard::common.date_range.previous_quarter');
        $dayStart = Carbon::now()->subQuarter()->startOfQuarter();
        $dayEnd = Carbon::now()->subQuarter()->endOfQuarter();

        $this->options[$title] = [$dayStart, $dayEnd];

        return $this;
    }

    /**
     * set Carbon current year date
     *
     * @param $title
     * @return DateRange
     */
    public function addCurrentYear($title = null): self
    {

        $title = $title ?? __('dashboard::common.date_range.this_year');
        $dayStart = Carbon::now()->firstOfYear();
        $dayEnd = Carbon::now()->lastOfYear();

        $this->options[$title] = [$dayStart, $dayEnd];

        return $this;
    }

    /**
     * set Carbon previous year date
     *
     * @param $title
     * @return self
     */
    public function addPreviousYear($title = null): self
    {
        $title = $title ?? __('dashboard::common.date_range.previous_year');
        $dayStart = Carbon::now()->subYear()->firstOfYear();
        $dayEnd = Carbon::now()->subYear()->lastOfYear();

        $this->options[$title] = [$dayStart, $dayEnd];

        return $this;
    }

    /**
     * Add Custom Range
     *
     * @param string $title
     * @param Carbon $dayStart
     * @param Carbon|null $dayEnd
     * @return self
     */
    public function addRange(string $title, Carbon $dayStart, Carbon $dayEnd = null) : self
    {
        $this->options[$title] = [$dayStart, $dayEnd];
        return $this;
    }

    /**
     * Clear existing ranges
     *
     * @return self
     */
    public function clearRanges(): self
    {
        $this->options = [];
        return $this;
    }

    /**
     * Change date format
     *
     * @param string $dateFormat
     * @return self
     */
    public function setDateFormat(string $dateFormat = ''): self
    {
        if($dateFormat == '') {
            return $this;
        }

        $this->dateFormat = $dateFormat;
        return $this;
    }


    /**
     * Performs formatting and validation of the element's content before displaying it
     *
     * @return string
     */
    public function render(): string
    {
        foreach ($this->options as $title => $dateCarbon) {

            $optionValue = $this->formatDate($title, $dateCarbon);

            $this->options[$optionValue] = $title;

        }

        return parent::render();
    }
}
