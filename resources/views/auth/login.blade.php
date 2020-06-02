@extends('layouts.basic')

@section('content')
<div class="login-box">
    <div class="login-logo">
      <a href="{{route('login')}}">Aeropayer</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">@lang('messages.login.title')</p>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('login')}}" method="post">
            @csrf
          <div class="input-group mb-3">
            <input type="email"  name="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember" name="remmember">
                <label for="remember">
                  @lang('messages.login.remmember_me')
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">@lang('messages.login.sign_in')</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        
        <p class="mb-1">
          <a href="{{ route('password.request') }}">@lang('messages.login.forgot_password')</a>
        </p>
        <p class="mb-1">
          <a href="{{ route('register') }}">@lang('messages.login.no_account')</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
@endsection
