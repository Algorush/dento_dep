> Grid

The functional is implemented using the `\Webmagic\Dashboard\Elements\Grid\Grid` class

[Bootstrap grid system](https://getbootstrap.com/docs/5.0/layout/grid/)

Use our powerful mobile-first flexbox grid to build layouts of all shapes and sizes thanks to a twelve column system,
4 default responsive tiers. By default, use: col-xs-12 col-sm-12 col-md-3 col-lg-2

- **xsRowCount = 1** - method, number of grid tiers for xs breakpoint
- **smRowCount = 1** - method, number of grid tiers for sm breakpoint
- **mdRowCount = 4** - method, number of grid tiers for md breakpoint
- **lgRowCount = 6** - method, number of grid tiers for lg breakpoint
- **beforeGrid** - method, add other content before grids
- **afterGrid** - method, add other content after grids
- **rowClass** - method, add class for row

### How to use

#### Method 1

Use methods (xsRowCount, smRowCount, mdRowCount, lgRowCount) to set the number of grids per row

```php
$grid = (new Grid())
    ->xsRowCount(1)
    ->addContent([
        (new Box())
            ->showFullscreenBtn()
            ->boxHeaderContent("<b>$boxHeader</b>")
            ->content([
                (new FormGroup())->select('outgoing_account_id', [1 => 'Option 1', 2 => 'Option 2'], '', 'Account', true),
                (new FormGroup())->dateInput('outgoing_date', now(), 'Date', true),
                (new FormGroup())->numberInput('value', 0, 'Value', true, 0.01),
                (new FormGroup())->numberInput('outgoing_commission', 0, 'Commission', false, 0.01),
                (new FormGroup())->select('outgoing_contractor_id', [1 => 'Option 1', 2 => 'Option 2'], '', 'Contractor'),
            ])
    ])
```

#### Method 2

Also, you can set data before and after grid.

```php
$grid = (new Grid())
    ->addContent([
        (new Box())
            ->showFullscreenBtn()
            ->boxHeaderContent("<b>$boxHeader</b>")
            ->content([
                (new FormGroup())->select('outgoing_account_id', [1 => 'Option 1', 2 => 'Option 2'], '', 'Account', true),
                (new FormGroup())->dateInput('outgoing_date', now(), 'Date', true),
                (new FormGroup())->numberInput('value', 0, 'Value', true, 0.01),
                (new FormGroup())->numberInput('outgoing_commission', 0, 'Commission', false, 0.01),
                (new FormGroup())->select('outgoing_contractor_id', [1 => 'Option 1', 2 => 'Option 2'], '', 'Contractor'),
            ])
    ])
    ->beforeGrid('Content before grid')
    ->afterGrid('Content after grid');
```

#### Method 3

By using element grid, you can build forms like so.

```php
(new FormPageGenerator())->getBox()->element()->grid([
    (new Box())
        ->showFullscreenBtn()
        ->boxHeaderContent('<b>From</b>')
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
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::grid`
