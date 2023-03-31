<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'create songs']);
        Permission::create(['name' => 'edit songs']);
        Permission::create(['name' => 'delete songs']);

        // Create roles
        Role::create(['name' => 'artist'])
            ->givePermissionTo('create songs', 'edit songs', 'delete songs');
    }
}
