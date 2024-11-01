<?php

use App\Enums\AbilityiesEnum;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user_register', [AuthController::class, 'register']);
Route::post('/user_login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->post('/user_logOut', [AuthController::class, 'logout']);
Route::get('/email/verify/{id}', [AuthController::class, 'verify'])->name('verification.verify')->middleware('throttle:10,1');
Route::middleware(['auth:sanctum', 'ability:' . AbilityiesEnum::REFRESH_TOKEN->value])->post('/refresh-token', [AuthController::class, 'refresh']);
// Route::apiResource('/user',UsersController::class);
