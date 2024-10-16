<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Trait\ApiResponse;

class UsersController extends Controller
{
    use ApiResponse;

    public function register(RegisterUserRequest $request)
    {
        try {
            $user = User::create([
                'email' => $request->email,
                'mobile' => $request->mobile,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'two_step_verificaztion' => false,
                'subscribtion_plan' => 'FREE',
                'role' => 'USER',
            ]);

            return $this->success('User registered successfully.', ['user' => $user]);
        } catch (\Exception $exception) {
            return $this->error('User registration failed.', 500, [$exception->getMessage()]);
        }
    }
}
