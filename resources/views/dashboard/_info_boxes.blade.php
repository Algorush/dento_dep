<div class="admin-info-boxes">


    <form class="form-inline js-submit" action="{{route('dashboard::index')}}" method="GET" data-replace-blk=".admin-info-boxes" data-success-msg="false" data-status="false" id="form-filter-1">
        <input type="hidden" name="_token" value="{{csrf_token()}}">


        <div class="form-group clearfix" data-original-title="" title="">
            <label for="seller-select" data-original-title="" title="">By Seller</label>
            <select id="seller-select" name="seller_id" class="form-control form-required" data-placeholder="Choose seller" data-original-title="" title="">
                <option value="{{null}}"  data-original-title="" title="">----</option>
                @foreach($sellersForSelect as $id => $sellerName)
                    <option value="{{$id}}" @if(isset($seller_id) && $seller_id == $id) selected @endif data-original-title="" title="">{{$sellerName}}</option>
                @endforeach

            </select>
        </div>

        <div class="form-group clearfix" data-original-title="" title="">
            <div id="date_range" class="input-group js_datetime_picker-blk" data-original-title="" title="">
                <input type="text" name="date_from" class="form-control js_datetime_picker" value="{{$date_from ?? ''}}"
                       readonly
                       data-time="true" data-seconds="true" data-date="true" data-single="false" data-ranges="true" data-format="Y/MM/DD H:mm">
                <div class="input-group-addon px-2" data-original-title="" title="">to</div>
                <input type="text" name="date_to" class="form-control js_datetime_picker-end" readonly="" value="{{$date_to ?? ''}}" data-original-title="" title="">
            </div>

        </div>

        <div class="form-group clearfix" data-original-title="" title="">

            <button type="submit" class="btn  btn btn-primary float-right ml-2" data-original-title="" title="" data-form="#form-filter-1">
                Search
            </button>
        </div>
    </form>


    <div class="row   mt-5" >
        <!-- info-boxes start-->
        @if(!isset($seller_id) || $seller_id == null)
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Sellers</span>
                        <span class="info-box-number">{{$allSellers->count()}}</span>
                    </div>
                </div>
            </div>

        @else
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Client Name</span>
                        <span class="info-box-number">{{$sellersForSelect[$seller_id]}}</span>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Clients</span>
                    <span class="info-box-number">{{$allClients->count()}}</span>
                </div>
            </div>
        </div>


        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-clone"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Cases</span>
                    <span class="info-box-number">{{$allCases->count()}}</span>
                </div>
            </div>
        </div>
        <!-- info-boxes end -->
    </div>
</div>
{{--@push('after-scripts')--}}
{{--<script>--}}
{{--    $( "#form-filter-1" ).submit(function( event ) {--}}
{{--       console.log('after submit')--}}
{{--       console.log($('.js_datetime_picker').val())--}}
{{--        setTimeout(function () {--}}
{{--            console.log('set data')--}}
{{--        }, 1500)--}}
{{--    });--}}
{{--</script>--}}
{{--@endpush--}}
