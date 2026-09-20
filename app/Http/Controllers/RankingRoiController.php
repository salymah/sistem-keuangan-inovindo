<?php

namespace App\Http\Controllers;

use App\Models\Proyek;

class RankingRoiController extends Controller
{
    public function index()
    {
        $ranking = Proyek::has('transaksis')
            ->get()
            ->map(fn ($proyek) => [
                'nama_proyek' => $proyek->nama_proyek,
                'roi' => $proyek->hitungRoi(),
            ])
            ->sortByDesc('roi')
            ->values();

        return view('ranking-roi.index', [
            'ranking' => $ranking,
        ]);
    }
}