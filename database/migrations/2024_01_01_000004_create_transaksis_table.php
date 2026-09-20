<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('id_transaksi');

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained('kategoris', 'id_kategori')->cascadeOnDelete();
            $table->foreignId('proyek_id')->nullable()->constrained('proyeks', 'id_proyek')->nullOnDelete();

            $table->date('tanggal');
            $table->decimal('jumlah', 15, 2);
            $table->enum('tipe', ['one_time', 'recurring'])->default('one_time');
            $table->string('bukti_transaksi')->nullable(); // path file upload

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};