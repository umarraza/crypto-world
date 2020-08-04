@extends('layouts.app')

@section('title', __('Crypto World'))

@section('content')
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    {{ Form::open(array('route' => 'user.payment.withdraw.save','class' => 'kt-form')) }}
        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-group{{ $errors->has('withdraw_amount') ? ' has-error' : '' }}">
                    {!! Form::label('withdraw_amount', 'Withdraw Amount') !!}
                    {!! Form::number('withdraw_amount', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Please enter withdraw amount']) !!}
                    <small class="text-danger">{{ $errors->first('withdraw_amount') }}</small>
                </div>
            </div>
        </div><!--form-group-->
        <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Withdraw')</button>
    {{ Form::close() }}
</div>
<!-- end:: Content -->
@endsection
