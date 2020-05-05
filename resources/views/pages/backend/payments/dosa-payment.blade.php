@extends('layouts.backend')

@section('title', __('messages.dashboard.dashboard'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.manual-payments.manual-payments')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.manual-payments.manual-payments')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
	<form method="post" action="{{route('payments/dosa/store')}}" role="form" class="form-horizontal">
    <div class="card card-primary card-outline">
        @csrf
		@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li> @endforeach
			</ul>
		</div>
		@endif
		<div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('messages.manual-payments.plane')</label>
                        <select class="form-control" name="planeId" disabled="disabled" id="planes">
                            <option value="{{$plane->id}}">{{$plane->tail_number}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('messages.manual-payments.client')</label>
                        <select class="form-control" name="clientId" disabled="disabled" id="clients">
                        <option value="{{$client->id}}">{{$client->name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('messages.manual-payments.currency')</label>
                        <select class="form-control" name="currency" disabled="disabled" id="currency">
                            <option value="{{$client->currency}}">{{$client->currency}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>@lang('messages.manual-payments.reference')</label>
                        <input type="text" required="" placeholder="@lang('messages.manual-payments.reference')" id="reference" class="form-control" name="reference">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>@lang('messages.manual-payments.description')</label>
                        <textarea class="form-control" style="max-width: 100%;" name="description" id="description" placeholder="Description" rows="8"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">@lang('messages.payments.invoice_items')</label>
                @foreach($dosas as $dosa)
                    @foreach($dosa->items as $item)
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-9">
                                <input type="text" disabled="disabled" value="{{$item->concept}}" class="form-control" name="feeConcept[]">
                            </div>
                            <div class="col-md-3">
                                <input type="text" disabled="disabled" value="{{Currency::getSymbol($client->currency)}} {{$item->convertedAmount}}" name="feeAmount[]" class="form-control" name="feeConcept">
                            </div>
                        </div>
                    @endforeach
                    <input type="hidden" value="{{$dosa->id}}" name="dosaIds[]">
                @endforeach
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-9">
                        <input type="text" disabled="disabled" value="@lang('pages/dosas.tax') ({{$tax}}%) " class="form-control" name="feeConcept[]">
                    </div>
                    <div class="col-md-3">
                        <input type="text" disabled="disabled" value="{{Currency::getSymbol($client->currency)}} {{$taxAmount}}" name="feeAmount[]" class="form-control" name="feeConcept">
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-9">
                        <input type="text" disabled="disabled" value="Total" class="form-control" name="tax">
                    </div>
                    <div class="col-md-3">
                        <input type="text" disabled="disabled" value="{{Currency::getSymbol($client->currency)}} {{$totalAmount}}" name="totalAmount" class="form-control" name="feeConcept">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
        	<button type="submit" id="submit-btn" class="btn btn-primary">@lang('messages.payments.confirm')</button>
        	<a href="{{route('dosas/plane')}}" class="btn btn-default">@lang('pages/users.back')</a>
        </div>
    </div>
    </form>
</section>
<!-- /.content -->
@endsection
@section('extended-scripts')

@endsection
