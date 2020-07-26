@extends('layouts.app')

@section('title', __('Tracking App'))

@section('content')
<!-- begin:: Content -->
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                @lang('Users Management')
                <small class="text-muted">@lang('View')</small>
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#" data-target="#kt_tabs_overview">Details</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="kt_tabs_overview" role="tabpanel">
                <div class="kt-portlet">
                    <div class="kt-portlet__body">
                        <!--begin::Section-->
                        <div class="kt-section">
                            <div class="kt-section__content">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>@lang('Name')</th>
                                            <td>{{ $user->full_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('User Name')</th>
                                            <td>{{ $user->user_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Email')</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Blockchain Address')</th>
                                            <td>
                                                <span class="label label-warning label-pill label-inline mr-2">{{ $user->block_chain_address }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Status')</th>
                                            <td>@include('admin.user.includes.status', ['user' => $user])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Confirmed')</th>
                                            <td>@include('admin.user.includes.confirm', ['user' => $user])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Mobile')</th>
                                            <td>{{ $user->profile->mobile_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Date of Birth')</th>
                                            <td>{{ $user->profile->birthday }}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('Street')</th>
                                            <td>{{ $user->profile->street }}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('City')</th>
                                            <td>{{ $user->profile->city }}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('Post Code')</th>
                                            <td>{{ $user->profile->post_code }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-primary" type="submit">@lang('Bsck to List')</a>
        </div>
    </div>
</div>
<!-- end:: Content -->
@endsection