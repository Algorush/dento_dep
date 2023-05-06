> Box

The functional is implemented using the `\Webmagic\Dashboard\Elements\Boxes\Box` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/layout/boxed.html)

A `card` is a flexible and extensible content container. It includes options for headers and footers, a wide variety of
content, contextual background colors, and powerful display options.

- **addBoxType** - method, ...
- **addBoxTitle** - method, set box title in header (you can pass html)
- **addBoxTools** - method, adding different content to the header (button, etc.)
- **addBoxBody** - method, adding different content to the box body
- **addBoxFooter** - method, adding different content to the box footer
- **addClass** - method, set class for box container
- **addBoxBodyClasses** - method, set class for box body
- **addBoxHeaderContent** - method, add different content to the box header after the title
- **addHeaderAvailable** - method, hide or show box header
- **addFooterAvailable** - method, hide or show box footer
- **addColorType** - method, background to change the appearance of a box (bg-primary, bg-secondary, bg-success,
  bg-danger, bg-warning, bg-info, bg-light, bg-dark) with a space at the beginning
- **addSolid** - method, ...
- **fullscreenBtn = true** - method, button to expand the content to full screen

`methods are called on the box object`

- **setToolsLinkButton** - method, sets only this one button in the header on the left
- **addToolsLinkButton** - method, adds another button to the header
- **makeSimple** - method, box without header and footer

### How to use

#### Method 1

```php
$box = (new Box())
    ->addBoxTitle('<b>This form can be expanded to full screen</b>')
    ->addBoxTools((new DefaultButton('Button'))->icon('fa-link')->render())
    ->addBoxBody([
        'content1',
        (new TableGenerator())->items($items),
    ])
    ->addBoxFooter('Footer')
    ->addClass(true)
    ->addBoxBodyClasses('')
    ->addBoxHeaderContent('<p style="float: left;"><b> - SubTitle in header box</b></p>')
    ->addHeaderAvailable(true)
    ->addFooterAvailable(true)
    ->addColorType(' bg-info')
    ->addSolid(true)
    ->showFullscreenBtn()
);

$box->setToolsLinkButton(route('dashboard.docs.presentation.box'), 'Create', 'fa-plus', 'btn-primary');
$box->addToolsLinkButton(route('dashboard.docs.presentation.box'), 'Clone', 'fa-clone', 'btn-info');
```
