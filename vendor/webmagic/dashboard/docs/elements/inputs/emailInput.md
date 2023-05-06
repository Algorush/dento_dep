> Element for email input

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\Input` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/general.html)

Elements of type email are used to let the user enter and edit an e-mail address, or, if the multiple attribute is
specified, a list of e-mail addresses.

- **$name** - name of element
- **$valueOrDataSource = null** - value
- **string $labelTxt = ''** - label
- **bool $required = false** - is required
- **array $attributes = []** - additional attributes

### How to use

#### Method 1

```php
(new FormGroup())->emailInput('email', 'email@gmail.com', 'Email input', false, [])
```

#### Method 2

```php
(new FormGenerator())->emailInput('email', 'email@gmail.com', 'Email input', false, [])
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->emailInput('email', 'email@gmail.com', 'Email input', false, [])
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::emailInput``

#### Method 4

This method does not have the ability to set the label

```php
(new Input())->type('email')->name('email')->value('email@gmail.com')->required(false)->attrs([])
```