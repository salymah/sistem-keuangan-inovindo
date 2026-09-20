<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyek extends Model
{
    protected $primaryKey = 'id_proyek';

    protected $fillable = [
        'nama_proyek',
    ];

    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'proyek_id', 'id_proyek');
    }

    /**
     * ROI = (Total Pemasukan - Total Pengeluaran) / Total Pengeluaran * 100%
     */
    public function hitungRoi(): float
    {
        $pemasukan = $this->transaksis()
            ->whereHas('kategori', fn ($q) => $q->where('jenis', 'pemasukan'))
            ->sum('jumlah');

        $pengeluaran = $this->transaksis()
            ->whereHas('kategori', fn ($q) => $q->where('jenis', 'pengeluaran'))
            ->sum('jumlah');

        if ($pengeluaran <= 0) {
            return 0.0;
        }

        return round((($pemasukan - $pengeluaran) / $pengeluaran) * 100, 2);
    }
}