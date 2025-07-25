<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = array("HR", "IT", "Sales");
        $permissions = array("Manager", "Creator", 'Accountant', 'Administrator');
        foreach($permissions as $permission) {
            $permission = Permission::create(['name' => $permission]);
        }
        foreach($roles as $role) {
             $role = Role::create(['name' => $role]);
        }
    }
}
