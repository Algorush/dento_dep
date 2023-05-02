<!DOCTYPE html>
<html lang="{{App::getLocale()}}">

<head>
    <title>{{$styles['title'] ?? 'Dent 3D'}}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    {{--###Styles###--}}
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css?version=2020-08-14T08:57:23.778Z')}}">
    {{--###Styles###--}}

    <link rel="stylesheet" type="text/css" href="{{asset('css/custom.css?version=2020-03-23T19:48:41.933Z')}}">

    {{--style from admin panel--}}
    <style>
        html, body{
            /*background: rgba(65,65,65,1);*/
            background: {{$styles['body_color'] ?? '#414141'}};
        }
        .main-menu{
            background: {{$styles['header_color'] ?? '#fff'}};
        }
        .add{
            background: {{$styles['primary_color'] ?? '#037cdb'}};
        }
        .eye svg path.fill,
        .dvd svg path,
        path.fill{
            fill: {{$styles['primary_color'] ?? '#037cdb'}};
        }
        .hdr,
        .nmbr{
            color: {{$styles['text_color'] ?? '#999'}};
        }
        .nmbr span{
            color: {{$styles['primary_color'] ?? '#037cdb'}};
        }
    </style>
    {{--End style from admin panel--}}

    {{--Style for current user--}}
    @section('base-styles')
        @include('core.base_styles', $styles ?? [])
    @show

    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/three.min.js')}}"></script>
    <script src="{{asset('js/LoaderSupport.js')}}"></script>
    <!-- <script src="{{asset('js/GLTFLoader.js')}}" type="module"></script> -->
    <script src="{{asset('js/DRACOLoader.js')}}" type="module"></script>
    <!-- <script src="{{asset('js/OBJLoader.mjs')}}" type="module"></script> -->
    <script src="{{asset('js/stats.min.js')}}"></script>
    <script src="{{asset('js/Detector.js')}}"></script>
    <!-- <script src="{{asset('js/STLLoader.js')}}"></script> -->
    <script src="{{asset('js/OrbitControls.js')}}" type="module"></script>
    <script src="{{asset('js/tween.js')}}"></script>

    <script src="{{asset('js/material.min.js')}}"></script>

</head>

<body class="{{$body_class}}">
{{--Header--}}
@include('parts/_header', $styles ?? [])

{{--Content--}}
@section('content')
    TEst
@show

{{--Forms--}}
@include('parts/_forms', $styles ?? [])

{{--###Scripts###--}}
<script src="{{asset('js/libs.js?version=2020-08-14T08:57:23.236Z')}}"></script>
<script src="{{asset('js/script.js?version=2020-08-14T08:57:23.236Z')}}"></script>
{{--###Scripts###--}}

{{--Counters--}}
@if(!app()->environment('local'))
    @include('parts/_counters')
@endif
<div style="display: none;" id="_token-csrf">{{csrf_token()}}</div>

<script src="{{asset('js/dashboard_app.js')}}" type="module"></script>
</body>
</html>
