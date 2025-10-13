<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User Management
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Product Management
            'view products',
            'create products',
            'edit products',
            'delete products',
            'approve products',

            // Service Management
            'view services',
            'create services',
            'edit services',
            'delete services',

            // Job Management
            'view jobs',
            'create jobs',
            'edit jobs',
            'delete jobs',
            'bid on jobs',

            // Order Management
            'view orders',
            'create orders',
            'edit orders',
            'delete orders',
            'manage orders',

            // Financial
            'view transactions',
            'manage wallet',
            'withdraw funds',
            'add funds',

            // Support
            'create tickets',
            'view tickets',
            'manage tickets',

            // Disputes
            'create disputes',
            'view disputes',
            'manage disputes',

            // Reviews
            'create reviews',
            'view reviews',
            'manage reviews',

            // Admin
            'access admin panel',
            'manage settings',
            'view reports',

            // SPM - Smart Project Manager
            'access spm',
            'create projects',
            'manage projects',
            'create tasks',
            'manage tasks',
            'log time',
            'approve time',
            'create milestones',
            'manage extra work',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions

        // Super Admin - All permissions
        $superAdmin = Role::firstOrCreate(['name' => 'SuperAdmin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - Most permissions
        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $admin->givePermissionTo([
            'view users', 'edit users',
            'view products', 'edit products', 'approve products',
            'view services', 'edit services',
            'view jobs', 'edit jobs',
            'view orders', 'manage orders',
            'view transactions',
            'view tickets', 'manage tickets',
            'view disputes', 'manage disputes',
            'view reviews', 'manage reviews',
            'access admin panel',
            'view reports',
        ]);

        // Customer/Client - Basic user who posts jobs and buys
        $client = Role::firstOrCreate(['name' => 'client', 'guard_name' => 'web']);
        $client->givePermissionTo([
            'view products',
            'view services',
            'view jobs', 'create jobs', 'edit jobs', 'delete jobs',
            'view orders', 'create orders',
            'view transactions',
            'manage wallet',
            'add funds',
            'create tickets',
            'view tickets',
            'create disputes',
            'create reviews',
        ]);

        // Freelancer - Service provider who bids on jobs
        $freelancer = Role::firstOrCreate(['name' => 'freelancer', 'guard_name' => 'web']);
        $freelancer->givePermissionTo([
            'view jobs', 'bid on jobs',
            'view services', 'create services', 'edit services', 'delete services',
            'view orders',
            'view transactions',
            'manage wallet',
            'withdraw funds',
            'create tickets',
            'view tickets',
            'create reviews',
        ]);

        // Vendor - Product seller
        $vendor = Role::firstOrCreate(['name' => 'vendor', 'guard_name' => 'web']);
        $vendor->givePermissionTo([
            'view products', 'create products', 'edit products', 'delete products',
            'view orders',
            'view transactions',
            'manage wallet',
            'withdraw funds',
            'create tickets',
            'view tickets',
            'create reviews',
        ]);

        // Support Agent
        $support = Role::firstOrCreate(['name' => 'support', 'guard_name' => 'web']);
        $support->givePermissionTo([
            'view tickets', 'manage tickets',
            'view disputes',
            'view orders',
            'view users',
        ]);

        // Customer (default role for new users)
        $customer = Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);
        $customer->givePermissionTo([
            'view products',
            'view services',
            'view orders', 'create orders',
            'create tickets',
            'view tickets',
            'create reviews',
        ]);

        $this->command->info('Roles and Permissions created successfully!');
        $this->command->info('Roles created: SuperAdmin, Admin, client, freelancer, vendor, support, customer');
    }
}
