## Perbaikan Fitur Update Admin Panel — 16 Mei 2026

**Prioritas** : TINGGI
**Agen Terlibat** : Aulia, Ayu, Dika, Sinta

### Urutan Eksekusi

[STEP 1] Aulia -> Perbaiki `UpdateController.php`: ganti semua `shell_exec()` dan `exec()` dengan Symfony Process Component (sudah digunakan di `AppUpdate.php`). Buat GitService sebagai single source of truth untuk semua operasi git. Tambahkan error handling: jika Process gagal (karena `proc_open` juga di-disable), tangkap exception dan tampilkan pesan error informatif di halaman. Pastikan halaman tetap bisa di-load meskipun git info tidak tersedia.

[STEP 2] Ayu -> Security audit ulang setelah perubahan: pastikan tidak ada celah command injection via Process component, pastikan error message tidak mengekspos informasi sensitif (stack trace, path server). Verifikasi logging aktivitas.

[STEP 3] Dika -> Periksa UI halaman update: pastikan state "tidak bisa akses git" ditampilkan dengan baik (banner warning, disabled buttons dengan tooltip). Gunakan standar premium (radius 5px, glassmorphism, Tabler icons).

[STEP 4] Sinta -> QA testing: test dengan git tersedia, test dengan git tidak tersedia (simulasi), test error handling, regression test. Pantau laravel.log.

### Catatan Wajib Semua Agen

- Acuan fitur: docs/full-version/*
- Setiap agen WAJIB cek laravel.log sebelum melaporkan tugas selesai dan pastikan tidak ada error baru akibat perubahan yang dilakukan
- Fitur ini menyangkut eksekusi system command — keamanan adalah prioritas utama
- Halaman harus tetap berfungsi (dengan pesan informatif) jika semua fungsi system command diblokir oleh hosting
