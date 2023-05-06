@if($search_show)
    @section('search_block')
        <!-- SidebarSearch Form -->
        <form action="{{ $search_action }}" class="form-inline ml-0 ml-md-3">
            <div class="input-group input-group-sm">
                <div class="container __H">
                    <input class="form-control form-control-navbar w-100" type="search" placeholder="Search" aria-label="Search" name="{{ $search_attr_name }}">
                </div>
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    @endsection
@endif

<ul class="navbar-nav {{ $class }}">
    {!! $content !!}
</ul>
