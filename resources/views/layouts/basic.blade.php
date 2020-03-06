<!-- Stored in resources/views/layouts/app.blade.php -->
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> {{env('APP_NAME')}} - @yield('title')</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{asset('backend/dist/img/favicon1.png')}}">
        @include('partials/backend/head')
    </head>
    <body class="hold-transition login-page">
            <!-- Content Wrapper. Contains page content -->
            @yield('content')
        </div>
        @include('partials/backend/scripts')
    </body>
</html>

