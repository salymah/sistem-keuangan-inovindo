@extends('layouts.app')

@section('title', 'Input Transaksi')

@section('content')
<div class="card" style="max-width: 1200px;">
    <div class="card-body">
        <h6 class="fw-bold mb-4 d-flex align-items-center">
            <span class="card-header-icon"><i class="bi bi-plus-circle"></i></span>
            Tambah Transaksi
        </h6>

        <form method="POST" action="{{ route('transaksi.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-arrow-down-circle text-success"></i>Kategori Pemasukan</label>
                    <select name="kategori_pemasukan_id" class="form-select">
                        <option value="">-- Tidak dipilih --</option>
                        @foreach ($kategoriPemasukan as $kategori)
                            <option value="{{ $kategori->id_kategori }}" @selected(old('kategori_pemasukan_id') == $kategori->id_kategori)>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-arrow-up-circle text-danger"></i>Kategori Pengeluaran</label>
                    <select name="kategori_pengeluaran_id" class="form-select">
                        <option value="">-- Tidak dipilih --</option>
                        @foreach ($kategoriPengeluaran as $kategori)
                            <option value="{{ $kategori->id_kategori }}" @selected(old('kategori_pengeluaran_id') == $kategori->id_kategori)>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-kanban"></i>Proyek Terkait</label>
                    <select name="proyek_id" class="form-select">
                        <option value="">-- Tidak terkait proyek --</option>
                        @foreach ($proyeks as $proyek)
                            <option value="{{ $proyek->id_proyek }}" @selected(old('proyek_id') == $proyek->id_proyek)>
                                {{ $proyek->nama_proyek }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-calendar-event"></i>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-cash-stack"></i>Jumlah (Rp)</label>
                    <input type="text" inputmode="numeric" id="jumlah_display" class="form-control" placeholder="0" autocomplete="off">
                    <input type="hidden" name="jumlah" id="jumlah_hidden" value="{{ old('jumlah') }}">
                </div>

                <div class="col-12">
                    <label class="form-label d-block"><i class="bi bi-arrow-repeat"></i>Tipe</label>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="tipe" id="tipeOneTime" value="one_time" checked>
                        <label class="btn btn-outline-secondary" for="tipeOneTime">One-time</label>

                        <input type="radio" class="btn-check" name="tipe" id="tipeRecurring" value="recurring">
                        <label class="btn btn-outline-secondary" for="tipeRecurring">Recurring</label>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label"><i class="bi bi-paperclip"></i>Bukti Transaksi</label>
                    <input type="file" name="bukti_transaksi" class="form-control">
                    <div class="form-text">Format: jpg, png, pdf. Maks 5MB.</div>
                </div>
            </div>

            <button type="submit" class="btn btn-dark mt-4"><i class="bi bi-check-circle me-1"></i>SIMPAN</button>
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
        displayInput.value = formatRibuan(hiddenInput.value);
    }
</script>
@endsection