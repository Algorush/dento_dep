> FlexibleDateTimePicker

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\FlexibleDateTimePicker` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/advanced.html)

The FlexibleDateTimePicker is a date-time picker with the ability to flexibly adjust the position.

- **string $name** - name of element
- **$valueOrDataSource = null** - value
- **string $labelTxt = ''** - label above the field
- **bool $required = false** - field is required
- **array $attributes = []** - additional attributes for input field
- **string $verticalPosition = 'bottom'** - select vertical position for date picker interface (top, bottom)
- **string $horizontalPosition = 'right'** - select horizontal position for date picker interface (right, left)
- **bool $showWeekNumber = false** - show or not the week number in the calendar interface as the first column
- **string $toolbarPosition = 'top'** - position of the toolbar inside the calendar interface (top, bottom)
- **int $minYear = null** - minimum year
- **int $maxYear = null** - maximum year
- **string $viewMode = 'months'** - calendar interface view (decades, years, months, days)

### How to use

#### Method 1

```php
(new FormGroup())->datePickerFlex(
    'flexible_datetime_picker',
    now(),
    'Label'
);
```

#### Method 2

```php
(new FormGenerator())->datePickerFlex(
    'flexible_datetime_picker',
    now(),
    'Label',
    false,
    [],
    'top',
    'left',
    true,
    'top',
    null,
    null,
    'days'
);
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->datePickerFlex(
    'flexible_datetime_picker',
    now(),
    'Label',
    false,
    [],
    'top',
    'left',
    true,
    'top',
    2000,
    2025,
    'months'
);
```

#### Method 4

Through the `FlexibleDateTimePicker` class, you can set the date format, according to which you can limit the calendar
interface and write it in the desired format.

```php
(new FlexibleDateTimePicker())
    ->name('flexible_datetime_picker')
    ->value(now())
    ->horizontalPosition('right')
    ->verticalPosition('bottom')
    ->showWeekNumber(false)
    ->toolbarPosition('top')
    ->minYear(now()->subYears(5)->year)
    ->maxYear(now()->addYears(5)->year)
    ->viewMode('months')
    ->setDateFormat('d-m-Y');
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::flexibleDateTimePicker`