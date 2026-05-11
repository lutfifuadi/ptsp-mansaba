## Penyesuaian Script Instalasi (install.sh) — 11 Mei 2026

**Prioritas** : TINGGI
**Agen Terlibat** : Aulia

### Urutan Eksekusi

[STEP 1] Aulia -> Sesuaikan variabel `GITHUB_REPO` di `install.sh` menjadi `ptsp-mansaba`.
[STEP 2] Aulia -> Perbarui semua teks deskripsi di `install.sh` dari "Laravel Absensi" menjadi "Aplikasi PTSP MAN 1 Kota Bandung".
[STEP 3] Aulia -> Pastikan nama asset zip di step 4 sesuai dengan penamaan build Aplikasi PTSP (misal: `ptsp-siap-pakai.zip`).
[STEP 4] Aulia -> Cek apakah file `setup-queue-worker.sh` sudah tersedia di project, jika belum, buatkan versi standarnya atau sesuaikan referensinya.
[STEP 5] Aulia -> Berikan izin eksekusi pada file `install.sh` (`chmod +x`).

### Catatan Wajib Semua Agen

- Acuan fitur: docs/full-version/*
- Setiap agen WAJIB cek laravel.log sebelum melaporkan tugas selesai dan pastikan tidak ada error baru akibat perubahan yang dilakukan
