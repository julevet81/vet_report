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
        Schema::create('monthly_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedSmallInteger('report_year');
            $table->unsignedTinyInteger('report_month');
            $table->enum('status', ['draft', 'submitted', 'reviewed'])->default('submitted');

            $table->json('notifiable_diseases')->nullable();
            $table->json('lab_requests')->nullable();
            $table->json('rabies_vaccination')->nullable();
            $table->json('sheep_pox_vaccination')->nullable();
            $table->json('fmd_vaccination')->nullable();
            $table->json('enterotoxemia_vaccination')->nullable();
            $table->json('pet_vaccinations')->nullable();
            $table->json('parasite_treatments')->nullable();
            $table->json('artificial_inseminations')->nullable();
            $table->json('poultry_followups')->nullable();
            $table->json('beekeeping_followups')->nullable();
            $table->json('other_infectious_diseases')->nullable();
            $table->json('medicines_and_vaccines')->nullable();
            $table->text('suggestions')->nullable();
            $table->longText('ai_summary')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'report_year', 'report_month'], 'unique_report_per_vet_per_month');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_reports');
    }
};
