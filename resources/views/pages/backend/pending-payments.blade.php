@extends('layouts.backend')

@section('title', __('messages.dashboard.dashboard'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.pending-payments.pending-payments')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.pending-payments.pending-payments')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="row"  style="float:right;" >
        <div class="col-md-12">
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#generateReport" style="margin-bottom: 10px;">@lang('messages.payments.generate_report')</button>
        </div>
    </div>
	<table id="datatable" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>@lang('messages.pending-payments.tail-number')</th>
				<th>@lang('messages.pending-payments.amount')</th>
				<th>@lang('messages.pending-payments.date')</th>
				<th style="max-width: 400px:">@lang('messages.pending-payments.description')</th>
				<th>@lang('messages.pending-payments.number')</th>
				<th>@lang('messages.pending-payments.client')</th>
				<th>@lang('messages.pending-payments.operator')</th>
				<th>@lang('messages.pending-payments.actions')</th>
			</tr>
		</thead>
	</table>
	
</section>
<!-- /.content -->
 <!-- /.modal -->

 <div class="modal fade" id="generateReport">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form method="POST" action="{{route('payments/reports')}}">
            @csrf
            <input type="hidden" name="isPending" value="false">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('messages.payments.generate_report')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status" value="PENDING">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('messages.payments.begin_date')</label>
                                <input class="form-control" type="date" name="from" required>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('messages.payments.end_date')</label>
                                <input class="form-control" type="date" name="to" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('messages.payments.client')</label>
                                <select name="clientId" class="form-control">
                                    <option value="-1">@lang('messages.payments.any')</option>
                                    @foreach ($clients as $client)
                                        <option value="{{$client->id}}">{{$client->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('messages.payments.currency')</label>
                                <select name="currency" class="form-control">
                                    <option value="ALL">@lang('messages.payments.any')</option>
                                    <option value="USD">USD ($)</option>
                                    <option value="VEF">VEF (BsS)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="checkbox" name="excelToggle" checked data-toggle="toggle" data-on="Excel <i class='fa fa-file-excel'></i>" data-off="PDF <i class='fa fa-file-pdf'></i>" data-onstyle="success" data-offstyle="danger" data-width="100">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.payments.close')</button>
                    <button type="submit" class="btn btn-primary">@lang('messages.payments.generate_report')</button>
                </div>
            </form>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
@endsection
@section('extended-scripts')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{route('fetch-pending-payments')}}",
        },
        "columns":[
            {"data":"plane.tail_number"},
            {"data":"total_amount"},
            {"data":"dosa_date"},
            {"data":"description"},
            {"data":"dosa_number"},
            {"data":"client.name"},
            {"data":"user.name"},
            {"data":"action"},
        ]
    });
});
</script>
@endsection