@extends('layouts.backend')

@section('title', __('pages/dosas.approved_dosas'))

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('pages/dosas.approved_dosas')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active">@lang('pages/dosas.approved_dosas')</li>
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
				<th>@lang('pages/dosas.airplane')</th>
				<th>@lang('pages/dosas.billing_code')</th>
				<th>@lang('pages/dosas.total_amount')</th>
				<th>@lang('pages/dosas.currency')</th>
				<th>@lang('pages/dosas.options')</th>
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
            "url": "{{route('dosas/fetch/approved')}}",
        },
        "columns":[
            {"data":"airplane"},
            {"data":"billing_code"},
            {"data":"total_dosa_amount"},
            {"data":"currency"},
            {"data":"action"},
        ]
    });
});
</script>
@endsection
