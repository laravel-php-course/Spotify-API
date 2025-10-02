<?php

namespace App\Providers;

use App\Services\User\Auth\UserLoginService;
use App\Services\User\Auth\UserLoginServiceInterface;
use App\Services\User\Auth\UserRegisterService;
use App\Services\User\Auth\UserRegisterServiceInterface;
use Illuminate\Support\ServiceProvider;

// Repositories
use App\Repositories\AdminRepository;
use App\Repositories\AdminRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
// Services

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //repositories
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(AdminRepositoryInterface::class, AdminRepository::class);
        // Services
        $this->app->singleton(UserLoginServiceInterface::class, UserLoginService::class);
        $this->app->singleton(UserRegisterServiceInterface::class , UserRegisterService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
