@extends('layouts.backend')

@section('title', __('messages.recharges.recharges'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.recharges.recharges')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('recharges') }}">@lang('messages.recharges.recharges')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.recharges.details')</li>
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
            <a href="{{$recharge->image}}">
                <img src="{{$recharge->image}}" class="img-responsive" target="_blank"/>
            </a>
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
    <form method="post" action="{{route('recharges/update', $recharge->id)}}" enctype="multipart/form-data" role="form" class="form-horizontal">
        @csrf
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.recharges.status')</label>
            <div class="col-md-10">
                @if($isEditable)
                    <select class="form-control" name="status">
                        @foreach($options as $option)
                            <option value="{{$option}}">{{$option}}</option>
                        @endforeach
                    </select>
                @else
                    <input type="text" class="form-control" disabled value="{{$recharge->status}}">   
                @endif
            </div>
        </div>
        @if(auth()->user()->hasRole('MANAGER') && $isEditable)
            <div class="form-group">
                <label class="col-md-2 control-label">@lang('messages.recharges.amount')</label>
                <div class="col-md-10">
                    <input type="number" class="form-control" name="amount" required />
                </div>
            </div>
        @endif
        <div class="form-group">
            <label class="col-md-2 control-label">@lang('messages.recharges.client')</label>
            <div class="col-md-10">
                <input type="text" disabled value="{{$recharge->client->name}}" class="form-control" name="picture">
            </div>
        </div>
        @if($isEditable)
            <button type="submit" id="submit-btn" class="btn btn-primary">@lang('messages.recharges.confirm')</button>
        @endif
    </form>
</section>
<!-- /.content -->
@endsection
@section('extended-scripts')

@endsection
