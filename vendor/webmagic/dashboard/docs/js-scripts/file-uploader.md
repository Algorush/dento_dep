This functionality is used to upload files to the server using a plugin [FilePond](https://pqina.nl/filepond/).

### How to use

Add an input element with **```type="file"```**, add the **```'js_filepond'```** class to this element.
If we need to upload multiple files at once add the **```multiple```** attribute.

For the input, you need to set the data attributes:
* **data-url** - route to which requests for file uploads will go;
* **accept** - indicate which file formats can be uploaded;
* **data-max-file-size** - maximum file size that can be uploaded;
* **data-max-files** - maximum number of files that can be uploaded;
* **data-url-delete** - route to delete files, if this attribute is not set, then the delete request will go to the 
route **data-url** with __method='DELETE'_ ;
* **data-files** - an array of files to be displayed in the gallery;
* **data-allow-reorder** - allow users to reorder files with drag and drop interaction. Note that this only works in single 
column mode. It also only works on browsers that support pointer events.

[List of all options](https://pqina.nl/filepond/docs/api/instance/properties/), which can be set data attributes,
example added option **allowReorder** -> **data-allow-reorder="true"**

##### Example:
```html
<input type="file"
       class="js_filepond"
       name="filepond"
       multiple
       data-url="http://localhost:8080/process"
       data-url-delete="http://localhost:8080/delete"
       data-files='["https://images.pexels.com/photos/414612/pexels-photo-414612.jpeg","/webmagic/dashboard/img/default-image-png.png"]'
       data-allow-reorder="true"
       accept="image/png, image/jpeg, image/jpg"
       data-max-file-size="50MB"
       data-max-files="3">
```
