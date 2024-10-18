<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Trait\ApiResponse;

class UsersController extends Controller
{
    use ApiResponse;

    private UserRepository $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function register(RegisterUserRequest $request)
    {
        try {
            // Pass validated data to the repository
            $user = $this->repository->create($request->validated());

            return $this->success('User registered successfully.', ['user' => $user]);
        } catch (\Exception $exception) {
            return $this->error('User registration failed.', 500, [$exception->getMessage()]);
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
