<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return view('kategori.index', [
            'kategoris' => Kategori::orderBy('nama_kategori')->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'kelompok' => 'required|in:omset,hpp,operasional,non_operasional,depresiasi,lainnya',
        ]);

        Kategori::create($data);

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'kelompok' => 'required|in:omset,hpp,operasional,non_operasional,pajak,depresiasi,lainnya',
        ]);

        $kategori->update($data);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}