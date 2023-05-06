This functionality for notifications after send ajax data with plugin toastr.

### How to use
When sending an ajax message from the server is returned **data.responseJSON.message**.

JSON structure for error message:

```json
{
  "message": 'Message text after sending'
}
```

If you need to display a many of **errors** in a message, then the structure should be like this (**data.responseJSON.errors**. - an array errors with arrays by inputs name):
```json
{
  "errors": 
    address[1]: 
      0: 'The address[1] must be an integer.'
      1: 'The address[1] is required'        
    address[2]:
      0: 'The address[2] must be an integer.'
    address[3]: 
      0: 'The address[3] must be an integer.'
}
```

If you need to display success a message, then the structure should be like this:  
```json
{
  "header": "Success header",
  "message": "Success message"
}
```

Through each _data.responseJSON.errors_, error messages are sorted out and are displayed in a pop-up window one by one, and in 
addition, by name, corresponding inputs are found and messages are also displayed under them.

##### Example error notification:
```html
<div class="toast bg-danger fade show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <strong class="mr-auto">Error</strong>
        <small></small>
        <button data-dismiss="toast" type="button" class="ml-2 mb-1 close js_remove-btn" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="toast-body">Message success text</div>
</div>
```
##### Example success notification:
```html
<div class="toast bg-success fade show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <strong class="mr-auto">Success</strong>
        <small></small>
        <button data-dismiss="toast" type="button" class="ml-2 mb-1 close js_remove-btn" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="toast-body">Message text</div>
</div>
```
