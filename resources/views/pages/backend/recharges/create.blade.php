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
                    <li class="breadcrumb-item"><a href="{{ route('recharges') }}">@lang('pages/recharges.recharges')</a></li>
                    <li class="breadcrumb-item active">@lang('pages/recharges.create')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
	<form method="post" action="{{route('recharges/store')}}" enctype="multipart/form-data" role="form" class="form-horizontal">
		<div class="card card-primary card-outline">
			<div class="card-body">
				@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif @csrf
				<div class="form-group">
					<label for="picture">@lang('pages/recharges.image')</label>
					<div class="input-group">
						<div class="custom-file">
							<input type="file" class="custom-file-input" required="required" id="picture" name="picture">
							<label class="custom-file-label" for="picture">@lang('pages/recharges.choose-file')</label>
						</div>
						<div class="input-group-append">
							<span class="input-group-text" id="">@lang('pages/recharges.upload')</span>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" id="submit-btn" class="btn btn-primary">@lang('pages/recharges.create')</button>
				<a href="{{ route('recharges') }}" class="btn btn-default">@lang('pages/recharges.back')</a>
			</div>
		</div>
	</form>
</section>
<!-- /.content -->
@endsection
@section('extended-scripts')
<script src="{{asset('backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function () {
	bsCustomFileInput.init();
});
</script>
@endsection
