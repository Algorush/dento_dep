This functionality allows you to dynamically add multifields complex.

#### Activation dynamically multifields functionality
1. Add the class **```'js_clone-multi-wrap'```** to the parent block and the **```'data-max-count'```** = _"3"_ attribute - 
the maximum number of elements that can be added in this block (if 3, then there will be only 3 elements in this block).

2. Add the 'ADD' button and set the class **```'js_clone-multi-add'```** to it, the **```'data-url'```** attributes - 
the route for adding the element (takes the entity parameter - the name of the fields entity, for example, as in our 
example address), **```'data-method'```** - the method for sending the request, by default POST. If you need to hide 
the 'Add' button by default, then add the **```'d-none'```** class to it.

3. We set the class **```'js_clone-multi-blk'```** to the block with inputs, the attributes **```'data-entity'```** - 
the name of the entity (then this name will be sent to the back for adding and removing), **```'data-id'```** - the id 
of the entity.

4. We set the class **```'js_clone-multi-el'```** to the inputs, the **```'disabled'```**, **```'id'```** and **```'name'```** 
attributes, as in the example, taking into account their id (the current id must be specified in all these attributes), 
you also need to set the **```'value'```** attribute (you can specify the id as the value, then when cloning, this value 
is cleared, it is needed for validation).

5. Add the 'DELETE' button, set the class **```'js_clone-multi-remove'```** to it, **```'data-url'```** attributes - 
the route to delete the entity (on back takes two parameters entity - the name of the field entity, for example, as in our 
example address and entity_id - the entity id), **```'data-method'```** - the method sending a request, DELETE by default.

> Cloned blocks with inputs will be added to the block with the class **```'js_clone-cnt'```**.

##### Example:
```html
<form class="form-inline js-submit " action="/dashboard/tech/complex-multifields-test">
{!! csrf_field() !!}
    
    <div class="js_clone-multi-wrap" data-max-count="3">
        <!-- Add button -->
        <div class="form-group clearfix">
            <button type="button" class="btn btn btn-primary js_clone-multi-add"
                    data-url="/dashboard/tech/multifields-add"
                    data-method="POST">
                <i class="fas fas fa-plus"></i> Add</button>
        </div>
        <!-- End add button -->

        <!-- One block with input -->
        <div class="js_clone-multi-blk __hidden-blk" data-entity="address" data-id="0">
            <div class="form-group align-top">
                <input id="address_name_0" type="text" class="form-control mr-2 js_clone-multi-el" name="address[0][name]" value="0" disabled required>
            </div>
            <div class="form-group align-top">
                <input id="address_title_0" type="text" class="form-control mr-2 js_clone-multi-el" name="address[0][title]" value="0" disabled required>
            </div>
            <div class="form-group align-top clearfix">
                <button type="button" class="btn btn btn-danger js_clone-multi-remove"
                        data-url="/dashboard/tech/multifields-delete"
                        data-method="DELETE">
                    <i class="fas fas fa-trash"></i>
                </button>
            </div>
        </div>
        <!-- End one block with input -->

        <!-- Block for inputs clone -->
        <div class="js_clone-cnt"></div>
        <!-- ./Block for inputs clone -->
        
    </div>
    <div>
        <div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
```
