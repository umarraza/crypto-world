<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <base href="">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Tracking App')">

    <title>{{ config('app.name', 'Tracking') }}</title>
    <meta name="author" content="@yield('meta_author', 'Umar Raza')">
    <!--begin::Page Custom Styles(used by this page) -->
    <link href="assets/css/pages/login/login-4.css" rel="stylesheet" type="text/css" />

    <!--end::Page Custom Styles -->
    <!-- Include styles -->
    @include('layouts.includes.styles')

</head>
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
    <!-- begin:: Page -->
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v4 kt-login--signin" id="kt_login">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="{{ request()->is('password/reset') ? 'background-image: url(../assets/media/bg/bg-2.jpg)' : 'background-image: url(assets/media/bg/bg-2.jpg)' }} ;">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- Include scripts -->
    @include('layouts.includes.scripts')
    @include('layouts.includes.partials.messages')

    <!--begin::Page Scripts(used by this page) -->
    <script src="assets/js/pages/custom/login/login-general.js" type="text/javascript"></script>
    <!--end::Page Scripts -->
</body>
</html>
