<?php

namespace Database\Seeders;

use App\Enums\PermissionGroupEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ["name" => "admin dashboard" , "guard_name" => PermissionGroupEnum::ADMIN],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                [
                    'name' => $permission['name']
                ],
                [
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name'],
                ]
            );
        }
    }
}
