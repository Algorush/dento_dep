@if ($paginated_items->hasPages())
    <div class="row align-items-baseline float-right justify-content-end">
        <div class="col-sm-12 col-md-6">
            <div class="clearfix py-3">
                <ul class="pagination m-0" {!! $dynamic_fields !!}>
                    {{-- Previous Page Link --}}
                    <li class="page-item previous">
                        <a href="#"
                           class="page-link js_btn-pagination @if($paginated_items->onFirstPage()) btn disabled @endif"
                           data-action="{{$action}}"
                           data-method="GET"
                           data-page="{{$paginated_items->currentPage() - 1}}"
                           data-replace-blk="{{$result_block_class}}">Prev</a>
                    </li>

                    {{-- Next Page Link --}}
                    <li class="page-item next">
                        <a href="#"
                           class="page-link js_btn-pagination @if(!$paginated_items->hasMorePages())btn disabled @endif"
                           data-action="{{$action}}"
                           data-method="GET"
                           data-page="{{$paginated_items->currentPage() + 1}}"
                           data-replace-blk="{{$result_block_class}}">Next</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endif
