<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'branch_id',
    'veterinary_authority_number',
    'wilaya',
    'role',
    'approval_status',
    'approved_by_id',
    'approved_at',
    'preferred_locale',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'approved_at' => 'datetime',
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(MonthlyReport::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function approvedUsers(): HasMany
    {
        return $this->hasMany(User::class, 'approved_by_id');
    }

    public function isRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function isApproved(): bool
    {
        return $this->role === 'admin' || $this->approval_status === 'approved';
    }

    public function canApprove(User $target): bool
    {
        if (! $target->isRole('admin') && $this->isRole('admin') && $target->isRole('wilaya_inspector')) {
            return true;
        }

        if ($this->isRole('wilaya_inspector') && $target->isRole('branch_manager')) {
            return $this->wilaya === $target->wilaya;
        }

        if ($this->isRole('branch_manager') && $target->isRole('private_vet')) {
            return (int) $this->branch_id === (int) $target->branch_id;
        }

        return false;
    }
}