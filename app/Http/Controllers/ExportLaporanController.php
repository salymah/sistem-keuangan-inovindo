<?php

namespace App\Http\Controllers;

use App\Exports\LaporanTransaksiExport;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class ExportLaporanController extends Controller
{
    public function index(Request $request)
    {
        $transaksis = collect();
        $total = [
            'pemasukan' => 0,
            'pengeluaran' => 0,
            'selisih' => 0,
        ];

        $sudahPreview = false;

        if ($request->filled('dari_tanggal') || $request->filled('sampai_tanggal')) {
            $request->validate([
                'dari_tanggal' => 'required|date',
                'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
            ]);

            $transaksis = $this->ambilData($request);
            $total = $this->hitungTotal($transaksis);
            $sudahPreview = true;
        }

        return view('export.index', compact(
            'transaksis',
            'total',
            'sudahPreview'
        ));
    }

    protected function ambilData(Request $request)
    {
        return Transaksi::with(['kategori', 'proyek', 'user'])
            ->whereDate('tanggal', '>=', $request->dari_tanggal)
            ->whereDate('tanggal', '<=', $request->sampai_tanggal)
            ->orderBy('tanggal')
            ->get();
    }

    protected function hitungTotal($transaksis): array
    {
        $totalPemasukan = $transaksis
            ->filter(fn ($t) => $t->kategori?->jenis === 'pemasukan')
            ->sum('jumlah');

        $totalPengeluaran = $transaksis
            ->filter(fn ($t) => $t->kategori?->jenis === 'pengeluaran')
            ->sum('jumlah');

        return [
            'pemasukan' => $totalPemasukan,
            'pengeluaran' => $totalPengeluaran,
            'selisih' => $totalPemasukan - $totalPengeluaran,
        ];
    }

    public function exportPdf(Request $request)
    {
        $transaksis = $this->ambilDataTervalidasi($request);
        $total = $this->hitungTotal($transaksis);

        $pdf = Pdf::loadView('export.pdf', [
            'transaksis' => $transaksis,
            'dari' => $request->dari_tanggal,
            'sampai' => $request->sampai_tanggal,
            'total' => $total,
        ]);

        return $pdf->download(
            'laporan-keuangan-' . now()->format('Ymd-His') . '.pdf'
        );
    }

    public function exportExcel(Request $request)
    {
        $transaksis = $this->ambilDataTervalidasi($request);
        $total = $this->hitungTotal($transaksis);

        return Excel::download(
            new LaporanTransaksiExport($transaksis, $total),
            'laporan-keuangan-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    protected function ambilDataTervalidasi(Request $request)
    {
        $request->validate([
            'dari_tanggal' => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
        ]);

        return $this->ambilData($request);
    }
}