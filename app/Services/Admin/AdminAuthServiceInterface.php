<?php

namespace App\Services\Admin;

use App\Models\Admin;

interface AdminAuthServiceInterface
{
    /**
     * Attempt to login admin and return token
     *
     * @param string $email
     * @param string $password
     * @return array{admin: Admin, token: string}
     */
    public function login(string $email, string $password): array;

    /**
     * Logout admin (delete all tokens)
     *
     * @param Admin $admin
     * @return void
     */
    public function logout(Admin $admin): void;
}
