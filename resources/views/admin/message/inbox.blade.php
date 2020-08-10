@extends('layouts.app')

@section('title', __('Withdraw verification | Crypto World'))

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="container">
        <admin-inbox :data_auth_id="{{ json_decode(auth()->user()->id) }}"></admin-inbox>
    </div>
</div>
@endsection