[2026-05-13] Dashboard Buku Tamu — Halaman `/dashboard` kini menampilkan 2 kartu statistik baru (Total Tamu, Tamu Hari Ini) dan tabel 5 buku tamu terbaru. Data diambil dari model GuestBook. Backend: HomePage controller, Frontend: 2 stat cards + tabel, API docs diperbarui.
[2026-05-13] UI Role Management — Penyesuaian lebar halaman Edit & Tambah menjadi full width (col-12) dan pemindahan tombol simpan ke posisi kanan bawah form untuk meningkatkan UX.
[2026-05-13] Fix Delete Role — Route parameter mismatch pada resource `role-management` diperbaiki. Role `admin` dan `operator` diproteksi dari penghapusan. Validasi user terdampak sebelum hapus role. Dokumentasi endpoint dan security review selesai.
[2026-05-13] Permission System — 24 permission dibuat dan di-assign ke 5 role (admin, operator, mitra, staff, user). Middleware `can:permission-name` ditambahkan ke seluruh route admin. Role & permission mapping terdokumentasi.
[2026-05-13] Fitur Office Hour (Jam Operasional) — Pengaturan jam kerja kantor di halaman admin, proteksi otomatis seluruh form pelayanan publik (surat, ijazah, buku tamu) via middleware, dan indikator status operasional real-time di halaman beranda.
[2026-05-12] Notifikasi real-time buku tamu — toast popup otomatis untuk admin saat ada kunjungan baru + polling endpoint
[2026-05-12] Tampilkan hanya nama guru di dropdown & detail admin buku tamu (hilangkan bidang studi)
[2026-05-12] Perbaikan pagination & padding halaman admin siswa — kustomisasi view pagination dengan Tabler Icons, CSS tema emerald, padding konsisten 20px horizontal di tabel dan panel.
[2026-05-11] Penghapusan field 'Nama Orang Tua' dari data siswa (Database, Model, Controller, View, Import)
[2026-05-11] Fix GitHub Actions Workflow — PHP Version Incompatibility
[2026-05-11] Hapus bismillah Arab di halaman beranda PTSP
[2026-05-11] Mengganti teks statis 'Vuexy' menjadi dinamis menggunakan APP_NAME
[2026-05-11] Integrasi Data Buku Tamu Online ke Dashboard Admin
[2026-05-11] Perbaikan route /admin/buku-tamu 404 — clear route cache
[2026-05-11] Fitur truncation teks (11 karakter) di tabel buku tamu admin
[2026-05-11] Fitur modal detail buku tamu dengan animasi fade-in AJAX
[2026-05-11] Fitur rekap & export Excel/CSV buku tamu
[2026-05-11] Pemisahan data per layanan di dashboard admin
[2026-05-11] Penyesuaian header & navbar dinamis berdasarkan konteks layanan
[2026-05-11] Fitur statistik terfilter otomatis per layanan di admin dashboard
[2026-05-11] Sinkronisasi UI Data Siswa dengan Buku Tamu (Stats cards, Layout Master to ContentNavbar)
[2026-05-11] Fitur Export Excel & CSV untuk semua layanan PTSP (Admin Dashboard)
[2026-05-11] Dinamisasi Footer (Copyright, Made By, & Toggle Links) via Pengaturan Admin
[2026-05-11] Perbaikan error 'Vite manifest not found' — skrip deploy & build robust
[2026-05-11] Fitur download template Excel import siswa di halaman admin/siswa
[2026-05-11] Zona waktu sistem bisa diubah via Pengaturan Umum Admin (Asia/Jakarta, Makassar, Jayapura, dll)
[2026-05-11] Fix Error: View [ptsp.tracking-result] not found (Controller & Missing View)
[2026-05-11] Fitur Pengajuan Surat Siswa: Validasi NISN 10 digit & Konfirmasi Identitas
[2026-05-11] Hapus tampilan No. Peserta dari kolom NISN/NIS di tabel admin siswa
[2026-05-12] Fitur Legalisir Ijazah Alumni — layanan umum tanpa validasi NISN, form terpisah dari surat siswa
[2026-05-12] Fitur Edit NIS & Kelas oleh Siswa di Halaman Konfirmasi Surat — input editable di step konfirmasi, auto-save ke tabel siswa
[2026-05-12] Hapus deskripsi quick menu di halaman beranda PTSP
[2026-05-12] Feat: sinkronisasi versi aplikasi dengan GitHub release tag — command `php artisan version:sync` + auto-sync di deploy.sh
[2026-05-12] Penyelarasan UI Dashboard dengan tema Beranda — dark theme emerald/gold, glassmorphism, konsisten dengan portal publik PTSP
[2026-05-12] Perbaiki error `Helper::greeting()` tidak ditemukan di halaman /dashboard — tambah method greeting() di Helpers.php
[2026-05-12] Ubah border-radius halaman beranda (dashboard) dari 16px menjadi maksimal 5px — CSS .card, .btn, .badge, .avatar-initial, .quick-action-box, .stat-icon-wrapper, .premium-banner, .rounded, .time-badge
[2026-05-12] Rapikan posisi icon di beranda — tambah flexbox centering pada .stat-icon-wrapper dan .banner-icon-box agar icon tepat di tengah card
[2026-05-12] Implementasi UI Admin Premium untuk modul: Legalisir Ijazah, Buku Tamu, Pengambilan Ijazah, Pembuatan Surat, Legalisir, dan Semua Data.
[2026-05-12] Fitur Database Guru (Migration, Model, CRUD Admin, Public JSON API) & Integrasi dengan Buku Tamu — pengunjung bisa memilih guru tujuan dari dropdown dinamis saat memilih opsi "Guru" di form buku tamu.
[2026-05-12] Restrukturisasi Admin Dashboard: Penggunaan AdminPermohonanController untuk manajemen data per layanan yang lebih teratur.
[2026-05-12] Integrasi Menu Sidebar Admin: Penambahan link akses langsung ke tiap kategori layanan PTSP di menu navigasi utama.
[2026-05-12] Dokumentasi API Admin: Penambahan referensi endpoint administratif di docs/api/admin-ptsp.md.
[2026-05-12] Proporsionalitas font dashboard: perbesar font stat, heading, tabel; perkecil font quick menu.
[2026-05-12] Perkecil font form secara global (form-control, form-label, dll) via app.css + form surat publik.
[2026-05-12] Sinkronisasi UI Admin dengan Dashboard — shared CSS partial, stat-card, tbl, st-badge pattern di 12 halaman admin
[2026-05-12] Fitur Dropdown Kelas — input kelas di konfirmasi surat siswa & admin create/edit berubah dari text menjadi select dengan 36 opsi kelas (X.E-1 s/d XII.F-12). Validasi backend menggunakan config('kelas').
[2026-05-12] Hapus field 'Nomor Peserta' dari data siswa — Model, Controller (validasi + search), Import/Export, Migration drop column, View edit/create/index. UI Cleanup form edit & create siswa mengikuti gaya halaman pengaturan lembaga (form-actions, btn-primary).
[2026-05-12] Halaman Admin Form — Area referensi/testing komponen Select2 & Tagify (admin/form)
[2026-05-12] Sinkronisasi Select2 — Penerapan standar Select2 (search enabled, placeholder, dark theme) di halaman Buku Tamu, Konfirmasi Surat, dan Form Surat PTSP.
[2026-05-12] Manajemen Peran — Penambahan halaman Admin Role (admin/role) untuk pengelolaan akses pengguna.
