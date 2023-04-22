<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'fname' => 'ultra',
            'lname' => 'admin',
            'email' => 'admin@ultra.com',
            'password' => Hash::make('123456'),
            'phone' => '+201019030515',
            'area_id' => 1,
            'village_id' => 1,
            'street' => 'street',
            'budget' => 0,
            'role_id' => 1,
            'office_id' => 1,
            'active' => 1,
        ]);
        User::create([
            'fname' => 'ultra',
            'lname' => 'client',
            'email' => 'client@ultra.com',
            'password' => Hash::make('123456'),
            'phone' => '+201019030515',
            'area_id' => 1,
            'village_id' => 1,
            'street' => 'street',
            'budget' => 0,
            'role_id' => 2,
            'office_id' => 1,
            'active' => 1,
        ]);
        User::create([
            'fname' => 'ultra',
            'lname' => 'driver',
            'email' => 'driver@ultra.com',
            'password' => Hash::make('123456'),
            'phone' => '+201019030515',
            'area_id' => 1,
            'village_id' => 1,
            'street' => 'street',
            'budget' => 0,
            'role_id' => 3,
            'office_id' => 1,
            'active' => 1,
        ]);
        User::create([
            'fname' => 'ultra',
            'lname' => 'employee',
            'email' => 'employee@ultra.com',
            'password' => Hash::make('123456'),
            'phone' => '+201019030515',
            'area_id' => 1,
            'village_id' => 1,
            'street' => 'street',
            'budget' => 0,
            'role_id' => 4,
            'office_id' => 1,
            'active' => 1,
        ]);
    }
}
