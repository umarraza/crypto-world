@extends('layouts.app')

@section('title', __('Crypto World'))

@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Withdraw History
                </h3>
            </div>
            <div class="float-right">
                <small class="text-muted font-17">Total Withdraw: <b>${{ auth()->user()->totalWithdraw() }}</b></small><br>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="users-table-container">
                <table class="table table-striped- table-bordered table-hover table-checkable table-data_table" >
                    <thead>
                        <tr>
                            <th>@lang('Date')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Wallet ID')</th>
                            <th>@lang('Status')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentRequests as $request)
                        <tr>
                            <td>{{ $request->date }}</td>
                            <td>${{ $request->amount }}</td>
                            <td>123456</td>
                            <td>{!! $request->status_label !!}</td>
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
