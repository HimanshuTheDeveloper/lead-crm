<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
      User::insert([
            ['name'=> "Admin" , 'email' => 'admin@gmail.com' , 'password' => bcrypt('password')], 
            ['name'=> "HR" , 'email' => 'hr@gmail.com' , 'password' => bcrypt('password')], 
            ['name'=> "BDM" , 'email' => 'bdm@gmail.com' , 'password' => bcrypt('password')], 
            ['name'=> "BDE" , 'email' => 'bde@gmail.com' , 'password' => bcrypt('password')] 
        ]);

       Role::insert([
            ['name'=> "Admin", 'slug'=> 'admin'],
            ['name'=> "HR", 'slug'=> 'hr'],
            ['name'=> "BDM", 'slug'=> 'bdm'],
            ['name'=> "BDE", 'slug'=> 'bde']
        ]);

        Permission::insert([
            ['name'=> "add client", 'slug'=> 'add-client'],
            ['name'=> "delete client", 'slug'=> 'delete-client'],
        ]);

    }
}
