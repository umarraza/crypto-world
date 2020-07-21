<?php

namespace App\Http\Controllers\Auth\Admin;

use App\User;
use App\Models\Auth\Role;
use Illuminate\Http\Request;
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
        $user = $this->userService->store($request->validated());

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
        $this->userService->update($user, $request->validated());

        return redirect()->route('admin.user.index', $user)->withFlashSuccess(__('The user was successfully updated.'));
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
        $this->userService->delete($user);

        return redirect()->route('admin.user.index')->withFlashSuccess(__('The user was successfully deleted.'));
    }
}
