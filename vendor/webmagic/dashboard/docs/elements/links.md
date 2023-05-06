> Links

The functional is implemented using the `\Webmagic\Dashboard\Elements\Links\Link` class

Element allows you to create a simple link. Links allow users to click their way from page to page.

### Link

- **link** - href attribute, which indicates the link's destination.
- **inNewTab = true** method allows open links in a new tab.

```php
$linkElement = (new Link('link to Google search'))
    ->link('https://www.google.com/');
    ->inNewTab();
```  

### LinkButton

Element allows you to create a link in the form of a button  
The functional is implemented using the `\Webmagic\Dashboard\Elements\Links\LinkButton` class

- **class** - set class for button.
- **icon** - awesome icon from [Font Awesome](https://fontawesome.com/) library

```php
$linkButton = (new LinkButton('link button to DuckDuckGo search'))
    ->link('https://duckduckgo.com/');
    ->class('btn-warning');
    ->icon('fa-link');
    ->inNewTab();
```  

### LinkJSDelete

Element allows you to send a request to the server, as well as delete an HTML element.  
The functional is implemented using the `\Webmagic\Dashboard\Elements\Links\LinkJSDelete` class

- **requestUri** - route for request
- **method = 'POST'** - request method
- **icon** - awesome icon from [Font Awesome](https://fontawesome.com/) library
- **itemClass** - class of the element that will be removed if the action is confirmed
- **addClasses** - additional classes of **LinkJSDelete**
- **setModalTitle** - modal title text
- **setModalContent** - modal content text

```php
$linkJSDelete = (new LinkJSDelete('Remove rectangle'))
    ->requestUri('/')
    ->method('GET')
    ->icon('fa-trash-alt')
    ->itemClass('rectangle')
    ->addClasses(' btn-danger')
    ->setModalTitle('Rectangle deleting')
    ->setModalContent('Are you sure you want to delete Rectangle?');

$rectangle = new WrapperDiv('Rectangle');
$rectangle->addClass('border rectangle');
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::links`