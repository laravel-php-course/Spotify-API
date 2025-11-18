<?php

use App\Http\Controllers\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;


Route::post('admin/l0gin', [AdminAuthController::class , 'login'])->name('admin.login');
Route::post('admin/verify/phone' , [AdminAuthController::class, 'verifyPhone'])->name('admin.verify.phone');
Route::post('admin/logout',[AdminAuthController::class, 'logout'])->name('admin.logout');
