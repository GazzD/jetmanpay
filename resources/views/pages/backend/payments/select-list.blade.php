@extends('layouts.backend')

@section('title', __('messages.dashboard.dashboard'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.payments.add_tail')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item active">@lang('pages/payments.send-payment')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <form method="post" action="{{route('payments/filter/plane/pending')}}" role="form" class="form-horizontal">
        @csrf
        @if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif
		<div class="card card-primary card-outline">
			<div class="card-body">
				<div class="form-group">
					<div class="col-md-10">
						<div class="form-group">
							<label>@lang('pages/dosas.plane-tail')</label>
							<select class="form-control select2" placeholder="@lang('pages/payments.tail-number')" name="planeTail" style="width: 100%;">
								@foreach($planes as $plane)
									<option value="{{ $plane->tail_number }}">{{ $plane->tail_number }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" id="submit-btn" style="margin-top: 10px;"
					class="btn btn-primary">@lang('pages/payments.create')</button>
			</div>
		</div>
	</form>
</section>
<!-- /.content -->
@endsection
@section('extended-css')
<link rel="stylesheet" href="{{asset('backend/plugins/select2/css/select2.min.css')}}">
<style>
    .select2-container .select2-selection--single {
        height: 38px;
    }
</style>
@endsection
@section('extended-scripts')
<!-- Select2 -->
<script src="{{asset('backend/plugins/select2/js/select2.full.min.js')}}"></script>
<script type="text/javascript">
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();
    });
</script>
@endsection