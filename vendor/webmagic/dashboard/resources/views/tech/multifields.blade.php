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
        <div class="js_clone-cnt">

        </div>
        <!-- ./Block for inputs clone -->

    </div>

    <div>
        <div ><button type="submit" class="btn btn-primary">Submit</button></div>
    </div>
</form>
