> Image

The functional is implemented using the `\Webmagic\Dashboard\Elements\Image` class

Functionality allows you to display image by `<img>` tag. The `<img>` tag is used to embed an image in an HTML page.

- **addClass** - add class for image tag
- **addContent, src** - specifies the path to the image
- **alt** - specifies an alternate text for the image, if the image for some reason cannot be displayed
- **attr, attrs** - add custom attributes

### How to use

```php
$src = asset('/webmagic/dashboard/img/default_logo.png');

$imageElement = (new Image())
    ->src($src);
    ->alt('Webmagic logo')
    ->attr('data-src', $src)
``` 

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::image`