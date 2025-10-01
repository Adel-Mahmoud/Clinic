<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Dashboard
            'view dashboard',
        
            // Users
            'view users',
            'create user',
            'edit user',
            'delete user',
        
            // Roles & Permissions
            'view roles',
            'create role',
            'edit role',
            'delete role',
        
            'view permissions',
            'create permission',
            'edit permission',
            'delete permission',
        
            // Settings
            'view settings',
            'edit settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
