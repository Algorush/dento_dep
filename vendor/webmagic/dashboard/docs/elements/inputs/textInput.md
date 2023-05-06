> Element for text input

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\Input` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/general.html)

The element is presented as a single-line text field for entering various text data.

- **$name** - name of element
- **$valueOrDataSource = null** - value
- **string $labelTxt = ''** - label
- **bool $required = false** - is required
- **array $attributes = []** - additional attributes

### How to use

#### Method 1

```php
(new FormGroup())->textInput('name', null, 'Text input', true)
```

#### Method 2

```php
(new FormGenerator())->textInput('name', null, 'Text input', true)
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->textInput('name', null, 'Text input', true)
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::textInput``

#### Method 4

This method does not have the ability to set the label

```php
(new Input())->type('text')->name('name')->value('some_value')->required(false)->attrs([])
```