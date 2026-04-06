<?php

use App\Models\WilayaInspectorate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('branches', function (Blueprint $table): void {
            $table->foreignId('wilaya_inspectorate_id')
                ->nullable()
                ->after('id')
                ->constrained('wilaya_inspectorates')
                ->nullOnDelete();
        });

        $wilayas = DB::table('branches')
            ->select('wilaya')
            ->whereNotNull('wilaya')
            ->distinct()
            ->pluck('wilaya');

        foreach ($wilayas as $wilaya) {
            $inspectorate = WilayaInspectorate::query()->firstOrCreate(
                ['name' => $wilaya],
                ['code' => 'WIL-'.strtoupper(substr(md5((string) $wilaya), 0, 6))]
            );

            DB::table('branches')
                ->where('wilaya', $wilaya)
                ->update(['wilaya_inspectorate_id' => $inspectorate->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('wilaya_inspectorate_id');
        });
    }
};