<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_access',
            ],
            [
                'id'    => 2,
                'title' => 'user_delete',
            ],
            [
                'id'    => 3,
                'title' => 'permission_access',
            ],
            [
                'id'    => 4,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 5,
                'title' => 'role_access',
            ],
            [
                'id'    => 6,
                'title' => 'role_delete',
            ]
        ];

        Permission::insert($permissions);
    }
}
