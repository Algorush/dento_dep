> Element for color input

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\Color` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/advanced.html)

The Element color input provide a user interface element that lets a user specify a color, either by using a visual
color picker interface or by entering the color into a text field in #rrggbb hexadecimal format.

- **$name** - name of element
- **$valueOrDataSource = null** - value
- **string $labelTxt = ''** - label
- **bool $required = false** - is required
- **array $attributes = []** - additional attributes

### How to use

#### Method 1

```php
(new FormGroup())->colorInput('name', null, 'Color input', false, [])
```

#### Method 2

```php
(new FormGenerator())->colorInput('name', null, 'Color input', false, [])
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->colorInput('name', null, 'Color input', false, [])
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::colorInput``

#### Method 4

This method does not have the ability to set the label

```php
(new Input())->type('color')->name('name')->value(null)->required(false)->attrs(['style' => 'width:100px'])
```

#### Method 5

This method does not have the ability to set the label

```php
(new Color())->type('color')->name('name')->value(null)->required(false)->attrs([])
```