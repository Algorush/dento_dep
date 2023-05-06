This functionality allows you to dynamically add multifields simple.

#### Activation dynamically multifields functionality
1. Add the class **```'js_clone-wrap'```** to the parent block and the attribute **```'data-count'```** = _"0"_ - the id 
of the last added element, it will count what value to put in the name of the next element.

2. Add the button 'Add' with the class **```'js_clone-add'```** and the attribute **```'data-max-count'```** - the 
maximum number of how many blocks can be added.

3. We add a wrapper with the class **```'js_clone-blk'```** to each block with inputs.

4. In the input, we set the class **```'js_clone-el'```**, the **```'disabled'```**, **```'id'```** and **```'name'```**
attributes, as in the example, taking into account their id (the current id must be specified in all these attributes), 
you also need to set the **```'value'```** attribute (you can specify the id as the value, then when cloning this value 
is cleared, it is needed for validation).

5. Add the button 'Delete' with the class **```'js_clone-remove'```**.

> Cloned blocks with inputs will be added to the block with the class **```'js_clone-cnt'```**.

##### Example:
```html
<form class="form-inline js-submit" action="/dashboard/tech/multifields-test">
    {!! csrf_field() !!}
    
    <div class="js_clone-wrap" data-count="0">

        <!-- Add button -->
        <div class="form-group clearfix">
            <button type="button" class="btn btn btn-primary js_clone-add" data-max-count="5">
                <i class="fas fas fa-plus"></i> Add</button>
        </div>
        <!-- End add button -->

        <!-- One block with input -->
        <div class="d-flex align-items-start js_clone-blk __hidden-blk">
            <div class="form-group">
                <input id="field_0" type="text" class="form-control mr-2 js_clone-el" name="address[0]" value="0" disabled required>
            </div>
            <div class="form-group clearfix">
                <button type="button" class="btn btn btn-danger js_clone-remove">
                    <i class="fas fas fa-trash"></i>
                </button>
            </div>
        </div>
        <!-- End one block with input -->

        <!-- Block for inputs clone -->
        <div class="js_clone-cnt"></div>
        <!-- ./Block for inputs clone -->

        <div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
```
