<?php

namespace Webmagic\Dashboard\Docs\Http;

use Webmagic\Dashboard\Components\FormGenerator;
use Webmagic\Dashboard\Components\FormPageGenerator;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Dashboard;
use Webmagic\Dashboard\Elements\Forms\Elements\FormGroup;
use Webmagic\Dashboard\Elements\Titles\H4Title;
use Webmagic\Dashboard\Elements\WrapperDiv;

class DateRangeJsController
{
    /**
     * Tooltips functionality presentation
     *
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function example(): Dashboard
    {
        $dashboard = new Dashboard();

        $docs = view()->file(__DIR__ . '/../../../docs/elements/date-range-js.md');

        $formPageGenerator = (new FormPageGenerator())
            ->method('POST')
            ->action('/')
            ->ajax(true)
            ->datePickerJS('date_js_1', today(),
                '(datePickerJS) Select date',
                true, [], false, false, null, null, false, true, 'Y/m/d')
            ->datePickerJS('date_js_2', today(),
                '(datePickerJS) Select date with dropdown years and months (default years range +/- 10 years from current year)',
                true, [], false, true, null, null, false, true, 'Y/m/d')
            ->datePickerJS('date_js_3', today(),
                '(datePickerJS) Select date with dropdown years and months (from 2015 to 2016)',
                true, [], false, true, 2015, 2016, false, true, 'Y/m/d')
            ->datePickerJS('date_js_4', today(),
                '(datePickerJS) Select date with auto apply chose date',
                true, [], false, false, null, null, true, true, 'Y/m/d')
            ->datePickerJS('date_js_5', today(),
                '(datePickerJS) Select date open top',
                true, [], false, false, null, null, false, false, 'Y/m/d')
            ->dateTimePickerJS('date_time_js_1', now(),
                '(dateTimePickerJS) Select date and time',
                false, [], false, false)
            ->dateTimePickerJS('date_time_js_2', now(),
                '(dateTimePickerJS) Select date and time with 24 format',
                false, [], true, false)
            ->dateTimePickerJS('date_time_js_3', now(),
                '(dateTimePickerJS) Select date and time with default ranges',
                false, [], false, false)
            ->dateTimePickerJS('date_time_js_4', now(),
                '(dateTimePickerJS) Select date and time with default ranges, dropdown with default range of years and months',
                false, [], false, false, false, true)
            ->dateTimePickerJS('date_time_js_5', now(),
                '(dateTimePickerJS) Select date and time open top',
                false, [], false, false, false, false, null, null, false)
            ->dateRangePicker('date_range_start_1', 'date_range_end_1', today(), today(),
                '(dateRangePicker) Select range of dates',
                true, true, [], true, false, null, null, false, true, 'Y/m/d')
            ->dateRangePicker('date_range_start_2', 'date_range_end_2', today(), today(),
                '(dateRangePicker) Select range of dates, dropdown years and months (from 2015 to 2025), auto apply chose date',
                true, true, [], true, true, 2015, 2025, true, true, 'Y/m/d')
            ->dateRangePicker('date_range_start_3', 'date_range_end_3', today(), today(),
                '(dateRangePicker) Select range of dates open top',
                true, true, [], true, false, null, null, false, false, 'Y/m/d')
            ->dateTimeRangePicker('date_time_range_start_1', 'date_time_range_end_1', now(), now(),
                '(dateTimeRangePicker) Select range of dates and times',
                false, false, [], true, true)
            ->dateTimeRangePicker('date_time_range_start_2', 'date_time_range_end_2', now(), now(),
                '(dateTimeRangePicker) Select range of dates and times with default ranges',
                false, false, [], true, true, true)
            ->dateTimeRangePicker('date_time_range_start_3', 'date_time_range_end_3', now(), now(),
                '(dateTimeRangePicker) Select range of dates and times with default ranges, dropdown years and months (from 2015 to 2025)',
                false, false, [], true, true, true, true, 2015, 2025)
            ->dateTimeRangePicker('date_time_range_start_4', 'date_time_range_end_4', now(), now(),
                '(dateTimeRangePicker) Select range of dates and times open top',
                false, false, [], true, true, false, false, null, null, false);

        $formPageGenerator->getForm()->sendAllCheckbox(true);

        $examples = new WrapperDiv([
            new H4Title('by FormGroup'),
            (new FormGroup())->datePickerJS(
                'form-date-js-1',
                now(),
                'Select date',
                false,
                [],
                true,
                true,
                2000,
                2030,
                true,
                true,
                'd-m-Y'
            ),
            new H4Title('by FormGenerator'),
            (new FormGenerator())->datePickerJS(
                'form-date-js-2',
                now(),
                'Select date',
                false,
                [],
                false,
                false,
                2020,
                2025,
                false,
                true,
                'Y-m-d'
            ),
            new H4Title('by FormPageGenerator'),
            $formPageGenerator->getBox()

        ]);

        $dashboard->page()
            ->setPageTitle('Date range js')
            ->addElement()->tabs()->addTab()->title('Description')->content($docs)->active()
            ->parent()->addTab()->title('Example')->content($examples);

        return $dashboard;
    }
}
