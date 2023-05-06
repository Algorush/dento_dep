There are two ways to implement multifields.

## Multifields simple

``` \Webmagic\Dashboard\Elements\Forms\MultifieldsElements\MultifieldsSimpleElement```

The MultifieldsSimpleElement class allows you to clone a group of elements.  
Using the **addFields** method, the types of elements (and their names) are set, which will be displayed in one line.  
Using the **setData** method, you can initialize elements with existing data  
The **maxCopyCount** method sets the maximum possible number of clones.  
Supported classes (and their inheritors):

- \Webmagic\Dashboard\Elements\Forms\Elements\Input
- \Webmagic\Dashboard\Elements\Forms\Elements\Textarea
- \Webmagic\Dashboard\Elements\Forms\Elements\DateRange
- \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker
- \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS
- \Webmagic\Dashboard\Elements\Forms\Elements\Select

### How to use

```php
$dashboard = new Webmagic\Dashboard\Dashboard();

$multifieldsSimpleElement = new \Webmagic\Dashboard\Elements\Forms\MultifieldsElements\MultifieldsSimpleElement();
$multifieldsSimpleElement->maxCopyCount(5);

$multifieldsSimpleElement->addFields(
    (new Webmagic\Dashboard\Elements\Forms\Elements\Input())->name('address'),
    (new Webmagic\Dashboard\Elements\Forms\Elements\Textarea())->name('textarea'),
    (new Webmagic\Dashboard\Elements\Forms\Elements\DateRange())->name('dateRange'),
    (new Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker())->name('dateTimePicker'),
    (new \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS())->name('selectJS')->options([1,2,3]),
    (new \Webmagic\Dashboard\Elements\Forms\Elements\Select)->name('select')->options([1,2,3])
);

$multifieldsSimpleElement->setData(
    [
        [
            'address' => 'address1',
            'textarea' => 'textarea2',
            'dateRange' => now(),
            'dateTimePicker' => now()->addDay(),
            'selectJS' => ['a' => 123, 'b', 'c'],
            'select' => ['a' => 456, 'b' => 789, 'c'],
        ],
        [
            'address' => 'address2',
            'textarea' => 'textarea2',
            'dateRange' => now()->addDays(5),
            'dateTimePicker' => now()->addDays(6),
            'selectJS' => ['c', 'd', 'e'],
            'select' => ['a' => 101112, 'b' => 131415, 'c'],
        ],
    ]
);

$formGenerator = new \Webmagic\Dashboard\Components\FormGenerator();
$formGenerator->action('/dashboard/tech/multifields-test');
$formGenerator->getForm()->addContent($multifieldsSimpleElement);
$formGenerator->addSubmitButton([],'Submit', 'btn btn-primary float-left ml-2');

$dashboard->addContent($formGenerator);

return $dashboard;
```  

## Multifields complex

``` \Webmagic\Dashboard\Elements\Forms\MultifieldsElements\MultifieldsComplexElement```

The main difference from MultifieldsSimpleElement is the use of entity identifiers.  
MultifieldsComplexElement added:

- required entity name in constructor
- method ``setAddButtonUrl`` with 2 parameters - link, method for sending data. An identifier should be returned in
  response.
- ``setRemoveButtonUrl`` method with 2 parameters - link, method for sending data.
- extended ``setData`` method

The second parameter in ``setData`` - name of the identifier key [default = 'id'].  
It is needed in order to set the entity identifier in the database when initializing data

### How to use

```php
$dashboard = new Webmagic\Dashboard\Dashboard();

$multifieldsComplexElement = new \Webmagic\Dashboard\Elements\Forms\MultifieldsElements\MultifieldsSimpleElement();
$multifieldsComplexElement->setAddButtonUrl('/dashboard/tech/multifields-add', 'POST');
$multifieldsComplexElement->setRemoveButtonUrl('/dashboard/tech/multifields-delete', 'DELETE');
$multifieldsComplexElement->maxCopyCount(7);

$multifieldsComplexElement->addFields(
    (new Webmagic\Dashboard\Elements\Forms\Elements\Input())->name('address'),
    (new Webmagic\Dashboard\Elements\Forms\Elements\Textarea())->name('textarea'),
    (new Webmagic\Dashboard\Elements\Forms\Elements\DateRange())->name('dateRange'),
    (new Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker())->name('dateTimePicker'),
    (new \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS())->name('selectJS')->options([1,2,3]),
    (new \Webmagic\Dashboard\Elements\Forms\Elements\Select)->name('select')->options([1,2,3])
);

$multifieldsComplexElement->setData(
    [
        [
            'idKey' => 12312312,
            'address' => 'address1',
            'textarea' => 'textarea2',
            'dateRange' => now(),
            'dateTimePicker' => now()->addDay(),
            'selectJS' => ['a' => 123, 'b', 'c'],
            'select' => ['a' => 456, 'b' => 789, 'c'],
        ],
        [
            'idKey' => 35435435,
            'address' => 'address2',
            'textarea' => 'textarea2',
            'dateRange' => now()->addDays(5),
            'dateTimePicker' => now()->addDays(6),
            'selectJS' => ['c', 'd', 'e'],
            'select' => ['a' => 101112, 'b' => 131415, 'c'],
        ],
    ],
    'idKey'
);

$formGenerator = new \Webmagic\Dashboard\Components\FormGenerator();
$formGenerator->action('/dashboard/tech/multifields-test');
$formGenerator->getForm()->addContent($multifieldsSimpleElement);
$formGenerator->addSubmitButton([],'Submit', 'btn btn-primary float-left ml-2');

$dashboard->addContent($formGenerator);

return $dashboard;
```  
