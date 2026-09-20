@extends('layouts.app')

@section('title', 'Ranking ROI Proyek')

@section('content')
<div class="card">
    <div class="card-body">
        @forelse ($ranking as $item)
            <div class="mb-3">
                <div class="small text-muted mb-1">{{ $item['nama_proyek'] }}</div>
                <div class="d-flex align-items-center">
                    <div class="progress flex-grow-1" style="height: 22px;">
                        <div class="progress-bar bg-secondary" style="width: {{ min(max($item['roi'], 0), 100) }}%;"></div>
                    </div>
                    <span class="ms-2 fw-bold {{ $item['roi'] > 0 ? 'text-success' : ($item['roi'] < 0 ? 'text-danger' : '') }}">{{ $item['roi'] }}%</span>
                </div>
            </div>
        @empty
            <p class="text-muted mb-0">Belum ada data proyek dengan transaksi.</p>
        @endforelse
    </div>
</div>
@endsection