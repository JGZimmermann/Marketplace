<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function storeUser($data)
    {
        return $this->userRepository->storeUser($data);
    }

    public function storeModerator($data)
    {
        $user = $this->getLoggedUser();
        if($user->role != "ADMIN"){
            return response()->json([
                'message' => 'Precisa ser admin para realizar essa operação!'
            ]);
        } else {
            return $this->userRepository->storeModerator($data);
        }
    }

    public function getUserById($id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function updateUser($data)
    {
        $id = Auth::id();
        $user = $this->getUserById($id);
        if($data['password'] != null){
            $data = $this->hashPassword($data);
        }
        $this->userRepository->updateUser($user, $data);
        return response()->json([
            'message' => 'Usuário alterado com sucesso'
        ]);
    }

    public function hashPassword($data)
    {
        $data['password'] = Hash::make($data['password']);
        return $data;
    }

    public function loginUser($data)
    {
        $user = $this->userRepository->findUserByEmail($data['email']);
        if(!$user || !Hash::check($data['password'] , $user->password)){
            return response()->json([
                'message' => 'Credenciais Inválidas!'
            ]);
        }
        return response()->json([
            'token' => $user->createToken($user->name.'-AuthToken')->plainTextToken
        ]);
    }

    public function logoutUser()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Usuário deslogado'
        ]);
    }

    public function getLoggedUser()
    {
        return Auth::user();
    }

    public function deleteUser()
    {
        $id = Auth::id();
        $user = $this->getUserById($id);
        $user->delete();
        return response()->json([
            'message' => 'Usuário deletado com sucesso!'
        ]);
    }
}
