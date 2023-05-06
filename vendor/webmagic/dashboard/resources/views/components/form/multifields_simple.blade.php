<div class="js_clone-wrap" data-count-name="{{ $count_name }}" data-count-id="{{$count_id}}">

    <!-- Add button -->
    <div class="form-group clearfix">
        {!! $add_button !!}
    </div>
    <!-- End add button -->

    <!-- One block with input -->
    <div class="d-flex align-items-start js_clone-blk __hidden-blk">
        {!! $template_fields !!}

        {!! $remove_button !!}
    </div>
    <!-- End one block with input -->

    <!-- Block for inputs clone -->
    <div class="js_clone-cnt">
        {!! $prepared_fields !!}
    </div>
    <!-- ./Block for inputs clone -->
</div>
