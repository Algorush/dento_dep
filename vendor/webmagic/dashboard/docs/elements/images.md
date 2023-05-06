> Image Preview

The functional is implemented using the `\Webmagic\Dashboard\Elements\Files\ImagePreview` class

Image preview features.

- **string imgUrl** - path to image
- **string size** - string that tells the user the size of the image file
- **string downloadUrl** - path to download image
- **string fileName** - file name

### How to use

#### Method 1

```php
(new FormGenerator())->imageInput('image', $img, 'Image title', '10 Mb')
```

#### Method 2

```php
(new FormPageGenerator())->imageInput('image', $img, 'Image title', '10 Mb')
```

#### Method 3

```php
app(\Webmagic\Dashboard\Elements\Factories\ElementsFactory::class)->imagePreview()
```

#### Method 4

```php
app(\Webmagic\Dashboard\Elements\Factories\ElementsFactory::class)
    ->imagePreview()
    ->imgUrl($img)
    ->size('100 Mb')
    ->downloadUrl($img)
```

#### Method 5

Image input for using inside form

```php
app(\Webmagic\Dashboard\Elements\Factories\ElementsFactory::class)
    ->imageInput()
    ->addClass('col-6  col-md-4 col-lg-3')
    ->imgUrl($img)
    ->size('10 Mb')
    ->width('50')
    ->height('14')
    ->title('Image input for using inside form')
```

#### Method 6

Standalone full functional image input  
Allows you to use visually the same element as imageInput, but with ajax image loading and deleting
- **width** and **height** - image size in caption
- **title** - title
- **action** - url for processing and saving the image
- **method** - method for processing and saving the image
- **deleteAction** - url to remove image
- **deleteMethod** - method to remove image
- **noCaching** - doesn't use cache for image (default: true)


```php
app(\Webmagic\Dashboard\Elements\Factories\ElementsFactory::class)
    ->imageComponent()
    ->addClass('col-6  col-md-4 col-lg-3')
    ->imgUrl($img)
    ->size('10 Mb')
    ->width('50')
    ->height('14')
    ->title('Cool image component')
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::imageDisplaying`