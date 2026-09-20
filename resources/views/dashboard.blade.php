@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@if ($peringatanAlert)
    <div class="alert alert-danger d-flex align-items-center mb-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <div>
            <strong>Peringatan Cash Flow:</strong> {{ $peringatanAlert }}
        </div>
    </div>
@endif
 <div class="row g-3 mb-2">
    @php
        $cards = [
            'Cash Flow' => ['value' => $indikator['cash_flow'], 'icon' => 'bi-wallet2'],
            'Omset' => ['value' => $indikator['omset'], 'icon' => 'bi-graph-up-arrow'],
            'Gross Profit' => ['value' => $indikator['gross_profit'], 'icon' => 'bi-piggy-bank'],
            'Net Profit' => ['value' => $indikator['net_profit'], 'icon' => 'bi-trophy'],
        ];
    @endphp
    @foreach ($cards as $label => $data)
        <div class="col-md-3">
            <div class="card-metric d-flex justify-content-between align-items-start">
                <div>
                    <div class="label">{{ $label }}</div>
                    <div class="value {{ $data['value'] > 0 ? 'positive' : ($data['value'] < 0 ? 'negative' : '') }}">Rp {{ number_format($data['value'], 0, ',', '.') }}</div>
                </div>
                <div class="metric-icon"><i class="bi {{ $data['icon'] }}"></i></div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card-metric d-flex justify-content-between align-items-start">
            <div>
                <div class="label">EBITDA</div>
                <div class="value {{ $indikator['ebitda'] > 0 ? 'positive' : ($indikator['ebitda'] < 0 ? 'negative' : '') }}">Rp {{ number_format($indikator['ebitda'], 0, ',', '.') }}</div>
            </div>
            <div class="metric-icon"><i class="bi bi-bar-chart-line"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-metric d-flex justify-content-between align-items-start">
            <div>
                <div class="label">MRR</div>
                <div class="value">Rp {{ number_format($indikator['mrr'], 0, ',', '.') }}</div>
            </div>
            <div class="metric-icon"><i class="bi bi-arrow-repeat"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-metric d-flex justify-content-between align-items-start">
            <div>
                <div class="label">ROI Avg</div>
                <div class="value {{ $indikator['roi_avg'] > 0 ? 'positive' : ($indikator['roi_avg'] < 0 ? 'negative' : '') }}">{{ $indikator['roi_avg'] }}%</div>
            </div>
            <div class="metric-icon"><i class="bi bi-percent"></i></div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Grafik Tren (Cash Flow 6 Bulan Terakhir)</h6>
        <canvas id="chartTren" height="90"></canvas>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Insight & Rekomendasi</h6>
        <ul class="mb-0">
            @foreach ($insight as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('chartTren');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($tren->pluck('label')),
            datasets: [{
                label: 'Cash Flow',
                data: @json($tren->pluck('value')),
                backgroundColor: '#adb5bd'
            }]
        },
        options: { plugins: { legend: { display: false } } }
    });
</script>
@endsection