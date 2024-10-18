<?php

namespace App\Repositories;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function create(array $data): User
    {
        $user = User::create([
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'role' => RoleEnum::USER->value
        ]);

        return $user;
    }
}
