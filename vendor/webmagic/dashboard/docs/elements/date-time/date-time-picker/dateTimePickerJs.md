> Element for date time input

The functionality is implemented using the class `\Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker`

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/advanced.html)

Element dateTimePickerJS create input field that let the user choosing a date and time from the interface.
The element allows you to configure the output of the year, month in the dropdown, you can also select the format for
selecting hours, minutes. It is also possible to show a list to the left of the calendar for quick selection of date
range and current time.
The resulting value includes year, month, day, hours and minutes.

- **string $name** - name of element,
- **$valueOrDataSource = null** - value,
- **string $labelTxt = ''** - label,
- **bool $required = false** - field is required,
- **array $attributes = []** - additional attributes for input field,
- **bool $time24Format = true** - uses a 12- or 24-hour format for inputting times,
- **bool $showSeconds = true** - show or hide seconds,
- **bool $defaultRanges = false** - is show for quick selection of date range and current time
- **bool $showMonthsYearsDropdown = false** - show year and month as dropdown,
- **int $minYearForDropdown = null** - set minimum year from dropdown,
- **int $maxYearForDropdown = null** - set maximum year from dropdown,
- **bool $showDropdownsDown = true** - set visual display of the calendar above or below the input field

Fields that have a default value can be skipped

### How to use

#### Method 1

```php
(new FormGroup())->timePickerJS(
    'time-picker-js',   
    now(),              
    'Time picker js',   
    false,              
    [],                
    true,               
    true,               
    false,              
    false,              
    null,               
    null,               
    true                
);
```

#### Method 2

```php
(new FormGenerator())->timePickerJS(
    'time-picker-js',   
    now(),              
    'Time picker js',   
    false,              
    [],                 
    true,               
    true,               
    false,              
    false,              
    null,               
    null,               
    true                
);
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->timePickerJS(
    'time-picker-js',   
    now(),              
    'Time picker js',   
    false,             
    [],                 
    true,               
    true,               
    false,              
    false,              
    null,               
    null,               
    true                
);
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::dateTimePickerJS``