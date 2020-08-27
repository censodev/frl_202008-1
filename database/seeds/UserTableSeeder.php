<?php

use Illuminate\Database\Seeder;
use App\Models\backend\User;
use App\Models\backend\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_employee 	= Role::where('name', 'employee')->first();
       	$role_manager  	= Role::where('name', 'admin')->first();
       	$role_saler 	= Role::where('name', 'saler')->first();

       	$employee = new User();
       	$employee->name = 'Employee Name';
       	$employee->fullname = 'Employee Name Dev Code';
       	$employee->email 	= 'employee@example.com';
       	$employee->password = bcrypt('123456');
       	$employee->status 	= 1;
       	$employee->save();
       	$employee->roles()->attach($role_employee);

       	$saler = new User();
       	$saler->name 	= 'Saler Name';
       	$saler->fullname 	= 'Saler Name Dev Code';
       	$saler->email 		= 'saler@example.com';
       	$saler->password 	= bcrypt('123456');
       	$employee->status 	= 1;
       	$saler->save();
       	$saler->roles()->attach($role_saler);

       	$manager = new User();
       	$manager->name 	= 'Admin Name';
       	$manager->fullname 	= 'Admin Name Dev Code';
       	$manager->email 	= 'admin@example.com';
       	$manager->password 	= bcrypt('123456');
       	$employee->status 	= 1;
       	$manager->save();
       	$manager->roles()->attach($role_manager);
    }
}
