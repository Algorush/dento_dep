This functionality for sending ajax data on server.

> These points are performed for all ajax submissions described in this section:
1. If the checkbox is selected 1 is sent, if -0 is not checked.
2. Added redirect tracking: from the back it should come to Respons json **'{redirect: locationUrl}'** + header **Content-Type: application/json**
3. Sending statuses visualized by alerts.
4. After inserting a response from the server into a block, some plugins will be initialized inside this block.
5. The initPluginsInWrapper() function is responsible for this.

#### Sending form
**1. Submitting on click on an element of type = 'submit'**

To initialize ajax form submission, assign the required form to the class **```'.js-submit'```**.

Available form settings:
* **method**=_"post"_ - automatically used as a method for submitting the form;
* **action**=_"my-domain.com"_ - automatically used as url for form submission;
* **data-action-from-child**=_".js_ajax-form-action"_ - if the form has such an attribute, it takes the value of this element as the action, the element is inside the form;
* **data-result**=_".my-form-result"_ - outputs the server response to the specified block;
* **data-replace-blk**=_".my-form-replace-blk"_ - outputs the server response replacing the specified block;
* **data-send-all-checkbox**=_"true"_ - additionally adds checkboxes that have not been selected to the sending;
* **data-additional-el**=_".js_additional-el-id"_ - additional inputs to be sent along with this form.
* **data-success-msg**=_"true"_ - is show success message in popup
* **data-success-msg-txt**=_"{'title': '', 'text': 'Done'}"_ - if the response from the server is success and `data-success-msg` is `true` then a popup
  will be shown with the data from the parameter

##### Example:
```html
<form method="post" id="myForm" class="js-submit" action="/request" data-result=".result-blk">
   .....
</form>
```
**2. Submitting a form on click or change of any element**

How to use:

1. On the element that should respond on Click/Change added class **```'.js_submit-form-by-click-el.js_submit-form-by-change-el'```**.
2. Must set the attribute **data-form**="#myForm".
3. If this element is in a popup and after sending data the popup should not be closed, then this element should be 
4. Set to the attribute **data-modal-hide**="false".

Add attributes on the form specified in attribute **data-form**:
* **method**=_"post"_ - automatically used as a method for submitting the form;
* **action**=_"my-domain.com"_ - automatically used as url for form submission;
* **data-result-blk**=_".my-form-result"_ - displays the server response in the specified block;
* **data-replace-blk**=_".my-form-replace-blk"_ - displays the server response replacing the specified block;
* **data-modal**=_"true"_ - displays the response from the server in a popup;
* **data-modal-size**=_"modal-lg/modal-sm"_ - indicates what size the popup will open, large or small, respectively;
* **data-modal-ttl**=_"Title modal"_ - the title of the popup, which is raised after the successful receipt of data, 
given data-modal="true";
* **data-send-all-checkbox**=_"true"_ - additionally adds checkboxes that were not selected to the sending.
* **data-success-msg**=_"true"_ - is show success message in popup
* **data-success-msg-txt**=_"{'title': '', 'text': 'Done'}"_ - if the response from the server is success and `data-success-msg` is `true` then a popup
    will be shown with the data from the parameter

##### Example:
```html
<form method="post" id="myForm" action="/request" data-result=".result-blk">
    .....
</form>
<a href="" class="js_submit-form-by-click-el" data-form="#myForm">Click me and send form</a>
```
#### Sending data from an element without a form
> All data attributes are collected from the element, if this is a field, then the field name and its value are added to the sending.

Add attributes on the element for click and change:
* **data-method**=_"post"_ - used as a method to send data;
* **data-action**=_"my-domain.com"_ - automatically used as url for sending data;
* **data-result-blk**=_".my-form-result"_ - displays the server response in the specified block;
* **data-replace-blk**=_".my-form-replace-blk"_ - displays the server response replacing the specified block;
* **data-modal**=_"true"_ - displays the response from the server in a popup;
* **data-modal-size**=_"modal-lg/modal-sm"_ - indicates what size the popup will open, large or small, respectively;
* **data-modal-ttl**=_"Title modal"_ - the title of the popup, which is raised after the successful receipt of data, given data-modal="true";
* **data-id-category**=_"15"_ - if we, for example, want to get idCategory: 15 on the back, the attribute can be named 
whatever you like, the main thing is that there is a prefix _data-_.
* **data-success-msg**=_"true"_ - is show success message in popup
* **data-success-msg-txt**=_"{'title': '', 'text': 'Done'}"_ - if the response from the server is success and `data-success-msg` is `true` then a popup
    will be shown with the data from the parameter

**1. Sending on click an element**

To initialize added a class for this element **```'.js ajax-by-click-btn'```**

##### Example:
```html
<a href="" class="js_ajax-by-click-btn"
   data-action="/request"
   data-result-blk=".my-blk-result"
   data-id-product="162">Click me and send data attributes</a>
```
**2. Sending on change an element**

To initialize added a class for this element **```'.js_ajax-by-change'```**.

##### Example:
```html
<input type="checkbox" name="status-category"
       class="js_ajax-by-change"
       data-method="GET"
       data-action="/request"
       data-replace-blk=".my-blk-replace"
       data-category="162">
```

**3. Deleting an entity with a confirmation popup**
To initialize added a class for this element **```'.js_delete'```**.

Add attributes on this element:
* **data-method**=_"post"_ - the method for sending the request;
* **data-request**=_"/request"_ - request url;
* **data-item**=_".js_class-item"_ - the unique class of the entity wrapper that is being removed (this block will be 
removed from the html after the request is sent).

The confirmation popup is opened with the class **```'.js_base_modal'```**.

##### Example:
```html
<tr class="js_user_8">
    ...
    <a data-item=".js_user_8"
       class="js_delete"
       data-method="POST"
       data-request="/request">Delete</a>
    ...
</tr>
```
