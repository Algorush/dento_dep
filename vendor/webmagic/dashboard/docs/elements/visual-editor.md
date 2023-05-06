> Visual Editor

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\VisualEditor` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/editors.html)

Visual Editor is an element based on CKEditor and styled for work with AdminLTE panel.Visual editor params which you can
configure on back-end are almost the same as in TextArea. The main elements features are implemented on front-end.
Here is only one important feature which you can control on back end is possibility to turn on uploading images.
Any selected image will be converted into Base64 format and will be sent together with the content. However, the images
can be also saved on the server.

After change content of element you can send ajax request.

- **string $name** - name of element
- **$valueOrDataSource = null** - value
- **string $labelTxt = ''** - label for editor
- **bool $required = false** - is required
- **array $attributes = []** - additional attributes
- **string $imageUploadUrl = null** - route for uploading an image to the server
- **string $urlOnChange = null** - route to process when the focus on the editor changes
- **string $methodOnChange = 'POST'** - method for on blur event
- **bool $showSuccessMessage = false** - is show success message, when success response after on blur event
- **bool $showErrorMessage = true** - is show error message, when error response after on blur event
- **bool $showSpinnerOnBlur = true** - show spinner while load content of editor to server on blur event

### How to use

#### Method 1

```php
(new FormGroup())->visualEditor('visual-editor', 'Some content', 'Visual Editor');
```

#### Method 2

```php
(new FormGenerator())->visualEditor('visual-editor', 'Some content', 'Visual Editor')
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->visualEditor('visual-editor', 'Some content', 'Visual Editor')
```

#### Method 4

```php
(new VisualEditor())
    ->content('Some content for visual editor')
    ->title('Title')
    ->name('visual-editor-class')
    ->rows(5)
    ->methodOnBlur('GET')
    ->urlOnBlur(route('dashboard.docs.presentation.visual-editor.on-blur'))
    ->turnOnFileUpload('my-site.com/route/for-saving-images')  // route for uploading the photos
    ->showSuccessMessage()
    ->showErrorMessage()
    ->showSpinnerOnBlur(true)
```

Depends on the image saving result you should send back the next responses.

For success

```json
{
  "uploaded": 1,
  "fileName": "foo.jpg",
  "url": "/files/foo.jpg"
}
```

For error

```json
{
  "uploaded": 0,
  "error": {
    "message": "The file is too big."
  }
}
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::visualEditor`
