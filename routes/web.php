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
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\Admin\AdminGuruController;
use App\Http\Controllers\Admin\AdminPermohonanController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\RoleManagementController;
use App\Http\Controllers\Admin\OfficeHourController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PwaController;
use App\Http\Controllers\Admin\UpdateController;

// PWA Routes
Route::get('/manifest.json', [PwaController::class, 'manifest']);
Route::get('/sw.js', [PwaController::class, 'serviceWorker']);

// AI Chat Route
Route::post('/api/chat', [ChatController::class, 'chat'])
  ->middleware('throttle:ai_chat')
  ->name('api.chat');


// PTSP Routes
Route::prefix('ptsp')->name('ptsp.')->group(function () {
  Route::get('/', [PermohonanController::class, 'index'])->name('index');
  Route::get('/tracking', [PermohonanController::class, 'tracking'])->name('tracking');
  Route::post('/tracking', [PermohonanController::class, 'track'])->name('track');

  Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::middleware('office.hour')->group(function () {
      Route::get('/permohonan/baru', [PermohonanController::class, 'create'])->name('create');
      Route::post('/permohonan', [PermohonanController::class, 'store'])->name('store');
    });
    Route::get('/permohonan/{permohonan}', [PermohonanController::class, 'show'])->name('show');
  });

  // Public: Pengajuan Surat berbasis NISN (tanpa login)
  Route::middleware('office.hour')->group(function () {
    Route::get('/surat', [SuratSiswaController::class, 'formCek'])->name('surat.cek-form');
    Route::post('/surat/cek', [SuratSiswaController::class, 'cekNisn'])->name('surat.cek');
    Route::get('/surat/form', [SuratSiswaController::class, 'formPengajuan'])->name('surat.form');
    Route::post('/surat/store', [SuratSiswaController::class, 'store'])->name('surat.store');
    Route::post('/surat/konfirmasi', [SuratSiswaController::class, 'konfirmasiUpdate'])->name('surat.konfirmasi');
  });
  Route::get('/surat/sukses/{noTiket}', [SuratSiswaController::class, 'sukses'])->name('surat.sukses');
});

// Main Page Route (Refocused to PTSP)
Route::get('/', [PermohonanController::class, 'index'])->name('home');

// Guest Book Routes
Route::get('/buku-tamu', [GuestBookController::class, 'index'])->name('buku-tamu.index')->middleware('office.hour');
Route::post('/buku-tamu', [GuestBookController::class, 'store'])->name('buku-tamu.store')->middleware('office.hour');

// Public Guru API
Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');

