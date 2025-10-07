<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create or find the 'admin' role, explicitly for the 'api' guard
        $role = Role::firstOrCreate(
            ['name' => 'admin'], // Search for 'admin'
            ['guard_name' => 'api'] // If not found, create it with the 'api' guard
        );

        // Create the admin user
        $admin = Admin::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Test Admin',
                'password' => Hash::make('password'), // Explicitly hash for clarity
            ]
        );

        // Assign the 'admin' role to the user
        $admin->assignRole($role);
    }
}
