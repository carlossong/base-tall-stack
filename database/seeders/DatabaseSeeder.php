<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'José Carlos',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123Mudar'),
            'email_verified_at' => now(),
        ]);

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            PermissionRoleTableSeeder::class,
            RoleUserTableSeeder::class,
        ]);
    }
}
