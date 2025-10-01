<?php

namespace App\Repositories;

interface AdminRepositoryInterface
{
    public function findById($id);

    public function create(array $data);

    public function update($id, array $data);
}