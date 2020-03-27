@extends('layouts.backend')

@section('title', __('messages.dashboard.dashboard'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.users.profile')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.users.profile')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">{{ $user->name }}</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label class="col-md-2 control-label">@lang('messages.users.name')</label>
                <div class="col-md-10">
                    @if($user->name)
                        {{ $user->name }}
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">@lang('messages.users.email')</label>
                <div class="col-md-10">
                    @if($user->email)
                        {{ $user->email }}
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">@lang('messages.users.phone')</label>
                <div class="col-md-10">
                    @if($user->phone)
                        {{ $user->phone }}
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">@lang('messages.users.country')</label>
                <div class="col-md-10">
                    @if($user->country && $user->state && $user->zip_code)
                        {{ $user->country }}, {{ $user->state }} ({{ $user->zip_code }})
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">@lang('messages.users.address_line1')</label>
                <div class="col-md-10">
                    @if($user->address_line1)
                        {{ $user->address_line1 }}
                    @else
                        -
                    @endif
                    
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">@lang('messages.users.address_line2')</label>
                <div class="col-md-10">
                    @if($user->address_line2)
                        {{ $user->address_line2 }}
                    @else
                        -
                    @endif
                </div>
            </div>
            <a href="{{ route('users/edit-profile') }}" id="submit-btn" class="btn btn-primary">@lang('messages.users.edit')</a> <button id="submit-btn" data-toggle="modal" data-target="#change-password" class="btn btn-primary">@lang('messages.users.edit-password')</button>
        </div>
    </div>
    <div class="modal fade" id="change-password" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <!-- form start -->
        <form role="form" action="{{route('users/change-password')}}" class="form-horizontal form-label-left" method="post">
        <div class="modal-content">
          <div class="modal-body">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">@lang('messages.users.change-password')</h3>
                </div>
                  @csrf
                  <div class="box-body">
                    <div class="form-group">
                      <input type="password" required="true" class="form-control" name="password" placeholder="@lang('messages.users.password')">
                    </div>
                    <div class="form-group">
                      <input type="password" required="true" class="form-control" name="passwordConfirmation" placeholder="@lang('messages.users.password-confirmation')">
                    </div>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
            <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
          </div>
        </div>
        </form>
      </div>
    </div>
</section>
<!-- /.content -->
@endsection
@section('extended-scripts')

@endsection
