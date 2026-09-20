<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengaturanAlert extends Model
{
    protected $primaryKey = 'id_alert';

    protected $fillable = [
        'user_id',
        'ambang_batas',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}