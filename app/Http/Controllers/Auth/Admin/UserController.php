<?php

namespace App\Http\Controllers\Auth\Admin;

use App\User;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\Auth\Role;
use Illuminate\Http\Request;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Domains\Auth\Services\UserService;
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
    public function __construct(User $user, UserService $userService, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
        $this->userService = $userService;
    }

    /**
     * @param ManageUserRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.user.index')->withUsers($this->user->all());
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
    public function usersByLevel($id, $users = null) {

        $id = intval($id);

        if ($id>6 || $id<1) {
            return redirect()->route('user.home')->withFlashDanger(__('Invalid level, please select valid level.'));
        }


        $levelOneIds = null; $levelTwoIds = null; $levelThreeIds = null; $levelFourIds = null; $levelFiveIds = null; $levelSixIds = null;

        $levelOneUsers = User::where('referred_by', Auth::user()->id);
        $levelOneUsers = $levelOneUsers->get();

        if (!empty($levelOneUsers)) {
            $levelOneIds = $levelOneUsers->pluck('id');
        }

        $levelTwoUsers = User::whereIn('referred_by', $levelOneIds);
        $levelTwoUsers = $levelTwoUsers->get();

        if (!empty($levelTwoUsers)) {
            $levelTwoIds = $levelTwoUsers->pluck('id');
        }
        
        $levelThreeUsers = User::whereIn('referred_by', $levelTwoIds);
        $levelThreeUsers = $levelThreeUsers->get();

        if (!empty($levelThreeUsers)) {
            $levelThreeIds = $levelThreeUsers->pluck('id');
        }

        $levelFourUsers = User::whereIn('referred_by', $levelThreeIds);
        $levelFourUsers = $levelFourUsers->get();

        if (!empty($levelTwoUsers)) {
            $levelFourIds = $levelFourUsers->pluck('id');
        }

        $levelFiveUsers = User::whereIn('referred_by', $levelFourIds);
        $levelFiveUsers = $levelFiveUsers->get();

        if (!empty($levelFiveUsers)) {
            $levelFiveIds = $levelFiveUsers->pluck('id');
        }

        $levelSixUsers = User::whereIn('referred_by', $levelFiveIds)->get();

        switch ($id) {
            case User::LEVEL_ONE:
                $users = $levelOneUsers;
            break;

            case User::LEVEL_TWO:
                $users = $levelTwoUsers;
            break;

            case User::LEVEL_THREE:
                $users = $levelThreeUsers;
            break;

            case User::LEVEL_FOUR:
                $users = $levelFourUsers;
            break;

            case User::LEVEL_FIVE:
                $users = $levelFiveUsers;
            break;

            case User::LEVEL_SIX:
                $users = $levelSixUsers;
            break;
        }
        return view('auth.users-by-level')->withUsers($users)->withId($id);
    }
}
