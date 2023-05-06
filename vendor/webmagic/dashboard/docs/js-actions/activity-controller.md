The functionality allows you to control the properties of an element:
* active / inactive
* show / hide

The functional is implemented using the ``\Webmagic\Dashboard\Core\Content\JsActionsApplicable\ActivityController`` class

---  

### Active/Inactive

```php
$inputText = new Input('input text');
$inputText->js()->activityController()->addDisabilityController(".$checkboxForInputId", false);
``` 

``$inputText`` is target.  

```php
$checkboxForInput = new Checkbox();
$checkboxForInput->addClass($checkboxForInputId);
$checkboxForInput->checked(false);
``` 

``$checkboxForInput`` is controller.  
When user click on controller, target become disabled.  
Function ``addDisabilityController`` has second argument which decides to apply property right now or after control event.

### Show/Hide

```php
$formBlock = $this->getFormForActivityController();
$formBlock->js()->activityController()->addVisibilityController(".$formBlockClass", false);
```
``$inputText`` is target.
```php
$checkboxForForm = new Checkbox();
$checkboxForForm->content('Uncheck to show form');
$checkboxForForm->checked(true);
$checkboxForForm->addClass($formBlockClass);
```
``$checkboxForForm`` is controller.   
When user click on controller, target become visible, because by default controller checked.  
Function ``addVisibilityController`` also has second argument like previous function.  

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\JSActionsPresentationController::activityController``