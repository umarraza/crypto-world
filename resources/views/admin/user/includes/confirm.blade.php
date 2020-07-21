@if ($user->isConfirmed())
    @if ($user->id !== 1 && $user->id !== auth()->id())
        <a href="{{ route( 'admin.user.unconfirm', $user) }}" data-toggle="tooltip" data-placement="top" title="@lang('Unconfirm')" name="confirm_item">
            <span class="badge badge-success" style="cursor:pointer">@lang('Yes')</span>
        </a>
    @else
        <span class="badge badge-success">@lang('Yes')</span>
    @endif
@else
    <a href="{{ route('admin.user.confirm', $user->id) }}" data-toggle="tooltip" data-placement="top" title="@lang('Confirm')" name="confirm_item">
        <span class="badge badge-danger" style="cursor:pointer">@lang('No')</span>
    </a>
@endif
