@extends('layouts.backend')

@section('title', __('messages.claims.claims'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.claims.claims')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('claims') }}">@lang('messages.claims.claims')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.claims.details')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <form method="post" action="{{ route('claims/check') }}" enctype=multipart/form-data role="form" class="form-horizontal">
        @csrf
        <input type="hidden" name="claimId" value="{{$claim->id}}" />
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('messages.claims.type')</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" disabled name="planeId" required="required" id="planes">
                                <option selected>
                                    @if($claim->type == 'AMOUNT')
                                        @lang('messages.claims.incorrect_amount')
                                    @elseif($claim->type == 'FILE')
                                        @lang('messages.claims.incorrect_file')
                                    @else
                                        @lang('messages.claims.other')
                                    @endif
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('messages.claims.user')</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" disabled name="clientId" required="required" id="clients">
                                <option selected value="{{$claim->user->id}}">{{$claim->user->name}}</option>
                            </select>
                        </div>
                    </div>
            
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('messages.claims.payment')</label>
                            <input type="text" class="form-control" disabled name="invoice_number" value="{{$claim->payment->invoice_number}} ({{$claim->payment->total_amount}} {{$claim->payment->currency}})">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('messages.claims.date')</label>
                        <input type="text" disabled placeholder="Reference" id="reference" class="form-control" name="reference" value="{{$claim->created_at}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('messages.claims.status')</label>
                            <input type="text" class="form-control" disabled name="invoice_number" value="{{$claim->status}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('messages.claims.code')</label>
                            <input type="text" class="form-control" disabled name="invoice_number" value="{{$claim->code}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>@lang('messages.claims.description')</label>
                    <div class="col-md-12">
                    <textarea class="form-control" disabled style="max-width: 100%;" name="description" placeholder="@lang('messages.claims.description')" rows="8">{{$claim->description}}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
            	@if($canConfirm)
                <button type="submit" id="submit-btn" class="btn btn-primary">@lang('messages.claims.check')</button>
                @endif
                <a href="{{ route('claims') }}" class="btn btn-default">@lang('pages/users.back')</a>
            </div>
        </div>
    </form>
</section>
<!-- /.content -->
@endsection

