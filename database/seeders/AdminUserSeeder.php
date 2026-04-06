<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstBranch = Branch::query()->first();

        User::query()->updateOrCreate(
            ['email' => 'admin@vet-reports.local'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('Admin@12345'),
                'veterinary_authority_number' => 'ADMIN-00001',
                'wilaya' => $firstBranch?->wilaya ?? 'Alger',
                'branch_id' => $firstBranch?->id,
                'role' => 'admin',
                'approval_status' => 'approved',
                'approved_at' => now(),
                'preferred_locale' => 'ar',
            ]
        );
    }
}