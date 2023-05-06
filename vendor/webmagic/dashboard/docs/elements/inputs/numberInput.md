> Element for number input

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\Input` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/general.html)

Elements of type number are used to let the user enter a number. They include built-in validation to reject
non-numerical entries. You can also add attributes, set the step and min and max value for the produced data.

- **$name** - name of element
- **$valueOrDataSource = null** - value
- **string $labelTxt = ''** - label
- **bool $required = false** - is required
- **float $step = 1** - attribute is a number that specifies the granularity that the value must adhere to
- **float $min = null** - minimum value to accept for this input
- **float $max = null** - maximum value to accept for this input
- **array $attributes = []** - additional attributes

### How to use

#### Method 1

```php
(new FormGroup())->numberInput('name', '12345', 'Number input', false, 1, null, null, [])
```

#### Method 2

```php
(new FormGenerator())->numberInput('name', '12345', 'Number input', false, 1, null, null, [])
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->numberInput('name', '12345', 'Number input', false, 1, null, null, [])
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::numberInput``

#### Method 4

This method does not have the ability to set the label. Through the attributes you can set the required step and the
minimum and maximum value validation

```php
(new Input())->type('number')->name('name')->value('12345')->required(false)->attrs([])
```