<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository{
    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    public function updateUser(User $user, $data)
    {
        return $user->update($data);
    }

    public function storeUser($data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'CLIENT'
        ]);
    }

    public function storeModerator($data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'MODERATOR'
        ]);
    }

    public function findUserByEmail($data)
    {
        return User::where('email',$data)->first();
    }
}
