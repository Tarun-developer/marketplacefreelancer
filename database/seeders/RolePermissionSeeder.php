<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view dashboard',
            'manage users',
            'manage products',
            'manage services',
            'manage jobs',
            'manage orders',
            'manage payments',
            'manage disputes',
            'manage support',
            'view reports',
            // Additional permissions
            'view users', 'create users', 'edit users', 'delete users',
            'view products', 'create products', 'edit products', 'delete products', 'approve products',
            'view services', 'create services', 'edit services', 'delete services',
            'view jobs', 'create jobs', 'edit jobs', 'delete jobs', 'bid on jobs',
            'view orders', 'create orders', 'edit orders', 'delete orders',
            'view transactions', 'manage wallet', 'withdraw funds', 'add funds',
            'create tickets', 'view tickets', 'manage tickets',
            'create disputes', 'view disputes',
            'create reviews', 'view reviews', 'manage reviews',
            'access admin panel', 'manage settings',
            // SPM permissions
            'access spm', 'create projects', 'manage projects', 'create tasks', 'manage tasks',
            'log time', 'approve time', 'create milestones', 'manage extra work',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdmin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(\Spatie\Permission\Models\Permission::all());

        $admin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(['view dashboard', 'manage users', 'manage products', 'manage services', 'manage jobs', 'manage orders', 'manage payments', 'manage disputes', 'manage support', 'view reports']);

        $vendor = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'vendor']);
        $vendor->givePermissionTo(['view dashboard', 'manage products', 'manage orders', 'manage payments']);

        $freelancer = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'freelancer']);
        $freelancer->givePermissionTo(['view dashboard', 'manage services', 'manage jobs', 'manage orders']);

         $client = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'client']);
         $client->givePermissionTo(['view dashboard', 'manage jobs', 'manage orders']);

         $customer = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'customer']);
         $customer->givePermissionTo(['view dashboard']);

         $support = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'support']);
         $support->givePermissionTo(['view dashboard', 'manage support', 'manage disputes']);

         $userRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'user']);
         $userRole->givePermissionTo(['view dashboard']);
    }
}
