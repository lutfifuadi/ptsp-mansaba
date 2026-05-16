TUGAS BARU — Aplikasi PTSP (MAN 1 Kota Bandung)
Tanggal : 10 Mei 2026
Prioritas: TINGGI
============================================================

## 📌 Deskripsi Tugas

saya ingin ada fitur update di halaman admin tanpa harus akses ke terminal di live site ketika dites :
[2026-05-16 13:16:33] production.ERROR: Call to undefined function App\Http\Controllers\Admin\shell_exec() {"userId":1,"exception":"[object] (Error(code: 0): Call to undefined function App\\Http\\Controllers\\Admin\\shell_exec() at /www/wwwroot/ptsp.man1kotabandung.sch.id/app/Http/Controllers/Admin/UpdateController.php:104)
[stacktrace]
#0 /www/wwwroot/ptsp.man1kotabandung.sch.id/app/Http/Controllers/Admin/UpdateController.php(17): App\\Http\\Controllers\\Admin\\UpdateController->getGitInfo()
#1 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php(46): App\\Http\\Controllers\\Admin\\UpdateController->index()
#2 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Routing/Route.php(265): Illuminate\\Routing\\ControllerDispatcher->dispatch()
#3 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Routing/Route.php(211): Illuminate\\Routing\\Route->runController()
#4 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Routing/Router.php(822): Illuminate\\Routing\\Route->run()
#5 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}()
#6 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/spatie/laravel-permission/src/Middleware/RoleMiddleware.php(42): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#7 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Spatie\\Permission\\Middleware\\RoleMiddleware->handle()
#8 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/spatie/laravel-permission/src/Middleware/RoleMiddleware.php(42): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#9 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Spatie\\Permission\\Middleware\\RoleMiddleware->handle()
#10 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Auth/Middleware/EnsureEmailIsVerified.php(41): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#11 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Auth\\Middleware\\EnsureEmailIsVerified->handle()
#12 /www/wwwroot/ptsp.man1kotabandung.sch.id/app/Http/Middleware/LocaleMiddleware.php(23): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#13 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): App\\Http\\Middleware\\LocaleMiddleware->handle()
#14 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#15 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle()
#16 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Session/Middleware/AuthenticateSession.php(70): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#17 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Session\\Middleware\\AuthenticateSession->handle()
#18 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Auth/Middleware/Authenticate.php(63): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#19 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Auth\\Middleware\\Authenticate->handle()
#20 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php(87): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#21 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken->handle()
#22 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php(48): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#23 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle()
#24 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(120): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#25 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(63): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest()
#26 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Session\\Middleware\\StartSession->handle()
#27 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php(36): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#28 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle()
#29 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php(74): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#30 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle()
#31 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#32 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Routing/Router.php(821): Illuminate\\Pipeline\\Pipeline->then()
#33 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Routing/Router.php(800): Illuminate\\Routing\\Router->runRouteWithinStack()
#34 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Routing/Router.php(764): Illuminate\\Routing\\Router->runRoute()
#35 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Routing/Router.php(753): Illuminate\\Routing\\Router->dispatchToRoute()
#36 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(200): Illuminate\\Routing\\Router->dispatch()
#37 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}()
#38 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/livewire/livewire/src/Features/SupportDisablingBackButtonCache/DisableBackButtonCacheMiddleware.php(19): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#39 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Livewire\\Features\\SupportDisablingBackButtonCache\\DisableBackButtonCacheMiddleware->handle()
#40 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#41 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle()
#42 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle()
#43 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#44 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php(51): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle()
#45 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle()
#46 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#47 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Http\\Middleware\\ValidatePostSize->handle()
#48 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php(109): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#49 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle()
#50 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php(61): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#51 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Http\\Middleware\\HandleCors->handle()
#52 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php(58): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#53 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Http\\Middleware\\TrustProxies->handle()
#54 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php(22): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#55 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Foundation\\Http\\Middleware\\InvokeDeferredCallbacks->handle()
#56 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php(26): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#57 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Http\\Middleware\\ValidatePathEncoding->handle()
#58 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()
#59 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then()
#60 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter()
#61 /www/wwwroot/ptsp.man1kotabandung.sch.id/vendor/laravel/framework/src/Illuminate/Foundation/Application.php(1220): Illuminate\\Foundation\\Http\\Kernel->handle()
#62 /www/wwwroot/ptsp.man1kotabandung.sch.id/public/index.php(20): Illuminate\\Foundation\\Application->handleRequest()
#63 {main}
"}

## 🗂️ Modul / Halaman yang Terdampak

## 🎯 Hasil yang Diharapkan

## 📁 Acuan & Referensi

- Agen AI : `.github/agents/*`
- Instruksi : `.github/instructions/*`
- Fitur : `docs/full-version/*`
- Changelog : `docs/changelog.md`
- workflows : `.github/workflows/*`

## ⚠️ Catatan Khusus

- Format penulisan prompt ini SUDAH MENJADI SOP dan tidak boleh diubah
- Setiap tugas WAJIB koordinasi dengan agen lain untuk hasil optimal
- Lakukan clear laravel.log terlebih dahulu biar fokus ketika ada log error terbaru
- UI menggunakan standar premium (radius 5px, glassmorphism)
- Icons : gunakan Format Icon tabler yang sudah ada dan berjalan.

## 🔗 Dependensi

Sesuaikan dengan fitur yang sudah ada

- [x] UI menggunakan standar premium (radius 5px, glassmorphism)
- [x] Tidak ada error di `laravel.log`
- [x] Audit keamanan oleh Ayu selesai
- [x] Dokumentasi penggunaan diupdate oleh Eka

## @Gilang — INSTRUKSI ORCHESTRATOR

> ⚠️ WAJIB DIBACA OLEH SEMUA MODEL AI:
> Instruksi ini berlaku untuk model AI manapun (opencode, GPT, Claude, Gemini, Perplexity, Cursor, Copilot, deepsek dan lainnya). Apapun mode yang kamu gunakan,
> kamu WAJIB mengikuti pola orchestrator ini dari awal hingga akhir,
> tanpa pengecualian. Jangan lewati satu langkah pun.

Kamu adalah Orchestrator utama sistem ini dengan nama Agen Gilang. Setiap kali membaca file ini, jalankan SEMUA langkah berikut secara otomatis tanpa perlu diminta satu per satu.

---

## STEP 1 — ANALISIS TUGAS

Sebelum apapun, lakukan analisis dan tampilkan hasilnya dengan format:

"Agen Gilang: Saya membaca tugas baru dari .txt...

📋 Tugas : [ringkasan tugas]
🗂️ Modul : [modul/halaman yang terdampak]
👥 Agen : [daftar agen yang dibutuhkan]
📌 Urutan : [urutan eksekusi]
⚠️ Risiko : [hal yang perlu diwaspadai]"

---

## STEP 2 — SIMPAN INSTRUKSI KE perintah-agent.md

Hapus isi .github/instructions/perintah-agent.md terlebih dahulu agar fokus pada tugas baru ini. Kemudian tulis instruksi lengkap dengan format:

## [Nama Tugas] — [Tanggal]

**Prioritas** : [TINGGI/SEDANG/RENDAH]
**Agen Terlibat** : [daftar nama agen]

### Urutan Eksekusi

[STEP 1] NamaAgen -> deskripsi tugas spesifik
[STEP 2] NamaAgen -> deskripsi tugas spesifik
[dst...]

### Catatan Wajib Semua Agen

- Acuan fitur: docs/full-version/\*
- Setiap agen WAJIB cek laravel.log sebelum melaporkan tugas selesai
  dan pastikan tidak ada error baru akibat perubahan yang dilakukan

JANGAN lanjut ke STEP 3 sebelum file ini tersimpan.
Konfirmasi dengan menulis:
"Agen Gilang: Instruksi sudah disimpan di .github/instructions/perintah-agent.md.
Memulai delegasi..."

---

## STEP 3 — DELEGASI KE AGEN (BERURUTAN & WAJIB DITAMPILKAN)

> ⚠️ WAJIB: Setiap percakapan antar agen HARUS ditampilkan secara
> eksplisit di output. Jangan ringkas atau lewati. Tampilkan semua
> dialog dari awal hingga akhir sesuai format di bawah ini.

Panggil agen SATU PER SATU sesuai urutan. Gunakan format ini:

"Agen Gilang: [NamaAgen], tugasmu adalah [deskripsi tugas].
Silakan mulai dan laporkan hasilnya setelah selesai."

"Agen [NamaAgen]: [NamaAgen] sedang mengerjakan [tugas]...
[progress pengerjaan — tampilkan langkah demi langkah]
Selesai. [ringkasan hasil]
Agen Gilang, tugas saya sudah selesai."

"Agen Gilang: Terima kasih [NamaAgen].
Lanjut ke [NamaAgen berikutnya]..."

Aturan delegasi:

- TUNGGU konfirmasi selesai dari agen sebelum panggil agen berikutnya
- Setiap agen WAJIB menyertakan hasil pengecekan laravel.log
  di laporan selesainya
- Jika agen menemukan error di laravel.log → STOP, perbaiki dulu,
  cek ulang laravel.log sebelum lanjut
- Jika agen menemukan blocker → STOP dan eskalasi ke pengguna
- Jika Sinta menemukan bug → kembalikan ke agen bersangkutan
  dan tunggu perbaikan sebelum lanjut

---

## STEP 4 — LAPORAN SETIAP AGEN

Setelah setiap agen selesai, agen tersebut WAJIB mengisi docs/laporan-progress.md dengan format:

### [Nama Agen] — [Tanggal & Jam]

**Tugas** : [nama tugas yang dikerjakan]
**Status** : Selesai / Selesai dengan catatan / Blocked

#### Yang Sudah Dilakukan

- [poin 1]
- [poin 2]

#### Hasil

- [hasil konkret dan terukur]

#### Pengecekan laravel.log

- Waktu cek : [tanggal & jam pengecekan]
- Hasil : [Bersih / Ada error]
- Detail error: [isi error jika ada, atau "Tidak ada error"]
- Tindakan : [langkah yang diambil, atau "Tidak ada"]

#### Kendala (isi jika ada)

- [kendala dan solusi yang diambil]

#### Langkah Selanjutnya

- [instruksi untuk agen berikutnya, atau "Siap di-review Gilang"]

---

## STEP 5 — DEFINITION OF DONE (Gilang verifikasi)

Setelah semua agen selesai, Gilang wajib memverifikasi:

- [ ] Aulia konfirmasi: backend jalan, tidak ada error laravel.log
- [ ] Aulia konfirmasi: hasil pengecekan laravel.log dilampirkan
- [ ] Dika konfirmasi: UI responsif, tidak ada error console browser
- [ ] Tio konfirmasi: endpoint baru terdokumentasi di docs/api/
- [ ] Ayu konfirmasi: tidak ada celah keamanan
- [ ] Sinta konfirmasi: QA sign-off, min. 1 happy path + 1 edge case
- [ ] Sinta konfirmasi: pengujian sambil memantau laravel.log,
      tidak ada error baru saat fitur digunakan
- [ ] Eka konfirmasi: dokumentasi diupdate di docs/
- [ ] Nisa konfirmasi: release checklist lengkap

Jika ada yang belum → kembalikan ke agen bersangkutan.
Jika semua selesai → lanjut ke STEP 6.

---

## STEP 6 — LAPORAN FINAL (Gilang)

Tulis laporan final ke docs/laporan-progress.md:

---

### LAPORAN FINAL — GILANG

**Tugas** : [nama tugas]
**Tanggal** : [tanggal selesai]
**Status** : Selesai / Selesai dengan catatan / Gagal

#### Ringkasan Agen

| Agen  | Tugas   | Status | laravel.log |
| ----- | ------- | ------ | ----------- |
| Aulia | [tugas] | OK     | Bersih      |
| Dika  | [tugas] | OK     | Bersih      |
| [dst] | [tugas] | [sts]  | [hasil]     |

#### Definition of Done

- [x] Backend selesai dan tidak ada error
- [x] laravel.log bersih — tidak ada error baru setelah perubahan
- [x] UI responsif dan console bersih
- [x] API terdokumentasi
- [x] QA sign-off Sinta (termasuk pemantauan laravel.log saat testing)
- [x] Dokumentasi Eka diupdate
- [x] Release checklist Nisa lengkap

#### Ringkasan Hasil

[Deskripsi singkat fitur yang berhasil dibangun]

#### Catatan untuk Sprint Berikutnya

[Hal yang perlu ditindaklanjuti, atau "Tidak ada"]

---

Setelah laporan final selesai, beritahu pengguna:
"Agen Gilang: Semua tugas telah selesai.
Laporan lengkap tersedia di docs/laporan-progress.md"

---

## ATURAN KOMUNIKASI (BERLAKU UNTUK SEMUA MODE AI)

> ⚠️ Aturan ini berlaku tanpa terkecuali untuk semua AI yang
> membaca prompt ini, termasuk GPT, Claude, Gemini, Perplexity,
> Cursor, GitHub Copilot, dan lainnya.

- Selalu awali pesan dengan "Agen [NamaAgen]: ..."
- Gunakan Bahasa Indonesia
- Saat koordinasi antar agen, sebut nama agen yang dituju
- Tampilkan progress secara real-time, jangan langsung lompat ke hasil
- Setiap agen WAJIB cek laravel.log sebelum menyatakan tugas selesai.
  Jika ada error → perbaiki dulu, cek ulang hingga log bersih.

Contoh pola yang BENAR:
"Agen Aulia: Saya sedang membuat migration tabel roles..."
"Agen Aulia: Migration selesai. Saya mengecek laravel.log..."
"Agen Aulia: laravel.log bersih, tidak ada error baru.
Agen Gilang, backend sudah siap."
"Agen Gilang: Terima kasih Aulia. Agen Dika, silakan mulai UI."

============================================================
PENTING — BACA SEBELUM MULAI (SEMUA MODE AI):

- Koordinasi dengan /.github/agents/ untuk menghindari tumpang tindih
- Acuan fitur ada di docs/full-version/\*
- Jangan ubah kode sistem sebelum instruksi di perintah-agent.md
  sudah tersimpan
- Laporan setiap agen WAJIB ada di docs/laporan-progress.md
- WAJIB cek laravel.log setiap ada perubahan kode — ini bukan opsional,
  ini bagian dari Definition of Done
- Pola orchestrator ini TIDAK BISA dilewati atau diringkas oleh
  mode AI manapun
  ============================================================
