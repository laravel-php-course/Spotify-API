<?php

namespace App\Repositories;

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
            'two_step_verification' => false,
            'subscription_plan' => 'FREE',
            'role' => 'USER',
        ]);

        return $user;
    }
}
