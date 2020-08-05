<?php

namespace App\Http\Controllers\Auth\Admin;

use App\User;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\Auth\Role;
use Illuminate\Http\Request;
use App\Events\InviteRefferal;
use App\Models\PaymentRequest;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Domains\Auth\Services\UserService;
use App\Http\Requests\Auth\DepositPaymentRequest;
use App\Http\Requests\Admin\User\ManageUserRequest;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Http\Requests\Admin\User\DeleteUserRequest;

class UserController extends Controller
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Role
     */
    protected $role;

    /**
     * User constructor.
     *
     * @param App\User $user
     */
    public function __construct(User $user, UserService $userService, Role $role, Payment $payment, PaymentRequest $paymentRequest)
    {
        $this->user = $user;
        $this->role = $role;
        $this->payment = $payment;
        $this->userService = $userService;
        $this->paymentRequest = $paymentRequest;
    }

    /**
     * @param ManageUserRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.user.index')->withUsers($this->user->paginate(config('access.default_size')));
    }

    /**
     * @param ManageUserRequest    $request
     *
     * @return mixed
     */
    public function create(ManageUserRequest $request)
    {
        return view('admin.user.create')
            ->withRoles($this->role->all());
    }

    /**
     * @param  StoreUserRequest  $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->store($request->all());

        return redirect()->route('admin.user.show', $user)->withFlashSuccess(__('The user was successfully created.'));
    }


     /**
     * @param  User  $user
     *
     * @return mixed
     */ 
    public function show(User $user)
    {
        return view('admin.user.show')
            ->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.user.edit')->withUser($user);  
    }

    /**
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     *
     * @return mixed
     * @throws \Throwable
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->update($user, $request->all());

        return redirect()->route('admin.user.index')->withFlashSuccess(__('The user was successfully updated.'));
    }

    
    /**
     * @param  DeleteUserRequest  $request
     * @param  User  $user
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(DeleteUserRequest $request, User $user)
    {
        $this->userService->destroy($user);

        return redirect()->route('admin.user.index')->withFlashSuccess(__('The user was successfully deleted.'));
    }

    /**
     * @param ManageUserRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unpaid(ManageUserRequest $request) {

        return view('admin.user.unpaid')
            ->withUsers(User::getUsersByRole(config('access.users.customer_role')));
    }

        /**
     * @param ManageUserRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function usersByLevel($level) {        
        if ($level>User::LEVEL_SIX || $level<User::LEVEL_ONE) {
            return redirect()->route('user.home')->withFlashDanger(__('Invalid level, please select valid level.'));
        }

        return view('auth.users-by-level')->withUsers(Auth::user()->getUsersByRefferalLevel($level))->withLevel($level);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deposit(Request $request) {
        return view('admin.deposit')->withId($request->id);
    }

     /**
     * @param  DepositPaymentRequest  $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function depositAmount(DepositPaymentRequest $request) {

        \DB::beginTransaction();

            try {

                $paymentRequest = PaymentRequest::create([
                    'user_id' => decrypt($request->id),
                    'amount' => $request->deposit_amount,
                    'type' => PaymentRequest::DEPOSIT,
                    'status' => PaymentRequest::APPROVED,
                    'date' => date('Y-m-d'),
                ]);

            } catch (Exception $e) {
                \DB::rollBack();
                throw new GeneralException(__('There was a problem while depositing this amount. Please try again.'));
            }
            \DB::commit();

        return redirect()->route('admin.user.index')->withFlashSuccess(__('The payment was deposited successfully.'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function inviteRefferalUser() {
        return view('auth.invite');
    }

    /**
     * Send refferal invitation mail
     */
     public function invite(Request $request) {

        event(new InviteRefferal($request->email));
        return redirect()->route('user.home')->withFlashSuccess(__('Refferal invitation sent successfully.'));
    }
}
