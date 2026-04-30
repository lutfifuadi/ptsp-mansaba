<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanKelulusanController extends Controller
{
    public function index()
    {
        $pengaturan = [
            'tanggal_pengumuman'  => Pengaturan::get('tanggal_pengumuman', '2026-05-04 00:00:00'),
            'nama_kepala_sekolah' => Pengaturan::get('nama_kepala_sekolah'),
            'nip_kepala_sekolah'  => Pengaturan::get('nip_kepala_sekolah'),
            'ttd_kepala_sekolah'  => Pengaturan::get('ttd_kepala_sekolah'),
            'stempel_sekolah'     => Pengaturan::get('stempel_sekolah'),
            'tahun_ajaran'        => Pengaturan::get('tahun_ajaran', '2025/2026'),
            'nomor_surat'         => Pengaturan::get('nomor_surat'),
        ];

        return view('content.pages.admin.pengaturan-kelulusan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tanggal_pengumuman'  => ['required', 'date_format:Y-m-d\TH:i'],
            'nama_kepala_sekolah' => ['required', 'string', 'max:255'],
            'nip_kepala_sekolah'  => ['nullable', 'string', 'max:50'],
            'tahun_ajaran'        => ['required', 'string', 'max:20'],
            'nomor_surat'         => ['nullable', 'string', 'max:100'],
            'ttd_kepala_sekolah'  => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
            'stempel_sekolah'     => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        // Simpan tanggal (input datetime-local sudah WIB dari UI)
        $tanggal = Carbon::createFromFormat('Y-m-d\TH:i', $request->tanggal_pengumuman, 'Asia/Jakarta');
        Pengaturan::set('tanggal_pengumuman', $tanggal->format('Y-m-d H:i:s'));

        Pengaturan::set('nama_kepala_sekolah', $request->nama_kepala_sekolah);
        Pengaturan::set('nip_kepala_sekolah', $request->nip_kepala_sekolah);
        Pengaturan::set('tahun_ajaran', $request->tahun_ajaran);
        Pengaturan::set('nomor_surat', $request->nomor_surat);

        if ($request->hasFile('ttd_kepala_sekolah')) {
            $oldTtd = Pengaturan::get('ttd_kepala_sekolah');
            if ($oldTtd) {
                Storage::disk('public')->delete($oldTtd);
            }
            $path = $request->file('ttd_kepala_sekolah')->store('kelulusan/ttd', 'public');
            Pengaturan::set('ttd_kepala_sekolah', $path);
        }

        if ($request->hasFile('stempel_sekolah')) {
            $oldStempel = Pengaturan::get('stempel_sekolah');
            if ($oldStempel) {
                Storage::disk('public')->delete($oldStempel);
            }
            $path = $request->file('stempel_sekolah')->store('kelulusan/stempel', 'public');
            Pengaturan::set('stempel_sekolah', $path);
        }

        return redirect()->route('admin.pengaturan-kelulusan.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
