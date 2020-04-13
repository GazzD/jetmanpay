@extends('layouts.backend')

@section('title', __('messages.documents.documents'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.payment-dosa.dosa')</h1>
                {{$payment->description}}
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{route('pending-payments')}}">@lang('messages.payments.payments')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.payment-dosa.dosa')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            @foreach($dosas as $dosa)
            <div class="col-md-3 col-sm-6 col-12">
                <a href="{{ $dosa->url }}" target="_blank">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="far fa-file-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ $dosa->aircraft_movement_id }}</span>
                            <div class="progress">
                              <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                            </span>
                        </div>
                      <!-- /.info-box-content -->
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- /.content -->
@endsection