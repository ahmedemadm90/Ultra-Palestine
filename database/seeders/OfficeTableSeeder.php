<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;

class OfficeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offices = [
            'مكتب نابلس',
            'مكتب القدس',
            'مكتب القاهرة',
        ];
        foreach ($offices as $office) {
            Office::create([
                'office_name' => $office
            ]);
        }
    }
}
