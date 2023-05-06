> Input element to enter a unique value

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\Input` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/general.html)

The slug element is a text field to hold a unique value for the model.
Which can be filled with a unique value from another form field if no initial value is specified for the field's slug or
manually.
Can be used for client side url for seo.

- **string $name** - name of element
- **string $sourceName** - field input name from the same form
- **$valueOrDataSource = null** - value
- **string $labelTxt = ''** - label
- **bool $required = false** - is required
- **string $separator = '-'** - separator between words
- **string $transformRule = 'lowercase'** - convert slug value to lower or upper case
- **array $attributes = []** - additional attributes

### How to use

#### Method 1

```php
(new FormGroup())->slugInput(
    'slug', 
    'text', 
    null, 
    'Slug generated automatically based on name', 
    false, 
    '-', 
    'lowercase', 
    []                                           
), 
```

#### Method 2

```php
(new FormGenerator())->slugInput(
    'slug',                                         
    'text',                                        
    null,                                         
    'Slug generated automatically based on name',  
    false,                                         
    '-',                                           
    'lowercase',                                  
    []                                            
), 
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->slugInput(
    'slug',                                         
    'text',                                         
    null,                                          
    'Slug generated automatically based on name',   
    false,                                         
    '-',                                           
    'lowercase',
    []
), 
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::slugInput``