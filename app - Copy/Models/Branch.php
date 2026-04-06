<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'wilaya',
        'code',
        'wilaya_inspectorate_id',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(MonthlyReport::class);
    }

    public function inspectorate(): BelongsTo
    {
        return $this->belongsTo(WilayaInspectorate::class, 'wilaya_inspectorate_id');
    }
}