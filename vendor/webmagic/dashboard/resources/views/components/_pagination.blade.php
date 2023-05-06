@if ($paginated_items->hasPages())
    <div class="row align-items-baseline">

        <div class="col-sm-12 col-md-6">
            <div class="clearfix py-3 d-flex align-items-baseline justify-content-start">
                <div class="pagination-txt">Showing {{$paginated_items->firstItem()}}
                    to {{$paginated_items->lastItem()}} of {{$paginated_items->total()}} entries
                </div>
                @if($steps_change)
                    <div class="form-group row ml-4">
                        <label for="entries-per-page" class="col-form-label pr-2">Entries per page</label>
                        <select id="entries-per-page"
                                name="{{$pagination_step_param}}"
                                class="form-control w-auto js_ajax-by-change"
                                data-method="GET"
                                data-action="{{$step_update_action ?: $action}}"
                                data-replace-blk="{{$result_block_class}}">
                            @foreach($available_steps as $step)
                                <option @if($step == $per_page) selected @endif value="{{$step}}">{{$step}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
        </div>

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

                    @php
                        $start = $paginated_items->currentPage() - 2; // show 3 pagination links before current
                        $end = $paginated_items->currentPage() + 2; // show 3 pagination links after current
                        if ($start < 1) {
                            $start = 1; // reset start to 1
                            $end += 1;
                        }
                        if ($end >= $paginated_items->lastPage()) $end = $paginated_items->lastPage(); // reset end to last page
                    @endphp

                    @if($start > 1)
                        <li class="page-item">
                            <a href="#"
                               class="page-link js_btn-pagination"
                               data-page="1"
                               data-method="GET"
                               data-action="{{$action}}"
                               data-replace-blk="{{$result_block_class}}">1</a>
                        </li>
                        @if($paginated_items->currentPage() != 4)
                            {{-- "Three Dots" Separator --}}
                            <li class="page-item">
                                <span class="page-link disabled">...</span>
                            </li>
                        @endif
                    @endif
                    @for ($i = $start; $i <= $end; $i++)
                        <li class="page-item {{ ($paginated_items->currentPage() == $i) ? ' active' : '' }}">
                            <a href="#"
                               class="page-link js_btn-pagination"
                               data-page="{{$i}}"
                               data-method="GET"
                               data-action="{{$action}}"
                               data-replace-blk="{{$result_block_class}}">{{ $i }}</a>
                        </li>
                    @endfor
                    @if($end < $paginated_items->lastPage())
                        @if($paginated_items->currentPage() + 3 != $paginated_items->lastPage())
                            {{-- "Three Dots" Separator --}}
                            <li class="page-item">
                                <span class="page-link disabled">...</span>
                            </li>
                        @endif
                        <li class="page-item">
                            <a href="#"
                               class="page-link js_btn-pagination"
                               data-page="{{ $paginated_items->lastPage() }}"
                               data-method="GET"
                               data-action="{{$action}}"
                               data-replace-blk="{{$result_block_class}}">{{$paginated_items->lastPage()}}</a>
                        </li>
                    @endif

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
