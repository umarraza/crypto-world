<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\User;
use App\Models\Profile;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Cookie;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'mobile_number' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'post_code' => ['required', 'string', 'max:255'],
            'user_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     * @throws \Throwable
     */
    protected function create(array $data)
    {
         DB::beginTransaction();

        try {
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'user_name' => $data['user_name'],
                'email' => $data['email'],
                'referred_by' => $this->refferedByUser(),
                'password' => Hash::make($data['password']),
            ]);

            if($user) {
                
                Payment::create(['user_id' => $user->id,'current_balance' => $data['payment']]);

                $profile = Profile::create([
                    'user_id' => $user->id,
                    'mobile_number' => $data['mobile_number'],
                    'birthday' => $data['birthday'],
                    'street' => $data['street'],
                    'city' => $data['city'],
                    'post_code' => $data['post_code'],
                ]);
            }

            $user->syncRoles(config('access.users.customer_role'));

        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem creating this user. Please try again.'));
        }

        DB::commit();
        return $user;
    }


    /**
     * @return int
     */
    private function refferedByUser() {

        $referred_by = Cookie::get('referral');
        $referred_by = explode(":",$referred_by);
        $referred_by = $referred_by[1];
        $referred_by = explode(";",$referred_by);
        $referred_by = (int)$referred_by[0];
        
        return $referred_by;
    }
}