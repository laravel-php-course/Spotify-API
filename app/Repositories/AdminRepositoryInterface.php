<?php

namespace App\Repositories;

use App\Models\Admin;

interface AdminRepositoryInterface
{
    public function findById($id);

    public function create(array $data);

    public function update($id, array $data);

    public function findByField(string $field, mixed $value): ?Admin;
}
