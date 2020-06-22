@extends('layouts.backend')

@section('title', __('pages/transfers.transfers'))

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('pages/transfers.transfers')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('transfers') }}">@lang('pages/transfers.transfers')</a></li>
                    <li class="breadcrumb-item active">@lang('pages/transfers.details')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <form method="post" action="{{route('transfers/approve')}}" role="form" class="form-horizontal">
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
                <input type="hidden" name="id" value="{{$transfer->id}}">
                @csrf
                <div class="form-group">
                    <label class="col-md-2 control-label">@lang('pages/transfers.amount')</label>
                    <div class="col-md-12">
                        <div class="form-group">
                        <input type="number" disabled placeholder="@lang('pages/transfers.amount')" value="{{$transfer->amount}}" id="name" class="form-control" name="name">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">@lang('pages/transfers.currency')</label>
                    <div class="col-md-12">
                    	<div class="form-group">
                            <select name="currency" disabled class="form-control select2" style="width: 100%;">
                                <option value="USD">{{$transfer->currency}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">@lang('pages/transfers.concept')</label>
                    <div class="col-md-12">
                        <input type="text" disabled placeholder="@lang('pages/transfers.concept')" value="{{$transfer->concept}}" id="name" class="form-control" name="concept">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">@lang('pages/transfers.description')</label>
                    <div class="col-md-12">
                        <textarea class="form-control" disabled name="description">{{$transfer->description}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">@lang('pages/transfers.reference')</label>
                    <div class="col-md-12">
                        <div class="form-group">
                            <img src="{{$transfer->reference}}" alt="reference image for transference"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">@lang('pages/transfers.created_by')</label>
                <div class="col-md-12">
                <input type="text" disabled placeholder="@lang('pages/transfers.created_by')" value="{{$transfer->user->name}}" id="name" class="form-control" name="concept">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">@lang('pages/transfers.status')</label>
                <div class="col-md-12">
                <input type="text" disabled placeholder="@lang('pages/transfers.status')" value="{{$transfer->status}}" id="name" class="form-control" name="concept">
                </div>
            </div>
            <div class="card-footer">
                @if($transfer->status == 'PENDING')
                    <button type="submit" id="submit-btn" class="btn btn-success">@lang('pages/transfers.approve')</button>
                @endif
                <a href="{{ route('transfers') }}" class="btn btn-default">@lang('pages/transfers.back')</a>
            </div>
        </div>
    </form>
</section>
<!-- /.content -->
@endsection

