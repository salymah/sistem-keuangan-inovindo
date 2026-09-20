@extends('layouts.app')

@section('title', 'Pengaturan Alert')

@section('content')
<div class="card mb-4" style="max-width: 520px;">
    <div class="card-body">
        <h6 class="fw-bold mb-3 d-flex align-items-center">
            <span class="card-header-icon"><i class="bi bi-bell"></i></span>
            Pengaturan Ambang Batas Cash Flow
        </h6>
        <form method="POST" action="{{ route('alert.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-cash-stack"></i>Ambang Batas (Rp)</label>
                <input type="text" inputmode="numeric" id="ambang_display" class="form-control" placeholder="0" autocomplete="off">
                <input type="hidden" name="ambang_batas" id="ambang_hidden" value="{{ old('ambang_batas', $alert->ambang_batas ?? '') }}">
                <div class="form-text"><i class="bi bi-info-circle"></i> Kalau Cash Flow di bawah angka ini, sistem akan otomatis membuat notifikasi.</div>
            </div>
            <button class="btn btn-dark"><i class="bi bi-check-circle me-1"></i>SIMPAN</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h6 class="fw-bold mb-3 d-flex align-items-center">
            <span class="card-header-icon"><i class="bi bi-clock-history"></i></span>
            Riwayat Notifikasi Terkirim
        </h6>
        @forelse ($notifikasis as $n)
            <div class="border rounded p-3 mb-2 d-flex align-items-start">
                <i class="bi bi-exclamation-triangle-fill text-danger me-2 mt-1"></i>
                <div>
                    <div class="small">{{ $n->pesan }}</div>
                    <div class="text-muted" style="font-size: .75rem;">
                        <i class="bi bi-calendar3"></i> {{ $n->terkirim_at->format('d-m-Y H:i') }}
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted mb-0"><i class="bi bi-check-circle text-success"></i> Belum ada notifikasi terkirim.</p>
        @endforelse
    </div>
</div>

<script>
    const ambangDisplay = document.getElementById('ambang_display');
    const ambangHidden = document.getElementById('ambang_hidden');

    function formatRibuan(angka) {
        return angka.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    ambangDisplay.addEventListener('input', function () {
        const angkaMentah = this.value.replace(/\D/g, '');
        this.value = formatRibuan(this.value);
        ambangHidden.value = angkaMentah;
    });

    if (ambangHidden.value) {
        const angkaAwal = Math.round(parseFloat(ambangHidden.value)).toString();
        ambangHidden.value = angkaAwal;
        ambangDisplay.value = formatRibuan(angkaAwal);
    }
</script>
@endsection