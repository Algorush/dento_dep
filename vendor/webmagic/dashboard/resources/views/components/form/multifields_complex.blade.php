<div class="js_clone-multi-wrap" data-max-count="{{ $max_copy_count }}">
    {!! $add_button !!}

    <!-- One block with input -->
    <div class="js_clone-multi-blk __hidden-blk d-flex" data-entity="{{ $entity_name }}" data-id="0">
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