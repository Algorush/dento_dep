@if (Auth::check() && $showUserPanel)
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <div class="userFirstLetter">{{ $userFirstLetter }}</div>
        </div>
        <div class="info user-panel-name">
            <span class="d-block">{{ $userTitle }}</span>
        </div>
    </div>
@endif

@if(!Auth::check())
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="{{route('login')}}" class="d-block">Sign in</a>
        </div>
    </div>
@endif

@if($search_show)
    <!-- Sidebar user panel (optional) -->
    <form action="{{ $search_action }}" class="form-inline">
        <div class="input-group">
            <input class="form-control form-control-sidebar" type="text" placeholder="Search" aria-label="Search"
               name="{{ $search_attr_name }}">
            <div class="input-group-append">
                <button class="btn btn-sidebar" type="submit">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </form>
@endif
<!-- SidebarSearch Form -->

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column {{ $class }}" data-widget="treeview" role="menu" data-accordion="false">
        {!! $content !!}
    </ul>
</nav>
