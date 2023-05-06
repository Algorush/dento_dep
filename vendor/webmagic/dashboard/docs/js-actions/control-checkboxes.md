# Controlled checkboxes

Controlled checkboxes js action provide a possibility to organize control the checkboxes group by using a control
element. The js action provide a possibility to use 3 types of control element: checkbox, button and dropdown

## Controlled checkboxes creating

Mark checkboxes with group identifier which will be used for control their states

```php
    $checkboxGroupIdentifier = 'some_group'; // may be any value
    $unchecked = false; // should uncheck checkbox when control element is checked (default: false)

    $checboxOne = (new \Webmagic\Dashboard\Elements\Forms\Elements\Checkbox())
                ->js()->checkboxGroupsControl()->addCheckboxToControlledGroup($checkboxGroupIdentifier, $unchecked)
                ->content('Checkbox One');
     
    $checboxTwo = (new \Webmagic\Dashboard\Elements\Forms\Elements\Checkbox())
                ->js()->checkboxGroupsControl()->addCheckboxToControlledGroup($checkboxGroupIdentifier, $unchecked)
                ->content('Checkbox Two');     
```

## Control checkboxes group by using checkbox

Create checkbox which will be a controller

```php
    $checkboxController = (new \Webmagic\Dashboard\Elements\Forms\Elements\Checkbox())
        ->js()->checkboxGroupsControl()->makeCheckboxGroupController($checkboxGroupIdentifier, $unchecked)
        ->content('Checkbox group controller');
```

## Control checkboxes group by using button

Create checkbox which will be a controller

```php
    $button = (new \Webmagic\Dashboard\Elements\Buttons\DefaultButton())
                ->class('btn-default')
                ->js()->checkboxGroupsControl()
                ->makeButtonGroupController($checkboxGroupIdentifier, $unchecked)
                ->content('Checkbox group controller')
                ->icon('fa-check')      
```
Also, for method ``makeButtonGroupController`` exist third optional parameter - ``string $uncheckedEl``  
You can pass class of elements which can unchecked (rest of checkboxes on the page can't be unchecked):

```php
    (new FormGroup(
        (new \Webmagic\Dashboard\Elements\Buttons\DefaultButton())
            ->class('btn-default')
            ->js()->checkboxGroupsControl()
            ->makeButtonGroupController('some_group', false, 'checkbox_group_can_be_unselect')
            ->content('Checkbox group controller')
            ->icon('fa-check')
    )),
    (new \Webmagic\Dashboard\Elements\Forms\Elements\Checkbox('Button can unselect this checkbox'))
        ->addClass($checkboxGroupCanBeUnselect)
        ->js()->checkboxGroupsControl()->addCheckboxToControlledGroup('other_control_group_class', $unchecked),
    '<br>',
    (new \Webmagic\Dashboard\Elements\Forms\Elements\Checkbox('Button CAN\'t unselect this checkbox'))
        ->js()->checkboxGroupsControl()->addCheckboxToControlledGroup('other_control_group_class', $unchecked),
    '<br>',
```

In code example above note class checkbox with label 'Button can unselect this checkbox' and to third parameter of ``makeButtonGroupController`` method.  
Look at live example below for better understanding.