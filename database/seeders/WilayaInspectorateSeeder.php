<?php

namespace Database\Seeders;

use App\Models\WilayaInspectorate;
use Illuminate\Database\Seeder;

class WilayaInspectorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            ['name' => 'Oran', 'code' => 'WIL-ORAN', 'description' => 'Wilaya inspectorate of Oran'],
            ['name' => 'Alger', 'code' => 'WIL-ALG', 'description' => 'Wilaya inspectorate of Algiers'],
            ['name' => 'Constantine', 'code' => 'WIL-CST', 'description' => 'Wilaya inspectorate of Constantine'],
            ['name' => 'Annaba', 'code' => 'WIL-ANB', 'description' => 'Wilaya inspectorate of Annaba'],
        ];

        foreach ($rows as $row) {
            WilayaInspectorate::query()->updateOrCreate(['code' => $row['code']], $row);
        }
    }
}