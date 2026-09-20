<?php

namespace App\Http\Controllers;

use App\Exports\LaporanTransaksiExport;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportLaporanController extends Controller
{
    public function index()
    {
        return view('export.index');
    }

    protected function ambilData(Request $request)
    {
        $request->validate([
            'dari_tanggal' => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
        ]);

        return Transaksi::with(['kategori', 'proyek', 'user'])
            ->whereBetween('tanggal', [$request->dari_tanggal, $request->sampai_tanggal])
            ->orderBy('tanggal')
            ->get();
    }

    public function exportPdf(Request $request)
    {
        $transaksis = $this->ambilData($request);

        $pdf = Pdf::loadView('export.pdf', [
            'transaksis' => $transaksis,
            'dari' => $request->dari_tanggal,
            'sampai' => $request->sampai_tanggal,
        ]);

        return $pdf->download('laporan-keuangan-'.now()->format('Ymd-His').'.pdf');
    }

    public function exportExcel(Request $request)
    {
        $transaksis = $this->ambilData($request);

        return Excel::download(
            new LaporanTransaksiExport($transaksis),
            'laporan-keuangan-'.now()->format('Ymd-His').'.xlsx'
        );
    }
}