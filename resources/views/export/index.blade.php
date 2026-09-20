@extends('layouts.app')

@section('title', 'Export Laporan')

@section('content')
<div class="card" style="max-width: 560px;">
    <div class="card-body">
        <h6 class="fw-bold mb-4 d-flex align-items-center">
            <span class="card-header-icon"><i class="bi bi-download"></i></span>
            Export Laporan Keuangan
        </h6>
        <form id="formExport" method="POST">
            @csrf
            <div class="row g-3 mb-4">
                <div class="col-6">
                    <label class="form-label"><i class="bi bi-calendar-event"></i>Dari Tanggal</label>
                    <input type="date" name="dari_tanggal" class="form-control" required>
                </div>
                <div class="col-6">
                    <label class="form-label"><i class="bi bi-calendar-check"></i>Sampai Tanggal</label>
                    <input type="date" name="sampai_tanggal" class="form-control" required>
                </div>
            </div>
            <button type="submit" formaction="{{ route('export.pdf') }}" class="btn btn-outline-dark">
                <i class="bi bi-file-earmark-pdf me-1"></i>EXPORT PDF
            </button>
            <button type="submit" formaction="{{ route('export.excel') }}" class="btn btn-outline-dark">
                <i class="bi bi-file-earmark-excel me-1"></i>EXPORT EXCEL
            </button>
        </form>
    </div>
</div>
@endsection