<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Trait\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(private UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function register(RegisterUserRequest $request)
    {
        try {
            $user = $this->userRepository->create($request->all());

            return $this->success('Welcome to our app. You are registered', [
                'token' => $user->createToken('user todo token', [], now()->addWeek())->plainTextToken,
                'user'  => $user
            ]);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            if (!$request->user()) {
                return $this->error('User not authenticated.', 401);
            }

            $request->user()->currentAccessToken()->delete();

            return $this->success('Logout successful', []);
        } catch (\Exception $exception) {
            return $this->error('Logout failed: ' . $exception->getMessage(), 500);
        }
    }
}
