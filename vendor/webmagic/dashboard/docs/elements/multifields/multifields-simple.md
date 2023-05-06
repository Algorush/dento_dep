> Multifields simple

The functional is implemented using
the `\Webmagic\Dashboard\Elements\Forms\MultifieldsElements\MultifieldsSimpleElement` class

Multifields simple allows you to clone a group of elements a given number of times.

- **addFields** - method, the types of elements (and their names) are set, which will be displayed in one line.
- **setData** - method, you can initialize elements with existing data
- **maxCopyCount** - method sets the maximum possible number of clones.

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