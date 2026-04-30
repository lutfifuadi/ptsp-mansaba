<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\KelulusanController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\PengaturanKelulusanController;

// Main Page Route
Route::get('/', [KelulusanController::class, 'index'])->name('kelulusan.index');
Route::post('/cek', [KelulusanController::class, 'cek'])->name('kelulusan.cek');
Route::get('/download/{nisn}', [KelulusanController::class, 'downloadPdf'])->name('kelulusan.pdf');

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

  // ─── Admin Kelulusan ──────────────────────────────────────────────────────
  Route::prefix('admin')->name('admin.')->group(function () {

    // Data Siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/tambah', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
    Route::post('/siswa/bulk-status', [SiswaController::class, 'bulkStatus'])->name('siswa.bulk-status');

    // Pengaturan Kelulusan
    Route::get('/pengaturan-kelulusan', [PengaturanKelulusanController::class, 'index'])->name('pengaturan-kelulusan.index');
    Route::put('/pengaturan-kelulusan', [PengaturanKelulusanController::class, 'update'])->name('pengaturan-kelulusan.update');
  });
});
