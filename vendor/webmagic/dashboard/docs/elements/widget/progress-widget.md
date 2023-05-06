Using inherited classes of ***\Webmagic\Dashboard\Elements\Graphics\Graphic***, you can create widgets.

### ProgressWidget

Class **\Webmagic\Dashboard\Elements\Widgets\ProgressWidget**

- **icon** - icon of widget
- **iconBackgroundColor** - background of icon
- **title** - title section
- **message** - message section
- **class** - custom class for widget block
- **description** - description section
- **backgroundColor** - background of widget
- **textColor** - color of text
- **progress** - value from 0 to 100 percent
- **progressColor** - color of progress bar line

#### Example of ProgressWidget

```php
(new ProgressWidget())
    ->message('41,410')
    ->description('70% Increase in 30 Days')
    ->progress(70)
    ->title('Bookmarks')
    ->textColor('#fff')
    ->iconBackgroundColor('#17a2b8')
    ->backgroundColor('#17a2b8')
    ->class('classes')
    ->icon('fa-bookmark');
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::progressWidget`

Also, you can look up at [AdminLTE page](https://adminlte.io/themes/v3/pages/widgets.html)
