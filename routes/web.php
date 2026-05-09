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
use App\Http\Controllers\Admin\CalonMuridController;
use App\Http\Controllers\Admin\PmbmSettingController;
use App\Http\Controllers\Admin\PengaturanKelulusanController;
use App\Http\Controllers\Admin\LembagaSettingController;
use App\Http\Controllers\Admin\GeneralSettingController;

// Main Page Route
Route::get('/', [KelulusanController::class, 'index'])->name('kelulusan.index');
Route::get('/xii-check', [KelulusanController::class, 'showForm'])->name('kelulusan.form');
Route::post('/cek', [KelulusanController::class, 'cek'])->name('kelulusan.cek');
Route::get('/download/{nisn}', [KelulusanController::class, 'downloadPdf'])->name('kelulusan.pdf');
Route::get('/validasi/{token}', [KelulusanController::class, 'validasi'])->middleware('throttle:60,1')->name('kelulusan.validasi');

// PMBM Public Routes
use App\Http\Controllers\PmbmController;
Route::get('/pmbm-check', [PmbmController::class, 'index'])->name('pmbm.index');
Route::post('/pmbm-check/cek', [PmbmController::class, 'cek'])->name('pmbm.cek');
Route::get('/pmbm-check/download/{no_pendaftaran}', [PmbmController::class, 'downloadPdf'])->name('pmbm.pdf');

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

    // Data PMBM
    Route::resource('pmbm', CalonMuridController::class)->names('pmbm');
    Route::post('/pmbm/import', [CalonMuridController::class, 'import'])->name('pmbm.import');
    // Pengaturan
    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
      // Lembaga
      Route::get('/lembaga', [LembagaSettingController::class, 'index'])->name('lembaga');
      Route::put('/lembaga', [LembagaSettingController::class, 'update'])->name('lembaga.update');

      // Umum
      Route::get('/umum', [GeneralSettingController::class, 'index'])->name('umum');
      Route::put('/umum', [GeneralSettingController::class, 'update'])->name('umum.update');

      // Kelulusan (XII)
      Route::get('/kelulusan', [PengaturanKelulusanController::class, 'index'])->name('kelulusan');
      Route::put('/kelulusan', [PengaturanKelulusanController::class, 'update'])->name('kelulusan.update');
      Route::get('/kelulusan/preview', [PengaturanKelulusanController::class, 'preview'])->name('kelulusan.preview');
      Route::post('/kelulusan/redaksi', [PengaturanKelulusanController::class, 'updateRedaksi'])->name('kelulusan.update-redaksi');

      // PMBM
      Route::get('/pmbm', [PmbmSettingController::class, 'index'])->name('pmbm');
      Route::put('/pmbm', [PmbmSettingController::class, 'update'])->name('pmbm.update');
      Route::get('/pmbm/preview', [PmbmSettingController::class, 'preview'])->name('pmbm.preview');
    });
  });
});
