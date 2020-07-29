@extends('layouts.app')

@section('title', __('Tracking App'))

@section('content')
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    {{ Form::open(array('route' => array('admin.user.update', $user),'method' => 'PATCH','class' => 'kt-form')) }}

            <div class="form-group row">
                <label for="first_name" class="col-md-2 col-form-label">@lang('First Name')</label>

                <div class="col-md-10">
                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $user->first_name }}" autocomplete="name" autofocus>
                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div><!--form-group-->
           

            <div class="form-group row">
                <label for="last_name" class="col-md-2 col-form-label">@lang('Last Name')</label>

                <div class="col-md-10">
                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $user->last_name }}" autocomplete="name" autofocus>
                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div><!--form-group-->

            <div class="form-group row">
                <label for="email" class="col-md-2 col-form-label">@lang('Email')</label>

                <div class="col-md-10">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" autocomplete="name" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div><!--form-group-->

            <div class="form-group row">
                <label for="user_name" class="col-md-2 col-form-label">@lang('User Name')</label>

                <div class="col-md-10">
                    <input type="text" name="user_name" id="user_name" class="form-control" placeholder="{{ __('User Name') }}" maxlength="100" value="{{ $user->user_name }}" autocomplete="new-password" />
                </div>
            </div><!--form-group-->

            <div class="form-group row">
                <label for="birthday" class="col-md-2 col-form-label">@lang('Birthday')</label>

                <div class="col-md-10">
                    <input id="kt_datepicker_1" type="text" class="form-control @error('birthday') is-invalid @enderror" name="birthday" value="{{ $user->profile->birthday }}" autocomplete="name" autofocus readonly>
                </div>
            </div>

            <div class="form-group row">
                <label for="mobile_number" class="col-md-2 col-form-label">@lang('Mobile Number')</label>

                <div class="col-md-10">
                    <input id="mobile_number" type="text" class="form-control" name="mobile_number" value="{{ $user->profile->mobile_number }}" autocomplete="name" autofocus>
                    @error('mobile_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div><!--form-group-->

            <div class="form-group row">
                <label for="street" class="col-md-2 col-form-label">@lang('Street')</label>

                <div class="col-md-10">
                    <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ $user->profile->street }}" autocomplete="name" autofocus>
                    @error('street')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div><!--form-group-->


            <div class="form-group row">
                <label for="street" class="col-md-2 col-form-label">@lang('City/State')</label>

                <div class="col-md-10">
                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ $user->profile->city }}" autocomplete="name" autofocus>
                    @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div><!--form-group-->

            <div class="form-group row">
                <label for="post_code" class="col-md-2 col-form-label">@lang('Post Code')</label>

                <div class="col-md-10">
                    <input id="post_code" type="text" class="form-control @error('post_code') is-invalid @enderror" name="post_code" value="{{ $user->profile->post_code }}" autocomplete="name" autofocus>
                    @error('post_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div><!--form-group-->

            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update')</button>
            <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-danger mr-2 float-right" type="submit">@lang('Cancel')</a>
    {{ Form::close() }}
</div>
<!-- end:: Content -->
@endsection