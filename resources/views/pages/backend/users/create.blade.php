@extends('layouts.backend')

@section('title', __('pages/users.users'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('pages/users.users')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users') }}">@lang('pages/users.users')</a></li>
                    <li class="breadcrumb-item active">@lang('pages/users.create')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <form method="post" action="{{route('users/store')}}" role="form" class="form-horizontal">
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
                @csrf
                <div class="form-group">
                    <label class="col-md-2 control-label">@lang('pages/users.name')</label>
                    <div class="col-md-10">
                      <input type="text" required="required" placeholder="@lang('pages/users.name')" id="name" class="form-control" name="name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">@lang('pages/users.email')</label>
                    <div class="col-md-10">
                      <input type="email" required="required" placeholder="@lang('pages/users.email')" id="email" class="form-control" name="email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">@lang('pages/users.role')</label>
                    <div class="col-md-10">
                    	<div class="form-group">
                            <select name="roleId" class="form-control select2" style="width: 100%;">
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{ __('messages.'.strtolower($role->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">@lang('pages/users.client')</label>
                    <div class="col-md-10">
                    	<div class="form-group">
                            <select name="clientId" class="form-control select2" style="width: 100%;">
                            	<option value="-1">@lang('pages/users.choose-one')</option>
                                @foreach($clients as $client)
                                    <option value="{{$client->id}}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">@lang('pages/users.password')</label>
                    <div class="col-md-10">
                        <input type="password" required="required" placeholder="@lang('pages/users.password')" id="password" class="form-control" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">@lang('pages/users.password-confirmation')</label>
                    <div class="col-md-10">
                        <input type="password" required="required" placeholder="@lang('pages/users.password-confirmation')" class="form-control" name="passwordConfirmation">
                    </div>
                </div>
    		</div>
			<div class="card-footer">
                <button type="submit" id="submit-btn" class="btn btn-primary">@lang('pages/users.create')</button>
                <a href="{{ route('users') }}" class="btn btn-default">@lang('pages/users.back')</a>
            </div>
        </div>
	</form>
</section>
<!-- /.content -->
@endsection
@section('extended-css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('backend/plugins/select2/css/select2.min.css')}}">
    <style>
        .select2-container .select2-selection--single {
            height: 38px;
        }
    </style>
@endsection

@section('extended-scripts')
    <!-- Select2 -->
    <script src="{{asset('backend/plugins/select2/js/select2.full.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>
@endsection
