<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Services\WhatsappService;
use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $wa = app(WhatsappService::class);

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
            // PWA Settings
            'pwa_name'          => Pengaturan::get('pwa_name', 'Aplikasi PTSP'),
            'pwa_short_name'    => Pengaturan::get('pwa_short_name', 'PTSP'),
            'pwa_description'   => Pengaturan::get('pwa_description', 'Sistem Informasi Pelayanan Terpadu Satu Pintu MAN 1 Kota Bandung'),
            'pwa_background_color' => Pengaturan::get('pwa_background_color', '#ffffff'),
            'pwa_theme_color'   => Pengaturan::get('pwa_theme_color', '#7367f0'),
            // AI Chat Settings
            'gemini_api_keys'   => Pengaturan::get('gemini_api_keys', ''),
            // Theme Color Settings
            'theme_primary'         => Pengaturan::get('theme_primary', '#059669'),
            'theme_primary_dark'    => Pengaturan::get('theme_primary_dark', '#047857'),
            'theme_primary_darker'  => Pengaturan::get('theme_primary_darker', '#064e3b'),
            'theme_accent'          => Pengaturan::get('theme_accent', '#d97706'),
            'theme_danger'          => Pengaturan::get('theme_danger', '#dc2626'),
            'theme_info'            => Pengaturan::get('theme_info', '#4f46e5'),
            'theme_success'         => Pengaturan::get('theme_success', '#0284c7'),
            'theme_muted'           => Pengaturan::get('theme_muted', '#64748b'),
            'theme_text'            => Pengaturan::get('theme_text', '#0f172a'),
            'theme_surface'         => Pengaturan::get('theme_surface', '#ffffff'),
            'theme_background'      => Pengaturan::get('theme_background', '#f1f5f9'),
            'theme_border'          => Pengaturan::get('theme_border', '#e2e8f0'),
            'theme_border_light'    => Pengaturan::get('theme_border_light', '#cbd5e1'),
        ];

        foreach ($wa->getAllTemplates() as $key => $value) {
            $pengaturan['wa_template_' . $key] = $value;
        }

        return view('content.pages.admin.pengaturan.umum', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $timezones = timezone_identifiers_list();

        $rules = [
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
            'pwa_name'          => ['nullable', 'string', 'max:100'],
            'pwa_short_name'    => ['nullable', 'string', 'max:20'],
            'pwa_description'   => ['nullable', 'string', 'max:255'],
            'pwa_background_color' => ['nullable', 'string', 'max:20'],
            'pwa_theme_color'   => ['nullable', 'string', 'max:20'],
            'gemini_api_keys'   => ['nullable', 'string'],
            // Theme Colors - validasi format hex
            'theme_primary'         => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_primary_dark'    => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_primary_darker'  => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_accent'          => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_danger'          => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_info'            => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_success'         => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_muted'           => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_text'            => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_surface'         => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_background'      => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_border'          => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_border_light'    => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ];

        $templateKeys = [
            'wa_template_baru_petugas',
            'wa_template_baru_pemohon',
            'wa_template_baru_group',
            'wa_template_status_petugas',
            'wa_template_status_pemohon',
            'wa_template_status_group',
        ];

        foreach ($templateKeys as $key) {
            $rules[$key] = ['nullable', 'string', 'max:2000'];
        }

        $request->validate($rules);

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
        Pengaturan::set('pwa_name', $request->pwa_name);
        Pengaturan::set('pwa_short_name', $request->pwa_short_name);
        Pengaturan::set('pwa_description', $request->pwa_description);
        Pengaturan::set('pwa_background_color', $request->pwa_background_color);
        Pengaturan::set('pwa_theme_color', $request->pwa_theme_color);
        Pengaturan::set('gemini_api_keys', $request->gemini_api_keys);

        // Theme Colors
        Pengaturan::set('theme_primary', $request->theme_primary);
        Pengaturan::set('theme_primary_dark', $request->theme_primary_dark);
        Pengaturan::set('theme_primary_darker', $request->theme_primary_darker);
        Pengaturan::set('theme_accent', $request->theme_accent);
        Pengaturan::set('theme_danger', $request->theme_danger);
        Pengaturan::set('theme_info', $request->theme_info);
        Pengaturan::set('theme_success', $request->theme_success);
        Pengaturan::set('theme_muted', $request->theme_muted);
        Pengaturan::set('theme_text', $request->theme_text);
        Pengaturan::set('theme_surface', $request->theme_surface);
        Pengaturan::set('theme_background', $request->theme_background);
        Pengaturan::set('theme_border', $request->theme_border);
        Pengaturan::set('theme_border_light', $request->theme_border_light);

        foreach ($templateKeys as $key) {
            if ($request->has($key)) {
                Pengaturan::set($key, $request->$key);
            }
        }

        return redirect()->back()->with('success', 'Pengaturan umum berhasil disimpan.');
    }

    /**
     * Save only WhatsApp template redactions separately.
     */
    public function updateTemplates(Request $request)
    {
        $templateKeys = [
            'wa_template_baru_petugas',
            'wa_template_baru_pemohon',
            'wa_template_baru_group',
            'wa_template_status_petugas',
            'wa_template_status_pemohon',
            'wa_template_status_group',
        ];

        $rules = [];
        foreach ($templateKeys as $key) {
            $rules[$key] = ['nullable', 'string', 'max:2000'];
        }

        $request->validate($rules);

        foreach ($templateKeys as $key) {
            // Use null coalescing to allow emptying template
            Pengaturan::set($key, $request->input($key, ''));
        }

        return redirect()->back()->with('success', 'Redaksi notifikasi WhatsApp berhasil disimpan.');
    }
}
