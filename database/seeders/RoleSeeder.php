<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::factory()->create([
            "name" => "Admin",
        ]); //1
        $editor = Role::factory()->create(
            ["name" => "Editor"]
        ); //2

        $viewer = Role::factory()->create(
            ["name" => "Viewer"]
        ); //3

        $permissions = Permission::all();

        $admin->permissions()->attach($permissions->pluck('id'));

        $editor->permissions()->attach($permissions->pluck('id'));

        //detach mean from permission no4
        $editor->permissions()->detach(4);
        //attach mean from permission no1,3,5,7
        //attach only
        $viewer->permissions()->attach([1, 3, 5, 7]);

    }
}
