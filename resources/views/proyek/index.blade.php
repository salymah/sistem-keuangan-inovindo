@extends('layouts.app')

@section('title', 'Kelola Proyek')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="fw-bold mb-0 d-flex align-items-center">
        <span class="card-header-icon"><i class="bi bi-kanban"></i></span>
        Daftar Proyek
    </h6>
    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalTambahProyek">
        <i class="bi bi-plus-circle me-1"></i>Tambah Proyek
    </button>
</div>

<table class="table table-bordered bg-white align-middle">
    <thead class="table-light">
        <tr>
            <th>Nama Proyek</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($proyeks as $proyek)
            <tr>
                <td>
                    <a href="{{ route('proyek.show', $proyek) }}" class="text-decoration-none">
                        <i class="bi bi-briefcase-fill text-primary me-2"></i>
                        {{ $proyek->nama_proyek }}
                    </a>
                </td>
                                <td>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $proyek->id_proyek }}">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <form method="POST" action="{{ route('proyek.destroy', $proyek) }}" class="d-inline" onsubmit="return confirm('Hapus proyek ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button>
                    </form>

                    <!-- Modal Edit Proyek -->
                    <div class="modal fade" id="modalEdit{{ $proyek->id_proyek }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('proyek.update', $proyek) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h6 class="modal-title fw-bold d-flex align-items-center">
                                            <span class="card-header-icon"><i class="bi bi-pencil"></i></span>
                                            Edit Proyek
                                        </h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-briefcase"></i>Nama Proyek</label>
                                            <input type="text" name="nama_proyek" class="form-control" value="{{ $proyek->nama_proyek }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-dark"><i class="bi bi-check-circle me-1"></i>SIMPAN</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="text-center text-muted py-4">Belum ada proyek.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $proyeks->links() }}

<!-- Modal Tambah Proyek -->
<div class="modal fade" id="modalTambahProyek" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('proyek.store') }}">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title fw-bold d-flex align-items-center">
                        <span class="card-header-icon"><i class="bi bi-plus-circle"></i></span>
                        Tambah Proyek
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-briefcase"></i>Nama Proyek</label>
                        <input type="text" name="nama_proyek" class="form-control" placeholder="Contoh: Website - Toko Sejahtera" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark"><i class="bi bi-check-circle me-1"></i>SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection