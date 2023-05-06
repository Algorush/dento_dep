# Form page generation with form group

One way to generate a form is to use the `FormPageGenerator` class with `FormGroup`

```php
$formPageGenerator = (new \Webmagic\Dashboard\Components\FormPageGenerator())
    ->title('Creating new movement from account to account ')
    ->action(route('/'));

$formPageGenerator->getBox()->element()->grid([
    (new Box())
        ->boxHeaderContent('From')
        ->content([
            (new FormGroup())->select('outgoing_account_id', [1 => 'Option 1', 2 => 'Option 2'], '', 'Account', true),
            (new FormGroup())->dateInput('outgoing_date', now(), 'Date', true),
            (new FormGroup())->numberInput('value', 0, 'Value', true, 0.01),
            (new FormGroup())->numberInput('outgoing_commission', 0, 'Commission', false, 0.01),
            (new FormGroup())->select('outgoing_contractor_id', [1 => 'Option 1', 2 => 'Option 2'], '', 'Contractor'),
        ]),
    (new Box())
        ->boxHeaderContent('&nbsp')
        ->content([
            (new FormGroup())->numberInput('rate', 1, 'Rate', true, 0.01),
            (new FormGroup())->textarea('comment', '', 'Comment', false, ['rows' => 8]),
        ]),
    (new Box())
        ->boxHeaderContent('<b>To</b>')
        ->content([
            (new FormGroup())->select('incoming_account_id', [1 => 'Option 1', 2 => 'Option 2'], '', 'Account', true),
            (new FormGroup())->datePickerJS('incoming_date', now(), 'Date', true),
            (new FormGroup())->numberInput('value', 0, 'Value', true, 0.01),
            (new FormGroup())->numberInput('incoming_commission', 0, 'Commission', false, 0.01),
            (new FormGroup())->select('incoming_contractor_id', array_prepend([1 => 'Option 1', 2 => 'Option 2'], '', ''), '', 'Contractor'),
        ]),
    ])->lgRowCount(3);

$formPageGenerator->submitButtonTitle('Make transaction and go to it');

return $formPageGenerator;
```