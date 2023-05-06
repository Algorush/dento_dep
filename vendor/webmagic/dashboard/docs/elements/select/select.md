> Element for select

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\Select` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/advanced.html)

Element represents a control that provides a menu of options. There is a possibility of multiple choice of options

- **string $name** - name of element
- **array $options** - all available options
- **$selectedKeys = ''** - only selected option(s)
- **string $labelTxt = ''** - label above the field
- **bool $required = false** - field is required
- **bool $multiple = false** - this boolean attribute indicates that multiple options can be selected in the list. If it
  is not specified, then only one option can be selected at a time. When multiple is specified, most browsers will show
  a scrolling list box instead of a single line dropdown.
- **array $attributes = []** - some unique attributes you can use to control it

Fields that have a default value can be skipped

### How to use

#### Method 1

Simple select with the ability to select one value

```php
(new FormGroup())->select('select', ['Active', 'Inactive'], 1, 'Select', false, true, [])
```

#### Method 2

Select with the ability to select multiple values from an associative array

```php
(new FormGenerator())->select('select', ['active' => 'Active', 'inactive' => 'Inactive'], ['active','inactive'], 'Select', false, true, [])
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->select('select', ['active' => 'Active', 'inactive' => 'Inactive'], ['inactive'], 'Select', false, true, [])
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::select`

#### Method 4

Can also be implemented using a class select, but it does not have the ability to set a label

```php
(new Select())
    ->name('select')
    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
    ->selectedKeys(['inactive'])
    ->required(false)
    ->multiple(false)
    ->attrs(['title' => 'Select class'])
```