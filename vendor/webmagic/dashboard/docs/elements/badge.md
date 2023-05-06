> Badge

The functional is implemented using `\Webmagic\Dashboard\Elements\Badge` class

Labels are used to provide additional information about something. `SPAN` tag is used.

- **addClass** - add a class to define the color of the badge
- **addContent** - add content to the badge

### How to use

```php
(new Badge('Badge'))->addClass('badge-primary');
(new Badge('Badge'))->addClass('badge-secondary');
(new Badge('Badge'))->addClass('badge-success');
(new Badge('Badge'))->addClass('badge-danger');
(new Badge('Badge'))->addClass('badge-warning');
(new Badge('Badge'))->addClass('badge-info');
(new Badge('Badge'))->addClass('badge-light');
(new Badge('Badge'))->addClass('badge-dark');
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::badge`  