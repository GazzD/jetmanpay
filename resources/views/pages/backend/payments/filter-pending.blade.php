@extends('layouts.backend')

@section('title', __('messages.dashboard.dashboard'))

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('messages.payments.select_invocice')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('payments/filter/plane')}}">@lang('messages.sidebar.by-airline')</a></li>
                        <li class="breadcrumb-item active">@lang('messages.payments.select_invocice')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="card card-default">
        @foreach($payments as $payment)
        <div class="row">
            <h3 style="margin: 0.5em 1em;">
                <a href="{{route('payments/pay/create',$payment->id)}}">
                    {{$payment->invoice_number}} ({{$payment->total_amount}} {{$payment->currency}})
                </a>
            </h3>
        </div>
        <hr style="margin-bottom: 0;">
        @endforeach
    </div>
    </section>

<!-- /.content -->
@endsection
@section('extended-scripts')

@endsection
