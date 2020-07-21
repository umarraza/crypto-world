<?php

namespace App\Http\Controllers\Auth\Admin;

use App\User;
use App\Http\Controllers\Controller;
use App\Domains\Auth\Services\UserService;
use App\Http\Requests\Admin\User\ManageUserRequest;

/**
 * Class UserConfirmationController.
 */
class UserConfirmationController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @return mixed
     */
    public function sendConfirmationEmail(ManageUserRequest $request, User $user)
    {
        // Shouldn't allow users to confirm their own accounts when the application is set to manual confirmation
        if (config('access.users.requires_approval')) {
            return redirect()->back()->withFlashDanger(__('alerts.backend.users.cant_resend_confirmation'));
        }

        if ($user->isConfirmed()) {
            return redirect()->back()->withFlashSuccess(__('exceptions.backend.access.users.already_confirmed'));
        }

        $user->notify(new UserNeedsConfirmation($user->confirmation_code));

        return redirect()->back()->withFlashSuccess(__('alerts.backend.users.confirmation_email'));
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @throws \App\Exceptions\GeneralException
     * @return mixed
     */
    public function confirm(ManageUserRequest $request, User $user)
    {
        $this->userService->confirm($user);

        return redirect()->route('admin.user.index')->withFlashSuccess(__('The user was successfully confirmed.'));
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @throws \App\Exceptions\GeneralException
     * @return mixed
     */
    public function unconfirm(ManageUserRequest $request, User $user)
    {
        $this->userService->unconfirm($user);

        return redirect()->route('admin.user.index')->withFlashSuccess(__('The user was successfully un-confirmed'));
    }
}
