> Multifields complex

The functional is implemented using
the `\Webmagic\Dashboard\Elements\Forms\MultifieldsElements\MultifieldsComplexElement` class

Multifields allows you to clone a group of elements a given number of times.
The main difference from MultifieldsSimpleElement is the use of entity identifiers.

- **addFields** - method, the types of elements (and their names) are set, which will be displayed in one line.
- **setData** - method, you can initialize elements with existing data.The second parameter name of the identifier
  key [default = 'id']. It is needed in order to set the entity identifier in the database when initializing data
- **maxCopyCount** - method sets the maximum possible number of clones.
- **setAddButtonUrl** - method with 2 parameters - link, method for sending data. An identifier should be returned in
  response.
- **setRemoveButtonUrl** - method with 2 parameters - link, method for sending data.

Supported classes (and their inheritors):

- \Webmagic\Dashboard\Elements\Forms\Elements\Input
- \Webmagic\Dashboard\Elements\Forms\Elements\Textarea
- \Webmagic\Dashboard\Elements\Forms\Elements\DateRange
- \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker
- \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS
- \Webmagic\Dashboard\Elements\Forms\Elements\Select
- \Webmagic\Dashboard\Elements\Forms\Elements\Checkbox

### How to use

```php
$dashboard = new Webmagic\Dashboard\Dashboard();

$multifieldsComplexElement = new \Webmagic\Dashboard\Elements\Forms\MultifieldsElements\MultifieldsComplexElement('entity_given_name');
$multifieldsComplexElement->maxCopyCount(7);
$multifieldsComplexElement->setAddButtonUrl('/dashboard/tech/multifields-add', 'POST');
$multifieldsComplexElement->setRemoveButtonUrl('/dashboard/tech/multifields-delete', 'DELETE');

$multifieldsComplexElement->addFields(
    (new \Webmagic\Dashboard\Elements\Forms\Elements\Input())->name('input'),
    (new \Webmagic\Dashboard\Elements\Forms\Elements\Textarea())->name('textarea'),
    (new \Webmagic\Dashboard\Elements\Forms\Elements\DateRange())->name('dateRange'),
    (new \Webmagic\Dashboard\Elements\Forms\Elements\DateTimePicker())->setDateFormat('Y/m/d')->name('dateTimePicker'),
    (new \Webmagic\Dashboard\Elements\Forms\Elements\SelectJS())->name('selectJS')->options([1,2,3]),
    (new \Webmagic\Dashboard\Elements\Forms\Elements\Select)->name('select')->options([1,2,3]),
    (new \Webmagic\Dashboard\Elements\Forms\Elements\Checkbox())->name('checkbox')->checked(true)
);

$multifieldsComplexElement->setData(
    [
        [
            'idKey' => 12312312,
            'input' => '1',
            'textarea' => 'textarea2',
            'dateRange' => now(),
            'dateTimePicker' => now()->addDay(),
            'selectJS' => ['a' => 123, 'b', 'c'],
            'select' => ['a' => 456, 'b' => 789, 'c'],
            'checkbox' => true,
        ],
        [
            'idKey' => 35435435,
            'input' => '2',
            'textarea' => 'textarea2',
            'dateRange' => now()->addDays(5),
            'dateTimePicker' => now()->addDays(6),
            'selectJS' => ['c', 'd', 'e'],
            'select' => ['a' => 101112, 'b' => 131415, 'c'],
            'checkbox' => false,
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