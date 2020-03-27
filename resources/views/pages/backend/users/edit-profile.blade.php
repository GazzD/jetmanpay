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
                    <li class="breadcrumb-item"><a href="{{ route('users/profile') }}">@lang('messages.users.profile')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.users.edit-profile')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="card card-primary card-outline">
    <div class="card-body">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{route('users/update-profile')}}" role="form" class="form-horizontal">
        @csrf
        <div class="form-group">
          <div class="row">
            <label class="col-md-2 control-label">@lang('messages.users.name')</label>
            <div class="col-md-10">
              <input type="text" value="{{ $user->name }}" required="required" placeholder="@lang('messages.users.name')" id="name" class="form-control" name="name">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-2 control-label">@lang('messages.users.email')</label>
            <div class="col-md-10">
              <input type="email" value="{{ $user->email }}" disabled="disabled" placeholder="@lang('messages.users.email')" id="email" class="form-control">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-2 control-label">@lang('messages.users.phone')</label>
            <div class="col-md-10">
              <input type="text" value="{{ $user->phone }}" required="required" placeholder="@lang('messages.users.phone')" id="phone" class="form-control" name="phone">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-2 control-label">@lang('messages.users.country')</label>
            <div class="col-md-4">
              <input type="text" value="{{ $user->country }}" required="required" placeholder="@lang('messages.users.country')" id="country" class="form-control" name="country">
            </div>
            <div class="col-md-3">
              <input type="text" value="{{ $user->state }}" required="required" placeholder="@lang('messages.users.state')" id="state" class="form-control" name="state">
            </div>
            <div class="col-md-3">
              <input type="text" value="{{ $user->zip_code }}" required="required" placeholder="@lang('messages.users.zip_code')" id="zip_code" class="form-control" name="zipCode">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-2 control-label">@lang('messages.users.address_line1')</label>
            <div class="col-md-10">
              <input type="text" value="{{ $user->address_line1 }}" required="required" placeholder="@lang('messages.users.address_line1')" id="addressLine1" class="form-control" name="addressLine1">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-2 control-label">@lang('messages.users.address_line2')</label>
            <div class="col-md-10">
              <input type="text" value="{{ $user->address_line2 }}" placeholder="@lang('messages.users.address_line2')" id="addressLine2" class="form-control" name="addressLine2">
            </div>
          </div>
        </div>
        
        <button type="submit" id="submit-btn" class="btn btn-primary">@lang('messages.users.save')</button>
	</form>
	</div>
	</div>
</section>
<!-- /.content -->
@endsection
@section('extended-scripts')

@endsection
