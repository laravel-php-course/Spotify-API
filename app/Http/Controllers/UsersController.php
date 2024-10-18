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

}
