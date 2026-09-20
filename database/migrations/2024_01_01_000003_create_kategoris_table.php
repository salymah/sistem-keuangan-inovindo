<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori');

            // Sesuai wireframe "Kelola Kategori" kolom "Jenis": pemasukan / pengeluaran
            $table->enum('jenis', ['pemasukan', 'pengeluaran']);

            // Tambahan (di luar wireframe, tapi wajib untuk menghitung 7 indikator
            // di dashboard: Gross Profit, EBITDA, dsb).
            // - omset            -> pemasukan utama usaha
            // - hpp               -> harga pokok penjualan (pengeluaran)
            // - operasional       -> beban operasional (pengeluaran)
            // - non_operasional   -> beban non operasional (pengeluaran)
            // - depresiasi        -> depresiasi & amortisasi (pengeluaran, non-cash)
            $table->enum('kelompok', [
                'omset', 'hpp', 'operasional', 'non_operasional', 'depresiasi', 'lainnya',
            ])->default('lainnya');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};