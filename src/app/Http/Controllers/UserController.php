<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserLoginRequest;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function register(StoreUserRequest $request)
    {
        return $this->userService->storeUser($request->validated());
    }

    public function registerModerator(StoreUserRequest $request)
    {
        return $this->userService->storeModerator($request->validated());
    }

    public function login(UserLoginRequest $request)
    {
        return $this->userService->loginUser($request->validated());
    }

    public function logout()
    {
        return $this->userService->logoutUser();
    }

    public function loggedUser()
    {
        return $this->userService->getLoggedUser();
    }

    public function update(UpdateUserRequest $request)
    {
        return $this->userService->updateUser($request->validated());
    }

    public function delete()
    {
        return $this->userService->deleteUser();
    }
}
