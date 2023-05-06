@extends('dashboard::core.adminlte_base')

@section('title', $title)

@section('body_class', 'layout-top-nav')

@section('is_auto_close_notification', $is_auto_close_notification)
@section('close_notification_in_seconds', $close_notification_in_seconds)
@push('after-styles')
    <style>
        .brand-link {
            width: 1px;
            min-width: 100px;
        }
        .brand-link:hover {
            color: inherit;
        }
    </style>
@endpush
@section('base_content')
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white {!! $header_nav_style !!}" role="navigation">
            <!-- Navbar links -->
            <div class="container">
                @section('header_logo')
                    {!! $header_logo !!}
                @show
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <div class="sidebar">
                        @section('main_sidebar')
                            {!! $main_sidebar !!}
                        @show
                    </div>

                    @yield('search_block')

                    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

                        @section('header_nav')
                            {!! $header_nav !!}
                        @show

                        <!-- Language Dropdown Menu -->
                        @if(config('webmagic.dashboard.dashboard.header_navigation_options.language_switcher') === true)
                            <li class="nav-item dropdown">

                                <a class="nav-link" data-toggle="dropdown" href="" aria-expanded="false">
                                    <i class="flag-icon flag-icon-{{(new \Webmagic\Dashboard\Services\DashboardSettingsManager())->getLocale()}}"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right p-0">
                                    @foreach(config('webmagic.dashboard.dashboard.header_navigation_options.available_locales') as $lang)
                                        <a href="" data-method="post" data-action="{{route('dashboard.api.set-locale')}}" data-reload-after-success="true" data-lang="{{$lang['code']}}"
                                           class="dropdown-item js_ajax-by-click-btn @if((new \Webmagic\Dashboard\Services\DashboardSettingsManager())->getLocale() === $lang['code']) active @endif ">
                                            <i class="flag-icon flag-icon-{{$lang['code']}} mr-2"></i> {{$lang['name']}}
                                        </a>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                        <!-- /.Language Dropdown Menu -->

                        @if(config('webmagic.dashboard.dashboard.header_navigation_options.show_fullscreen_btn') === true)
                            <li class="nav-item">
                                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                                    <i class="fas fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content-wrapper" style="min-height: 861px;">

            <!-- Content Wrapper. Contains page content -->
            <div class="container">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                {!! $content_header !!}
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                {!! $breadcrumbs !!}
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content container-fluid">
                    <!-- Notification area -->
                @section('notification_area')
                    {!! $notification_area !!}
                @show
                <!-- /.notification -->

                    @section('content')
                        {!! $data !!}
                    @show

                </section>
                <!-- /.content -->
                <a id="back-to-top" href="#" class="btn btn-primary back-to-top js_scroll-top" role="button" aria-label="Scroll to top" style="display: none">
                    <i class="fas fa-chevron-up"></i>
                </a>
            </div>

        <!-- Main Footer -->

    </div>
        <footer class="main-footer {!! $footer_class !!}">
            @section('footer')
                {!! $footer !!}
                <p class="text-right mr-6 mb-0">Dashboard version - <strong>{{$webmagicDashboardVersion}}</strong></p>
            @show
        </footer>
@endsection
