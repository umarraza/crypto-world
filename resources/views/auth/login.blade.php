@extends('layouts.guest')

@section('content')
<div class="kt-login__container">
    <div class="kt-login__logo">
        <a href="#">
            <img src="assets/media/logos/logo-5.png">
        </a>
    </div>
    <div class="kt-login__signin">
        <div class="kt-login__head">
            <h3 class="kt-login__title">Sign In To Admin</h3>
        </div>
        {{ Form::open(array('route' => 'login','class' => 'kt-form')) }}
            <div class="input-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>
            <div class="input-group">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            </div>
            <div class="row kt-login__extra">
                <div class="col kt-align-right">
                    <a href="{{ route('password.request') }}" class="kt-login__link">Forget Password ?</a>
                </div>
            </div>
            <div class="kt-login__actions">
                <button type="submit" class="btn btn-brand btn-pill kt-login__btn-primary">
                    {{ __('Sign In') }}
                </button>
            </div>
        {{ Form::close() }}
    </div>
    <div class="kt-login__forgot">
        <div class="kt-login__head">
            <h3 class="kt-login__title">Forgotten Password ?</h3>
            <div class="kt-login__desc">Enter your email to reset your password:</div>
        </div>
        <form class="kt-form" action="">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="off">
            </div>
            <div class="kt-login__actions">
                <a class="btn btn-brand btn-pill kt-login__btn-primary" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                {{-- <button id="kt_login_forgot_submit" class="btn btn-brand btn-pill kt-login__btn-primary">Request</button>&nbsp;&nbsp; --}}
                <button id="kt_login_forgot_cancel" class="btn btn-secondary btn-pill kt-login__btn-secondary">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection
