
<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportLaporanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengaturanAlertController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RankingRoiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProyekController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Ranking ROI - Finance & Owner
    Route::get('/ranking-roi', [RankingRoiController::class, 'index'])
        ->name('ranking-roi.index');

    // Export Laporan - Finance & Owner
    Route::get('/export', [ExportLaporanController::class, 'index'])
        ->name('export.index');

    Route::post('/export/pdf', [ExportLaporanController::class, 'exportPdf'])
        ->name('export.pdf');

    Route::post('/export/excel', [ExportLaporanController::class, 'exportExcel'])
        ->name('export.excel');

   
    Route::middleware('role:finance,owner')->group(function () {
        Route::get('/transaksi', [TransaksiController::class, 'index'])
            ->name('transaksi.index');
    });


    // Pengelolaan Transaksi - Finance saja
    Route::middleware('role:finance')->group(function () {

        Route::get('/transaksi/create-pemasukan', [TransaksiController::class, 'createPemasukan'])
            ->name('transaksi.create-pemasukan');

        Route::get('/transaksi/create-pengeluaran', [TransaksiController::class, 'createPengeluaran'])
            ->name('transaksi.create-pengeluaran');

        Route::post('/transaksi', [TransaksiController::class, 'store'])
            ->name('transaksi.store');

        Route::get('/transaksi/{transaksi}/edit', [TransaksiController::class, 'edit'])
            ->name('transaksi.edit');

        Route::put('/transaksi/{transaksi}', [TransaksiController::class, 'update'])
            ->name('transaksi.update');

        Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])
            ->name('transaksi.destroy');


        // Kelola Kategori - Finance saja
        Route::get('/kategori', [KategoriController::class, 'index'])
            ->name('kategori.index');

        Route::post('/kategori', [KategoriController::class, 'store'])
            ->name('kategori.store');

        Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])
            ->name('kategori.edit');

        Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])
            ->name('kategori.update');

        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])
            ->name('kategori.destroy');


        // Kelola Proyek - Finance saja
        Route::get('/proyek', [ProyekController::class, 'index'])
            ->name('proyek.index');

        Route::get('/proyek/{proyek}', [ProyekController::class, 'show'])
            ->name('proyek.show');

        Route::post('/proyek', [ProyekController::class, 'store'])
            ->name('proyek.store');

        Route::put('/proyek/{proyek}', [ProyekController::class, 'update'])
            ->name('proyek.update');
        

        Route::delete('/proyek/{proyek}', [ProyekController::class, 'destroy'])
            ->name('proyek.destroy');


        // Pengaturan Alert - Finance saja
        Route::get('/alert', [PengaturanAlertController::class, 'index'])
            ->name('alert.index');

        Route::post('/alert', [PengaturanAlertController::class, 'store'])
            ->name('alert.store');
    });


    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';

