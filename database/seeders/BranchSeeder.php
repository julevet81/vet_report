<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\WilayaInspectorate;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inspectorates = WilayaInspectorate::query()->pluck('id', 'name');

        $branches = [
            ['name' => 'Es Senia', 'wilaya' => 'Oran', 'code' => 'ORN-SENIA'],
            ['name' => 'Bir El Djir', 'wilaya' => 'Oran', 'code' => 'ORN-BIRDJIR'],
            ['name' => 'Ben Aknoun', 'wilaya' => 'Alger', 'code' => 'ALG-BENAKNOUN'],
            ['name' => 'Kouba', 'wilaya' => 'Alger', 'code' => 'ALG-KOUBA'],
            ['name' => 'Constantine Center', 'wilaya' => 'Constantine', 'code' => 'CST-CENTER'],
            ['name' => 'Annaba Center', 'wilaya' => 'Annaba', 'code' => 'ANB-CENTER'],
        ];

        foreach ($branches as $branch) {
            Branch::query()->updateOrCreate(
                ['code' => $branch['code']],
                [
                    'name' => $branch['name'],
                    'wilaya' => $branch['wilaya'],
                    'wilaya_inspectorate_id' => $inspectorates[$branch['wilaya']] ?? null,
                ]
            );
        }
    }
}