@extends('layouts.backend')

@section('title', __('messages.dashboard.dashboard'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.payments.add_tail')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.sidebar.by-airline')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">@lang('messages.payments.add_tail')</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{route('dosas/plane')}}" role="form" class="form-horizontal">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('messages.payments.plane_tail')</label>
                            <select class="form-control select2" name="tailNumber" style="width: 100%;">
                                @foreach($planes as $plane)
                                <option value="{{ $plane->tail_number }}">{{ $plane->tail_number }}</option>
                                @endforeach
                            </select>
                            <button type="submit" id="submit-btn" style="margin-top: 10px;" class="btn btn-primary">@lang('messages.dosa.search')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection
@section('extended-css')
<link rel="stylesheet" href="{{asset('backend/plugins/select2/css/select2.min.css')}}">
<style>
    .select2-container .select2-selection--single {
        height: 38px;
    }
</style>
@endsection
@section('extended-scripts')
<!-- Select2 -->
<script src="{{asset('backend/plugins/select2/js/select2.full.min.js')}}"></script>
<script type="text/javascript">
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();
    });
</script>
@endsection
