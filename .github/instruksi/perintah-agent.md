## Fitur Single/Multi Sekolah Mode — 25 Mei 2026

**Prioritas** : TINGGI
**Agen Terlibat** : Fajar, Dika, Intan, Rizky, Eka, Gilang

### Ringkasan Fitur

Buat setting global on/off di aplikasi untuk mengubah mode operasi:
- **Multi Sekolah (default)**: Perilaku saat ini — Super Admin/Dinas melihat semua data sekolah.
- **Single Sekolah**: Mode untuk deploy 1 sekolah — semua pengguna (termasuk Super Admin) hanya melihat data 1 sekolah tertentu.

Implementasi via `settings` table (key-value) dan helper function `activeSekolahId()`.

### Urutan Eksekusi

[STEP 1] Fajar   -> Backend: migration `settings` table, model, helper function, middleware, dan update semua Livewire components.
[STEP 2] Dika   -> Frontend: buat halaman pengaturan mode sekolah di admin, tambahkan menu sidebar.
[STEP 3] Intan  -> UX Review: review alur toggle, label, dan pesan sistem.
[STEP 4] Rizky  -> QA: test single mode & multi mode, regresi query data, cek laravel.log.
[STEP 5] Eka    -> Dokumentasi: update docs/changelog.md dan docs/laporan-progress.md.

### Detail Teknis untuk Fajar

1. **Migration** `create_settings_table`:
   - `id`, `key` (unique string), `value` (text), timestamps
   - Seeder: `app_mode` = 'multi', `default_sekolah_id` = null

2. **Model** `App\Models\Setting`:
   - `$fillable = ['key', 'value']`
   - Method `static::get($key, $default = null)` — ambil value by key
   - Method `static::set($key, $value)` — set value by key

3. **Helper function** di `app/helpers.php` (auto-load via composer.json):
   ```php
   function setting($key, $default = null) {
       return App\Models\Setting::get($key, $default);
   }
   function activeSekolahId() {
       $user = auth()->user();
       if (!$user) return null;
       if ($user->sekolah_id) return $user->sekolah_id;
       if (setting('app_mode') === 'single') return setting('default_sekolah_id');
       return null;
   }
   ```

4. **Update Livewire Components** — ganti pola `Auth::user()->sekolah_id` dengan `activeSekolahId()`:
   - `app/Livewire/Emis/MasterSiswa.php` — mount & render
   - `app/Livewire/Emis/MasterUser.php`
   - `app/Livewire/Emis/MasterKelas.php`
   - `app/Livewire/Emis/MasterJurusan.php`
   - `app/Livewire/Emis/MasterTahunAjaran.php`
   - `app/Livewire/Emis/ApprovalAntrian.php`

5. **Update API Controllers** — ganti pola `$user->sekolah_id` dengan `activeSekolahId()`:
   - `app/Http/Controllers/api/SiswaApiController.php`
   - `app/Http/Controllers/api/SekolahApiController.php`
   - `app/Http/Controllers/api/ApprovalApiController.php`

6. **Update Controllers**:
   - `app/Http/Controllers/Sekolah/DashboardController.php` — scoping approval count

7. **Auto-load helpers**: Tambahkan `"files": ["app/helpers.php"]` ke `composer.json` autoload.

### Detail Teknis untuk Dika

1. Buat halaman **Setting Mode Sekolah** di `/admin/master/setting-sekolah`:
   - Toggle switch: Single Sekolah / Multi Sekolah
   - Jika Single: tampilkan dropdown pilih sekolah (dari tabel sekolah)
   - Tombol Simpan
   - Pesan konfirmasi bahwa mode single akan membatasi akses admin ke 1 sekolah

2. Tambahkan menu ke `resources/menu/verticalMenu-admin.json`:
   - Di bawah "Pengaturan" atau "Google Sheet"
   - Icon: `tabler-building-community` atau `tabler-switch-horizontal`

### Catatan Wajib Semua Agen

- Setiap agen WAJIB cek `storage/logs/laravel.log` sebelum dan sesudah perubahan.
- Setiap agen WAJIB isi laporan di `agen/instruksi/laporan-progress.md`.
- Jika ada error di log → STOP, perbaiki dulu, baru lanjut.
