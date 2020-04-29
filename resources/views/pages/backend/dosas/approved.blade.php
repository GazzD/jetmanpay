@extends('layouts.backend')

@section('title', __('messages.dosa.approved_dosas'))

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.dosa.approved_dosas')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.dosa.approved_dosas')</li>
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
				<th>@lang('messages.dosa.airplane')</th>
				<th>@lang('messages.dosa.billing_code')</th>
				<th>@lang('messages.dosa.total_amount')</th>
				<th>@lang('messages.dosa.currency')</th>
				<th>@lang('messages.dosa.options')</th>
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
