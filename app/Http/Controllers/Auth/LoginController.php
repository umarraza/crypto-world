<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo() {
        $logged_in_user = Auth::user();

        if ($logged_in_user->isAdmin()) {
            return route('admin.home');
        }

        if ($logged_in_user->isCustomer()) {
            return route('user.home');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Two factor authentication.
     *
     * @return void
     */
    protected function authenticated(Request $request, $user)
    {
        if (! $user->isActive()) {
            auth()->logout();

            return redirect()->route('login')->withFlashDanger(__('Your account has been deactivated.'));
        }
        
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
    }

     /**
     * Get the login username or email to be used by the controller.
     *
     * @return string
     */
     public function username($request)
     {
        return filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';
     }
}