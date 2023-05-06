Using inherited classes of ***\Webmagic\Dashboard\Elements\Graphics\Graphic***, you can create widgets.

### BoxWidget

Class **\Webmagic\Dashboard\Elements\Widgets\BoxWidget**

- **icon** - icon of widget
- **title** - title section
- **message** - message section
- **class** - custom class for widget block
- **description** - description section
- **backgroundColor** - background of widget
- **textColor** - color of text
- **link** - url
- **lintTitle** - text of link
- **linkIcon** - icon before link

#### Example of BoxWidget

```php
(new BoxWidget())
    ->description('New Orders')
    ->title('150')
    ->textColor('#fff')
    ->backgroundColor('#17a2b8')
    ->class('classes')
    ->icon('fa-shopping-cart')
    ->link('www.google.com')
    ->linkTitle('More info')
    ->linkIcon('fa-arrow-circle-right');
```

---

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::boxWidget`

Also, you can look up at [AdminLTE page](https://adminlte.io/themes/v3/pages/widgets.html)
