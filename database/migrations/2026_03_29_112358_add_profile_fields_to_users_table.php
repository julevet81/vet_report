<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->string('veterinary_authority_number')->unique();
            $table->string('wilaya');
            $table->enum('role', ['admin', 'wilaya_inspector', 'branch_manager', 'private_vet'])->default('private_vet');
            $table->string('preferred_locale', 2)->default('ar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('branch_id');
            $table->dropColumn([
                'veterinary_authority_number',
                'wilaya',
                'role',
                'preferred_locale',
            ]);
        });
    }
};
