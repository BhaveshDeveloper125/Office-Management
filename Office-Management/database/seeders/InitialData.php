<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
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

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'post' => 'Admin',
            'mobile' => '9773400215',
            'qualification' => 'Admin',
            'experience' => 0,
            'password' => bcrypt(123456789),
            'address' => 'Admin',
            'joining' => Carbon::now(),
            'working_from' => '00:00:00',
            'working_to' => '24:00:00',
            'hours' => 24,
            'working' => true,
        ]);
        $user->assignRole('Super Admin');

        $SuperAdmin->syncPermissions(Permission::all());
    }
}
