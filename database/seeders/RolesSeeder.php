<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::create(['name' => 'admin']);
        $role_manager = Role::create(['name' => 'manager']);

        $admin_read = Permission::create(['name' => 'read admin']);
        $admin_edit = Permission::create(['name' => 'edit admin']);
        $admin_write = Permission::create(['name' => 'write admin']);
        $admin_delete = Permission::create(['name' => 'delete admin']);

        $manager_read = Permission::create(['name' => 'read manager']);
        $manager_edit = Permission::create(['name' => 'edit manager']);
        $manager_write = Permission::create(['name' => 'write manager']);
        $manager_delete = Permission::create(['name' => 'delete manager']);

        $permissions_manager = [$manager_read, $manager_edit, $manager_write, $manager_delete];
        $permissions_admin = [...$permissions_manager, $admin_read, $admin_edit, $admin_write, $admin_delete];

        $role_admin->syncPermissions($permissions_admin);
        $role_manager->syncPermissions($permissions_manager);
        // $role_manager->givePermissionTo($permission_read);
    }
}
