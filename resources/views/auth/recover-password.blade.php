@extends('dashboard::core.adminlte_base')

@section('title', 'Recover Password')

@section('body_class', 'hold-transition login-page ')

@section('base_content')
    <div class="login-box">
        <div class="login-logo">
            <p><b>DENTO</b>ADMIN</p>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

                <form action="{{route('password.update')}}" method="post" class="">
                    <input type="hidden" name="email" value="{{$email}}">
                    <input type="hidden" name="token" value="{{$token}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="New Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block ">Change password</button>
                        </div>
                    </div>

                    @if ($errors->has('password'))
                        <div class="form-group has-error">
                            @foreach($errors->get('password') as $error)
                                <span class="help-block text-red">{{$error}}</span>
                            @endforeach
                        </div>
                    @endif
                </form>
                <p class="mt-3 mb-1">
                    <a href="{{route('login')}}">Login</a>
                </p>
            </div>
        </div>
    </div>
@endsection
