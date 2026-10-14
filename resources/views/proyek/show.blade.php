@extends('layouts.app')

@section('title', 'Detail Proyek')

@section('content')
<div class="mb-3">
    <a href="{{ route('proyek.index') }}" class="text-decoration-none">
        <i class="bi bi-arrow-left"></i> Kembali ke Kelola Proyek
    </a>
</div>

<h5 class="fw-bold mb-4 d-flex align-items-center">
    <i class="bi bi-briefcase-fill text-primary me-2"></i>
    {{ $proyek->nama_proyek }}
</h5>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card-metric">
            <div class="label">Total Pemasukan</div>
            <div class="value positive">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-metric">
            <div class="label">Total Pengeluaran</div>
            <div class="value negative">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-metric">
            <div class="label">ROI Proyek</div>
            <div class="value {{ $roi > 0 ? 'positive' : ($roi < 0 ? 'negative' : '') }}">{{ $roi }}%</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Riwayat Transaksi Proyek Ini</h6>
        <table class="table table-bordered bg-white align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Tipe</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksis as $t)
                    <tr>
                        <td>{{ $t->tanggal->format('d-m-Y') }}</td>
                        <td>
                            <i class="bi {{ $t->kategori->jenis === 'pemasukan' ? 'bi-arrow-down-circle-fill text-success' : 'bi-arrow-up-circle-fill text-danger' }} me-1"></i>
                            {{ $t->kategori->nama_kategori }}
                        </td>
                        <td class="fw-semibold {{ $t->kategori->jenis === 'pemasukan' ? 'text-success' : 'text-danger' }}">
                            {{ $t->kategori->jenis === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="badge {{ $t->tipe === 'recurring' ? 'bg-info' : 'bg-secondary' }}">
                                {{ $t->tipe === 'recurring' ? 'Recurring' : 'One-time' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada transaksi untuk proyek ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection