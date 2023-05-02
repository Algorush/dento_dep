{{-- View for element Webmagic\Dashboard\Pages\LoginPage --}}
@extends('dashboard::core.adminlte_base')

@section('title', 'Login')

@section('body_class', 'hold-transition login-page ')

@section('base_content')
    <div class="login-box">
        <div class="login-logo">
            <img class="w-100" style="max-width:350px;" src="{{asset('img/in-align-logo.png')}}">
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">@lang('dashboard::common.login_page.description')</p>

                <form action="{{route('login')}}" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="mt-1">
                                <input type="checkbox" id="remember" class="checkbox" name="remember">
                                <label for="remember" class="checkbox-lbl"></label>

                                <label for="remember">Remember Me</label>
                            </div>
                        </div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>

                <a href="{{route('password.request')}}" class="text-center">I forgot my password</a>

                @if ($errors->has('password'))
                    <div class="form-group has-error">
                        @foreach($errors->get('password') as $error)
                            <span class="help-block text-red">{{$error}}</span>
                        @endforeach
                    </div>
                @endif

                @if ($errors->has('email'))
                    <div class="form-group has-error">
                        @foreach($errors->get('email') as $error)
                            <span class="help-block text-red">{{$error}}</span>
                        @endforeach
                    </div>
                @endif
            </div>
            <!-- /.login-box-body -->
        </div>
    </div>
    <!-- /.login-box -->
@endsection
