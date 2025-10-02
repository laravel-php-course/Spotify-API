<?php

use App\Http\Controllers\User\UserAuthController;
use Illuminate\Support\Facades\Route;




Route::post('/login', [UserAuthController::class, 'login'])->name('user.login');
Route::post('/login/validate/otp', [UserAuthController::class, 'validate'])->name('user.login.validate.otp');

Route::post('/register' , [UserAuthController::class, 'register'])->name('user.register');
Route::post('/verify/send/email' , [UserAuthController::class, 'verifyEmailSend'])->name('user.verify.send.email');
Route::post('/verify/send/phone' , [UserAuthController::class, 'verifyPhoneSend'])->name('user.verify.send.phone');
Route::post('/verify/email' , [UserAuthController::class, 'verifyEmail'])->name('user.verify.email');
Route::post('/verify/phone' , [UserAuthController::class, 'verifyPhone'])->name('user.verify.phone');
