<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\FilesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CreateAdminUserSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(PerformanceProfileTemplateSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(CreateClientUsersSeeder::class);
        $this->call(FilesTableSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
