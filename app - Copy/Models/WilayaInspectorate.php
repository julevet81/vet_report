<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class WilayaInspectorate extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class, 'wilaya_inspectorate_id');
    }
}