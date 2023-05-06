> Progress bar

The functional is implemented using the `\Webmagic\Dashboard\Elements\ProgressBar\ProgressBar` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/UI/general.html)

A progress bar can be used to show a user how far along he/she is in a process.

- **title** - title, written above the progress bar
- **progress** - progress bar value (0 to 100)
- **striped** - progress style
- **thickness** - progress bar different sizes ('', 'progress-sm', 'progress-xs', 'progress-xxs')
- **color** - custom color
- **setThicknessSmall** - method to make the progress bar look thinner in line thickness
- **setThicknessMini** - method to make the progress bar look mini in line thickness
- **setThicknessMicro** - method to make the progress bar look like a thin line
- **setColorPrimary** - method for specifying the color of the progress bar (#007bff - blue)
- **setColorSecondary** - method for specifying the color of the progress bar (#6c757d - grey)
- **setColorSuccess** - method for specifying the color of the progress bar (#28a745 - green)
- **setColorDanger** - method for specifying the color of the progress bar (#dc3545 - red)
- **setColorWarning** - method for specifying the color of the progress bar (#ffc107 - yellow)
- **setColorInfo** - method for specifying the color of the progress bar (#17a2b8 - bright cyan)
- **setColorDark** - method for specifying the color of the progress bar (#343a40 - dark)

### How to use

#### Method 1

Simple progress bar with default settings

```php
$progressBar = new \Webmagic\Dashboard\Elements\ProgressBar\ProgressBar();
```

#### Method 2

Progress bar striped with title

```php
$progressBar = new \Webmagic\Dashboard\Elements\ProgressBar\ProgressBar()
    ->title('Progress bar striped with title')
    ->progress(15)
    ->striped(true)
    ->setColorPrimary();
```

#### Method 3

Progress bar thinnest with custom color (bg-info)

```php
$progressBar = new \Webmagic\Dashboard\Elements\ProgressBar\ProgressBar();
    ->progress(85)
    ->color('bg-info');
```

#### Method 4

Progress bar of medium thickness with preset green color

```php
$progressBar = new \Webmagic\Dashboard\Elements\ProgressBar\ProgressBar();
    ->progress(25)
    ->setColorSuccess()
    ->setThicknessMini();
```

#### Method 5

Progress bar of medium thickness with preset red color

```php
$progressBar = new \Webmagic\Dashboard\Elements\ProgressBar\ProgressBar();
    ->progress(45)
    ->setColorDanger()
    ->setThicknessMicro()
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::progressbar`