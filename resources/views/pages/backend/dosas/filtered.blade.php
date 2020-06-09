@extends('layouts.backend')

@section('title', __('messages.dashboard.dashboard'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('pages/dosas.dosa')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dosas/plane') }}">@lang('pages/dosas.pending-dosas')</a></li>
                    <li class="breadcrumb-item active">@lang('pages/dosas.dosa')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    @if($errors->any())
        <h4>{{$errors->first()}}</h4>
    @endif
	<form action="{{route('payments/dosa/create')}}" method="post">
		@csrf
        <div class="row"  style="float:right;" >
            <div class="col-md-12">
                {{-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#generateReport" style="margin-bottom: 10px;">@lang('messages.payments.generate_report')</button> --}}
                <button type="submit" class="btn btn-warning" style="margin-bottom: 10px;">@lang('pages/dosas.pay-dosas')</button>
            </div>
        </div>
    	<table id="datatable" class="table table-striped table-bordered">
    		<thead>
    			<tr>
    				<th width="5%"></th>
    				<th>@lang('pages/dosas.airplane')</th>
    				<th>@lang('pages/dosas.billing_code')</th>
    				<th>@lang('pages/dosas.aperture_date')</th>
    				<th>@lang('pages/dosas.total_amount')</th>
    				<th>@lang('pages/dosas.status')</th>
    				<th>@lang('pages/dosas.actions')</th>
    			</tr>
    		</thead>
    		<tbody>
    			@foreach($dosas as $dosa)
    			<tr>
    				<td><input type="checkbox" name="dosasToPay[]" style="margin: 0.5em 1.3em;" value="{{ $dosa->id }}"></td>
    				<td>{{ $dosa->airplane }}</td>
    				<td>{{ $dosa->billing_code }}</td>
    				<td>{{ $dosa->aperture_date }}</td>
    				<td>{{ $dosa->total_dosa_amount }} {{ $dosa->currency }}</td>
    				<td>{{ $dosa->status }}</td>
    				<td>
    					<ul class="fc-color-picker" id="color-chooser">
    						<li><a class="text-muted" href="{{route('dosa-detail', $dosa->id)}}"><i class="fas fa-search" data-toggle="tooltip" data-placement="top" title="@lang('messages.pending-payments.view-receipt')"></i></a></li>
    					</ul>
    				</td>
    			</tr>
    			@endforeach
    		</tbody>
    	</table>
	</form>
</section>
<!-- /.content -->

@endsection
@section('extended-scripts')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#datatable').DataTable({
    	columnDefs: [{
    	      orderable: false,
    	      targets: 0
    	    }, {
    	      "targets": [2],
    	      "visible": false,
    	      "searchable": false
    	    }],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]]
    });
});
</script>
@endsection