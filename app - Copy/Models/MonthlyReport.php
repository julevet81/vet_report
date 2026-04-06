<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    protected $fillable = [
        'user_id',
        'branch_id',
        'report_year',
        'report_month',
        'status',
        'notifiable_diseases',
        'lab_requests',
        'rabies_vaccination',
        'sheep_pox_vaccination',
        'fmd_vaccination',
        'enterotoxemia_vaccination',
        'pet_vaccinations',
        'parasite_treatments',
        'artificial_inseminations',
        'poultry_followups',
        'beekeeping_followups',
        'other_infectious_diseases',
        'medicines_and_vaccines',
        'suggestions',
        'ai_summary',
    ];

    protected function casts(): array
    {
        return [
            'notifiable_diseases' => 'array',
            'lab_requests' => 'array',
            'rabies_vaccination' => 'array',
            'sheep_pox_vaccination' => 'array',
            'fmd_vaccination' => 'array',
            'enterotoxemia_vaccination' => 'array',
            'pet_vaccinations' => 'array',
            'parasite_treatments' => 'array',
            'artificial_inseminations' => 'array',
            'poultry_followups' => 'array',
            'beekeeping_followups' => 'array',
            'other_infectious_diseases' => 'array',
            'medicines_and_vaccines' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
