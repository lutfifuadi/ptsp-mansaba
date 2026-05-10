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
            'wa_api_key'    => Pengaturan::get('wa_api_key', ''),
            'wa_sender'     => Pengaturan::get('wa_sender', ''),
            'app_name'      => Pengaturan::get('app_name', 'Aplikasi PTSP'),
            'app_version'   => Pengaturan::get('app_version', '1.0.0'),
        ];

        return view('content.pages.admin.pengaturan.umum', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tahun_ajaran'  => ['required', 'string', 'max:20'],
            'tanggal_surat' => ['required', 'date'],
            'footer_teks'   => ['nullable', 'string', 'max:255'],
            'wa_api_key'    => ['nullable', 'string', 'max:255'],
            'wa_sender'     => ['nullable', 'string', 'max:20'],
            'app_name'      => ['nullable', 'string', 'max:100'],
            'app_version'   => ['nullable', 'string', 'max:20'],
        ]);

        Pengaturan::set('tahun_ajaran', $request->tahun_ajaran);
        Pengaturan::set('tanggal_surat', $request->tanggal_surat);
        Pengaturan::set('footer_teks', $request->footer_teks);
        Pengaturan::set('wa_api_key', $request->wa_api_key);
        Pengaturan::set('wa_sender', $request->wa_sender);
        Pengaturan::set('app_name', $request->app_name);
        Pengaturan::set('app_version', $request->app_version);

        return redirect()->back()->with('success', 'Pengaturan umum berhasil disimpan.');
    }
}
