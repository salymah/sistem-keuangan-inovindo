<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\PengaturanAlert;
use Illuminate\Http\Request;

class PengaturanAlertController extends Controller
{
    public function index(Request $request)
    {
        $alert = PengaturanAlert::where('user_id', $request->user()->id)->latest()->first();

        $notifikasis = Notifikasi::latest('terkirim_at')
            ->limit(10)
            ->get();

        return view('alert.index', [
            'alert' => $alert,
            'notifikasis' => $notifikasis,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ambang_batas' => 'required|numeric|min:0',
        ]);

        PengaturanAlert::updateOrCreate(
            ['user_id' => $request->user()->id],
            ['ambang_batas' => $data['ambang_batas']]
        );

        return back()->with('success', 'Ambang batas cash flow berhasil disimpan.');
    }
}