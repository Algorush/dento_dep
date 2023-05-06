> Element for hidden input

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\Input` class

Elements of type hidden let web developers include data that cannot be seen or modified by users when a form is
submitted. For example, the ID of the content that is currently being ordered or edited, or a unique security token.
Hidden inputs are completely invisible in the rendered page, and there is no way to make it visible in the page's
content.

- **$name** - name of element
- **$valueOrDataSource = null** - value

### How to use

#### Method 1

```php
(new FormGroup())->hiddenInput('id', Str::random())
```

#### Method 2

```php
(new FormGenerator())->hiddenInput('id', Str::random())
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->hiddenInput('id', Str::random())
```

#### Method 4

This method does not have the ability to set the label

```php
(new Input())->type('hidden')->name('name')->value(Str::random())->attrs([])
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::hiddenInput``