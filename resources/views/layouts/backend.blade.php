<!-- Stored in resources/views/layouts/app.blade.php -->

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>App Name - @yield('title')</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('partials/backend/head')
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            @include('partials/backend/userbar')
            @include('partials/backend/sidebar')
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
                @include('partials/backend/footer')
            </div>
        </div>
        @include('partials/backend/scripts')
    </body>
</html>

