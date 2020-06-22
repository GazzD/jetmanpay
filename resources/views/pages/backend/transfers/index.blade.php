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
                    <li class="breadcrumb-item active">@lang('pages/transfers.transfers')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="card card-primary card-outline">
        <div class="card-header">
        </div>
        <div class="card-body">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>@lang('pages/transfers.concept')</th>
                        <th>@lang('pages/transfers.amount')</th>
                        <th>@lang('pages/transfers.currency')</th>
                        <th>@lang('pages/transfers.status')</th>
                        <th>@lang('pages/transfers.created_at')</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection
@section('extended-scripts')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{route('transfers/fetch')}}",
        },
        "columns":[
            {"data":"concept"},
            {"data":"amount"},
            {"data":"currency"},
            {"data":"status"},
            {"data":"created_at"},
        ]
    });
});
</script>
@endsection
