@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<div class="card" style="max-width: 1200px;">
    <div class="card-body">
        <h6 class="fw-bold mb-4 d-flex align-items-center">
            <span class="card-header-icon"><i class="bi bi-pencil-square"></i></span>
            Edit Transaksi
        </h6>

        <form method="POST" action="{{ route('transaksi.update', $transaksi) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-tags"></i>Kategori</label>
                    <select name="kategori_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id_kategori }}" @selected(old('kategori_id', $transaksi->kategori_id) == $kategori->id_kategori)>
                                {{ $kategori->nama_kategori }} ({{ $kategori->jenis }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-kanban"></i>Proyek Terkait</label>
                    <select name="proyek_id" class="form-select">
                        <option value="">-- Tidak terkait proyek --</option>
                        @foreach ($proyeks as $proyek)
                            <option value="{{ $proyek->id_proyek }}" @selected(old('proyek_id', $transaksi->proyek_id) == $proyek->id_proyek)>
                                {{ $proyek->nama_proyek }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-calendar-event"></i>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $transaksi->tanggal->format('Y-m-d')) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-cash-stack"></i>Jumlah (Rp)</label>
                    <input type="text" inputmode="numeric" id="jumlah_display" class="form-control" placeholder="0" autocomplete="off">
                    <input type="hidden" name="jumlah" id="jumlah_hidden" value="{{ old('jumlah', $transaksi->jumlah) }}">
                </div>

                <div class="col-12">
                    <label class="form-label d-block"><i class="bi bi-arrow-repeat"></i>Tipe</label>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="tipe" id="tipeOneTime" value="one_time" @checked(old('tipe', $transaksi->tipe) === 'one_time')>
                        <label class="btn btn-outline-secondary" for="tipeOneTime">One-time</label>

                        <input type="radio" class="btn-check" name="tipe" id="tipeRecurring" value="recurring" @checked(old('tipe', $transaksi->tipe) === 'recurring')>
                        <label class="btn btn-outline-secondary" for="tipeRecurring">Recurring</label>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label"><i class="bi bi-paperclip"></i>Bukti Transaksi</label>
                    @if ($transaksi->bukti_transaksi)
                        <div class="mb-2">
                            <a href="{{ Storage::url($transaksi->bukti_transaksi) }}" target="_blank">
                                <i class="bi bi-eye"></i> Lihat bukti saat ini
                            </a>
                        </div>
                    @endif
                    <input type="file" name="bukti_transaksi" class="form-control">
                    <div class="form-text">Kosongkan jika tidak ingin mengganti file.</div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-dark"><i class="bi bi-check-circle me-1"></i>SIMPAN PERUBAHAN</button>
                <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    const displayInput = document.getElementById('jumlah_display');
    const hiddenInput = document.getElementById('jumlah_hidden');

    function formatRibuan(angka) {
        return angka.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    displayInput.addEventListener('input', function () {
        const angkaMentah = this.value.replace(/\D/g, '');
        this.value = formatRibuan(this.value);
        hiddenInput.value = angkaMentah;
    });

    if (hiddenInput.value) {
        const angkaAwal = Math.round(parseFloat(hiddenInput.value)).toString();
        hiddenInput.value = angkaAwal;
        displayInput.value = formatRibuan(angkaAwal);
    }
</script>
@endsection