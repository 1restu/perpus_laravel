<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\HistoryController;

Route::get('/', function () {
    return view('layouts.index');
});
Route::get('/home', function () {
    return view('halaman.home');
});

Route::get('/buku', [BukuController::class, 'bukutampil'])->name('buku.tampil');
Route::post('/buku/tambah', [BukuController::class, 'bukutambah'])->name('buku.tambah');
Route::get('/buku/hapus/{id_bku}', [BukuController::class, 'bukuhapus'])->name('buku.hapus');
Route::put('/buku/edit/{id_bku}', [BukuController::class, 'bukuedit'])->name('buku.edit');
Route::get('/siswa', [SiswaController::class, 'siswatampil'])->name('siswa.tampil');
Route::post('/siswa/tambah', [SiswaController::class, 'siswatambah'])->name('siswa.tambah');
Route::get('/siswa/hapus/{id_bku}', [SiswaController::class, 'siswahapus'])->name('siswa.hapus');
Route::put('/siswa/edit/{id_bku}', [SiswaController::class, 'siswaedit'])->name('siswa.edit');
Route::get('/peminjaman', [PeminjamanController::class, 'peminjamantampil'])->name('peminjaman.tampil');
Route::post('/peminjaman/tambah', [PeminjamanController::class, 'peminjamantambah'])->name('peminjaman.tambah');
Route::get('/peminjaman/hapus/{id_pinjam}', [PeminjamanController::class, 'peminjamanhapus'])->name('peminjaman.hapus');
Route::put('/peminjaman/edit/{id_pinjam}', [PeminjamanController::class, 'peminjamanedit'])->name('peminjaman.edit');
Route::post('/peminjaman/kembalikan/{id_pinjam}', [PeminjamanController::class, 'peminjamankembalikan'])->name('peminjaman.kembalikan');
Route::get('/history', [HistoryController::class, 'historytampil'])->name('history.tampil');
Route::get('/history/hapus/{id_history}', [HistoryController::class, 'historyhapus'])->name('history.hapus');