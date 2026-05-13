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
            'wa_group_id'   => Pengaturan::get('wa_group_id', ''),
            'app_name'      => Pengaturan::get('app_name', 'Aplikasi PTSP'),
            'app_version'   => Pengaturan::get('app_version', '1.0.0'),
            'app_timezone'  => Pengaturan::get('app_timezone', 'Asia/Jakarta'),
            'footer_copyright' => Pengaturan::get('footer_copyright', '© ' . date('Y')),
            'footer_made_by' => Pengaturan::get('footer_made_by', 'Pixinvent'),
            'footer_made_by_url' => Pengaturan::get('footer_made_by_url', 'https://pixinvent.com'),
            'footer_show_links' => Pengaturan::get('footer_show_links', '1'),
        ];

        return view('content.pages.admin.pengaturan.umum', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $timezones = timezone_identifiers_list();

        $request->validate([
            'tahun_ajaran'  => ['required', 'string', 'max:20'],
            'tanggal_surat' => ['required', 'date'],
            'footer_teks'   => ['nullable', 'string', 'max:255'],
            'wa_api_key'    => ['nullable', 'string', 'max:255'],
            'wa_sender'     => ['nullable', 'string', 'max:20'],
            'wa_group_id'   => ['nullable', 'string', 'max:100'],
            'app_name'      => ['nullable', 'string', 'max:100'],
            'app_version'   => ['nullable', 'string', 'max:20'],
            'app_timezone'  => ['nullable', 'string', 'in:' . implode(',', $timezones)],
            'footer_copyright' => ['nullable', 'string', 'max:100'],
            'footer_made_by' => ['nullable', 'string', 'max:100'],
            'footer_made_by_url' => ['nullable', 'url', 'max:255'],
            'footer_show_links' => ['nullable', 'boolean'],
        ]);

        Pengaturan::set('tahun_ajaran', $request->tahun_ajaran);
        Pengaturan::set('tanggal_surat', $request->tanggal_surat);
        Pengaturan::set('footer_teks', $request->footer_teks);
        Pengaturan::set('wa_api_key', $request->wa_api_key);
        Pengaturan::set('wa_sender', $request->wa_sender);
        Pengaturan::set('wa_group_id', $request->wa_group_id);
        Pengaturan::set('app_name', $request->app_name);
        Pengaturan::set('app_version', $request->app_version);
        Pengaturan::set('app_timezone', $request->app_timezone);
        Pengaturan::set('footer_copyright', $request->footer_copyright);
        Pengaturan::set('footer_made_by', $request->footer_made_by);
        Pengaturan::set('footer_made_by_url', $request->footer_made_by_url);
        Pengaturan::set('footer_show_links', $request->has('footer_show_links') ? '1' : '0');

        return redirect()->back()->with('success', 'Pengaturan umum berhasil disimpan.');
    }
}
