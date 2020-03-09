@extends('layouts.backend')

@section('title', __('messages.dashboard.dashboard'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.upload-json.json')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.upload-json.json')</li>
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
                <h3 class="card-title">@lang('messages.upload-json.upload-file')</h3>
            </div>
            <div class="card-body">
                <form action="{{route('store-json')}}" class="form-horizontal form-label-left" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">@lang('messages.upload-json.json-file')<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="file" id="jsonFile" name="jsonFile" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">@lang('messages.upload-json.send')</button>
                        </div>
                    </div>
                    @if (session('status'))
                        <div class="callout callout-success" style="background-color: #00a65a !important;">
                            <p style="color: #FFF;">{{ session('status') }}</p>
                      	</div>
                    @endif
                </form>
            </div><!-- /.card-body -->
        </div>
    </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection