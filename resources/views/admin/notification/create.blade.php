@extends('layouts.app')

@section('title', __('Crypto World'))

@section('content')
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    {{ Form::open(array('route' => 'admin.notification.store','class' => 'kt-form')) }}
            <div class="form-group row">
                <div class="col-12">
                    {!! Form::label('notification', 'Notification') !!}
                    {!! Form::textarea('notification', null, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>
            </div><!--form-group-->
        <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create')</button>
    {{ Form::close() }}
</div>
<!-- end:: Content -->
@endsection