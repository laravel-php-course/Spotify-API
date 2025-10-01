<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function findById($id): ?User
    {
        return User::find($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update($id, array $data): ?User
    {
        $model = $this->findById($id);
        $model->update($data);
        return $model;
    }

    public function findByField(string $field, mixed $value): ?User
    {
        return User::where($field , $value)->first();
    }
}
