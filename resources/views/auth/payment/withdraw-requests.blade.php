@extends('layouts.app')

@section('title', __('Crypto World'))

@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    User Payment Withdraw Requests
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="users-table-container">
                <table class="table table-striped- table-bordered table-hover table-checkable table-admin_tables" >
                    <thead>
                        <tr>
                            <th>@lang('Name')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Address')</th>
                            <th>@lang('Date')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($withdrawRequests as $request)
                        <tr>
                            <td>{{ $request->user->name }}</td>
                            <td>${{ $request->amount }}</td>
                            <td>${{ $request->user->block_chain_address }}</td>
                            <td>{{ $request->date }}</td>
                            <td>{!! $request->status_label !!}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <a href="{{ route('admin.payment.withdraw.request.action', ['flag'=>encrypt(1),'id'=>encrypt($request->id),'user_id'=>encrypt($request->user->id)]) }}" class="btn btn-success btn-sm" data-toggle="tooltip" title="View">Accept</a>
                                    <a href="{{ route('admin.payment.withdraw.request.action', ['flag'=>encrypt(2),'id'=>encrypt($request->id),'user_id'=>encrypt($request->user->id)]) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="View">Reject</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination" style="margin-left:auto">
                {{-- {{ $users->links() }} --}}
            </div>
        </div>
    </div>
</div>
<!-- end:: Content -->
@endsection
