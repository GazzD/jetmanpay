@extends('layouts.backend')

@section('title', __('pages/clients.clients'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('pages/clients.clients')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users/profile') }}">@lang('pages/users.profile')</a></li>
                    <li class="breadcrumb-item active">@lang('pages/clients.edit_client')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
	<form method="post" action="{{route('clients/update')}}" role="form" class="form-horizontal">
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
						<label class="col-md-2 control-label">@lang('pages/clients.name')</label>
						<div class="col-md-10">
							<input type="text" value="{{ $client->name }}" 
								placeholder="@lang('pages/clients.name')" id="name"
								class="form-control" name="name">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">RIF</label>
						<div class="col-md-10">
							<input type="text" disabled value="{{ $client->rif }}" 
								placeholder="RIF" id="rif"
								class="form-control" name="rif">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/clients.code')</label>
						<div class="col-md-10">
							<input type="text" value="{{ $client->code }}" 
								placeholder="@lang('pages/clients.code')" id="code"
								class="form-control" name="code">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/clients.email')</label>
						<div class="col-md-10">
							<input type="email" value="{{ $client->email }}"
							    placeholder="@lang('pages/clients.email')"
								id="email" class="form-control" name="email">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/clients.business_name')</label>
						<div class="col-md-10">
							<input type="text" value="{{ $client->business_name }}" 
								placeholder="@lang('pages/clients.business_name')" id="businessName"
								class="form-control" name="businessName">
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/clients.acronym')</label>
						<div class="col-md-10">
							<input type="text" value="{{ $client->acronym }}"
								placeholder="@lang('pages/clients.acronym')"
								id="acronym" class="form-control" name="acronym">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/clients.accounting_assistant')</label>
						<div class="col-md-10">
							<input type="text" value="{{ $client->accounting_assistant }}"
								placeholder="@lang('pages/clients.accounting_assistant')"
								id="accountingAssistant" class="form-control" name="accountingAssistant">
						</div>
					</div>
				</div>
                <div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/clients.phone_number')</label>
						<div class="col-md-4">
							<input type="text" value="{{ $client->phone_number1 }}"
								
								placeholder="@lang('pages/clients.phone_number') 1" id="phoneNumber1"
								class="form-control" name="phoneNumber1">
						</div>
						<div class="col-md-3">
							<input type="text" value="{{ $client->phone_number2 }}" 
								placeholder="@lang('pages/clients.phone_number') 2" id="phoneNumber2"
								class="form-control" name="phoneNumber2">
						</div>
						<div class="col-md-3">
							<input type="text" value="{{ $client->phone_number3 }}" 
								placeholder="@lang('pages/clients.phone_number') 3" id="phoneNumber3"
								class="form-control" name="phoneNumber3">
						</div>
					</div>
                </div>
                <div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/clients.web')</label>
						<div class="col-md-10">
							<input type="text" value="{{ $client->web }}"
								placeholder="@lang('pages/clients.web')"
								id="web" class="form-control" name="website">
						</div>
					</div>
				</div>
                <div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/clients.president')</label>
						<div class="col-md-10">
							<input type="text" value="{{ $client->president }}"
								placeholder="@lang('pages/clients.president')"
								id="president" class="form-control" name="president">
						</div>
					</div>
				</div>
                <div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/clients.contact_person')</label>
						<div class="col-md-10">
							<input type="text" value="{{ $client->contact_person }}"
								placeholder="@lang('pages/clients.contact_person')"
								id="contactPerson" class="form-control" name="contactPerson">
						</div>
					</div>
				</div>
                <div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/clients.street')</label>
						<div class="col-md-10">
							<input type="text" value="{{ $client->street }}"
								placeholder="@lang('pages/clients.street')"
								id="street" class="form-control" name="street">
						</div>
					</div>
				</div>
                <div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/clients.sector')</label>
						<div class="col-md-10">
							<input type="text" value="{{ $client->sector }}"
								placeholder="@lang('pages/clients.sector')"
								id="sector" class="form-control" name="sector">
						</div>
					</div>
                </div>
                <div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/clients.building')</label>
						<div class="col-md-4">
							<input type="text" value="{{ $client->building }}"
								
								placeholder="@lang('pages/clients.building')" id="building"
								class="form-control" name="building">
						</div>
						<div class="col-md-3">
							<input type="text" value="{{ $client->floor }}" 
								placeholder="@lang('pages/clients.floor')" id="floor"
								class="form-control" name="floor">
						</div>
						<div class="col-md-3">
							<input type="text" value="{{ $client->office }}"
								
								placeholder="@lang('pages/clients.office')" id="office"
								class="form-control" name="office">
						</div>
					</div>
                </div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/clients.state')</label>
						<div class="col-md-2">
							<input type="text" value="{{ $client->state }}"
								placeholder="@lang('pages/clients.state')"
								id="state" class="form-control" name="state">
						</div>
						<div class="col-md-2">
							<input type="text" value="{{ $client->city }}"
								placeholder="@lang('pages/clients.city')"
								id="city" class="form-control" name="city">
							</div>
						<div class="col-md-3">
							<input type="text" value="{{ $client->municipality }}"
								placeholder="@lang('pages/clients.municipality')"
								id="municipality" class="form-control" name="municipality">
						</div>
						<div class="col-md-3">
							<input type="text" value="{{ $client->parish }}"
								placeholder="@lang('pages/clients.parish')"
								id="parish" class="form-control" name="parish">
						</div>
					</div>
                </div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/clients.rm_number')</label>
						<div class="col-md-5">
							<input type="text" value="{{ $client->rm_number }}"
								placeholder="@lang('pages/clients.rm_number')"
								id="rmNumber" class="form-control" name="rmNumber">
						</div>
						<div class="col-md-5">
							<input type="text" value="{{ $client->rm_volume }}"
								placeholder="@lang('pages/clients.rm_volume')"
								id="rmVolume" class="form-control" name="rmVolume">
						</div>
					</div>
                </div>
				<div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/clients.rm_district')</label>
						<div class="col-md-5">
							<input type="text" value="{{ $client->rm_district }}"
								placeholder="@lang('pages/clients.rm_district')"
								id="rmDistrict" class="form-control" name="rmDistrict">
						</div>
						<div class="col-md-5">
							<input type="text" value="{{ $client->rm_city }}"
								placeholder="@lang('pages/clients.rm_city')"
								id="rmCity" class="form-control" name="rmCity">
						</div>
					</div>
                </div>
                <div class="form-group">
					<div class="row">
						<label class="col-md-2 control-label">@lang('pages/clients.rm_register')</label>
						<div class="col-md-10">
							<input type="text" value="{{ $client->rm_register }}"
								placeholder="@lang('pages/clients.rm_register')"
								id="rmRegister" class="form-control" name="rmRegister">
						</div>
					</div>
                </div>
                
			</div>
			<div class="card-footer">
				<button type="submit" id="submit-btn" class="btn btn-primary">@lang('pages/clients.save')</button>
				<a href="{{ route('users/profile') }}" class="btn btn-default">@lang('pages/users.back')</a>
			</div>
		</div>
	</form>
</section>
<!-- /.content -->
@endsection
@section('extended-scripts')

@endsection
