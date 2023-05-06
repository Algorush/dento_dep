> Element for textarea

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\Textarea` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/general.html)

The element represents a multi-line plain-text editing control, useful when you want to allow users to enter a sizeable
amount of free-form text, for example a comment on a review or feedback form.

- **$name** - name of element
- **$valueOrDataSource = null** - value
- **string $labelTxt = ''** - label
- **bool $required = false** - is required
- **array $attributes = []** - additional attributes

### How to use

#### Method 1

```php
(new FormGroup())->textarea('name', '', 'Textarea', false, ['rows' => 5])
```

#### Method 2

```php
(new FormGenerator())->textarea('name', '', 'Textarea', false, ['rows' => 5]),
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->textarea('name', '', 'Textarea', false, ['rows' => 5])
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::textarea``

#### Method 4

This method does not have the ability to set the label

```php
(new Textarea())->name('name')->content('')->required(false)->class('form-control')->attrs(['rows' => 5])->title('textarea'),
```