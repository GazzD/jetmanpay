@extends('layouts.backend')

@section('title', __('pages/users.users'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('pages/users.users')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active">@lang('pages/users.users')</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row mb-2" style="float:right;">
            <a href="{{route('users/create')}}" class="btn btn-primary"> @lang('pages/users.create')</a>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
	<table id="datatable" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>@lang('pages/users.name')</th>
				<th>@lang('pages/users.email')</th>
				<th>@lang('pages/users.role')</th>
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
            "url": "{{route('users/fetch')}}",
        },
        "columns":[
            {"data":"name"},
            {"data":"email"},
            {"data":"role"},
        ]
    });
});
</script>
@endsection
