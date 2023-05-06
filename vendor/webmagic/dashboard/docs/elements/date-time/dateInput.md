> Element for date input

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\DateInput` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/advanced.html)

Element date create input field that let the user enter a date, or by choosing a date from the calendar.
The resulting value includes the year, month, and day, but not the time.

- **string $name** - name of element
- **$valueOrDataSource = null** - value
- **string $labelTxt = ''** - label above the field
- **bool $required = false** - field is required
- **array $attributes = []** - additional attributes for input field

Fields that have a default value can be skipped

### How to use

#### Method 1

```php
(new FormGroup())->dateInput('date', now(), 'Date', false, [])
```

#### Method 2

```php
(new FormGenerator())->dateInput('date', now(), 'Date', false, [])
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->dateInput('date', now(), 'Date', false, [])
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::dateInput``

#### Method 4

This method does not have the ability to set the label

```php
(new Input())->type('date')->name('date')->value(now())->required(false)->attrs([])
```