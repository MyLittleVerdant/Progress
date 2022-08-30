<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://kit.fontawesome.com/81f114f794.js" crossorigin="anonymous"></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('js/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- toastr -->
    <link rel="stylesheet" href="{{ asset('js/plugins/toastr/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('admin.includes.navbar')

    <!-- Left side column. contains the logo and sidebar -->
    @include('layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            @yield('content')
        </section>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.0.5
        </div>
        <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
        reserved.
    </footer>
</div>


<script src="{{ asset('js/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('js/admin/app.js') }}"></script>
<script src="{{ mix('js/app.js') }}" defer></script>
@if(session('alerts'))
    <script>
        $(document).ready(function () {
            @foreach(session('alerts') as $key => $text)
            toastr.{{$key}}("{!! $text !!}");
            @endforeach
        });

    </script>
@endif
@stack('js')
</body>
</html>
