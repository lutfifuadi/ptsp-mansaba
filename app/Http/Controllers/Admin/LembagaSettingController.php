<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\HandlesPdfImages;

class LembagaSettingController extends Controller
{
    use HandlesPdfImages;

    public function index()
    {
        $pengaturan = [
            // Institution Details
            'nama_lembaga'            => Pengaturan::get('nama_lembaga', 'MAN 1 Kota Bandung'),
            'npsn'                    => Pengaturan::get('npsn', '20277069'),
            'alamat_lembaga'          => Pengaturan::get('alamat_lembaga', 'Jl. Terusan H. Alpi, Cibuntu, Kec. Bandung Kulon'),
            'kabupaten_kota'          => Pengaturan::get('kabupaten_kota', 'Kota Bandung'),
            'provinsi'                => Pengaturan::get('provinsi', 'Jawa Barat'),
            'telepon'                 => Pengaturan::get('telepon', '(022) 6027957'),
            'fax'                     => Pengaturan::get('fax'),
            'kode_pos'                => Pengaturan::get('kode_pos', '40212'),
            'email'                   => Pengaturan::get('email', 'info@man1kotabandung.sch.id'),
            'website'                 => Pengaturan::get('website', 'https://man1kotabandung.sch.id'),

            // Header (KOP)
            'header_baris_1'          => Pengaturan::get('header_baris_1', 'KEMENTERIAN AGAMA REPUBLIK INDONESIA'),
            'header_baris_2'          => Pengaturan::get('header_baris_2', 'KANTOR KEMENTERIAN AGAMA KOTA BANDUNG'),
            'logo_kiri'               => Pengaturan::get('logo_kiri'),
            'logo_kanan'              => Pengaturan::get('logo_kanan'),

            // Signatory
            'nama_kepala_sekolah'     => Pengaturan::get('nama_kepala_sekolah'),
            'nip_kepala_sekolah'      => Pengaturan::get('nip_kepala_sekolah'),
            'ttd_kepala_sekolah'      => Pengaturan::get('ttd_kepala_sekolah'),
            'stempel_sekolah'         => Pengaturan::get('stempel_sekolah'),
            'jabatan_penandatangan'   => Pengaturan::get('jabatan_penandatangan'),
        ];

        return view('content.pages.admin.pengaturan.lembaga', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_lembaga'          => ['required', 'string', 'max:255'],
            'npsn'                  => ['nullable', 'string', 'max:20'],
            'alamat_lembaga'        => ['required', 'string'],
            'kabupaten_kota'        => ['required', 'string', 'max:100'],
            'provinsi'              => ['required', 'string', 'max:100'],
            'telepon'               => ['nullable', 'string', 'max:50'],
            'fax'                   => ['nullable', 'string', 'max:50'],
            'kode_pos'              => ['nullable', 'string', 'max:10'],
            'email'                 => ['nullable', 'email', 'max:100'],
            'website'               => ['nullable', 'string', 'max:255'],
            'header_baris_1'        => ['nullable', 'string', 'max:255'],
            'header_baris_2'        => ['nullable', 'string', 'max:255'],
            'logo_kiri'             => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
            'logo_kanan'            => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
            'logo_kiri_url'         => ['nullable', 'string', 'max:500'],
            'logo_kanan_url'        => ['nullable', 'string', 'max:500'],
            'nama_kepala_sekolah'   => ['required', 'string', 'max:255'],
            'nip_kepala_sekolah'    => ['nullable', 'string', 'max:50'],
            'jabatan_penandatangan' => ['required', 'string', 'max:255'],
            'ttd_kepala_sekolah'    => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
            'stempel_sekolah'       => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
            'ttd_kepala_sekolah_url'=> ['nullable', 'string', 'max:500'],
            'stempel_sekolah_url'   => ['nullable', 'string', 'max:500'],
        ]);

        $fields = [
            'nama_lembaga', 'npsn', 'alamat_lembaga', 'kabupaten_kota', 'provinsi',
            'telepon', 'fax', 'kode_pos', 'email', 'website', 'header_baris_1', 'header_baris_2',
            'nama_kepala_sekolah', 'nip_kepala_sekolah', 'jabatan_penandatangan'
        ];

        foreach ($fields as $field) {
            Pengaturan::set($field, $request->get($field));
        }

        // Handle Images
        $imageFields = [
            'logo_kiri'          => 'kelulusan/logos',
            'logo_kanan'         => 'kelulusan/logos',
            'ttd_kepala_sekolah' => 'kelulusan/ttd',
            'stempel_sekolah'    => 'kelulusan/stempel',
        ];

        foreach ($imageFields as $key => $folder) {
            if ($request->hasFile($key)) {
                $oldPath = Pengaturan::get($key);
                if ($oldPath && !str_starts_with($oldPath, 'http')) {
                    Storage::disk('public')->delete($oldPath);
                }
                $path = $request->file($key)->store($folder, 'public');
                Pengaturan::set($key, $path);
            } elseif ($request->filled($key . '_url')) {
                $oldPath = Pengaturan::get($key);
                if ($oldPath && !str_starts_with($oldPath, 'http')) {
                    Storage::disk('public')->delete($oldPath);
                }
                Pengaturan::set($key, $request->get($key . '_url'));
            }
        }

        return redirect()->back()->with('success', 'Pengaturan lembaga berhasil disimpan.');
    }
}
