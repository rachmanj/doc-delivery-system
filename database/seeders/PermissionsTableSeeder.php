<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resources = [
            'dashboard' => ['index'],
            'master' => ['index', 'create', 'edit', 'delete'],
            'settings' => ['index', 'create', 'edit', 'delete'],
            'users' => ['index', 'create', 'edit', 'delete'],
            'roles' => ['index', 'create', 'edit', 'delete'],
            'permissions' => ['index', 'create', 'edit', 'delete'],
        ];

        foreach ($resources as $resource => $actions) {
            foreach ($actions as $action) {
                $permissionName = "{$resource}.{$action}";

                Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
            }
        }
    }
}
