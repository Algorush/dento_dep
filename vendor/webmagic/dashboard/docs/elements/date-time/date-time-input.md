> Element for datetime-local input

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\DateTimeInput` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/advanced.html)

Elements of type datetime-local create input controls that let the user easily enter both a date and a time, including
the year, month, and day as well as the time in hours and minutes. The control is intended to represent a local date and
time, not necessarily the user's local date and time.
The resulting value includes the year, month, day, hour (in 12-hour format) and minutes
Seconds are not supported by control, the control will never set values for seconds part. Using attribute ```step="1"``` has only
visual effect.
With a datetime-local input, the actual value is always normalized to the format YYYY-MM-DDThh:mm. With a text input on
the other hand, by default the browser has no recognition of what format the date should be in, and there are lots of
different ways. 
**Using the Input class the value in seconds will be displayed in the field**

- **string $name** - name of element
- **$valueOrDataSource = null** - value
- **string $labelTxt = ''** - label above the field
- **bool $required = false** - field is required
- **array $attributes = []** - additional attributes for input field

Fields that have a default value can be skipped

### How to use

#### Method 1

```php
(new FormGroup())->dateTimeInput('date-time-input', '2022-10-12T12:38:05', 'Date time input', false, [])
```

#### Method 2

```php
(new FormGenerator())->dateTimeInput('date-time-input', '2022-10-12T12:38:05', 'Date time input', false, [])
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->dateTimeInput('date-time-input', '2022-10-12T12:38:05', 'Date time input', false, [])
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::dateTimeInput`

#### Method 4

This method does not have the ability to set the label

```php
(new Input())->type('datetime-local')->name('date-time-input')->value('2022-10-12T12:38:05')->required(false)->attrs([])
```