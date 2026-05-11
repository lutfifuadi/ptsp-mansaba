<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\LembagaSettingController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\AdminGuestBookController;
use App\Http\Controllers\Admin\ExportGuestBookController;
use App\Http\Controllers\Admin\ExportPermohonanController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\SuratSiswaController;

// PTSP Routes
Route::prefix('ptsp')->name('ptsp.')->group(function () {
  Route::get('/', [PermohonanController::class, 'index'])->name('index');
  Route::get('/tracking', [PermohonanController::class, 'tracking'])->name('tracking');
  Route::post('/tracking', [PermohonanController::class, 'track'])->name('track');

  Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/permohonan/baru', [PermohonanController::class, 'create'])->name('create');
    Route::post('/permohonan', [PermohonanController::class, 'store'])->name('store');
    Route::get('/permohonan/{permohonan}', [PermohonanController::class, 'show'])->name('show');
  });

  // Public: Pengajuan Surat berbasis NISN (tanpa login)
  Route::get('/surat', [SuratSiswaController::class, 'formCek'])->name('surat.cek-form');
  Route::post('/surat/cek', [SuratSiswaController::class, 'cekNisn'])->name('surat.cek');
  Route::get('/surat/form', [SuratSiswaController::class, 'formPengajuan'])->name('surat.form');
  Route::post('/surat/store', [SuratSiswaController::class, 'store'])->name('surat.store');
  Route::get('/surat/sukses/{noTiket}', [SuratSiswaController::class, 'sukses'])->name('surat.sukses');
});

// Main Page Route (Refocused to PTSP)
Route::get('/', [PermohonanController::class, 'index'])->name('home');

// Guest Book Routes
use App\Http\Controllers\GuestBookController;
Route::get('/buku-tamu', [GuestBookController::class, 'index'])->name('buku-tamu.index');
Route::post('/buku-tamu', [GuestBookController::class, 'store'])->name('buku-tamu.store');

// Pengambilan Ijazah Routes (Public)
Route::get('/ptsp/pengambilan-ijazah', [PermohonanController::class, 'pengambilanIjazah'])->name('ptsp.pengambilan-ijazah');
Route::post('/ptsp/pengambilan-ijazah', [PermohonanController::class, 'storeIjazah'])->name('ptsp.pengambilan-ijazah.store');

Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

// locale
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');

Route::middleware([
  'auth:sanctum',
  config('jetstream.auth_session'),
  'verified',
])->group(function () {
  Route::get('/dashboard', [HomePage::class, 'index'])->name('dashboard');

  Route::prefix('admin')->name('admin.')->group(function () {

    // Data Siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/tambah', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
    Route::get('/siswa/import/template', [SiswaController::class, 'downloadTemplate'])->name('siswa.import.template');


    // Data PTSP
    Route::get('/ptsp', [PermohonanController::class, 'adminIndex'])->name('ptsp.index');
    Route::get('/ptsp/export/{format}', [ExportPermohonanController::class, 'export'])->name('ptsp.export');
    Route::get('/ptsp/{permohonan}', [PermohonanController::class, 'adminShow'])->name('ptsp.show');
    Route::put('/ptsp/{permohonan}/status', [PermohonanController::class, 'updateStatus'])->name('ptsp.status');
    Route::post('/ptsp/reset/{layanan}', [PermohonanController::class, 'adminReset'])->name('ptsp.reset');

    // Buku Tamu
    Route::get('/buku-tamu', [AdminGuestBookController::class, 'index'])->name('guest-book.index');

    // Buku Tamu - Rekap & Export (HARUS sebelum {guestBook} wildcard)
    Route::get('/buku-tamu/rekap', [ExportGuestBookController::class, 'rekap'])->name('guest-book.rekap');
    Route::get('/buku-tamu/export/{format}', [ExportGuestBookController::class, 'export'])->name('guest-book.export');

    Route::get('/buku-tamu/{guestBook}', [AdminGuestBookController::class, 'show'])->name('guest-book.show');
    Route::delete('/buku-tamu/{guestBook}', [AdminGuestBookController::class, 'destroy'])->name('guest-book.destroy');
    Route::post('/buku-tamu/reset', [AdminGuestBookController::class, 'reset'])->name('guest-book.reset');

    // Pengaturan
    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
      // Lembaga
      Route::get('/lembaga', [LembagaSettingController::class, 'index'])->name('lembaga');
      Route::put('/lembaga', [LembagaSettingController::class, 'update'])->name('lembaga.update');

      // Umum
      Route::get('/umum', [GeneralSettingController::class, 'index'])->name('umum');
      Route::put('/umum', [GeneralSettingController::class, 'update'])->name('umum.update');


    });
  });
});
