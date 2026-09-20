<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    public function index()
    {
        return view('proyek.index', [
            'proyeks' => Proyek::orderBy('nama_proyek')->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_proyek' => 'required|string|max:255',
        ]);

        Proyek::create($data);

        return back()->with('success', 'Proyek berhasil ditambahkan.');
    }

    public function destroy(Proyek $proyek)
    {
        $proyek->delete();

        return back()->with('success', 'Proyek berhasil dihapus.');
    }
}