<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use app\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Trait\ApiResponse;

class UsersController extends Controller
{
    use ApiResponse;
    private  UserRepository $Repository;
    public function __construct(UserRepository $userRepository){
        $this->Repository = $userRepository;
    }
    public function register(RegisterUserRequest $request)
    {
        try {

            $user = $this->Repository->create($request)
            return $this->success('User registered successfully.', ['user' => $user]);
        } catch (\Exception $exception) {
            return $this->error('User registration failed.', 500, [$exception->getMessage()]);
        }
    }
    public function logout(Request $request)
    {
        try {
            // Check if the user is authenticated
            if (!$request->user()) {
                return $this->error('User not authenticated.', 401);
            }

            // Delete the current access token
            $request->user()->currentAccessToken()->delete();

            return $this->success('Logout successful',[]);
        } catch (\Exception $exception) {
            return $this->error('Logout failed: ' . $exception->getMessage(), 500);
        }
    }
}
