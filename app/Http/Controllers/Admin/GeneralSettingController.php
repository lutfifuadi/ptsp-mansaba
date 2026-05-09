<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $pengaturan = [
            'tahun_ajaran'  => Pengaturan::get('tahun_ajaran', '2025/2026'),
            'tanggal_surat' => Pengaturan::get('tanggal_surat', date('Y-m-d')),
            'footer_teks'   => Pengaturan::get('footer_teks', 'Dokumen ini diterbitkan secara resmi oleh Sistem Informasi Kelulusan'),
        ];

        return view('content.pages.admin.pengaturan.umum', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tahun_ajaran'  => ['required', 'string', 'max:20'],
            'tanggal_surat' => ['required', 'date'],
            'footer_teks'   => ['nullable', 'string', 'max:255'],
        ]);

        Pengaturan::set('tahun_ajaran', $request->tahun_ajaran);
        Pengaturan::set('tanggal_surat', $request->tanggal_surat);
        Pengaturan::set('footer_teks', $request->footer_teks);

        return redirect()->back()->with('success', 'Pengaturan umum berhasil disimpan.');
    }
}
