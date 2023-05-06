'Hide show on click' is a js action which helps to hide/show block on click on element. 'Hide show on click' applyes by attaching it to the element with ``js()`` method.

```php
$btnController = (new DefaultButton())->content('Hide/show form')
    ->js()->hideShowOnClick()->makeHideShowController('box_class');
``` 

Pass in makeHideShowController class name of element which you want to hide/show  
Also, makeHideShowController take second parameter - showTargetBlock (default: true).  
Second parameter responsible for displaying block initially or not