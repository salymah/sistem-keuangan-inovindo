<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
        'jenis',      // pemasukan | pengeluaran
        'kelompok',   // omset | hpp | operasional | non_operasional | depresiasi | lainnya
    ];

    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'kategori_id', 'id_kategori');
    }
}