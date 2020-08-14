<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\User;
use App\Helpers\BTCAddressValidatorValidator;
use Illuminate\Support\Arr;
use App\Exceptions\GeneralException;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Cookie;
use App\Notifications\User\WelcomeMail;


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
            'btc_address' => ['required', 'string', 'max:255'],
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

        $index = 0;     
        $level = 0;
        $power = 0;
        $counter = 1;
        $userIds = [$this->refferedByUser()];
        $found = false;
        while ($found == false) {

            $users = User::where('referred_by', $userIds[$index]) ->get();
            $count = $users->count();

            if ($count < 6) {
                $found = true;
                $refferdById = $userIds[$index]; 

                $user =  $this->registerUser($data,$refferdById);
                if ($user) {
                    $user->notify(new WelcomeMail());
                    return $user;
                }
            } else {
                $ids = User::where('referred_by', $userIds[$index])->where('payment_status', Payment::PAID)->pluck('id')->toArray();
                $userIds = array_merge($userIds, $ids);
                $index++;
            }
            $counter++; 
            if ($counter >  pow(6,$power)) {
                $power++;
                $level++;
                $counter = 1;
            }
            if ($level == 6) {
                $found = true;
                throw new GeneralException(__('Refferals limit reached against your refferal. Please contact your refferal.'));
            }
        }
    }

    private function registerUser(array $data,$refferdById) {
        try {
            $user = User::create([
                'first_name'    => $data['first_name'],
                'last_name'     => $data['last_name'],
                'user_name'     => $data['user_name'],
                'email'         => $data['email'],
                'referred_by'   => $refferdById,
                'original_reffered_by' => $this->refferedByUser(),
                'password'      => Hash::make($data['password']),
            ]);

            if($user) {
                
                Payment::create(['user_id' => $user->id,'current_balance' => Payment::DEFAULT_BALANCE_ZERO]);                

                $profile = Profile::create([
                    'user_id'       => $user->id,
                    'mobile_number' => $data['mobile_number'],
                    'birthday'      => $data['birthday'],
                    'street'        => $data['street'],
                    'city'          => $data['city'],
                    'post_code'     => $data['post_code'],
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

        if (Arr::exists($_COOKIE, 'referral')) {
            return intval($_COOKIE['referral']);
        } else {
            return NULL;
        }

        throw new GeneralException(__('Something went wrong while registration. Please contact support.'));
    }
}