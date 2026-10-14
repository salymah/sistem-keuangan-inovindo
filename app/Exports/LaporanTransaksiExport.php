<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanTransaksiExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(protected Collection $transaksis, protected array $total = [])
    {
    }

    public function collection(): Collection
    {
        $baris = $this->transaksis;

        if (! empty($this->total)) {
            $baris = $baris->concat([
                (object) ['pemisah' => true],
                (object) ['pemisah' => true, 'label' => 'Total Pemasukan', 'nilai' => $this->total['pemasukan']],
                (object) ['pemisah' => true, 'label' => 'Total Pengeluaran', 'nilai' => $this->total['pengeluaran']],
                (object) ['pemisah' => true, 'label' => 'Selisih (Laba/Rugi)', 'nilai' => $this->total['selisih']],
            ]);
        }

        return $baris;
    }

    public function headings(): array
    {
        return ['Tanggal', 'Kategori', 'Jenis', 'Proyek', 'Jumlah (Rp)', 'Tipe', 'Dicatat Oleh'];
    }

    public function map($row): array
    {
        if (isset($row->pemisah)) {
            if (isset($row->label)) {
                return ['', '', '', '', $row->label.': Rp '.number_format($row->nilai, 0, ',', '.'), '', ''];
            }

            return ['', '', '', '', '', '', ''];
        }

        return [
            $row->tanggal->format('d-m-Y'),
            $row->kategori->nama_kategori,
            $row->kategori->jenis,
            $row->proyek->nama_proyek ?? '-',
            $row->jumlah,
            $row->tipe === 'recurring' ? 'Recurring' : 'One-time',
            $row->user->name ?? '-',
        ];
    }
}