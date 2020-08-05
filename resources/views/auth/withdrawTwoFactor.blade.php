@extends('layouts.app')

@section('title', __('Withdraw verification | Crypto World'))

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    {{ Form::open(array('route' => 'user.verify.payment.withdraw','class' => 'kt-form')) }}
        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-group{{ $errors->has('withdraw_two_factor_code') ? ' has-error' : '' }}">
                    {!! Form::label('withdraw_amount', 'Two Factor Payment Withdraw Verification') !!}
                    {!! Form::hidden('withdraw_amount', $amount) !!}
                    {!! Form::number('withdraw_two_factor_code', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Verification Code']) !!}
                    <small class="text-danger">{{ $errors->first('withdraw_amount') }}</small>
                </div>
            </div>
        </div><!--form-group-->
        <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Verify')</button>
    {{ Form::close() }}
</div>
@endsection