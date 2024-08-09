<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'server_id',
        'name',
        'url',
        'site_path',
        'admin_email',
        'secret_key',
    ];

    /*=== Relationship Start ===*/
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    public function magicLoginTokens(): HasMany
    {
        return $this->hasMany(MagicLoginToken::class);
    }
    /*=== Relationship End ===*/
}
