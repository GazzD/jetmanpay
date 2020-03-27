@extends('layouts.backend')

@section('title', __('messages.dashboard.dashboard'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.users.users')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users') }}">@lang('messages.users.users')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.users.create')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{route('users/store')}}" role="form" class="form-horizontal">
        @csrf
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.users.name')</label>
            <div class="col-md-10">
              <input type="text" required="" placeholder="@lang('messages.users.name')" id="name" class="form-control" name="name">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.users.email')</label>
            <div class="col-md-10">
              <input type="email" required="" placeholder="@lang('messages.users.email')" id="email" class="form-control" name="email">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.users.role')</label>
            <div class="col-md-10">
                <select name="roleId" class="form-control">
                    @foreach($roles as $role)
                        <option value="{{$role->id}}">{{ __('messages.'.strtolower($role->name)) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.users.password')</label>
            <div class="col-md-10">
                <input type="password" required="" placeholder="@lang('messages.users.password')" id="password" class="form-control" name="password">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">@lang('messages.users.password-confirmation')</label>
            <div class="col-md-10">
                <input type="password" required="" placeholder="@lang('messages.users.password-confirmation')" class="form-control" name="passwordConfirmation">
            </div>
        </div>

        <button type="submit" id="submit-btn" class="btn btn-primary">@lang('messages.users.create')</button>
	</form>
</section>
<!-- /.content -->
@endsection
@section('extended-scripts')

@endsection
