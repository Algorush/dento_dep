> Element for checkbox

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\Checkbox` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/general.html)

The elements of type checkbox are rendered by default as boxes that are checked (ticked) when activated, like you might
see in an official government paper form. The exact appearance depends upon the operating system configuration under
which the browser is running. Generally this is a square but it may have rounded corners. A checkbox allows you to
select single values for submission in a form (or not).

- **$name** - name of element
- **$checkedOrDataSource = false** - value (check or not check)
- **string $labelTxt = ''** - label
- **bool $required = false** - is required
- **array $attributes = []** - additional attributes

### How to use

#### Method 1

```php
(new FormGroup())->checkbox('name', ['name' => true], 'Checkbox', false, [])
```

#### Method 2

```php
(new FormGenerator())->checkbox('name', ['name' => true], 'Checkbox', false, [])
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->checkbox('name', ['name' => true], 'Checkbox', false, [])
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::checkbox``

#### Method 4

This method does not have the ability to set the label

```php
(new Checkbox())->name('name')->checked(true)->required(false)->attrs([])
```