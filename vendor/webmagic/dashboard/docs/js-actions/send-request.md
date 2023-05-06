Functionality allows you to send a request and, if necessary, display a response.  
  
The functional is implemented using  
``\Webmagic\Dashboard\JsActions\SendRequestOnClick`` class and  
``\Webmagic\Dashboard\JsActions\SendRequestOnChange`` class

```php
$button = new DefaultButton('Click');
$button->js()->sendRequestOnClick()->regular(
    $route, 
    $paramsForRequest = [], 
    $method = 'POST', 
    $successNotification = true, 
    $errorNotification = false, 
    $reloadOnSuccess = false,
    $successNotificationTitle = null,
    $successNotificationText = null
);
``` 

If the response from the server is success and `$successNotification` is `true` then a popup
will be shown with the data from the parameters `$successNotificationTitle` (as title) 
and `$successNotificationText` (as message text)  

After clicking button, request will be executed
* to route ``$route`` 
* using the ``POST`` method 
* with additional ``$paramsForRequest`` parameters 
* notifying the user about the successful execution of the request
* without notifying about the error of the request
* and without reloading the page.

You can also output the result to a block.  
For it use ``showResponse`` function:  
```php
$button = new DefaultButton('Click');
$button->js()->sendRequestOnClick()->showResponse(
    $routeWithResultBlock, 
    $classOfBlockForShowingResult = '.result-block', 
    $paramsForRequest = ['some' => 'Value for result block.'],
    $successNotification = true, 
    $errorNotification = false, 
    $reloadOnSuccess = false,
    $successNotificationTitle = null,
    $successNotificationText = null
);
``` 
  
Also, you can execute request with replace target block.  
For it use ``replaceWithResponse`` function:  
```php
$button = new DefaultButton('Click');
$button->js()->sendRequestOnClick()->replaceWithResponse(
    $routeWithResultBlock, 
    $classOfBlockForReplaceByResponse = '.replace-block', 
    $paramsForRequest = ['some' => 'Value for replace block.'],
    $successNotification = true, 
    $errorNotification = false, 
    $reloadOnSuccess = false,
    $successNotificationTitle = null,
    $successNotificationText = null
);
``` 
  
For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\JSActionsPresentationController::sendRequest``  