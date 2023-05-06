This functionality makes it possible to add the ability to activate several checkboxes when selecting one special checkbox or button.

### Activation selecting checkbox functionality
You have three ways to activate functionality:

**1. To initialize with a checkbox.**

Add the **```'js_select-some'```** class and the following attributes to the main checkboxes:

**```'data-checked-el'```** = _".js_select-some-1"_ - specify the class of child checkboxes (must start with js_select-some-);

**```'data-unchecked'```** = _"true/false"_ - if you need to do the inversion, set it to true (if true, then we will
uncheck the child checkboxes when the parent is checked, if you need the usual functionality, then set it to false).

**2. To initialize with a button.**

Add the **```'js_select-some-btn'```** class to the button and the attributes:

**```'data-checked-el'```** = _".js_select-some-1"_ - specify the class of child checkboxes (must start with js_select-some-);

**```'data-unchecked'```** = _"true/false"_ - if you need to make an inversion, set it to true (if true, then we will 
uncheck the child checkboxes).


**3. To initialize with a select.**

The select can be default or select2.

Add the **```'js_select-some-wrap'```** class to the select.

Specify the required option for the **```'js_select-some-el'```** class and the attributes:

**```'data-checked-el'```** = _".js_select-some-1"_ - specify the class of child checkboxes (must start with js_select-some-);

**```'data-unchecked'```** = _"true/false"_ - if you need to make an inversion, set it to true (if true, then we will
uncheck the child checkboxes).

If the option should not mark anything, then we do not add the class and these attributes to it at all.

___

Add the **```'js_select-some-{i}'```** class to the child checkboxes and the **```'data-unchecked'```** = _"true/false"_
attribute - if the parent checkbox has true in this attribute, then set the child checkbox to true, if the parent has 
false, then the child checkbox is also false we put.

> If one by one all the checkboxes of one group are checked or not checked, then I make the parent element active or inactive.

##### Example by all means:
```html
<div class="row">
    <div class="col-2">
        <div class="mb-2">
            <a href=""  class="btn btn-primary js_select-some-btn" data-checked-el=".js_select-some-all">
                <i class="fas fas fa-check"></i> All</a>
        </div>
    </div>
    <div class="col-2">
        <div class="mb-2">
            <a href=""  class="btn btn-primary js_select-some-btn" data-checked-el=".js_select-some-1">
                <i class="fas fas fa-check"></i> Default 1</a>
        </div>
    </div>
    <div class="col-2">
        <div class="mb-2">
            <a href=""  class="btn btn-primary js_select-some-btn" data-checked-el=".js_select-some-default">
                <i class="fas fas fa-check"></i> Default 2</a>
        </div>
    </div>
    <div class="col-2">
        <div class="mb-2">
            <a href=""  class="btn btn-primary js_select-some-btn" data-unchecked="false" data-checked-el=".js_select-some-even">
                <i class="fas fas fa-check"></i> Only even</a>
        </div>
    </div>
    <div class="col-2">
        <div class="mb-2">
            <select class="form-control js-select2 js_select-some-wrap" data-unchecked="false" data-placeholder="Select a Category" style="width: 100%;" tabindex="-1" aria-hidden="true" name="category">
                <option class="js_select-some-el" data-checked-el=".js_select-some-1">Alabama</option>
                <option class="js_select-some-el" data-checked-el=".js_select-some-2">Alaska</option>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="mb-2">
            <input type="checkbox" id="checkbox-id-1" class="checkbox js_select-some js_select-some-all" data-unchecked="false" data-checked-el=".js_select-some-1">
            <label for="checkbox-id-1" class="checkbox-lbl">Read Only</label>
        </div>
        <div>
            <input  name="ids" value="" type="checkbox" data-unchecked="false"
                    id="checkbox-id-2" class="checkbox js_select-some-1 js_select-some-all">
            <label for="checkbox-id-2" class="checkbox-lbl">Test 1</label>
        </div>

        <div>
            <input  name="ids" value="" type="checkbox" data-unchecked="false"
                    id="checkbox-id-3" class="checkbox js_select-some-1 js_select-some-default js_select-some-all">
            <label for="checkbox-id-3" class="checkbox-lbl">Test 2</label>
        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <input type="checkbox" id="checkbox-id-4" class="checkbox js_select-some js_select-some-all" data-unchecked="false" data-checked-el=".js_select-some-2">
            <label for="checkbox-id-4" class="checkbox-lbl">Read Only 2</label>
        </div>

        <div>
            <input  name="ids" value="" type="checkbox" data-unchecked="false"
                    id="checkbox-id-5" class="checkbox js_select-some-2 js_select-some-all">
            <label for="checkbox-id-5" class="checkbox-lbl">Test 1</label>
        </div>

        <div>
            <input  name="ids" value="" type="checkbox" data-unchecked="false"
                    id="checkbox-id-6" class="checkbox js_select-some-2 js_select-some-default js_select-some-all">
            <label for="checkbox-id-6" class="checkbox-lbl">Test 2</label>
        </div>
    </div>
    <div class="col">
        <div>
            <input  name="ids" value="" type="checkbox" data-unchecked="false"
                    id="checkbox-id-16" class="checkbox js_select-some-odd js_select-some-all">
            <label for="checkbox-id-16" class="checkbox-lbl">Odd</label>
        </div>
        <div>
            <input  name="ids" value="" type="checkbox" data-unchecked="false"
                    id="checkbox-id-17" class="checkbox js_select-some-even js_select-some-all">
            <label for="checkbox-id-17" class="checkbox-lbl">Even</label>
        </div>
        <div>
            <input  name="ids" value="" type="checkbox" data-unchecked="false"
                    id="checkbox-id-18" class="checkbox js_select-some-odd js_select-some-all">
            <label for="checkbox-id-18" class="checkbox-lbl">Odd</label>
        </div>
        <div>
            <input  name="ids" value="" type="checkbox" data-unchecked="false"
                    id="checkbox-id-19" class="checkbox js_select-some-even js_select-some-all">
            <label for="checkbox-id-19" class="checkbox-lbl">Even</label>
        </div>
    </div>
</div>
```
