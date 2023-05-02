<?php

use App\Users\Roles\Role;
use App\Users\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRoles();
        $this->createAdmin();
    }

    public function createRoles()
    {
        $role_employee = new Role();
        $role_employee->name = 'Admin';
        $role_employee->description = 'Can use dashboard, can create all type of users, all functionality available';
        $role_employee->save();

        $role_manager = new Role();
        $role_manager->name = 'Seller';
        $role_manager->description = 'Can create Client, partially functional';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = 'Client';
        $role_manager->description = 'Can\'t use dashboard, may have a unique styling';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = 'Customer';
        $role_manager->description = 'Patient, creating with Case. Do nothing';
        $role_manager->save();
    }

    public function createAdmin()
    {
        $role_admin = Role::where('name', 'Admin')->first();

        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'role_id' => $role_admin->id
        ]);
    }
}
