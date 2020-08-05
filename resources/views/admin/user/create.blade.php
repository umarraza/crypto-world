@extends('layouts.app')

@section('title', __('Crypto World'))

@section('content')
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    {{ Form::open(array('route' => 'admin.user.store','class' => 'kt-form')) }}

            <div class="form-group row">
                <div class="col-6">
                    <label for="first_name" class="col-md-2 col-form-label">@lang('First Name')</label>
                    <div class="col-md-10">
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" maxlength="100" />
                    </div>
                </div>
                <div class="col-6">
                    <label for="last_name" class="col-md-2 col-form-label">@lang('Last Name')</label>

                    <div class="col-md-10">
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" maxlength="100" />
                    </div>
                </div>
            </div><!--form-group-->


            <div class="form-group row">
                <div class="col-6">
                    <label for="user_name" class="col-md-2 col-form-label">@lang('User Name')</label>

                    <div class="col-md-10">
                        <input type="text" name="user_name" class="form-control" value="{{ old('user_name') }}" maxlength="100" />
                    </div>
                </div>
                <div class="col-6">
                    <label for="email" class="col-md-2 col-form-label">@lang('E-mail Address')</label>

                    <div class="col-md-10">
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" maxlength="255" />
                    </div>  
                </div>
            </div><!--form-group-->


            <div class="form-group row">
                <div class="col-6">
                    <label for="mobile_number" class="col-md-2 col-form-label">@lang('Mobile Number')</label>

                    <div class="col-md-10">
                        <input type="text" name="mobile_number" class="form-control" value="{{ old('mobile_number') }}" maxlength="255" />
                    </div>
                </div>
                <div class="col-6">
                    <label for="birthday" class="col-md-2 col-form-label">@lang('Birthday')</label>

                    <div class="col-md-10">
                        <input id="kt_datepicker_1" type="text" class="form-control" name="birthday" value="{{ old('birthday') }}" autocomplete="name" autofocus readonly>
                    </div>
                </div>
            </div><!--form-group-->

            <div class="form-group row">
                <div class="col-6">
                    <label for="street" class="col-md-2 col-form-label">@lang('Street')</label>

                    <div class="col-md-10">
                        <input type="text" name="street" class="form-control" value="{{ old('street') }}" maxlength="255" />
                    </div>
                </div>
                <div class="col-6">
                    <label for="text" class="col-md-2 col-form-label">@lang('City')</label>

                    <div class="col-md-10">
                        <input type="city" name="city" class="form-control" value="{{ old('city') }}" maxlength="255" />
                    </div>
                </div>
            </div><!--form-group-->

            <div class="form-group row">
                <div class="col-6">
                    <label for="text" class="col-md-2 col-form-label">@lang('Post Code')</label>

                    <div class="col-md-10">
                        <input type="post_code" name="post_code" class="form-control" value="{{ old('post_code') }}" maxlength="255" />
                    </div>
                </div>
                <div class="col-6">
                    <label for="name" class="col-md-2 col-form-label">@lang('Type')</label>
                    <div class="col-md-10">
                        @include('admin.user.includes.roles')
                    </div>
                </div>
            </div><!--form-group-->
            <div class="form-group row">
                    <label for="password" class="col-md-2 col-form-label">@lang('Password')</label>

                    <div class="col-md-10">
                        <input type="password" name="password" id="password" class="form-control" maxlength="100" autocomplete="new-password" />
                    </div>
            </div><!--form-group-->
            <div class="form-group row">
                    <label for="password_confirmation" class="col-md-2 col-form-label">@lang('Password Confirmation')</label>

                    <div class="col-md-10">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" maxlength="100" autocomplete="new-password" />
                    </div>
            </div>
            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create User')</button>

            {{-- <div class="form-group row">
                <label for="active" class="col-md-2 col-form-label">@lang('Active')</label>

                <div class="col-md-10">
                    <div class="form-check">
                        <input name="active" id="active" class="form-check-input" type="checkbox" value="1" {{ old('active', true) ? 'checked' : '' }} />
                    </div><!--form-check-->
                </div>
            </div><!--form-group-->

            <div x-data="{ emailVerified : false }">
                <div class="form-group row">
                    <label for="email_verified" class="col-md-2 col-form-label">@lang('E-mail Verified')</label>

                    <div class="col-md-10">
                        <div class="form-check">
                            <input
                                type="checkbox"
                                name="email_verified"
                                id="email_verified"
                                value="1"
                                class="form-check-input"
                                @click="emailVerified = !emailVerified"
                                {{ old('email_verified') ? 'checked' : '' }} />
                        </div><!--form-check-->
                    </div>
                </div><!--form-group-->

                <div x-show="!emailVerified">
                    <div class="form-group row">
                        <label for="send_confirmation_email" class="col-md-2 col-form-label">@lang('Send Confirmation E-mail')</label>

                        <div class="col-md-10">
                            <div class="form-check">
                                <input
                                    type="checkbox"
                                    name="send_confirmation_email"
                                    id="send_confirmation_email"
                                    value="1"
                                    class="form-check-input"
                                    {{ old('send_confirmation_email') ? 'checked' : '' }} />
                            </div><!--form-check-->
                        </div>
                    </div><!--form-group-->
                </div>
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create User')</button>
            </div> --}}
    {{ Form::close() }}
</div>
<!-- end:: Content -->
@endsection