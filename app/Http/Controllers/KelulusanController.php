<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KelulusanController extends Controller
{
    public function index()
    {
        $tanggalPengumuman = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            Pengaturan::get('tanggal_pengumuman', '2026-05-04 00:00:00'),
            'Asia/Jakarta'
        );

        $sudahDibuka = Carbon::now('Asia/Jakarta')->gte($tanggalPengumuman);

        return view('kelulusan.cek', compact('sudahDibuka', 'tanggalPengumuman'));
    }

    public function cek(Request $request)
    {
        $tanggalPengumuman = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            Pengaturan::get('tanggal_pengumuman', '2026-05-04 00:00:00'),
            'Asia/Jakarta'
        );

        if (Carbon::now('Asia/Jakarta')->lt($tanggalPengumuman)) {
            return redirect()->route('kelulusan.index');
        }

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

        return view('kelulusan.hasil', compact('siswa'));
    }

    public function downloadPdf(string $nisn)
    {
        $tanggalPengumuman = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            Pengaturan::get('tanggal_pengumuman', '2026-05-04 00:00:00'),
            'Asia/Jakarta'
        );

        if (Carbon::now('Asia/Jakarta')->lt($tanggalPengumuman)) {
            abort(403, 'Pengumuman belum dibuka.');
        }

        $siswa = Siswa::where('nisn', $nisn)->firstOrFail();

        if (!$siswa->isLulus()) {
            abort(403, 'Surat kelulusan hanya tersedia untuk siswa yang lulus.');
        }

        $pengaturan = [
            'nama_kepala_sekolah' => Pengaturan::get('nama_kepala_sekolah'),
            'nip_kepala_sekolah'  => Pengaturan::get('nip_kepala_sekolah'),
            'ttd_kepala_sekolah'  => Pengaturan::get('ttd_kepala_sekolah'),
            'stempel_sekolah'     => Pengaturan::get('stempel_sekolah'),
            'tahun_ajaran'        => Pengaturan::get('tahun_ajaran', '2025/2026'),
            'nomor_surat'         => Pengaturan::get('nomor_surat'),
        ];

        $tanggalSurat = Carbon::now('Asia/Jakarta')->translatedFormat('d F Y');

        $pdf = Pdf::loadView('pdf.surat-kelulusan', compact('siswa', 'pengaturan', 'tanggalSurat'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Surat_Kelulusan_' . $siswa->nisn . '.pdf');
    }
}
