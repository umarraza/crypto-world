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

    <!-- Include styles -->
    @include('layouts.includes.styles')

</head>
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
    @include('layouts.includes.sidebar')
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
        @include('layouts.includes.header')
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
            <div class="kt-container kt-container--fluid  kt-grid__item kt-grid__item--fluid" id="app">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- Include scripts -->
    @include('layouts.includes.scripts')
    @include('layouts.includes.partials.messages')
</body>
</html>
