<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Proyek;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['kategori', 'proyek', 'user']);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('proyek_id')) {
            $query->where('proyek_id', $request->proyek_id);
        }

        $transaksis = $query->latest('tanggal')->paginate(10)->withQueryString();

        return view('transaksi.index', [
            'transaksis' => $transaksis,
            'kategoris' => Kategori::orderBy('nama_kategori')->get(),
            'proyeks' => Proyek::orderBy('nama_proyek')->get(),
        ]);
    }

            public function createPemasukan()
    {
        return view('transaksi.create-pemasukan', [
            'kategoris' => Kategori::where('jenis', 'pemasukan')->orderBy('nama_kategori')->get(),
            'proyeks' => Proyek::orderBy('nama_proyek')->get(),
        ]);
    }

    public function createPengeluaran()
    {
        return view('transaksi.create-pengeluaran', [
            'kategoris' => Kategori::where('jenis', 'pengeluaran')->orderBy('nama_kategori')->get(),
            'proyeks' => Proyek::orderBy('nama_proyek')->get(),
        ]);
    }

           public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id_kategori',
            'proyek_id' => 'nullable|exists:proyeks,id_proyek',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'tipe' => 'required|in:one_time,recurring',
            'bukti_transaksi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('bukti_transaksi')) {
            $data['bukti_transaksi'] = $request->file('bukti_transaksi')->store('bukti-transaksi', 'public');
        }

        Transaksi::create($data);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil disimpan.');
    }

        public function edit(Transaksi $transaksi)
    {
        return view('transaksi.edit', [
            'transaksi' => $transaksi,
            'kategoris' => Kategori::orderBy('nama_kategori')->get(),
            'proyeks' => Proyek::orderBy('nama_proyek')->get(),
        ]);
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id_kategori',
            'proyek_id' => 'nullable|exists:proyeks,id_proyek',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'tipe' => 'required|in:one_time,recurring',
            'bukti_transaksi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($request->hasFile('bukti_transaksi')) {
            $data['bukti_transaksi'] = $request->file('bukti_transaksi')->store('bukti-transaksi', 'public');
        }

        $transaksi->update($data);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return back()->with('success', 'Transaksi berhasil dihapus.');
    }
}