@extends('layouts.backend')

@section('title', __('messages.dashboard.dashboard'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('messages.users.users')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('messages.home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users') }}">@lang('messages.users.users')</a></li>
                    <li class="breadcrumb-item active">@lang('messages.users.create')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <h1>@lang('messages.payments.add_tail')</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{route('payments/filter/plane/pending')}}" role="form" class="form-horizontal">
        @csrf
        <div class="form-group">
            <div class="col-md-10">
              <input type="text" required="" placeholder="@lang('messages.users.name')" id="name" class="form-control" name="name">
            </div>
        </div>
        <button type="submit" id="submit-btn" class="btn btn-primary">@lang('messages.users.create')</button>
	</form>
</section>
<!-- /.content -->
@endsection
@section('extended-scripts')

@endsection
