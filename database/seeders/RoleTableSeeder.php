<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['client','driver','admin'];
        Role::create([
            'role_name'=>'admin', // 1
        ]);
        Role::create([
            'role_name'=>'client', // 2
        ]);
        Role::create([
            'role_name'=>'driver', // 3
        ]);
        Role::create([
            'role_name'=>'employee', // 4
        ]);
    }
}
