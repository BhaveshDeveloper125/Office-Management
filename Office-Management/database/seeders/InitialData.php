<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InitialData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $SuperAdmin = Role::create(['name' => 'Super Admin']);
        $SubAdmin = Role::create(['name' => 'Sub Admin']);
        $Employee = Role::create(['name' => 'Employee']);

        $SuperAdmin->syncPermissions(Permission::all());
    }
}
