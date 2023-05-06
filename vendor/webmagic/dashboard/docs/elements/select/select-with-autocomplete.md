> Element for select with autocomplete

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\SelectJS` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/advanced.html)

Element select with back-end autocomplete.
The second parameter in which the url is indicated where goes
"GET" request with a delay of 300 milliseconds with data each time you enter the field. The delay is not changeable.
The minimum search length is 1 character and cannot be changed. On the backend side, the request has the "q" key, which
contains the search string.
Under the hood, the library (https://select2.org/) is used. The structure of the returned request has the form of an
array with the keys "id" and "name". An example of a return request can be found in the function
**\Webmagic\Dashboard\Docs\Http\PresentationController::autoComplete**

```php
$data['results'][] = [
   'id' => 1,
   'name' => 'London',
];
```

Here the suggestions are tags for city, give "Lo" (for London or NewYork) a try.

- **string $name** - name of element
- **string $requestUrl** - autocomplete url
- **array $options = []** - all available options
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

```php
(new FormGroup())->selectWithAutocomplete(
    'select',                                                   
    route('dashboard.docs.presentation.select-autocomplete'),   
    [1 => 'London', 2 => 'New York'],                           
    1,                                                          
    'Search with back-end autocomplete',                        
    false,                                                      
    true,                                                       
    ['style' => 'width:100%'])                                  
```

#### Method 2

```php
(new FormGenerator())->selectWithAutocomplete(
    'select',                                                   
    route('dashboard.docs.presentation.select-autocomplete'),   
    [1 => 'London', 2 => 'New York'],                           
    1,                                                          
    'Search with back-end autocomplete',                        
    false,                                                      
    true,                                                       
    ['style' => 'width:100%'])                                  
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->selectWithAutocomplete(
    'select',                                                   
    route('dashboard.docs.presentation.select-autocomplete'),   
    [1 => 'London', 2 => 'New York'],                           
    1,                                                          
    'Search with back-end autocomplete',                        
    false,                                                      
    true,                                                       
    ['style' => 'width:100%'])                                  
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::selectWithAutocomplete`

#### Method 4

Can also be implemented using a class SelectJS, but it does not have the ability to set a label.

```php
(new SelectJs())
    ->name('select')
    ->options([1 => 'London', 2 => 'New York'])
    ->selectedKeys([1, 2])
    ->required(false)
    ->multiple(true)
    ->attrs(['style' => 'width:100%'])
    ->addAutocomplete(route('dashboard.docs.presentation.select-autocomplete'))
```