
@extends('layouts.app')

@section('title', 'Export Laporan')

@section('content')
<div class="container-fluid">

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-download me-2"></i>
                Export Laporan Keuangan
            </h5>

            <p class="text-muted">
                Pilih periode laporan untuk melihat transaksi sebelum
                mengunduh file PDF atau Excel.
            </p>

            <form method="GET" action="{{ route('export.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Dari Tanggal</label>
                        <input
                            type="date"
                            name="dari_tanggal"
                            class="form-control"
                            value="{{ request('dari_tanggal') }}"
                            required
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Sampai Tanggal</label>
                        <input
                            type="date"
                            name="sampai_tanggal"
                            class="form-control"
                            value="{{ request('sampai_tanggal') }}"
                            min="{{ request('dari_tanggal') }}"
                            required
                        >
                    </div>

                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-eye me-1"></i>
                            Tampilkan Pratinjau
                        </button>
                    </div>
                </div>
            </form>

            @if ($errors->any())
                <div class="alert alert-danger mt-3 mb-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    @if ($sudahPreview)
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">Pratinjau Laporan</h5>
                        <div class="text-muted">
                            Periode:
                            {{ \Carbon\Carbon::parse(request('dari_tanggal'))->format('d/m/Y') }}
                            -
                            {{ \Carbon\Carbon::parse(request('sampai_tanggal'))->format('d/m/Y') }}
                        </div>
                        <div class="text-muted small mt-1">
                            Jumlah transaksi: {{ $transaksis->count() }}
                        </div>
                    </div>

                    @if ($transaksis->isNotEmpty())
                        <div class="d-flex gap-2 flex-wrap">
                            <form method="POST" action="{{ route('export.pdf') }}">
                                @csrf
                                <input type="hidden" name="dari_tanggal"
                                    value="{{ request('dari_tanggal') }}">
                                <input type="hidden" name="sampai_tanggal"
                                    value="{{ request('sampai_tanggal') }}">

                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="bi bi-file-earmark-pdf me-1"></i>
                                    Ekspor PDF
                                </button>
                            </form>

                            <form method="POST" action="{{ route('export.excel') }}">
                                @csrf
                                <input type="hidden" name="dari_tanggal"
                                    value="{{ request('dari_tanggal') }}">
                                <input type="hidden" name="sampai_tanggal"
                                    value="{{ request('sampai_tanggal') }}">

                                <button type="submit" class="btn btn-outline-success">
                                    <i class="bi bi-file-earmark-excel me-1"></i>
                                    Ekspor Excel
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-muted small">Total Pemasukan</div>
                            <h5 class="fw-bold text-success mb-0">
                                Rp {{ number_format($total['pemasukan'], 0, ',', '.') }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-muted small">Total Pengeluaran</div>
                            <h5 class="fw-bold text-danger mb-0">
                                Rp {{ number_format($total['pengeluaran'], 0, ',', '.') }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-muted small">Selisih Pemasukan - Pengeluaran</div>
                            <h5 class="fw-bold mb-0 {{ $total['selisih'] < 0 ? 'text-danger' : 'text-primary' }}">
                                Rp {{ number_format($total['selisih'], 0, ',', '.') }}
                            </h5>
                        </div>
                    </div>
                </div>

                @if ($transaksis->isEmpty())
                    <div class="alert alert-warning mb-0">
                        Tidak ada transaksi pada periode yang dipilih.
                        Silakan pilih periode lain.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Kategori</th>
                                    <th>Jenis</th>
                                    <th>Proyek</th>
                                    <th>Pengguna</th>
                                    <th class="text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksis as $transaksi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            {{ $transaksi->kategori?->nama_kategori ?? '-' }}
                                        </td>
                                        <td>
                                            @if ($transaksi->kategori?->jenis === 'pemasukan')
                                                <span class="badge bg-success">Pemasukan</span>
                                            @else
                                                <span class="badge bg-danger">Pengeluaran</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $transaksi->proyek?->nama_proyek ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $transaksi->user?->name ?? '-' }}
                                        </td>
                                        <td class="text-end text-nowrap">
                                            Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="6" class="text-end">Total Pemasukan</th>
                                    <th class="text-end text-success text-nowrap">
                                        Rp {{ number_format($total['pemasukan'], 0, ',', '.') }}
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="6" class="text-end">Total Pengeluaran</th>
                                    <th class="text-end text-danger text-nowrap">
                                        Rp {{ number_format($total['pengeluaran'], 0, ',', '.') }}
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="6" class="text-end">Selisih</th>
                                    <th class="text-end text-nowrap">
                                        Rp {{ number_format($total['selisih'], 0, ',', '.') }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endif

</div>
@endsection