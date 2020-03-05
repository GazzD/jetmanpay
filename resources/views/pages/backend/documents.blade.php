@extends('layouts.backend')

@section('title', __('messages.documents.documents'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.documents.documents')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.documents.documents')</li>
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
            <div class="col-md-3 col-sm-6 col-12">
                <a href="{{asset('backend/dist/docs/general_service_agreement.pdf')}}" target="_blank">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-file-signature"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('messages.documents.service-agreement')</span>
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
            <div class="col-md-3 col-sm-6 col-12">
                <a href="http://bcdaero.com/privacy-policy.html" target="_blank">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-user-lock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('messages.documents.privacy-policy')</span>
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
            <div class="col-md-3 col-sm-6 col-12">
                <a href="{{asset('backend/dist/docs/carta_de_representacion.pdf')}}" target="_blank">
                    <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-file-contract"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('messages.documents.representation-letter')</span>
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
            <div class="col-md-3 col-sm-6 col-12">
                <a href="http://bcdaero.com/user-agreement.html" target="_blank">
                    <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('messages.documents.user-agreement')</span>
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
        </div>
    </div>
</section>
<!-- /.content -->
@endsection