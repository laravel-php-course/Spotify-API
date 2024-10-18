<?php
namespace app\Repositories;
use App\Models\User;
use Request;
use Illuminate\Support\Facades\Hash;

class UserRepository{
   public function getAllUsers(){
    return User::all();
   }
   public function create(array $data){
    $user = User::create([
        'email' => $data["email"],
        'mobile' => $data["mobile"],
        'username' => $data["username"],
        'password' => Hash::make($data["password"]),
        'two_step_verificaztion' => false,
        'subscribtion_plan' => 'FREE',
        'role' => 'USER',
    ]);
    return $user;
   }
}
