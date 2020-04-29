@extends('layouts.backend')

@section('title', __('messages.dashboard.dashboard'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.planes.planes')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.planes.planes')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <table id="datatable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>@lang('messages.planes.tail-number')</th>
                <th>@lang('messages.planes.passengers-number')</th>
                <th>@lang('messages.planes.weight')</th>
            </tr>
        </thead>
    </table>
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
            "url": "{{route('planes/fetch')}}",
        },
        "columns":[
            {"data":"tail_number"},
            {"data":"passengers_number"},
            {"data":"weight"},
        ]
    });
});
</script>
@endsection