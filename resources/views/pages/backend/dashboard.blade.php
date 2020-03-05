@extends('layouts.backend')

@section('title', __('messages.dashboard.dashboard'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.dashboard.dashboard')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">@lang('messages.dashboard.home')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.dashboard.dashboard')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Notification title</h3>
            </div>
            <div class="card-body">
                <p>Notification Body</p>
            </div><!-- /.card-body -->
        </div>
    </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection