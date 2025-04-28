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
        return response()->json($this->userService->storeUser($request->validated()), 201);
    }

    public function registerModerator(StoreUserRequest $request)
    {
        return response()->json($this->userService->storeModerator($request->validated()), 201);
    }

    public function login(UserLoginRequest $request)
    {
        return $this->userService->loginUser($request->validated());
    }

    public function logout()
    {
        return response()->json($this->userService->logoutUser());
    }

    public function loggedUser()
    {
        return response()->json($this->userService->getLoggedUser());
    }

    public function update(UpdateUserRequest $request)
    {
        return response()->json($this->userService->updateUser($request->validated()));
    }

    public function delete()
    {
        return response()->json($this->userService->deleteUser(),204);
    }
}
