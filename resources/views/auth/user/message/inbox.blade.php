@extends('layouts.app')

@section('title', __('Crypto World'))

@section('content')
<!-- begin:: Content -->

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="container">
        <user-inbox :data_auth_id="{{ json_encode(auth()->user()->id) }}"></user-inbox>
    </div>
</div>
<!-- end:: Content -->
@endsection