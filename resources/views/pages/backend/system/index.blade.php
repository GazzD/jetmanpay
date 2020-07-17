@extends('layouts.backend')

@section('title', __('pages/system.system'))

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('pages/system.system')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active">@lang('pages/system.system')</li>
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
            <h2 class="card-title">@lang('pages/system.ACTIVE')</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4"><h3>@lang('pages/system.balance_usd')</h3></div>
                <div class="col-md-4"><h3>@lang('pages/system.balance_bs')</h3></div>
                <div class="col-md-4"><h3>@lang('pages/system.balance_eu')</h3></div>
            </div>
            <div class="row">
                <div class="col-md-4"><h3> {{$system->balance_usd}}</h3></div>
                <div class="col-md-4"><h3> {{$system->balance_bs}}</h3></div>
                <div class="col-md-4"><h3> {{$system->balance_eu}}</h3></div>
            </div>
        </div>
    </div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h2 class="card-title">@lang('pages/system.HISTORIC')</h2>
        </div>
        <div class="card-body">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>@lang('pages/system.balance_usd')</th>
                        <th>@lang('pages/system.balance_bs')</th>
                        <th>@lang('pages/system.balance_eu')</th>
                        <th>@lang('pages/system.status')</th>
                        <th>@lang('pages/system.created_at')</th>
                        <th>@lang('pages/system.updated_at')</th>
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
<script src="http://cdn.datatables.net/plug-ins/1.10.15/dataRender/datetime.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#datatable').DataTable({
    	columnDefs:[
        	{
            	targets:4, render:function(data){
	      			return moment(data).format('DD/MM/YYYY h:m:s A');
	    		}
    		},
    		{
            	targets:5, render:function(data){
            		return moment(data).format('DD/MM/YYYY h:m:s A');
	    		}
    		}
		],
    	processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('system/fetch')}}",
        },
        columns:[
            {"data":"balance_usd"},
            {"data":"balance_bs"},
            {"data":"balance_eu"},
            {"data":"status"},
            {"data":"created_at"},
            {"data":"updated_at"},
        ]
    });
});
</script>
@endsection
