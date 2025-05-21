<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // List of permissions
        $permissions = [
            'manage categories',
            'manage bank',
            'manage bouquet',
            'manage transaction',
            'manage user',
            'checkout',
            'view orders',
        ];

        // Create or get permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Role Customer
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Assign permissions to Customer role
        $customerPermissions = [
            'checkout',
            'view orders',
        ];

        // Sync permissions for the customer role
        $customerRole->syncPermissions($customerPermissions);

        // Create customer user and assign role
        $customer = User::create([
            'name' => 'Wildan Hawari',
            'email' => 'wildanhawari@gmail.com',
            'phone_number' => '1234567',
            'avatar' => 'images/default-avatar.png',
            'password' => bcrypt('12345'),
        ]);

        $customer->assignRole($customerRole);

        // Role Admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create admin user and assign role
        $admin = User::create([
            'name' => 'Qetcil Florist',
            'email' => 'admin@qetcil.com',
            'phone_number' => '0834612321',
            'avatar' => 'images/default-avatar.png',
            'password' => bcrypt('qetcil'),
        ]);

        $admin->assignRole($adminRole);

        // Optionally, you can add permissions to admin role if needed
        // $adminRole->syncPermissions(Permission::all());
    }
}
