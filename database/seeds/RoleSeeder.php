<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolegrand = Role::create(["name"->"GrandMaster"]);
        $rolepreven = Role::create(["name"->"Preventionist"]);
        $rolesuper = Role::create(["name"->"Supervisor"]);
        $roletask = Role::create(["name"->"Taskmaster"]);
        $roleware = Role::create(["name"->"Warehouse"]);
        $rolecolla = Role::create(["name"->"collaborator"]);
    }
}
