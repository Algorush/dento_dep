Functionality allows you to edit text and send data to the server.  
The functional is implemented using `\Webmagic\Dashboard\JsActions\EditableText` class  
  
```php
$div = new WrapperDiv('content');

return $div->js()->editableText()->regular(
    $name, 
    $url, 
    $method = 'POST', // string 
    $showEditableMark = true // bool
);
```
  
After apply edit (click on green button) will send ajax request to *$url* with *$name* and edited value by *$method*.    
If you cancel changes (click on red button), value of element backs to previous value (value get after last request).  

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\JSActionsPresentationController::prepareEditableTextExample`