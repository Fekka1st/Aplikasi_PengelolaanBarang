<?php

use App\Exports\BarangKeluarExport;
use App\Exports\BarangMasukExport;
use App\Exports\TotalStockBarangExport;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Kelola_BarangKeluarController;
use App\Http\Controllers\Kelola_BarangMasukController;
use App\Http\Controllers\Kelola_JenisBarangController;
use App\Http\Controllers\Kelola_KategoriController;
use App\Http\Controllers\Kelola_PenggunaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Manajemen_BarangController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/cek-barang/{kode_transaksi}', [DashboardController::class, 'cek_barang'])->name('cekbarang');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('checkrole:0,1')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/Laporan',[LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/total-stok/export', function (Request $request) {
            return Excel::download(new TotalStockBarangExport($request->tgl_awal, $request->tgl_akhir), 'laporan_total_stok_barang.xlsx');
        })->name('laporan.totalstok.export');

        Route::get('/laporan/Barang-Masuk/export', function (Request $request) {
            return Excel::download(new BarangMasukExport($request->tgl_awal, $request->tgl_akhir), 'laporan_Barang_Masuk.xlsx');
        })->name('laporan.BarangMasuk.export');

        Route::get('/laporan/Barang_Keluar/export', function (Request $request) {
            return Excel::download(new BarangKeluarExport($request->tgl_awal, $request->tgl_akhir), 'laporan_Barang_Keluar.xlsx');
        })->name('laporan.BarangKeluar.export');

        Route::get('/Manajemen_Barang',[Manajemen_BarangController::class, 'index'])->name('Manajemen_Barang.index');
        Route::post('/Manajemen_Barang',[Manajemen_BarangController::class, 'store'])->name('Manajemen_Barang.store');
        Route::get('/Manajemen_Barang/edit/{id}',[Manajemen_BarangController::class, 'edit'])->name('Manajemen_Barang.edit');
        Route::put('/Manajemen_Barang/update/{id}',[Manajemen_BarangController::class, 'update'])->name('Manajemen_Barang.update');
        Route::delete('/Manajemen_Barang/delete/{id}',[Manajemen_BarangController::class, 'destroy'])->name('Manajemen_Barang.destroy');

        Route::get('/Kelola_Barang_Masuk',[Kelola_BarangMasukController::class, 'index'])->name('Barang_Masuk.index');
        Route::post('/Kelola_Barang_Masuk',[Kelola_BarangMasukController::class, 'store'])->name('Barang_Masuk.store');
        Route::get('/Kelola_Barang_Masuk/edit/{id}',[Kelola_BarangMasukController::class, 'edit'])->name('Barang_Masuk.edit');
        Route::put('/Kelola_Barang_Masuk/update/{id}',[Kelola_BarangMasukController::class, 'update'])->name('Barang_Masuk.update');
        Route::delete('/Kelola_Barang_Masuk/delete/{id}',[Kelola_BarangMasukController::class, 'destroy'])->name('Barang_Masuk.destroy');

        Route::get('/Kelola_Barang_Keluar',[Kelola_BarangKeluarController::class, 'index'])->name('Barang_Keluar.index');
        Route::post('/Kelola_Barang_Keluar',[Kelola_BarangKeluarController::class, 'store'])->name('Barang_Keluar.store');
        Route::get('/Kelola_Barang_Keluar/edit/{id}',[Kelola_BarangKeluarController::class, 'edit'])->name('Barang_Keluar.edit');
        Route::put('/Kelola_Barang_Keluar/update/{id}',[Kelola_BarangKeluarController::class, 'update'])->name('Barang_Keluar.update');
        Route::delete('/Kelola_Barang_Keluar/delete/{id}',[Kelola_BarangKeluarController::class, 'destroy'])->name('Barang_Keluar.destroy');
    });

    Route::middleware('checkrole:1')->group(function () {
        // Role HR
        Route::get('/Kelola-Kategori',[Kelola_KategoriController::class, 'index'])->name('Kategori.index');
        Route::post('/Kelola-Kategori',[Kelola_KategoriController::class, 'store'])->name('Kategori.store');
        Route::get('/Kelola-Kategori/edit/{id}',[Kelola_KategoriController::class, 'edit'])->name('Kategori.edit');
        Route::put('/Kelola-Kategori/update/{id}',[Kelola_KategoriController::class, 'update'])->name('Kategori.update');
        Route::delete('/Kelola-Kategori/delete/{id}',[Kelola_KategoriController::class, 'destroy'])->name('Kategori.destroy');

        Route::get('/Kelola-Jenis',[Kelola_JenisBarangController::class, 'index'])->name('Jenis.index');
        Route::post('/Kelola-Jenis',[Kelola_JenisBarangController::class, 'store'])->name('Jenis.store');
        Route::get('/Kelola-Jenis/edit/{id}',[Kelola_JenisBarangController::class, 'edit'])->name('Jenis.edit');
        Route::put('/Kelola-Jenis/update/{id}',[Kelola_JenisBarangController::class, 'update'])->name('Jenis.update');
        Route::delete('/Kelola-Jenis/delete/{id}',[Kelola_JenisBarangController::class, 'destroy'])->name('Jenis.destroy');

        Route::get('/Kelola-Pengguna',[Kelola_PenggunaController::class, 'index'])->name('Pengguna.index');
        Route::post('/Kelola-Pengguna',[Kelola_PenggunaController::class, 'store'])->name('Pengguna.store');
        Route::get('/Kelola-Pengguna/edit/{id}',[Kelola_PenggunaController::class, 'edit'])->name('Pengguna.edit');
        Route::put('/Kelola-Pengguna/update/{id}',[Kelola_PenggunaController::class, 'update'])->name('Pengguna.update');
        Route::delete('/Kelola-Pengguna/delete/{id}',[Kelola_PenggunaController::class, 'destroy'])->name('Pengguna.destroy');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
