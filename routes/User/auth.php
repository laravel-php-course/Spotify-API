<?php

use App\Http\Controllers\User\UserAuthController;
use Illuminate\Support\Facades\Route;




Route::post('/login', [UserAuthController::class, 'login'])->name('user.login');
Route::post('/login/validate/otp', [UserAuthController::class, 'validate'])->name('user.login.validate.otp');
