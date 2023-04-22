<?php

namespace Database\Seeders;

use App\Models\Api\Office;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // **************
        $this->call([
            OfficeTableSeeder::class,
            RoleTableSeeder::class,
            AreaTableSeeder::class,
            VillageTableSeeder::class,
            UserTableSeeder::class,

        ]);
    }
}
