Using inherited classes of ***\Webmagic\Dashboard\Elements\Graphics\Graphic***, you can create widgets.

### SimpleWidget

Class **\Webmagic\Dashboard\Elements\Widgets\SimpleWidget**

- **icon** - icon of widget
- **iconColor** - color of icon
- **iconBackgroundColor** - background of icon
- **backgroundColor** - background of widget
- **title** - title section
- **message** - message section
- **class** - custom class for widget block

#### Example of SimpleWidget

```php
(new SimpleWidget())
    ->message('1,410')
    ->title('Messages')
    ->iconBackgroundColor('#17a2b8')
    ->iconColor('#fff')
    ->backgroundColor('#fff')
    ->class('custom_class')
    ->icon('fa-envelope')
    ->textColor('#000');
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::simpleWidget`

Also, you can look up at [AdminLTE page](https://adminlte.io/themes/v3/pages/widgets.html)
