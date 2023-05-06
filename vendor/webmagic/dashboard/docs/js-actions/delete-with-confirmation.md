The functionality allows you to delete an element from the page after confirmation in a modal window, as well as a request will be sent to perform deletion actions on the server side  
  
The functional is implemented using the ``\Webmagic\Dashboard\JsActions\DeleteWithConfirmation`` class
```php
$record = new WrapperDiv();
$record->addClass($recordClass);

$removeButton = new DefaultButton();
$removeButton->addClass($removeButtonClass);
$removeButton->js()->deleteWithConfirmation()->regular($route,".$recordClass", 'POST', 'ModalTitle', 'ModalText');
``` 

When the user clicks on the ``$removeButton`` button, modal window will appear with 
the title ``ModalTitle`` and the text ``ModalText``, in which he will need to confirm 
his actions to remove the element.  
A request will be sent to route ``$route`` using the 
``POST`` method, after which the HTML element with the ``$recordClass`` class will be removed.  

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\JSActionsPresentationController::deleteWithConfirmation``