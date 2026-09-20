<?php

namespace App\Services;

use App\Models\Transaksi;
use Carbon\Carbon;

/**
 * Implementasi node "Hitung 7 Indikator" pada flowchart:
 * Cash Flow, Omset, Gross Profit, Net Profit, EBITDA, MRR, ROI Avg.
 */
class FinancialIndicatorService
{
    /**
     * @param  Carbon|null  $awal  Awal periode (default: awal bulan berjalan)
     * @param  Carbon|null  $akhir  Akhir periode (default: hari ini)
     */
    public function hitungSemua(?Carbon $awal = null, ?Carbon $akhir = null): array
    {
        $awal = $awal ?? now()->startOfMonth();
        $akhir = $akhir ?? now()->endOfDay();

        $query = fn () => Transaksi::with('kategori')
            ->whereBetween('tanggal', [$awal, $akhir]);

        $omset = (clone $query())->whereHas('kategori', fn ($q) => $q->where('kelompok', 'omset'))->sum('jumlah');
        $hpp = (clone $query())->whereHas('kategori', fn ($q) => $q->where('kelompok', 'hpp'))->sum('jumlah');
        $operasional = (clone $query())->whereHas('kategori', fn ($q) => $q->where('kelompok', 'operasional'))->sum('jumlah');
        $nonOperasional = (clone $query())->whereHas('kategori', fn ($q) => $q->where('kelompok', 'non_operasional'))->sum('jumlah');
        $depresiasi = (clone $query())->whereHas('kategori', fn ($q) => $q->where('kelompok', 'depresiasi'))->sum('jumlah');

        $totalPemasukan = (clone $query())->whereHas('kategori', fn ($q) => $q->where('jenis', 'pemasukan'))->sum('jumlah');
        $totalPengeluaran = (clone $query())->whereHas('kategori', fn ($q) => $q->where('jenis', 'pengeluaran'))->sum('jumlah');

        $grossProfit = $omset - $hpp;
        $netProfit = $grossProfit - $operasional - $nonOperasional - $depresiasi;
        $ebitda = $netProfit + $depresiasi;
        $cashFlow = $totalPemasukan - $totalPengeluaran;

        $mrr = (clone $query())
            ->where('tipe', 'recurring')
            ->whereHas('kategori', fn ($q) => $q->where('jenis', 'pemasukan'))
            ->sum('jumlah');

        $roiAvg = $this->hitungRoiAvg();

        return [
            'cash_flow' => (float) $cashFlow,
            'omset' => (float) $omset,
            'gross_profit' => (float) $grossProfit,
            'net_profit' => (float) $netProfit,
            'ebitda' => (float) $ebitda,
            'mrr' => (float) $mrr,
            'roi_avg' => $roiAvg,
        ];
    }

    protected function hitungRoiAvg(): float
    {
        $proyeks = \App\Models\Proyek::has('transaksis')->get();

        if ($proyeks->isEmpty()) {
            return 0.0;
        }

        return round($proyeks->avg(fn ($p) => $p->hitungRoi()), 2);
    }
}