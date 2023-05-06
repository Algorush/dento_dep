> Element for switcher

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\Switcher` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/general.html)

The element switcher this is a kind of stylized checkbox

- **$name** - name of element
- **$checkedOrDataSource = false** - value (check or not check)
- **string $labelTxt = ''** - label
- **bool $required = false** - is required
- **array $attributes = []** - additional attributes

### How to use

#### Method 1

```php
(new FormGroup())->switcher('name', ['name' => true], 'Switcher', false, [])
```

#### Method 2

```php
(new FormGenerator())->switcher('name', ['name' => true], 'Switcher', false, [])
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->switcher('name', ['name' => true], 'Switcher', false, [])
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::switcher``

#### Method 4

This method does not have the ability to set the label

```php
(new Switcher())->name('name')->checked(true)->required(false)->attrs([])
```