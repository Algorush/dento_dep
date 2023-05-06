<?php


namespace Webmagic\Dashboard\Docs\Http;

use Carbon\Carbon;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Dashboard;
use Webmagic\Dashboard\Elements\Forms\Elements\DateRange;
use Webmagic\Dashboard\Elements\Forms\Elements\FormGroup;
use Webmagic\Dashboard\Elements\Titles\H4Title;
use Webmagic\Dashboard\Elements\WrapperDiv;

class DateRangeController
{
    /**
     * Tooltips functionality presentation
     *
     * @param Dashboard $dashboard
     *
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function example(Dashboard $dashboard): Dashboard
    {
        $docs = view()->file(__DIR__ . '/../../../docs/elements/date-range.md');

        $dateRangeWithOwnedRange = (new FormGroup())
            ->element()
            ->dateRange()
            ->clearRanges()
            ->addRange(
                'Last 1 days (except today)',
                Carbon::now()->subDays(1),
                Carbon::yesterday()
            )
            ->addCurrentYear('Current year with my title')
            ->addEmptyLine('! Empty value !')
            ->addRange(
                'Last 5 days (except today)',
                Carbon::now()->subDays(5),
                Carbon::yesterday()
            )
            ->addRange(
                'My Today',
                Carbon::today()
            )
            ->addPreviousMonth()
            ->setDateFormat('Y-d-m')
            ->name('selectName2');


        $dateRange = new DateRange();
        $dateRange->addName('date-range');
        $dateRange->addRequired(false);
        $dateRange->setDateFormat('d-m-Y');
        $dateRange->addEmptyLine('...');
        $dateRange->clearRanges();
        $dateRange->addRange('Last 1 days (except today)', Carbon::now()->subDays(1), Carbon::yesterday());
        $dateRange->addRange('Last 5 days (except today)', Carbon::now()->subDays(5), Carbon::yesterday());

        $examples = new WrapperDiv([
            new H4Title('Select date with default options'),
            (new FormGroup())->dateRange('date-range', 'Select date'),
            new H4Title('Select date with custom date format d-m-Y'),
            (new FormGroup())->dateRange('date-range', 'Select date', 'd-m-Y'),
            new H4Title('Select date without option with empty string'),
            (new FormGroup())->dateRange('date-range', 'Select date', '', false, false),
            new H4Title('Select date with added custom ranges "Current and previous months"'),
            (new FormGroup())->dateRange('date-range', 'Select date', '', false, true, [['Current and previous months', Carbon::now()->subMonth()->startOfMonth(), Carbon::today()->endOfMonth()]]),
            new H4Title('Select date with own date range implemented via methods'),
            $dateRangeWithOwnedRange,
            new H4Title('Select date with DateRange class'),
            $dateRange
        ]);

        $dashboard->page()
            ->setPageTitle('Date range')
            ->addElement()->tabs()->addTab()->title('Description')->content($docs)->active()
            ->parent()->addTab()->title('Example')->content($examples);

        return $dashboard;
    }
}
