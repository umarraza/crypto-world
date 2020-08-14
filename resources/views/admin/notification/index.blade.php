@extends('layouts.app')

@section('title', __('Crypto World'))

@section('content')
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Notification Management
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                        <a href="{{ route('admin.notification.create') }}" class="btn btn-brand btn-elevate btn-icon-sm" title="@lang('labels.general.create_new')">
                            <i class="la la-plus"></i>
                            New Notification
                        </a>
                    </div><!--btn-toolbar--> 
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="users-table-container">
                <table class="table table-striped- table-bordered table-hover table-checkable table-admin_tables">
                    <thead>
                        <tr>
                            <th>@lang('Notification')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications as $notification)
                        <tr>
                            <td>{{ $notification->notification }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="@lang('User Actions')">
                                    <a href="{{ route('admin.notification.edit', $notification) }}" data-toggle="tooltip" data-placement="top" title="@lang('Edit')" class="btn btn-dark">Edit</a>
                                    <a href="{{ route('admin.notification.delete', $notification->id) }}" data-toggle="tooltip" data-placement="top" title="@lang('Edit')" class="btn btn-danger">Delete</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination" style="margin-left:auto">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</div>
<!-- end:: Content -->
@endsection