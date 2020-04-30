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
                    <li class="breadcrumb-item"><a href="{{ route('users/profile') }}">@lang('pages/users.profile')</a></li>
                    <li class="breadcrumb-item active">@lang('pages/users.edit-profile')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
	<form method="post" action="{{route('users/update-profile')}}" role="form" class="form-horizontal">
		@csrf
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
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/users.name')</label>
						<div class="col-md-10">
							<input type="text" value="{{ $user->name }}" required="required"
								placeholder="@lang('pages/users.name')" id="name"
								class="form-control" name="name">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/users.email')</label>
						<div class="col-md-10">
							<input type="email" value="{{ $user->email }}"
								disabled="disabled" placeholder="@lang('pages/users.email')"
								id="email" class="form-control">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/users.phone')</label>
						<div class="col-md-10">
							<input type="text" value="{{ $user->phone }}" required="required"
								placeholder="@lang('pages/users.phone')" id="phone"
								class="form-control" name="phone">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/users.country')</label>
						<div class="col-md-4">
							<input type="text" value="{{ $user->country }}"
								required="required"
								placeholder="@lang('pages/users.country')" id="country"
								class="form-control" name="country">
						</div>
						<div class="col-md-3">
							<input type="text" value="{{ $user->state }}" required="required"
								placeholder="@lang('pages/users.state')" id="state"
								class="form-control" name="state">
						</div>
						<div class="col-md-3">
							<input type="text" value="{{ $user->zip_code }}"
								required="required"
								placeholder="@lang('pages/users.zip_code')" id="zip_code"
								class="form-control" name="zipCode">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/users.address_line1')</label>
						<div class="col-md-10">
							<input type="text" value="{{ $user->address_line1 }}"
								required="required"
								placeholder="@lang('pages/users.address_line1')"
								id="addressLine1" class="form-control" name="addressLine1">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/users.address_line2')</label>
						<div class="col-md-10">
							<input type="text" value="{{ $user->address_line2 }}"
								placeholder="@lang('pages/users.address_line2')"
								id="addressLine2" class="form-control" name="addressLine2">
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" id="submit-btn" class="btn btn-primary">@lang('pages/users.save')</button>
				<a href="{{ route('users/profile') }}" class="btn btn-default">@lang('pages/users.back')</a>
			</div>
		</div>
	</form>
</section>
<!-- /.content -->
@endsection
@section('extended-scripts')

@endsection
