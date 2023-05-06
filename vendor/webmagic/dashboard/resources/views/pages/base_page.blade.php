@extends('dashboard::core.adminlte_base')

@section('title', $title)

@section('body_class', 'sidebar-mini layout-fixed layout-navbar-fixed')

@section('is_auto_close_notification', $is_auto_close_notification)
@section('close_notification_in_seconds', $close_notification_in_seconds)

@section('base_content')
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand {!! $header_nav_style !!}" role="navigation">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                @if(config('webmagic.dashboard.dashboard.header_navigation_options.show_collapse_sidebar_btn') === true)
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                @endif
                @if(config('webmagic.dashboard.dashboard.header_navigation_options.show_home_btn') === true)
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/dashboard" class="nav-link">Home</a>
                </li>
                @endif
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
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
        </nav>

        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar main-sidebar-custom elevation-4 {{ $aside_class }}">
            @section('header_logo')
                {!! $header_logo !!}
            @show
            <div class="sidebar js_show-scroll">
                @section('main_sidebar')
                    {!! $main_sidebar !!}
                @show
            </div>
            <!-- sidebar-custom -->
            <div class="sidebar-custom">
                <div class="sidebar-custom-txt">WM
                    <span class="sidebar-custom-desc">Dashboard - {{$webmagicDashboardVersion}}</span>
                </div>
            </div>
            <!-- /.sidebar-custom -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper p-lg-2">
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
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        {{--    <footer class="main-footer {!! $footer_class !!}">--}}
        {{--        @section('footer')--}}
        {{--            {!! $footer !!}--}}
        {{--            <p class="text-right mr-6">Dashboard version - <strong>{{$webmagicDashboardVersion}}</strong></p>--}}
        {{--        @show--}}
        {{--    </footer>--}}
    </div>
@endsection
