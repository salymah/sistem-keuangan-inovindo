<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\PengaturanAlert;
use App\Models\Proyek;
use App\Models\Transaksi;
use App\Services\FinancialIndicatorService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected FinancialIndicatorService $indicatorService)
    {
    }

    public function index(Request $request)
    {
        // 1. Hitung 7 Indikator
        $indikator = $this->indicatorService->hitungSemua();

        // 2. Cash flow di bawah ambang batas? -> Ya: kirim notifikasi / Tidak: tampilkan dashboard
        $peringatanAlert = $this->cekAmbangBatas($request->user(), $indikator['cash_flow']);

        // Data grafik tren (6 bulan terakhir, berdasarkan cash flow bulanan)
        $tren = collect(range(5, 0))->map(function ($i) {
            $bulan = now()->subMonths($i);
            $awal = $bulan->copy()->startOfMonth();
            $akhir = $bulan->copy()->endOfMonth();

            $pemasukan = Transaksi::whereBetween('tanggal', [$awal, $akhir])
                ->whereHas('kategori', fn ($q) => $q->where('jenis', 'pemasukan'))->sum('jumlah');
            $pengeluaran = Transaksi::whereBetween('tanggal', [$awal, $akhir])
                ->whereHas('kategori', fn ($q) => $q->where('jenis', 'pengeluaran'))->sum('jumlah');

            return [
                'label' => $bulan->translatedFormat('M Y'),
                'value' => (float) ($pemasukan - $pengeluaran),
            ];
        });

        // Insight & Rekomendasi sederhana
        $insight = $this->buatInsight($indikator);

        return view('dashboard', [
            'indikator' => $indikator,
            'tren' => $tren,
            'insight' => $insight,
            'peringatanAlert' => $peringatanAlert,
        ]);
    }

    protected function cekAmbangBatas($user, float $cashFlow): ?string
    {
        // Ambang batas milik perusahaan (bukan per-user), supaya Owner juga bisa lihat peringatan
        $alert = PengaturanAlert::latest()->first();

        if (! $alert) {
            return null;
        }

        if ($cashFlow < (float) $alert->ambang_batas) {
            $pesan = 'Cash flow (Rp '.number_format($cashFlow, 0, ',', '.').') berada di bawah ambang batas (Rp '.number_format($alert->ambang_batas, 0, ',', '.').').';

            // Hindari kirim notifikasi berulang dalam hari yang sama
            $sudahAda = Notifikasi::whereDate('terkirim_at', now()->toDateString())->exists();

            if (! $sudahAda) {
                Notifikasi::create([
                    'user_id' => $user->id,
                    'pesan' => $pesan,
                    'cash_flow_saat_itu' => $cashFlow,
                    'terkirim_at' => now(),
                ]);
            }

            return $pesan;
        }

        return null;
    }

    protected function buatInsight(array $indikator): array
    {
        $insight = [];

        if ($indikator['gross_profit'] < 0) {
            $insight[] = 'Gross profit bulan ini negatif. Periksa kembali harga jual atau efisiensi biaya produksi (HPP).';
        }

        if ($indikator['net_profit'] < 0) {
            $insight[] = 'Net profit bulan ini negatif. Pertimbangkan efisiensi beban operasional.';
        }

        if (empty($insight)) {
            $insight[] = 'Kondisi keuangan bulan ini sehat. Pertahankan tren pertumbuhan omset dan kendalikan beban operasional.';
            $insight[] = 'ROI rata-rata proyek: '.$indikator['roi_avg'].'%. Fokuskan sumber daya pada proyek dengan ROI tertinggi.';
        }

        return $insight;
    }
}