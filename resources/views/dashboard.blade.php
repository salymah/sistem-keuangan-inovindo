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
                <div class="label">ROI Avg (Rasio Keuntungan)</div>
                <div class="value {{ $indikator['roi_avg'] > 0 ? 'positive' : ($indikator['roi_avg'] < 0 ? 'negative' : '') }}">{{ $indikator['roi_avg'] }}%</div>
            </div>
            <div class="metric-icon"><i class="bi bi-percent"></i></div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0">Grafik Tren (Cash Flow)</h6>
            <select id="filterPeriode" class="form-select form-select-sm" style="width: auto;">
                <option value="3" {{ $jumlahBulan == 3 ? 'selected' : '' }}>3 Bulan Terakhir</option>
                <option value="6" {{ $jumlahBulan == 6 ? 'selected' : '' }}>6 Bulan Terakhir</option>
                <option value="12" {{ $jumlahBulan == 12 ? 'selected' : '' }}>12 Bulan Terakhir</option>
            </select>
        </div>
        <div style="height: 360px;">
    <canvas id="chartTren"></canvas>
</div>
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
    document.getElementById('filterPeriode').addEventListener('change', function () {
        window.location.href = '{{ route('dashboard') }}?periode=' + this.value;
    });


const ctx = document.getElementById('chartTren');

const labels = @json($tren->pluck('label'));
const values = @json($tren->pluck('value'));

// Format angka ke Rupiah
function formatRupiah(value) {
    return 'Rp ' + Number(value).toLocaleString('id-ID');
}

// Warna batang berdasarkan Cash Flow
function getBarColor(value) {
    if (value > 0) {
        return 'rgba(25, 135, 84, 0.75)';
    }

    if (value < 0) {
        return 'rgba(220, 53, 69, 0.75)';
    }

    return 'rgba(108, 117, 125, 0.45)';
}

function getBorderColor(value) {
    if (value > 0) {
        return '#198754';
    }

    if (value < 0) {
        return '#dc3545';
    }

    return '#6c757d';
}

new Chart(ctx, {
    type: 'bar',

    data: {
        labels: labels,
        datasets: [{
            label: 'Cash Flow',
            data: values,

            backgroundColor: function(context) {
                return getBarColor(context.raw);
            },

            borderColor: function(context) {
                return getBorderColor(context.raw);
            },

            borderWidth: 1,
            borderRadius: 8,
            borderSkipped: false,
            barPercentage: 0.70,
            categoryPercentage: 0.6
            
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        animation: {
            duration: 900,
            easing: 'easeOutQuart'
        },

        plugins: {
            legend: {
                display: false
            },

            tooltip: {
                backgroundColor: '#212529',
                titleColor: '#ffffff',
                bodyColor: '#ffffff',
                padding: 12,
                cornerRadius: 8,

                callbacks: {
                    title: function(context) {
                        return context[0].label;
                    },

                    label: function(context) {
                        return ' Cash Flow: ' +
                            formatRupiah(context.raw);
                    }
                }
            }
        },

        scales: {
            x: {
                grid: {
                    display: false
                },

                border: {
                    display: false
                },

                ticks: {
                    color: '#6c757d',
                    font: {
                        size: 12
                    }
                }
            },

            y: {
                beginAtZero: true,

                border: {
                    display: false
                },

                grid: {
                    color: 'rgba(0, 0, 0, 0.07)',
                    drawTicks: false
                },

                ticks: {
                    color: '#6c757d',
                    padding: 10,

                    font: {
                        size: 11
                    },

                    callback: function(value) {
                        if (Math.abs(value) >= 1000000) {
                            return 'Rp ' +
                                (value / 1000000)
                                .toLocaleString('id-ID') + ' jt';
                        }

                        if (Math.abs(value) >= 1000) {
                            return 'Rp ' +
                                (value / 1000)
                                .toLocaleString('id-ID') + ' rb';
                        }

                        return 'Rp ' +
                            value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
    });
</script>
@endsection

