Functionality that allows you to send a request to the server and replace the element,   
on which this function was called,  
with a response from the server.  
The functional is implemented using the ``\Webmagic\Dashboard\Core\Content\JsActionsApplicable\ContentAutoUpdate`` class  

```php
$icon = new Icon('fa-cog fa-spin');

$serverTimeStringFormatted = 'Updating button < Server time - ' . now()->format('H:i:s') . ' >';

$button = new DefaultButton();
$button->content($icon . $serverTimeStringFormatted);

$button->js()->contentAutoUpdate()->replaceCurrentElWithContent(route('dashboard.docs.presentation.auto-update-button'), 'GET', 5000);
```

In this example, every ``5000 milliseconds``, an AJAX request is sent to the server using the ``GET`` method to the address ``route('dashboard.docs.presentation.auto-update-button')``.  
This route returns exactly the same button but with the updated server time.
For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::autoUpdate``