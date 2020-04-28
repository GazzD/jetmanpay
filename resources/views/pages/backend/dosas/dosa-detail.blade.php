@extends('layouts.backend')

@section('title', __('messages.dosa.dosa'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.dosa.dosa')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dosas/approved') }}">@lang('messages.dosa.approved_dosas')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.dosa.details')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <a href="{{$dosa->image}}">
                <img src="{{$dosa->image}}" class="img-responsive" target="_blank"/>
            </a>
        </div>
    </div>
    <form method="post" action="#" enctype="multipart/form-data" role="form" class="form-horizontal">
        @csrf
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.airplane')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$dosa->airplane}}" class="form-control" name="picture">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.status')</label>
            <div class="col-md-10">
                <input type="text" class="form-control" disabled value="{{$dosa->status}}">   
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.billing_code')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$dosa->billing_code}}" class="form-control" name="picture">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.aperture_code')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$dosa->aperture_code}}" class="form-control" name="picture">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.closure_code')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$dosa->closure_code}}" class="form-control" name="picture">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.currency')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$dosa->currency}}" class="form-control" name="picture">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.aperture_date')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$dosa->aperture_date}}" class="form-control" name="picture">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.ton_max_weight')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$dosa->ton_max_weight}}" class="form-control" name="picture">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.taxable_base_amount')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$dosa->taxable_base_amount}}" class="form-control" name="picture">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.exempt_vat_amount')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$dosa->exempt_vat_amount}}" class="form-control" name="picture">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.total_amount')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$dosa->total_dosa_amount}}" class="form-control" name="picture">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.departure_time')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$dosa->departure_time}}" class="form-control" name="picture">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.arrival_time')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$dosa->arrival_time}}" class="form-control" name="picture">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.departure_flight_number')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$dosa->departure_flight_number}}" class="form-control" name="picture">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.arrival_flight_number')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$dosa->arrival_flight_number}}" class="form-control" name="picture">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.flight_type')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$dosa->flight_type}}" class="form-control" name="picture">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.dosa.client_name')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$dosa->client_name}}" class="form-control" name="picture">
            </div>
        </div>
        {{-- @if($isEditable)
            <button type="submit" id="submit-btn" class="btn btn-primary">@lang('messages.dosa.confirm')</button>
        @endif --}}
    </form>
</section>
<!-- /.content -->
@endsection
@section('extended-scripts')

@endsection
