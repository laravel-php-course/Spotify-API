<?php

namespace App\Repositories;

use App\Models\Admin;

class AdminRepository implements AdminRepositoryInterface
{

    public function findById($id)
    {
        return Admin::find($id);
    }

    public function create(array $data)
    {
        return Admin::create($data);
    }

    public function update($id, array $data)
    {
        $model = $this->findById($id);
        $model->update($data);
        return $model;
    }
}