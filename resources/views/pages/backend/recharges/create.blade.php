@extends('layouts.backend')

@section('title', __('messages.recharges.recharges'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.recharges.recharges')</h1>
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
            @endif
            <form method="post" action="{{route('recharges/store')}}" enctype="multipart/form-data" role="form" class="form-horizontal">
                @csrf
				<div class="form-group">
					<label for="picture">@lang('pages/recharges.image')</label>
					<div class="input-group">
						<div class="custom-file">
							<input type="file" class="custom-file-input" required="required" id="picture" name="picture">
							<label class="custom-file-label" for="picture">Choose file</label>
						</div>
						<div class="input-group-append">
							<span class="input-group-text" id="">Upload</span>
						</div>
					</div>
				</div>
                <button type="submit" id="submit-btn" class="btn btn-primary">@lang('pages/recharges.create')</button>
                <button onclick="window.history.back();" class="btn btn-default">@lang('pages/recharges.back')</button>
            </form>
        </div>
    </div>
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
