@section('content')

    @if($user->isAdmin())


        @include('dashboard._info_boxes')

    @else
    <div class="row">
        <!-- info-boxes start-->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Client Name</span>
                    <span class="info-box-number">{{$user->email}}</span>
                </div>
            </div>
        </div>

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
    <!-- tables start -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title mt-2">Latest Cases</h2>
                    <div class="card-tools">
                        <a href="{{route('dashboard::deals.create-by-seller', $user->id)}}"
                           class="btn btn-block btn-success btn-sm ">Add New Case</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Customer ID</th>
                            <th>Customer Name</th>
                            <th>Client</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cases as $case)
                            <tr>
                                <td>{{$case->case_id}}</td>
                                <td>{{$case->name}}</td>
                                <td>{{$case->client->name ?? ''}}</td>
                                <td>
                                    <a href="{{$case->present()->routeForCaseView()}}"
                                       class="btn btn-primary btn-block btn-sm" target="_blank" data-original-title="" title="">
                                        View </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title mt-2">Latest Clients</h2>
                    <div class="card-tools">
                        <a href="{{route('dashboard::clients.create', Auth::user()->id)}}" class="btn btn-block btn-success btn-sm ">Add New Client</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Client Contact</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td>{{$client->name}}</td>
                                <td>{{$client->contact_name}}</td>
                                <td>
                                    <a href="{{route('dashboard::clients.edit', $client->id)}}"
                                       class="btn btn-primary btn-block btn-sm" target="_blank" data-original-title="" title="">
                                        View </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- tables end -->
    @endif

@endsection
