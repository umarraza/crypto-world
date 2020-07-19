<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Domains\Auth\Services\UserService;
use App\Http\Requests\User\UpdateProfileRequest;

class ProfileController extends Controller
{

     /**
     * @param  User  $user
     *
     * @return mixed
     */
    public function profile() {
        return view('profile')->withUser(auth()->user());
    }

    /**
     * @param  UpdateProfileRequest  $request
     * @param  UserService  $userService
     *
     * @return mixed
     */
    public function update(UpdateProfileRequest $request, UserService $userService)
    {
        $userService->updateProfile($request->user(), $request->validated());

        // if (session()->has('resent')) {
        //     return redirect()->route('frontend.auth.verification.notice')->withFlashInfo(__('You must confirm your new e-mail address before you can go any further.'));
        // }

        return redirect()->route('frontend.user.profile', ['#information'])->withFlashSuccess(__('Profile successfully updated.'));
    }
}
