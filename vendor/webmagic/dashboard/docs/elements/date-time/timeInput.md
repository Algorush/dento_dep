> Element for time input

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\TimeInput` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/advanced.html)

Element time create input field that let the user enter a time, or by choosing a time from the interface.
The resulting value includes hours and minutes, and optionally seconds. **time** control is simple, with slots to enter
hours and minutes in 12 or 24-hour format depending on operating system locale, and up and down arrows to increment and
decrement the currently selected component.

The `step` attribute can be used with a numerical input value to dictate how granular the values you can input are. For
example, you might want users to enter a particular time, but only in 30 minute increments. In this case, we can use the
step attribute, keeping in mind that for time inputs the value of the attribute is in seconds. For example, a 30 minute
increment would have a step value of 1800

- **string $name** - name of element
- **$valueOrDataSource = null** - value
- **string $labelTxt = ''** - label above the field
- **bool $required = false** - field is required
- **array $attributes = []** - additional attributes for input field

Fields that have a default value can be skipped

### How to use

#### Method 1

```php
(new FormGroup())->timeInput('time', now(), 'Time', false, ['step' => 1])
```

#### Method 2

```php
(new FormGenerator())->timeInput('time', now(), 'Time', false, ['step' => 1])
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->timeInput('time', now(), 'Time', false, ['step' => 1])
```

#### Method 4

This method does not have the ability to set the label.

```php
(new Input())->type('time')->name('time')->value(now())->required(false)->attrs(['step' => 1])
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::timeInput``