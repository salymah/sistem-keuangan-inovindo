@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<form method="GET" class="row g-2 mb-3">
    <div class="col-auto">
        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}" placeholder="Tanggal">
    </div>
    <div class="col-auto">
        <select name="kategori_id" class="form-select">
            <option value="">Semua Kategori</option>
            @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id_kategori }}" @selected(request('kategori_id') == $kategori->id_kategori)>
                    {{ $kategori->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-auto">
        <select name="proyek_id" class="form-select">
            <option value="">Semua Proyek</option>
            @foreach ($proyeks as $proyek)
                <option value="{{ $proyek->id_proyek }}" @selected(request('proyek_id') == $proyek->id_proyek)>
                    {{ $proyek->nama_proyek }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-secondary">Filter</button>
        <a href="{{ route('transaksi.index') }}" class="btn btn-link">Reset</a>
    </div>
</form>

<table class="table table-bordered bg-white align-middle">
    <thead class="table-light">
        <tr>
            <th>Tanggal</th>
            <th>Kategori</th>
            <th>Jumlah</th>
            <th>Proyek</th>
            <th>Tipe</th>
            <th>Aksi</th>
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
                <td>{{ $t->proyek->nama_proyek ?? '-' }}</td>
                <td>
                    <span class="badge {{ $t->tipe === 'recurring' ? 'bg-info' : 'bg-secondary' }}">
                        {{ $t->tipe === 'recurring' ? 'Recurring' : 'One-time' }}
                    </span>
                </td>
            
                <td>
                    {{-- Owner dan Finance boleh melihat bukti transaksi --}}
                    @if ($t->bukti_transaksi)
                        <a href="{{ Storage::url($t->bukti_transaksi) }}"
                        target="_blank"
                        class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-file-earmark-image"></i> Bukti
                        </a>
                    @endif

                    {{-- Hanya Finance yang boleh mengedit dan menghapus --}}
                    @if (auth()->user()->isFinance())
                        <a href="{{ route('transaksi.edit', $t) }}"
                        class="btn btn-sm btn-outline-primary">
                            Edit
                        </a>

                        <form method="POST"
                            action="{{ route('transaksi.destroy', $t) }}"
                            class="d-inline"
                            onsubmit="return confirm('Hapus transaksi ini?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                Hapus
                            </button>
                        </form>
                    @endif
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted">Belum ada transaksi.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $transaksis->links() }}
@endsection