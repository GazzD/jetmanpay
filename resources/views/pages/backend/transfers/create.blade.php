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
                    <li class="breadcrumb-item active">@lang('pages/transfers.create')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <form method="post" action="{{route('transfers/store')}}" enctype="multipart/form-data" role="form" class="form-horizontal">
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
                    <label class="col-md-2 control-label">@lang('pages/transfers.amount')</label>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="number" required="required" placeholder="@lang('pages/transfers.amount')" id="amount" class="form-control" name="amount">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">@lang('pages/transfers.currency')</label>
                    <div class="col-md-12">
                    	<div class="form-group">
                            <select name="currency" class="form-control select2" style="width: 100%;">
                                <option value="USD">USD</option>
                                <option value="BS">BS</option>
                                <option value="EU">EU</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">@lang('pages/transfers.concept')</label>
                    <div class="col-md-12">
                        <input type="text" required="required" placeholder="@lang('pages/transfers.concept')" id="concept" class="form-control" name="concept">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">@lang('pages/transfers.description')</label>
                    <div class="col-md-12">
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">@lang('pages/transfers.reference')</label>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="file" class="form-control" name="reference"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" id="submit-btn" class="btn btn-primary">@lang('pages/transfers.create')</button>
                <a href="{{ route('transfers') }}" class="btn btn-default">@lang('pages/transfers.back')</a>
            </div>
        </div>
    </form>
</section>
<!-- /.content -->
@endsection

