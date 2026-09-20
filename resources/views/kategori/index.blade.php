@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="fw-bold mb-0 d-flex align-items-center">
        <span class="card-header-icon"><i class="bi bi-tags"></i></span>
        Daftar Kategori
    </h6>
    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
        <i class="bi bi-plus-circle me-1"></i>Tambah Kategori
    </button>
</div>

<table class="table table-bordered bg-white align-middle">
    <thead class="table-light">
        <tr>
            <th>Nama Kategori</th>
            <th>Jenis</th>
            <th>Kelompok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php
            $warnaKelompok = [
                'omset' => 'bg-success-subtle text-success',
                'hpp' => 'bg-warning-subtle text-warning-emphasis',
                'operasional' => 'bg-secondary-subtle text-secondary',
                'non_operasional' => 'bg-danger-subtle text-danger',
                'depresiasi' => 'bg-info-subtle text-info-emphasis',
                'lainnya' => 'bg-light text-muted',
            ];
        @endphp
        @forelse ($kategoris as $kategori)
            <tr>
                <td>
                    <i class="bi {{ $kategori->jenis === 'pemasukan' ? 'bi-arrow-down-circle-fill text-success' : 'bi-arrow-up-circle-fill text-danger' }} me-1"></i>
                    {{ $kategori->nama_kategori }}
                </td>
                <td>
                    <span class="badge {{ $kategori->jenis === 'pemasukan' ? 'bg-success' : 'bg-danger' }}">
                        {{ ucfirst($kategori->jenis) }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $warnaKelompok[$kategori->kelompok] ?? 'bg-light text-muted' }}">
                        {{ ucfirst(str_replace('_', ' ', $kategori->kelompok)) }}
                    </span>
                </td>
                <td>
                    <form method="POST" action="{{ route('kategori.destroy', $kategori) }}" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted py-4">Belum ada kategori.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $kategoris->links() }}

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="modalTambahKategori" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('kategori.store') }}">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title fw-bold d-flex align-items-center">
                        <span class="card-header-icon"><i class="bi bi-plus-circle"></i></span>
                        Tambah Kategori
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-tag"></i>Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Sewa Kantor" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-arrow-left-right"></i>Jenis</label>
                        <select name="jenis" class="form-select" required>
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-diagram-3"></i>Kelompok (untuk perhitungan dashboard)</label>
                        <select name="kelompok" class="form-select" required>
                            <option value="omset">Omset</option>
                            <option value="hpp">HPP</option>
                            <option value="operasional">Beban Operasional</option>
                            <option value="non_operasional">Beban Non Operasional</option>
                            <option value="depresiasi">Depresiasi & Amortisasi</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark"><i class="bi bi-check-circle me-1"></i>SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection