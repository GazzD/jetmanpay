@extends('layouts.backend')

@section('title', __('messages.claims.claims'))

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.claims.claims')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.claims.claims')</li>
                </ol>
            </div>
        </div>
    </div>
    {{-- <div class="container-fluid">
        <div class="row mb-2" style="float:right;">
            <a href="{{route('claims/create')}}" class="btn btn-primary"> @lang('messages.claims.create')</a>
        </div>
    </div> --}}
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
	<table id="datatable" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>@lang('messages.claims.date')</th>
				<th>@lang('messages.claims.code')</th>
				<th>@lang('messages.claims.type')</th>
				<th>@lang('messages.claims.status')</th>
				<th>@lang('messages.claims.user')</th>
				<th>@lang('messages.claims.description')</th>
				<th>@lang('messages.claims.options')</th>
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
            "url": "{{route('claims/fetch')}}",
        },
        "columns":[
            {"data":"date"},
            {"data":"code"},
            {"data":"type"},
            {"data":"status"},
            {"data":"user.name"},
            {"data":"description"},
            {"data":"action"},
        ]
    });
});
</script>
@endsection
