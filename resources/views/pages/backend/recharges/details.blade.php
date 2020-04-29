@extends('layouts.backend')

@section('title', __('pages/recharges.recharges'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('pages/recharges.recharges')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('recharges') }}">@lang('pages/recharges.recharges')</a></li>
                    <li class="breadcrumb-item active">@lang('pages/recharges.details')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <form method="post" action="{{route('recharges/update', $recharge->id)}}" enctype="multipart/form-data" role="form" class="form-horizontal">
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
                    <label class="col-md-2 control-label">@lang('pages/recharges.status')</label>
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
                @if(auth()->user()->hasRole('REVIEWER') && $isEditable)
                    <div class="form-group">
                        <label class="col-md-2 control-label">@lang('pages/recharges.amount')</label>
                        <div class="col-md-10">
                            <input type="number" class="form-control" name="amount" required />
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label class="col-md-2 control-label">@lang('pages/recharges.client')</label>
                    <div class="col-md-10">
                        <input type="text" disabled value="{{$recharge->client->name}}" class="form-control" name="picture">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <a href="{{$recharge->image}}">
                            <img src="{{$recharge->image}}" class="img-responsive" style="max-width: 100%;"/>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                @if($isEditable)
                    <button type="submit" id="submit-btn" class="btn btn-primary">@lang('pages/recharges.confirm')</button>
                @endif
                <a href="{{ route('recharges') }}" class="btn btn-default">@lang('pages/recharges.back')</a>
            </div>
        </div>
    </form>
</section>
<!-- /.content -->
@endsection
@section('extended-scripts')

@endsection
