@extends('layouts.backend')

@section('title', __('pages/recharges.recharges'))

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('pages/recharges.recharges')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active">@lang('pages/recharges.recharges')</li>
                </ol>
            </div>
        </div>
    </div>
    @role('CLIENT|TREASURER1|TREASURER2')
        <div class="container-fluid">
            <div class="row mb-2" style="float:right;">
                <a href="{{route('recharges/create')}}" class="btn btn-primary"> @lang('pages/recharges.create')</a>
            </div>
        </div>
    @endrole
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
	<table id="datatable" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>@lang('pages/recharges.date')</th>
				<th>@lang('pages/recharges.user')</th>
				<th>@lang('pages/recharges.status')</th>
				<th>@lang('pages/recharges.options')</th>
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
            "url": "{{route('recharges/fetch')}}",
        },
        "columns":[
            {"data":"date"},
            {"data":"client.name"},
            {"data":"status"},
            {"data":"action"},
        ]
    });
});
</script>
@endsection
