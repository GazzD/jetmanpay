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
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">@lang('messages.payments.confirm_payment')</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
        </div>
        <div class="card-body">
        <form method="post" action="{{route('payments/dosa')}}" enctype=multipart/form-data role="form" class="form-horizontal">
                <div class="row">
                    @csrf
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
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-9">
                                <input type="text" disabled="" value="{{$dosa->aperture_code}}" class="form-control" name="feeConcept[]">
                            </div>
                            <div class="col-md-3">
                                <input type="text" disabled="" value="{{$dosa->convertedAmount}} {{$client->currency}}" name="feeAmount[]" class="form-control" name="feeConcept">
                            </div>
                        </div>
                        <input type="hidden" value="{{$dosa->id}}" name="dosaIds[]">
                    @endforeach
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-9">
                            <input type="text" disabled="" value="@lang('messages.dosa.tax') ({{$tax}}%) " class="form-control" name="feeConcept[]">
                        </div>
                        <div class="col-md-3">
                            <input type="text" disabled="" value="{{$taxAmount}} {{$client->currency}}" name="feeAmount[]" class="form-control" name="feeConcept">
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-9">
                            <input type="text" disabled="" value="Total" class="form-control" name="tax">
                        </div>
                        <div class="col-md-3">
                            <input type="text" disabled="" value="{{$totalAmount}} {{$client->currency}}" name="totalAmount" class="form-control" name="feeConcept">
                        </div>
                    </div>
                </div>
                <button type="submit" id="submit-btn" class="btn btn-primary">@lang('messages.payments.confirm')</button>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection
@section('extended-scripts')

@endsection
