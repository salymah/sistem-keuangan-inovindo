<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Proyek;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Owner Inovindo',
            'email' => 'owner@inovindo.test',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);

        User::create([
            'name' => 'Staff Finance',
            'email' => 'finance@inovindo.test',
            'password' => Hash::make('password'),
            'role' => 'finance',
        ]);

        $kategoris = [
            ['nama_kategori' => 'Penjualan Jasa Digital', 'jenis' => 'pemasukan', 'kelompok' => 'omset'],
            ['nama_kategori' => 'Retainer Klien (Recurring)', 'jenis' => 'pemasukan', 'kelompok' => 'omset'],
            ['nama_kategori' => 'Biaya Produksi/Vendor', 'jenis' => 'pengeluaran', 'kelompok' => 'hpp'],
            ['nama_kategori' => 'Gaji Karyawan', 'jenis' => 'pengeluaran', 'kelompok' => 'operasional'],
            ['nama_kategori' => 'Sewa Kantor', 'jenis' => 'pengeluaran', 'kelompok' => 'operasional'],
            ['nama_kategori' => 'Bunga Pinjaman', 'jenis' => 'pengeluaran', 'kelompok' => 'non_operasional'],
            ['nama_kategori' => 'Penyusutan Peralatan', 'jenis' => 'pengeluaran', 'kelompok' => 'depresiasi'],
        ];

        foreach ($kategoris as $k) {
            Kategori::create($k);
        }

        $proyeks = ['Website Klien A', 'Campaign Sosmed Klien B', 'Aplikasi Internal', 'Branding Klien C'];
        foreach ($proyeks as $p) {
            Proyek::create(['nama_proyek' => $p]);
        }
    }
}