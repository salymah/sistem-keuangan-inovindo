<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    protected $fillable = [
        'user_id',
        'pesan',
        'cash_flow_saat_itu',
        'terkirim_at',
    ];

        protected $casts = [
        'terkirim_at' => 'datetime',
    ];
    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}