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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
        <form method="post" action="{{route('payments/update',$payment->id)}}" enctype=multipart/form-data role="form" class="form-horizontal">
                <div class="row">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('messages.manual-payments.plane')</label>
                            <select class="form-control" name="planeId" disabled="disabled" id="planes">
                                <option value="{{$payment->plane->id}}">{{$payment->plane->tail_number}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('messages.manual-payments.client')</label>
                            <select class="form-control" name="clientId" disabled="disabled" id="clients">
                            <option value="{{$payment->client->id}}">{{$payment->client->name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('messages.manual-payments.currency')</label>
                            <select class="form-control" name="currency" disabled="disabled" id="currency">
                                <option value="{{$payment->client->currency}}">{{$payment->client->currency}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('messages.manual-payments.reference')</label>
                            <input type="text" placeholder="@lang('messages.manual-payments.reference')" disabled id="reference" value="{{$payment->reference}}" class="form-control" name="reference">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('messages.manual-payments.description')</label>
                        <textarea class="form-control" style="max-width: 100%;" name="description" disabled id="description" placeholder="Description" rows="8">{{$payment->description}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">@lang('messages.payments.invoice_items')</label>
                    @foreach($payment->items as $item)
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-9">
                                <input type="text" disabled="" value="{{$item->concept}}" class="form-control" name="feeConcept[]">
                            </div>
                            <div class="col-md-3">
                                <input type="text" disabled="" value="{{$item->amount}} {{$payment->client->currency}}" name="feeAmount[]" class="form-control" name="feeConcept">
                            </div>
                        </div>
                    @endforeach
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-9">
                            <input type="text" disabled="" value="Total" class="form-control" name="tax">
                        </div>
                        <div class="col-md-3">
                            <input type="text" disabled="" value="{{$payment->total_amount}} {{$payment->client->currency}}" name="totalAmount" class="form-control" name="feeConcept">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('messages.payments.status')</label>
                            <select class="form-control" name="status" required id="status">
                                @role('CLIENT')
                                    <option value="PENDING">@lang('messages.payments.pending')</option>
                                    <option value="CANCELED">@lang('messages.payments.canceled')</option>
                                @endrole
                                @role('TREASURER1')
                                    <option value="REVISED1">@lang('messages.payments.revised1')</option>
                                @endrole
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">

                    <button type="submit" id="submit-btn" class="btn btn-primary">@lang('messages.payments.confirm')</button>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection
@section('extended-scripts')

@endsection
