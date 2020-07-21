<div class="btn-group" role="group" aria-label="@lang('User Actions')">
    <a href="{{ route('admin.user.show', $user) }}" data-toggle="tooltip" data-placement="top" title="@lang('View')" class="btn btn-primary">
        <i class="fas fa-eye"></i>
    </a>

    <a href="{{ route('admin.user.edit', $user) }}" data-toggle="tooltip" data-placement="top" title="@lang('Edit')" class="btn btn-dark">
        <i class="fas fa-edit"></i>
    </a>

    <div class="dropdown" role="group">
        <button id="userActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @lang('More')
        </button>
        <div class="dropdown-menu" aria-labelledby="userActions">

            <a href="{{ route('admin.user.destroy', $user->id) }}"
                class="dropdown-item" onclick="event.preventDefault();document.querySelector('.user-delete-form').submit()">@lang('Delete')</a>
            <form action="{{ route('admin.user.destroy', $user) }}" method="post" class="user-delete-form">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>