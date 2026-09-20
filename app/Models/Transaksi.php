<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'proyek_id',
        'tanggal',
        'jumlah',
        'tipe',            // one_time | recurring
        'bukti_transaksi', // path file
    ];

    protected $casts = [
    'tanggal' => 'date',
    'jumlah' => 'decimal:2',
    ];
    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id_kategori');
    }

    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class, 'proyek_id', 'id_proyek');
    }
}