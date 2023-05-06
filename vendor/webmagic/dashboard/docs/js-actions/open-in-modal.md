Functionality allows you to show modal window by clicking or changing an element 
and display the data received from the server in the window.  

The functional is implemented using  
``\Webmagic\Dashboard\JsActions\OpenInModalOnClick`` class and    
``\Webmagic\Dashboard\JsActions\OpenInModalOnChange`` class
    
```php
$button = new DefaultButton('click');
$button->js()->openInModalOnClick()->regular(
    $route,
    $method = 'POST',
    $title = '',
    $modalSize = '',
    $reloadOnClose = false
);
```
  
The modal window will contain the result of the request to route ``$route``.  
``$reloadOnClose`` - is to reload the after closing popup.  

``$modalSize`` - takes 3 values:
* empty string
* modal-sm
* modal-lg

You can also replace the ``regular`` function call with ``smallModal`` or ``bigModal``. 
The difference with the regular function is that it lacks the 4th parameter - ``$modalSize``.

If you need to show popup not by clicking, but by changing the element, then use ``openInModalOnChange`` instead of ``openInModalOnClick``.  
  
For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\JSActionsPresentationController::openInModal``