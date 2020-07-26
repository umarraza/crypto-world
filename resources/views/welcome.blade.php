<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <base href="">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="description" content="@yield('meta_description', 'Tracking App')">

    <title>{{ config('app.name', 'Tracking') }}</title>
    <meta name="author" content="@yield('meta_author', 'Umar Raza')">
    <!--begin::Page Custom Styles(used by this page) -->
    <link href="assets/css/pages/login/login-4.css" rel="stylesheet" type="text/css" />

    <!--end::Page Custom Styles -->
    <!-- Include styles -->
    @include('layouts.includes.styles')

    <style>
        html, body {
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #fff;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
    <!-- begin:: Page -->
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v4 kt-login--signin" id="kt_login">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url(assets/media/bg/bg-2.jpg);">
                <div class="flex-center position-ref full-height">
                    @if (Route::has('login'))
                        <div class="top-right links">
                            @auth
                                <a href="{{  auth()->user()->isAdmin() ? route('admin.home') : route('user.home') }}">Home</a>
                                <a href="{{  route('logout') }}">Logout</a>
                            @else
                                <a href="{{ route('register') }}">Register</a>
                                <a href="{{ route('login') }}">Login</a>
                            @endauth
                        </div>
                    @endif
        
                    <div class="content">
                        <div class="title m-b-md">
                            Crypto World
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>
