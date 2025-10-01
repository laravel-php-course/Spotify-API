<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function findById($id): ?User;

    public function create(array $data): User;

    public function update($id, array $data): ?User;

    public function findByField(string $field , mixed $value): ?User;
}
