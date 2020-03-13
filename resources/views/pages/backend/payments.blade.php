@extends('layouts.backend')

@section('title', __('messages.dashboard.dashboard'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.payments.payments')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.payments.payments')</li>
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
				<th>@lang('messages.payments.tail-number')</th>
				<th>@lang('messages.payments.amount')</th>
				<th>@lang('messages.payments.date')</th>
				<th style="max-width: 400px:">@lang('messages.payments.description')</th>
				<th>@lang('messages.payments.number')</th>
				<th>@lang('messages.payments.client')</th>
				<th>@lang('messages.payments.operator')</th>
				<th>@lang('messages.payments.status')</th>
				<th>@lang('messages.payments.actions')</th>
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
            "url": "{{route('fetch-payments')}}",
        },
        "columns":[
            {"data":"plane.tail_number"},
            {"data":"total_amount"},
            {"data":"dosa_date"},
            {"data":"description"},
            {"data":"dosa_number"},
            {"data":"client.name"},
            {"data":"user.name"},
            {"data":"status"},
            {"data":"action"},
        ]
    });
});
</script>
@endsection