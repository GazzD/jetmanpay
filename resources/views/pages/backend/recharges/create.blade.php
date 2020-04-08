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
                    <li class="breadcrumb-item"><a href="{{ route('recharges') }}">@lang('messages.recharges.recharges')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.recharges.create')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
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
            <label class="col-md-2 control-label">@lang('messages.recharges.image')</label>
            <div class="col-md-10">
              <input type="file" required="" class="form-control" name="picture">
            </div>
        </div>
        <button type="submit" id="submit-btn" class="btn btn-primary">@lang('messages.recharges.create')</button>
	</form>
</section>
<!-- /.content -->
@endsection
@section('extended-scripts')

@endsection
