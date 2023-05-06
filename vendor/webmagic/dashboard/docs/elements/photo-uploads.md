> Photo uploading

The functional is implemented using the `\Webmagic\Dashboard\Elements\Files\PhotoUploader` class.

Photo uploading component provides a basic functionality for uploading and deleting images. Photo uploading component
can be used as the part of a form or as a standalone component. For file uploads, there's a very popular JavaScript
library called [FilePond](https://pqina.nl/filepond/).

The image sends on back-end just after selection. Dashboard API image uploading and deleting route will be set as a
default when photo uploading element generates by ``\Webmagic\Dashboard\Components\FormGenerator``
. ``\Webmagic\Dashboard\Api\Http\ImagesController`` handles these routes. The images will be store
in ``storage/app/public`` directory and will be available with url ``/storage/path_to_image``. The image public path
will be returned after the image was store.

Image storing path can be changed in ``config/webmagic/dashboard/dashboard.php::images_directory``. For making photos
available for
front-end [the storage public symbolic link should be generated](https://laravel.com/docs/9.x/filesystem#the-public-disk)

The photo uploading and deleting process can be handled manually by defining custom urls.

The request for upload photo sends as POST request. The request for deleting photo sends as DELETE request. Detailed
implementation of uploading and deleting process can be seen in ``\Webmagic\Dashboard\Api\Http\ImagesController``

- **string $name** - name of element
- **array $images = []** - array of uploaded photos
- **string $labelTxt = ''** - label
- **bool $required = false** - is required
- **bool $multiple = true** - if true set, means the form control accepts one or more values
- **string $requestUrl = null** - route for processing the uploaded image
- **string $deleteUrl = null** - route for processing remote image
- **array $attributes = []** - additional attributes

### How to use

#### Method 1

```php
(new FormGroup())->imageArea(
    'photos[]', 
    ['dashboard/images/photo.jpg', 'dashboard/images/photo2.jpg'], 
    'Photo upload', 
    false, 
    true, 
    route('dashboard.docs.presentation.photo-uploading'), 
    route('dashboard.docs.presentation.photo-uploading')
);
```  

#### Method 2

```php
(new FormGenerator())->imageArea(
    'photos[]', 
    ['dashboard/images/photo.jpg', 'dashboard/images/photo2.jpg'], , 
    'Photo upload', 
    false, 
    true, 
    route('dashboard.docs.presentation.photo-uploading'), 
    route('dashboard.docs.presentation.photo-uploading')
);
```  

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->imageArea(
    'photos[]',
    ['dashboard/images/photo.jpg', 'dashboard/images/photo2.jpg'],
    'Photo upload',
    false,
    true,
    route('dashboard.api.image.upload'),
    route('dashboard.api.image.delete')
);
```  

#### Method 4

Photo uploading component can be used as a standalone component by
using ``\Webmagic\Dashboard\Elements\Files\PhotoUploader`` class. In this case all params should be set by
the ``\Webmagic\Dashboard\Elements\Files\PhotoUploader`` functions.

```php
(new PhotoUploader())
    ->images('https://images.pexels.com/photos/414612/pexels-photo-414612.jpeg')
    ->addName('photos[]')
    ->required(false)
    ->deleteUrl(route('dashboard.docs.presentation.photo-uploading'))
    ->requestUrl(route('dashboard.docs.presentation.photo-uploading'))
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::photoUploading``
