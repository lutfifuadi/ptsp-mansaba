<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Permohonan;
use App\Models\Siswa;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuratSiswaController extends Controller
{
    public function formCek()
    {
        return view('ptsp.surat.cek');
    }

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

        $token = (string) Str::uuid();
        $sessions = session('surat_sessions', []);
        $sessions[$token] = $siswa->nisn;
        session(['surat_sessions' => $sessions]);

        return view('ptsp.surat.konfirmasi', compact('siswa', 'token'));
    }

    public function konfirmasiUpdate(Request $request)
    {
        $token = $request->input('session_token');
        $nisn = $this->getNisnFromToken($token);

        if (!$nisn) {
            return redirect()->route('ptsp.surat.cek-form')->withErrors([
                'nisn' => 'Sesi tidak valid. Silakan mulai dari awal.',
            ]);
        }

        $request->validate([
            'nis'   => ['nullable', 'string', 'max:20'],
            'kelas' => ['required', 'string', 'in:' . implode(',', config('kelas'))],
        ], [
            'kelas.required' => 'Kelas wajib diisi.',
            'kelas.in'       => 'Kelas yang dipilih tidak valid.',
        ]);

        $siswa = Siswa::where('nisn', $nisn)->first();
        if (!$siswa) {
            return redirect()->route('ptsp.surat.cek-form')->withErrors([
                'nisn' => 'Data siswa tidak ditemukan. Silakan mulai dari awal.',
            ]);
        }

        $siswa->update([
            'nis'   => $request->nis,
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('ptsp.surat.form', ['session_token' => $token])
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function formPengajuan(Request $request)
    {
        $token = $request->input('session_token');
        $nisn = $this->getNisnFromToken($token);

        if (!$nisn) {
            return redirect()->route('ptsp.surat.cek-form')->withErrors([
                'nisn' => 'Silakan masukkan NISN Anda terlebih dahulu.',
            ]);
        }

        $siswa = Siswa::where('nisn', $nisn)->first();
        if (!$siswa) {
            return redirect()->route('ptsp.surat.cek-form')->withErrors([
                'nisn' => 'Data siswa tidak ditemukan. Silakan mulai dari awal.',
            ]);
        }

        return view('ptsp.surat.form', compact('siswa', 'token'));
    }

    public function store(Request $request)
    {
        $token = $request->input('session_token');
        $nisn = $this->getNisnFromToken($token);

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
            'no_wa'       => ['required', 'string', 'max:20'],
        ], [
            'jenis_surat.required' => 'Jenis surat wajib dipilih.',
            'keperluan.required'   => 'Keperluan wajib diisi.',
            'no_wa.required'       => 'No. WhatsApp wajib diisi.',
        ]);

        $siswa = Siswa::where('nisn', $nisn)->first();
        if (!$siswa) {
            return redirect()->route('ptsp.surat.cek-form')->withErrors([
                'nisn' => 'Data siswa tidak ditemukan. Silakan mulai dari awal.',
            ]);
        }

        $layanan = Layanan::firstOrCreate(
            ['nama_layanan' => 'Pembuatan Surat-Surat'],
            [
                'deskripsi' => 'Layanan pembuatan surat keterangan dan legalisir untuk siswa',
                'kategori'  => 'siswa',
                'is_active' => true,
            ]
        );

        $noTiket = 'SURAT-' . strtoupper(Str::random(10));

        $permohonan = Permohonan::create([
            'nisn'       => $siswa->nisn,
            'user_id'    => null,
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
                'no_wa'        => $request->no_wa,
            ],
        ]);

        $permohonan->load('layanan.petugas');
        app(WhatsappService::class)->sendPermohonanBaru($permohonan);

        $submittedTickets = session('submitted_tickets', []);
        $submittedTickets[] = $noTiket;
        session(['submitted_tickets' => $submittedTickets]);

        $sessions = session('surat_sessions', []);
        unset($sessions[$token]);
        session(['surat_sessions' => $sessions]);

        return redirect()->route('ptsp.surat.sukses', $noTiket)
            ->with('success', 'Permohonan berhasil dikirim!');
    }

    public function sukses(Request $request, string $noTiket)
    {
        $permohonan = Permohonan::where('no_tiket', $noTiket)->first();
        if (!$permohonan) {
            return redirect()->route('ptsp.surat.cek-form')->withErrors([
                'nisn' => 'Permohonan tidak ditemukan.',
            ]);
        }

        $submittedTickets = session('submitted_tickets', []);
        if (!in_array($noTiket, $submittedTickets)) {
            return redirect()->route('ptsp.surat.cek-form')->withErrors([
                'nisn' => 'Anda tidak memiliki akses ke halaman ini.',
            ]);
        }

        return view('ptsp.surat.sukses', compact('permohonan', 'noTiket'));
    }

    private function getNisnFromToken(?string $token): ?string
    {
        if (!$token) {
            return null;
        }

        $sessions = session('surat_sessions', []);
        return $sessions[$token] ?? null;
    }
}