// Pengambilan Ijazah & Legalisir Routes (Public)
Route::middleware('office.hour')->group(function () {
  // Pengambilan Ijazah
  Route::get('/ptsp/pengambilan-ijazah', [PermohonanController::class, 'pengambilanIjazah'])->name('ptsp.pengambilan-ijazah');
  Route::post('/ptsp/pengambilan-ijazah', [PermohonanController::class, 'storeIjazah'])->name('ptsp.pengambilan-ijazah.store');

  // Legalisir Ijazah
  Route::get('/ptsp/legalisir-ijazah', [PermohonanController::class, 'legalisirIjazah'])->name('ptsp.legalisir-ijazah');
  Route::post('/ptsp/legalisir-ijazah', [PermohonanController::class, 'storeLegalisirIjazah'])->name('ptsp.legalisir-ijazah.store');
});

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

  Route::prefix('admin')->name('admin.')->middleware('role:admin|operator')->group(function () {

    // Data Siswa
    Route::middleware('can:lihat-siswa')->group(function () {
      Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
      Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    });
    Route::middleware('can:tambah-siswa')->group(function () {
      Route::get('/siswa/tambah', [SiswaController::class, 'create'])->name('siswa.create');
      Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    });
    Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update')->middleware('can:edit-siswa');
    Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy')->middleware('can:hapus-siswa');
    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import')->middleware('can:impor-siswa');
    Route::get('/siswa/import/template', [SiswaController::class, 'downloadTemplate'])->name('siswa.import.template')->middleware('can:impor-siswa');

    // Data Guru
    Route::middleware('can:lihat-guru')->group(function () {
      Route::get('/guru', [AdminGuruController::class, 'index'])->name('guru.index');
      Route::get('/guru/{guru}', [AdminGuruController::class, 'show'])->name('guru.show');
      Route::get('/guru/{guru}/edit', [AdminGuruController::class, 'edit'])->name('guru.edit');
    });
    Route::middleware('can:tambah-guru')->group(function () {
      Route::get('/guru/tambah', [AdminGuruController::class, 'create'])->name('guru.create');
      Route::post('/guru', [AdminGuruController::class, 'store'])->name('guru.store');
    });
    Route::put('/guru/{guru}', [AdminGuruController::class, 'update'])->name('guru.update')->middleware('can:edit-guru');
    Route::delete('/guru/{guru}', [AdminGuruController::class, 'destroy'])->name('guru.destroy')->middleware('can:hapus-guru');

    // Data Petugas
    Route::middleware('can:lihat-petugas')->group(function () {
      Route::get('/petugas', [\App\Http\Controllers\Admin\AdminPetugasController::class, 'index'])->name('petugas.index');
      Route::get('/petugas/{petugas}', [\App\Http\Controllers\Admin\AdminPetugasController::class, 'show'])->name('petugas.show');
      Route::get('/petugas/{petugas}/edit', [\App\Http\Controllers\Admin\AdminPetugasController::class, 'edit'])->name('petugas.edit');
    });
    Route::middleware('can:tambah-petugas')->group(function () {
      Route::get('/petugas/tambah', [\App\Http\Controllers\Admin\AdminPetugasController::class, 'create'])->name('petugas.create');
      Route::post('/petugas', [\App\Http\Controllers\Admin\AdminPetugasController::class, 'store'])->name('petugas.store');
    });
    Route::put('/petugas/{petugas}', [\App\Http\Controllers\Admin\AdminPetugasController::class, 'update'])->name('petugas.update')->middleware('can:edit-petugas');
    Route::delete('/petugas/{petugas}', [\App\Http\Controllers\Admin\AdminPetugasController::class, 'destroy'])->name('petugas.destroy')->middleware('can:hapus-petugas');
    Route::middleware('can:impor-guru')->group(function () {
      Route::post('/guru/import', [AdminGuruController::class, 'import'])->name('guru.import');
      Route::get('/guru/import/template', [AdminGuruController::class, 'downloadTemplate'])->name('guru.import.template');
    });

    // Data PTSP
    Route::middleware('can:lihat-ptsp')->group(function () {
      Route::get('/ptsp', [AdminPermohonanController::class, 'semuaData'])->name('ptsp.index');
      Route::get('/ptsp/semua-data', [AdminPermohonanController::class, 'semuaData'])->name('ptsp.semua-data');
      Route::get('/ptsp/legalisir-ijazah', [AdminPermohonanController::class, 'legalisirIjazah'])->name('ptsp.legalisir-ijazah');
      Route::get('/ptsp/pengambilan-ijazah', [AdminPermohonanController::class, 'pengambilanIjazah'])->name('ptsp.pengambilan-ijazah');
      Route::get('/ptsp/pembuatan-surat', [AdminPermohonanController::class, 'pembuatanSurat'])->name('ptsp.pembuatan-surat');
      Route::get('/ptsp/legalisir', [AdminPermohonanController::class, 'legalisir'])->name('ptsp.legalisir');
      Route::get('/ptsp/{permohonan}', [PermohonanController::class, 'adminShow'])->name('ptsp.show');
    });
    Route::put('/ptsp/{permohonan}/status', [PermohonanController::class, 'updateStatus'])->name('ptsp.status')->middleware('can:kelola-ptsp');
    Route::post('/ptsp/reset/{layanan}', [PermohonanController::class, 'adminReset'])->name('ptsp.reset')->middleware('can:kelola-ptsp');
    Route::get('/ptsp/export/{format}', [ExportPermohonanController::class, 'export'])->name('ptsp.export')->middleware('can:export-ptsp');

    // Buku Tamu
    Route::middleware('can:lihat-buku-tamu')->group(function () {
      Route::get('/buku-tamu', [AdminGuestBookController::class, 'index'])->name('guest-book.index');
      Route::get('/buku-tamu/latest', [AdminGuestBookController::class, 'latest'])->name('guest-book.latest');
      
      Route::middleware('can:export-buku-tamu')->group(function () {
        Route::get('/buku-tamu/rekap', [ExportGuestBookController::class, 'rekap'])->name('guest-book.rekap');
        Route::get('/buku-tamu/export/{format}', [ExportGuestBookController::class, 'export'])->name('guest-book.export');
      });

      Route::get('/buku-tamu/{guestBook}', [AdminGuestBookController::class, 'show'])->name('guest-book.show');
    });
    Route::delete('/buku-tamu/{guestBook}', [AdminGuestBookController::class, 'destroy'])->name('guest-book.destroy')->middleware('can:hapus-buku-tamu');
    Route::post('/buku-tamu/reset', [AdminGuestBookController::class, 'reset'])->name('guest-book.reset')->middleware('can:reset-buku-tamu');

    // Manajemen Pengguna & Role
    Route::middleware('can:lihat-user')->group(function () {
      Route::get('/role', [AdminRoleController::class, 'index'])->name('role.index');
      Route::get('/role/{user}/edit', [AdminRoleController::class, 'edit'])->name('role.edit');
    });
    Route::middleware('can:tambah-user')->group(function () {
      Route::get('/role/tambah', [AdminRoleController::class, 'create'])->name('role.create');
      Route::post('/role', [AdminRoleController::class, 'store'])->name('role.store');
    });
    Route::put('/role/{user}', [AdminRoleController::class, 'update'])->name('role.update')->middleware('can:edit-user');
    Route::delete('/role/{user}', [AdminRoleController::class, 'destroy'])->name('role.destroy')->middleware('can:hapus-user');

    Route::resource('role-management', RoleManagementController::class)->parameters(['role-management' => 'role'])->names('role-management')->middleware(['role:admin', 'can:kelola-role']);

    // Form Elements
    Route::get('/form', function () {
      return view('content.pages.admin.form');
    })->name('form');

    // Pengaturan
    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
      Route::middleware('can:lihat-pengaturan')->group(function () {
        Route::get('/lembaga', [LembagaSettingController::class, 'index'])->name('lembaga');
        Route::get('/umum', [GeneralSettingController::class, 'index'])->name('umum');
        Route::get('/jam-operasional', [OfficeHourController::class, 'index'])->name('jam-operasional');
      });
      Route::middleware('can:edit-pengaturan')->group(function () {
        Route::put('/lembaga', [LembagaSettingController::class, 'update'])->name('lembaga.update');
       Route::put('/umum', [GeneralSettingController::class, 'update'])->name('umum.update');
        // Save only WhatsApp templates separately
       Route::put('/umum/templates', [GeneralSettingController::class, 'updateTemplates'])->name('umum.templates.update');
        Route::put('/jam-operasional', [OfficeHourController::class, 'update'])->name('jam-operasional.update');
        });
    });

    // Update Aplikasi
    Route::middleware('role:admin')->group(function () {
      Route::get('/update', [UpdateController::class, 'index'])->name('update.index');
      Route::post('/update/check', [UpdateController::class, 'check'])->name('update.check');
      Route::post('/update/run', [UpdateController::class, 'run'])->name('update.run');
    });
  });
});
