<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Permohonan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuratSiswaController extends Controller
{
    /**
     * STEP 1: Form input NISN
     * GET /ptsp/surat
     */
    public function formCek()
    {
        return view('ptsp.surat.cek');
    }

    /**
     * STEP 2: Validasi NISN dan tampilkan konfirmasi identitas
     * POST /ptsp/surat/cek
     * Pola session: ikuti KelulusanController::cek()
     */
    public function cekNisn(Request $request)
    {
        $request->validate([
            'nisn' => ['required', 'digits:10'],
        ], [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.digits'   => 'NISN harus terdiri dari 10 digit angka.',
        ]);

        $siswa = Siswa::where('nisn', $request->nisn)->first();

        if (!$siswa) {
            return back()->withInput()->withErrors([
                'nisn' => 'NISN tidak ditemukan. Pastikan NISN yang Anda masukkan benar.',
            ]);
        }

        // Simpan NISN ke session untuk melindungi halaman form
        session(['last_checked_nisn_surat' => $siswa->nisn]);

        return view('ptsp.surat.konfirmasi', compact('siswa'));
    }

    /**
     * STEP 2.5: Update NIS & Kelas dari halaman konfirmasi
     * POST /ptsp/surat/konfirmasi
     */
    public function konfirmasiUpdate(Request $request)
    {
        $nisn = session('last_checked_nisn_surat');

        if (!$nisn) {
            return redirect()->route('ptsp.surat.cek-form')->withErrors([
                'nisn' => 'Sesi tidak valid. Silakan mulai dari awal.',
            ]);
        }

        $request->validate([
            'nis'   => ['nullable', 'string', 'max:20'],
            'kelas' => ['required', 'string', 'max:50'],
        ], [
            'kelas.required' => 'Kelas wajib diisi.',
        ]);

        $siswa = Siswa::where('nisn', $nisn)->firstOrFail();
        $siswa->update([
            'nis'   => $request->nis,
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('ptsp.surat.form')
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * STEP 3: Form detail pengajuan surat
     * GET /ptsp/surat/form
     * Proteksi: harus ada session last_checked_nisn_surat
     */
    public function formPengajuan()
    {
        $nisn = session('last_checked_nisn_surat');

        if (!$nisn) {
            return redirect()->route('ptsp.surat.cek-form')->withErrors([
                'nisn' => 'Silakan masukkan NISN Anda terlebih dahulu.',
            ]);
        }

        $siswa = Siswa::where('nisn', $nisn)->firstOrFail();

        return view('ptsp.surat.form', compact('siswa'));
    }

    /**
     * STEP 4: Simpan permohonan surat
     * POST /ptsp/surat/store
     */
    public function store(Request $request)
    {
        $nisn = session('last_checked_nisn_surat');

        // Proteksi session
        if (!$nisn) {
            return redirect()->route('ptsp.surat.cek-form')->withErrors([
                'nisn' => 'Sesi tidak valid. Silakan mulai dari awal.',
            ]);
        }

        $request->validate([
            'jenis_surat' => ['required', 'string'],
            'keperluan'   => ['required', 'string', 'max:1000'],
            'legalisir'   => ['nullable', 'array'],
            'legalisir.*' => ['string', 'in:Raport,SKKB'],
        ], [
            'jenis_surat.required' => 'Jenis surat wajib dipilih.',
            'keperluan.required'   => 'Keperluan wajib diisi.',
        ]);

        $siswa = Siswa::where('nisn', $nisn)->firstOrFail();

        // Cari atau buat layanan Pembuatan Surat-Surat
        $layanan = Layanan::firstOrCreate(
            ['nama_layanan' => 'Pembuatan Surat-Surat'],
            [
                'deskripsi' => 'Layanan pembuatan surat keterangan dan legalisir untuk siswa',
                'kategori'  => 'siswa',
                'is_active' => true,
            ]
        );

        // Generate nomor tiket
        $noTiket = 'SURAT-' . strtoupper(Str::random(5));

        Permohonan::create([
            'nisn'       => $siswa->nisn,
            'user_id'    => null, // public, tanpa login
            'layanan_id' => $layanan->id,
            'no_tiket'   => $noTiket,
            'status'     => 'pending',
            'data_form'  => [
                'nisn'         => $siswa->nisn,
                'nama_lengkap' => $siswa->nama_lengkap,
                'kelas'        => $siswa->kelas,
                'tempat_lahir' => $siswa->tempat_lahir,
                'tanggal_lahir'=> $siswa->tanggal_lahir,
                'jenis_surat'  => $request->jenis_surat,
                'legalisir'    => $request->legalisir ?? [],
                'keperluan'    => $request->keperluan,
            ],
        ]);

        // Hapus session setelah submit berhasil
        session()->forget('last_checked_nisn_surat');

        return redirect()->route('ptsp.surat.sukses', $noTiket)
            ->with('success', 'Permohonan berhasil dikirim!');
    }

    /**
     * Halaman sukses setelah submit
     * GET /ptsp/surat/sukses/{noTiket}
     */
    public function sukses(string $noTiket)
    {
        $permohonan = Permohonan::where('no_tiket', $noTiket)->firstOrFail();

        return view('ptsp.surat.sukses', compact('permohonan', 'noTiket'));
    }
}
