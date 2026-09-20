<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanTransaksiExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(protected Collection $transaksis)
    {
    }

    public function collection(): Collection
    {
        return $this->transaksis;
    }

    public function headings(): array
    {
        return ['Tanggal', 'Kategori', 'Jenis', 'Proyek', 'Jumlah (Rp)', 'Tipe', 'Dicatat Oleh'];
    }

    public function map($transaksi): array
    {
        return [
            $transaksi->tanggal->format('d-m-Y'),
            $transaksi->kategori->nama_kategori,
            $transaksi->kategori->jenis,
            $transaksi->proyek->nama_proyek ?? '-',
            $transaksi->jumlah,
            $transaksi->tipe === 'recurring' ? 'Recurring' : 'One-time',
            $transaksi->user->name ?? '-',
        ];
    }
}