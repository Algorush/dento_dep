> Element for entering hidden data

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\Input` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/general.html)

The element is presented as a one-line plain text editor control in which the text is obscured so that it cannot be
read, usually by replacing each character with a symbol

- **$name** - name of element
- **$valueOrDataSource = null** - value
- **string $labelTxt = ''** - label
- **bool $required = false** - is required
- **array $attributes** - additional attributes

### How to use

#### Method 1

```php
(new FormGroup())->passwordInput('name', 'some_value', 'Password', false, [])
```

#### Method 2

```php
(new FormGenerator())->passwordInput('name', 'some_value', 'Password', false, [])
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->passwordInput('name', 'some_value', 'Password', false, [])
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::passwordInput``

#### Method 4

```php
(new Input())->type('password')->name('name')->value('some_value')->required(false)->attrs([])
```