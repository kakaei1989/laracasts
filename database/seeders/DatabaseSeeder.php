<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        // \App\Models\User::factory(10)->create();
        $roleInDatabase = Role::where('name', Config('permission.default_roles')[0]);
        if ($roleInDatabase->count() < 1) {
            foreach (Config('permission.default_roles') as $role) {
                Role::create([
                    'name' => $role
                ]);
            }
        }

        $permissionInDatabase = Permission::where('name', Config('permission.default_permissions')[0]);
        if ($permissionInDatabase->count() < 1) {
            foreach (Config('permission.default_permissions') as $permission) {
                Permission::create([
                    'name' => $permission
                ]);
            }
        }
        Schema::enableForeignKeyConstraints();
    }
}
