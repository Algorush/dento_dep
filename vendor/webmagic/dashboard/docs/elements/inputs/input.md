> Element for input with variety of types

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\Input` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/general.html)

Element input is used to create interactive controls for web-based forms in order to accept data from the user; a wide
variety of types of input data and control widgets are available, depending on the device and user agent.

- **$name** - name of element
- **$valueOrDataSource = null** - value
- **string $labelTxt = ''** - label
- **string $type = 'text'** - type input field
- **bool $required = false** - is required
- **string $placeholder = null** - placeholder
- **array $attributes = []** - additional attributes
- **string $class = ' form-control '** - custom class for input field

### How to use

#### Method 1

```php
(new FormGroup())->input('name', 'some_value', 'Text input', 'text', false, 'Text input', [], ' form-control ')
```

#### Method 2

```php
(new FormGenerator())->input('name', 'some_value', 'Number input', 'number', false, 'Number input', [], ' form-control ')
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->input('name', 'some_value', 'Number input', 'number', false, 'Number input', [], ' form-control ')
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::input``

#### Method 4

This method does not have the ability to set the label. Through attributes, you can fine-tune the input field you need
by type

```php
(new Input())->type('email')->name('name')->value('email@admin.com')->required(false)->attrs([]),
```