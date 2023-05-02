@extends('dashboard::core.adminlte_base')

@section('title', 'Reset Password')

@section('body_class', 'hold-transition login-page ')

@section('base_content')
    <div class="login-box">
        <div class="login-logo">
            <img class="w-100" style="max-width:350px;" src="{{asset('img/in-align-logo.png')}}">
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Please email <a href="mailto:info@in-align.com">info@in-align.com</a> for assistance in resetting your password.</p>
                <p class="text-center mb-1">
                    <a href="{{route('login')}}">Login</a>
                </p>
            </div>
        </div>
    </div>
@endsection
