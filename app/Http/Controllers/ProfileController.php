<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return view('auth.profile')->withUser(auth()->user());
    }

    /**
     * @param  UpdateProfileRequest  $request
     * @param  UserService  $userService
     *
     * @return mixed
     */
    public function update(UpdateProfileRequest $request, UserService $userService)
    {
        $logged_in_user = Auth::user();

        $userService->updateProfile($request->user(), $request->all());

        if ($logged_in_user->isAdmin()) {
            return redirect()->route('admin.home')->withFlashSuccess(__('Profile successfully updated.'));
        } else {
            return redirect()->route('user.home')->withFlashSuccess(__('Profile successfully updated.'));
        }

    }
}
