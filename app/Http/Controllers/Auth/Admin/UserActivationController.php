<?php

namespace App\Http\Controllers\Auth\Admin;

use App\User;
use App\Http\Controllers\Controller;
use App\Domains\Auth\Services\UserService;
use App\Http\Requests\Admin\User\ManageUserRequest;

/**
 * Class UserConfirmationController.
 */
class UserActivationController extends Controller
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
     * @throws \App\Exceptions\GeneralException
     * @return mixed
     */
    public function activate(ManageUserRequest $request, User $user)
    {
        $this->userService->active($user);

        return redirect()->route('admin.user.index')->withFlashSuccess(__('The user was successfully activated.'));
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @throws \App\Exceptions\GeneralException
     * @return mixed
     */
    public function unactivate(ManageUserRequest $request, User $user)
    {
        $this->userService->unactivate($user);

        return redirect()->route('admin.user.index')->withFlashSuccess(__('The user was successfully de-activated'));
    }
}
