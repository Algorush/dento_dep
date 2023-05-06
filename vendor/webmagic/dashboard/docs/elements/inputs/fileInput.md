> Element for file input

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\Input` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/general.html)

Elements file input let the user choose one or more files from their device storage.

- **$name** - name of element
- **$valueOrDataSource = null** - value
- **string $labelTxt = ''** - label
- **bool $required = false** - is required
- **array $attributes = []** - additional attributes

### How to use

#### Method 1

```php
(new FormGroup())->fileInput('name', null, 'File input', false, [])
```

#### Method 2

```php
(new FormGenerator())->fileInput('name', null, 'File input', false, [])
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->fileInput('name', null, 'File input', false, [])
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::fileInput``

#### Method 4

This method does not have the ability to set the label

```php
(new Input())->type('file')->name('name')->value(null)->required(false)->attrs([])
```