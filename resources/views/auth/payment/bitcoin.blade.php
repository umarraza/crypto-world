@extends('layouts.app')

@section('title', __('Crypto World'))

@section('content')
<div class="content">
    <div class="block block-transparent bg-video" data-vide-bg="{{asset('assets/theme/media/videos/city_night') }}" data-vide-options="posterType: jpg" style="position: relative;"><div style="position: absolute; z-index: -1; top: 0px; left: 0px; bottom: 0px; right: 0px; overflow: hidden; background-size: cover; background-color: transparent; background-repeat: no-repeat; background-position: 50% 50%; background-image: none;"><video autoplay="" loop="" muted="" style="margin: auto; position: absolute; z-index: -1; top: 50%; left: 50%; transform: translate(-50%, -50%); visibility: visible; opacity: 1; width: 1154px; height: auto;"><source src="{{asset('assets/theme/media/videos/city_night.mp4') }}" type="video/mp4"><source src="{{asset('assets/theme/media/videos/city_night.webm') }}" type="video/webm"><source src="{{asset('assets/theme/media/videos/city_night.ogv') }}" type="video/ogg"></video></div>
        <div class="block-content bg-primary-dark-op">
            <div class="py-20 text-center">
                <h1 class="font-w700 text-white mb-10">Bitcoin Blockchain</h1>
                <h5 class="h5 font-w400 text-white-op">
                    Please Send EXACTLY <span style="color:red">{{ $bitcoin['amount']}} </span>BTC <br>TO <span style="color:red">{{ $bitcoin['sendto']}} </span>
                </h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8 col-xl-8">
            <div class="block block-fx-shadow text-center">
                <a class="d-block bg-primary font-w600 text-uppercase py-5" href="javascript::void(0)" data-toggle="modal" data-target="#modal-crypto-wallet-btc">
                    <span class="text-white">SCAN TO SEND</span>
                </a>
                <div class="block-content block-content-full">
                    <div class="pb-30">
                        {!!  $bitcoin['code']  !!}
                    </div>
                    <div class="pb-30">
                        <div class="font-size-h4 font-w100" style="color: red;">*1 confirmation required to credit fund in your account.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
