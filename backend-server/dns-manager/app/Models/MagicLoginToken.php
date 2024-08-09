<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MagicLoginToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'token',
        'expires_at',
        'used_at',
    ];

    protected $casts = [
        'expires_at' => 'immutable_datetime',
        'used_at' => 'immutable_datetime',
    ];

    /*=== Local Scope Start ===*/
    public function scopeUnused(Builder $query): Builder
    {
        return $query->whereNull('used_at');
    }

    public function scopeIsNotExpired(Builder $query): Builder
    {
        return $query->where('expires_at', '>=', now());
    }
    /*=== Local Scope End ===*/

    /*=== Relationship Start ===*/
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
    /*=== Relationship End ===*/

    /*=== Action Start ===*/
    public function markAsUsed(): void
    {
        $this->update([
            'used_at' => now(),
        ]);
    }
    /*=== Action End ===*/

}
