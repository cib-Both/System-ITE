<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);

        // Create or get the admin role
        $role = Role::firstOrCreate(['name' => 'admin']);

        // Create or get the admin user
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin12'), // Set a default password
            ]
        );

        // Assign the admin role to the user if not already assigned
        if (!$user->hasRole('admin')) {
            $user->assignRole('admin');
        }
    }

}
