> Date range js

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker` class

You can enable users to quickly and easily set the desired date range.

- **string $name** - name of element
- **$valueOrDataSource = null** - value
- **string $labelTxt = ''** - label
- **bool $required = false** - field is required
- **array $attributes = []** - additional attributes for input field
- **bool $defaultRanges = false** - enable or disable the ability to display suggested date ranges on the left
- **bool $showMonthsYearsDropdown = false** - show dropdown with month and year
- **int $minYearForDropdown = null** - set the minimum year for the dropdown when selected
- **int $maxYearForDropdown = null** - set the maximum year for the dropdown when selected
- **bool $autoApplyDate = false** - hide the apply and cancel buttons, and automatically apply a new date range
- **bool $showDropdownsDown = true** - set visual display of the calendar above or below the input field
- **string $format = null** - set custom format date time

### How to use

#### Method 1

```php
(new FormGroup())->datePickerJS(
    'date-picker-js',
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
);
```

#### Method 2

```php
(new FormGenerator())->datePickerJS(
    'date-picker-js',
    now(),
    'Select date',
    false,
    [],
    true,
    true,
    2000,
    2025,
    true,
    true,
    'Y/m/d'
);
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())
    ->title('Page title', 'Page sub-title')
    ->method('POST')
    ->action('/')
    ->ajax(true)
    ->datePickerJS(
        'date_js',      // $name
        today(),        // $valueOrDataSource = null
        'Select date',  // $labelTxt = ''
        true,           // $required = false
        [],             // $attributes = []
        false,          // $defaultRanges = false
        false,          // $showMonthsYearsDropdown = false
        null,           // $minYearForDropdown = null
        null,           // $maxYearForDropdown = null
        false,          // $autoApplyDate = false
        true,           // $showDropdownsDown = true 
        ''              // $format = ''
    )
    ->dateTimePickerJS(
        'date_time_js', // $name
        now(),          // $valueOrDataSource = null
        'Select date',  // $labelTxt = ''
        false,          // $required = false
        [],             // $attributes = []
        false,          // $time24Format = true
        false,          // showSeconds = true
        true,           // $defaultRanges = false
        false,          // $showMonthsYearsDropdown = false
        null,           // $minYearForDropdown = null
        null,           // $maxYearForDropdown = null
        true            // $showDropdownsDown = true
    )
    ->dateRangePicker(
        'date_range_start',       // $name
        'date_range_end',         // $endName
        today(),                  // $valueOrDataSource = null
        today(),                  // $endValueOrDataSource = null
        'Select range of dates',  // $labelTxt = ''
        true,                     // $required = false
        true,                     // $endRequired = false
        [],                       // $attributes = []
        true,                     // $time24Format = true
        true,                     // $showSeconds = true
        true,                     // $defaultRanges = false
        false,                    // $showMonthsYearsDropdown = false
        null,                     // $minYearForDropdown = null
        null,                     // $maxYearForDropdown = null
        false,                    // $autoApplyDate = false 
        true,                     // $showDropdownsDown = true
        ''                        // $format = ''
    )
    ->dateTimeRangePicker(
        'date_time_range_start',  // $name
        'date_time_range_end',    // $endName
        now(),                    // $valueOrDataSource = null
        now(),                    // $endValueOrDataSource = null
        'Select range of dates and times', // $labelTxt = ''
        false,                    // $required = false
        false,                    // $endRequired = false
        [],                       // $attributes = []
        true,                     // $time24Format = true
        true,                     // $showSeconds = true
        false,                    // $showMonthsYearsDropdown = false
        null,                     // $minYearForDropdown = null
        null,                     // $maxYearForDropdown = null
        true                      // $showDropdownsDown = true
        );
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\DateRangeJsController::example`