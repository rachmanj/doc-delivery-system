<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
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
            // User permissions
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            
            // Role permissions
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
            
            // Permission permissions
            'view-permissions',
            'create-permissions',
            'edit-permissions',
            'delete-permissions',
            
            // Department permissions
            'view-departments',
            'create-departments', 
            'edit-departments',
            'delete-departments',
            
            // Position permissions
            'view-positions',
            'create-positions',
            'edit-positions',
            'delete-positions',
            
            // Project permissions
            'view-projects',
            'create-projects',
            'edit-projects',
            'delete-projects',
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
        // Create roles and assign permissions
        
        // Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
        
        // Manager role
        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view-users',
            'view-roles',
            'view-permissions',
            'view-departments',
            'view-positions',
            'view-projects',
            'create-departments',
            'edit-departments',
            'create-positions',
            'edit-positions',
            'create-projects',
            'edit-projects',
        ]);
        
        // User role
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view-departments',
            'view-positions',
            'view-projects',
        ]);
        
        // Assign admin role to user ID 1 if exists
        $admin = User::find(1);
        if ($admin) {
            $admin->assignRole('admin');
        }
    }
} 