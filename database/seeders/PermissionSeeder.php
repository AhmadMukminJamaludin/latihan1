<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $author = Role::create(['name' => 'author', 'guard_name' => 'web']);

        $permissions = [
            ['id' => 1, 'name' => 'manajemen-pengguna-list',],
            ['id' => 2, 'name' => 'manajemen-pengguna-create',],
            ['id' => 3, 'name' => 'manajemen-pengguna-edit',],
            ['id' => 4, 'name' => 'manajemen-pengguna-delete',],

            ['id' => 5, 'name' => 'post-list',],
            ['id' => 6, 'name' => 'post-create',],
            ['id' => 7, 'name' => 'post-edit',],
            ['id' => 8, 'name' => 'post-delete',],
        ];

        foreach ($permissions as $item) {
            Permission::create($item);
        }

        $author_permissions = [5, 6, 7, 8];

        $author->syncPermissions($author_permissions);
        $admin->syncPermissions(Permission::all());
    }
}
