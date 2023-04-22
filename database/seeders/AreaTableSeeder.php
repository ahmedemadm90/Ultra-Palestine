<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create([
            'area_name'=>'الضفة الغربية',
        ]);
        Area::create([
            'area_name'=>'القدس',
        ]);
        Area::create([
            'area_name'=> 'الداخل',
        ]);
    }
}
