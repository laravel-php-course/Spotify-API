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

    public function LoginUser(array $data)
    {
        $user = User::where('email',$data['email'])->first();
        if (!Hash::check($data['password'] , $user->password)){
            return False;
        }else{
            return  $user ;
        }
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
