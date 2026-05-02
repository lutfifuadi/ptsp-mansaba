<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\HandlesPdfImages;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Color\Gray;
use BaconQrCode\Writer;

class PengaturanKelulusanController extends Controller
{
    use HandlesPdfImages;
    public function index()
    {
        $pengaturan = [
            // General & Schedule
            'tanggal_pengumuman'      => Pengaturan::get('tanggal_pengumuman', '2026-05-04 00:00:00'),
            'tanggal_surat'           => Pengaturan::get('tanggal_surat', date('Y-m-d')),
            'tahun_ajaran'            => Pengaturan::get('tahun_ajaran', '2025/2026'),
            'nomor_surat'             => Pengaturan::get('nomor_surat'),
            'versi_surat'             => Pengaturan::get('versi_surat', 'lengkap'),

            // Institution Details
            'nama_lembaga'            => Pengaturan::get('nama_lembaga', 'NAMA SEKOLAH'),
            'npsn'                    => Pengaturan::get('npsn'),
            'alamat_lembaga'          => Pengaturan::get('alamat_lembaga', 'ALAMAT SEKOLAH'),
            'kabupaten_kota'          => Pengaturan::get('kabupaten_kota', 'KOTA BANDUNG'),
            'provinsi'                => Pengaturan::get('provinsi', 'JAWA BARAT'),
            'telepon'                 => Pengaturan::get('telepon'),
            'fax'                     => Pengaturan::get('fax'),
            'kode_pos'                => Pengaturan::get('kode_pos'),
            'email'                   => Pengaturan::get('email'),
            'website'                 => Pengaturan::get('website'),

            // Header (KOP)
            'header_baris_1'          => Pengaturan::get('header_baris_1', 'KEMENTERIAN AGAMA REPUBLIK INDONESIA'),
            'header_baris_2'          => Pengaturan::get('header_baris_2'), // Typically empty to use nama_lembaga
            'logo_kiri'               => Pengaturan::get('logo_kiri'),
            'logo_kanan'              => Pengaturan::get('logo_kanan'),

            // Titles & Labels
            'judul_lulus'             => Pengaturan::get('judul_lulus', 'SURAT KETERANGAN LULUS'),
            'judul_tidak_lulus'       => Pengaturan::get('judul_tidak_lulus', 'SURAT KETERANGAN TIDAK LULUS'),
            'teks_pembuka'            => Pengaturan::get('teks_pembuka', 'Yang bertanda tangan di bawah ini, Kepala ${nama_lembaga}, dengan ini menerangkan bahwa siswa berikut:'),
            'label_lulus'             => Pengaturan::get('label_lulus', 'LULUS'),
            'label_tidak_lulus'       => Pengaturan::get('label_tidak_lulus', 'TIDAK LULUS'),
            'teks_penutup'            => Pengaturan::get('teks_penutup', 'Demikian surat keterangan ini diberikan agar dapat dipergunakan sebagaimana mestinya.'),

            // Redaksi
            'redaksi_lulus'           => Pengaturan::get('redaksi_lulus', "Dinyatakan **LULUS** dari satuan pendidikan \${nama_lembaga} pada Tahun Pelajaran \${tahun_ajaran} berdasarkan kriteria kelulusan yang telah ditetapkan. Surat keterangan ini dapat digunakan sampai diterbitkannya ijazah asli."),
            'redaksi_tidak_lulus'     => Pengaturan::get('redaksi_tidak_lulus', "Dinyatakan **TIDAK LULUS** dari satuan pendidikan \${nama_lembaga} pada Tahun Pelajaran \${tahun_ajaran} berdasarkan kriteria kelulusan yang telah ditetapkan."),

            // Signatory
            'nama_kepala_sekolah'     => Pengaturan::get('nama_kepala_sekolah'),
            'nip_kepala_sekolah'      => Pengaturan::get('nip_kepala_sekolah'),
            'ttd_kepala_sekolah'      => Pengaturan::get('ttd_kepala_sekolah'),
            'stempel_sekolah'         => Pengaturan::get('stempel_sekolah'),
            'jabatan_penandatangan'   => Pengaturan::get('jabatan_penandatangan', 'Kepala ${nama_lembaga}'),

            // Footer
            'footer_teks'             => Pengaturan::get('footer_teks', 'Dokumen ini diterbitkan secara resmi oleh Sistem Informasi Kelulusan'),
        ];

        return view('content.pages.admin.pengaturan-kelulusan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tanggal_pengumuman'    => ['required', 'date_format:Y-m-d\TH:i'],
            'tahun_ajaran'          => ['required', 'string', 'max:20'],
            'nomor_surat'           => ['nullable', 'string', 'max:100'],
            'nama_lembaga'          => ['required', 'string', 'max:255'],
            'npsn'                  => ['nullable', 'string', 'max:20'],
            'alamat_lembaga'        => ['required', 'string'],
            'kabupaten_kota'        => ['required', 'string', 'max:100'],
            'provinsi'              => ['required', 'string', 'max:100'],
            'telepon'               => ['nullable', 'string', 'max:50'],
            'email'                 => ['nullable', 'email', 'max:100'],
            'website'               => ['nullable', 'string', 'max:255'],
            'header_baris_1'        => ['nullable', 'string', 'max:255'],
            'header_baris_2'        => ['nullable', 'string', 'max:255'],
            'logo_kiri'             => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
            'logo_kanan'            => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
            'logo_kiri_url'         => ['nullable', 'string', 'max:500'],
            'logo_kanan_url'        => ['nullable', 'string', 'max:500'],
            'ttd_kepala_sekolah'    => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
            'stempel_sekolah'       => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
            'ttd_kepala_sekolah_url'=> ['nullable', 'string', 'max:500'],
            'stempel_sekolah_url'   => ['nullable', 'string', 'max:500'],
            'judul_lulus'           => ['required', 'string', 'max:255'],
            'judul_tidak_lulus'     => ['required', 'string', 'max:255'],
            'teks_pembuka'          => ['required', 'string'],
            'label_lulus'           => ['required', 'string', 'max:50'],
            'label_tidak_lulus'     => ['required', 'string', 'max:50'],
            'redaksi_lulus'         => ['required', 'string'],
            'redaksi_tidak_lulus'   => ['required', 'string'],
            'teks_penutup'          => ['required', 'string'],
            'nama_kepala_sekolah'   => ['required', 'string', 'max:255'],
            'nip_kepala_sekolah'    => ['nullable', 'string', 'max:50'],
            'jabatan_penandatangan' => ['required', 'string', 'max:255'],
            'footer_teks'           => ['nullable', 'string', 'max:255'],
            'versi_surat'           => ['required', 'string', 'in:lengkap,tanpa_data'],
        ]);

        // Save simple text fields
        $fields = [
            'tahun_ajaran', 'tanggal_surat', 'nomor_surat', 'nama_lembaga', 'npsn', 'alamat_lembaga', 'kabupaten_kota', 'provinsi',
            'telepon', 'fax', 'kode_pos', 'email', 'website', 'header_baris_1', 'header_baris_2', 'judul_lulus', 'judul_tidak_lulus',
            'teks_pembuka', 'label_lulus', 'label_tidak_lulus', 'redaksi_lulus', 'redaksi_tidak_lulus',
            'teks_penutup', 'nama_kepala_sekolah', 'nip_kepala_sekolah', 'jabatan_penandatangan', 'footer_teks', 'versi_surat'
        ];

        foreach ($fields as $field) {
            Pengaturan::set($field, $request->get($field));
        }

        // Save date
        $tanggal = Carbon::createFromFormat('Y-m-d\TH:i', $request->tanggal_pengumuman, 'Asia/Jakarta');
        Pengaturan::set('tanggal_pengumuman', $tanggal->format('Y-m-d H:i:s'));

        // Handle Images (File Upload or URL)
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

        return redirect()->route('admin.pengaturan-kelulusan.index')
            ->with('success', 'Seluruh pengaturan PDF berhasil disimpan.');
    }

    // ── PARTIAL UPDATE: Card 1 — Jadwal & KOP ──────────────────────────────────
    public function updateJadwalKop(Request $request)
    {
        $request->validate([
            'tanggal_pengumuman' => ['required', 'date_format:Y-m-d\TH:i'],
            'tahun_ajaran'       => ['required', 'string', 'max:20'],
            'tanggal_surat'      => ['required', 'date'],
            'nomor_surat'        => ['nullable', 'string', 'max:100'],
            'header_baris_1'     => ['nullable', 'string', 'max:255'],
            'header_baris_2'     => ['nullable', 'string', 'max:255'],
            'logo_kiri'          => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
            'logo_kanan'         => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
            'logo_kiri_url'      => ['nullable', 'string', 'max:500'],
            'logo_kanan_url'     => ['nullable', 'string', 'max:500'],
        ]);

        foreach (['tahun_ajaran', 'tanggal_surat', 'nomor_surat', 'header_baris_1', 'header_baris_2'] as $field) {
            Pengaturan::set($field, $request->get($field));
        }

        $tanggal = Carbon::createFromFormat('Y-m-d\TH:i', $request->tanggal_pengumuman, 'Asia/Jakarta');
        Pengaturan::set('tanggal_pengumuman', $tanggal->format('Y-m-d H:i:s'));

        foreach (['logo_kiri' => 'kelulusan/logos', 'logo_kanan' => 'kelulusan/logos'] as $key => $folder) {
            if ($request->hasFile($key)) {
                $oldPath = Pengaturan::get($key);
                if ($oldPath && !str_starts_with($oldPath, 'http')) Storage::disk('public')->delete($oldPath);
                Pengaturan::set($key, $request->file($key)->store($folder, 'public'));
            } elseif ($request->filled($key . '_url')) {
                $oldPath = Pengaturan::get($key);
                if ($oldPath && !str_starts_with($oldPath, 'http')) Storage::disk('public')->delete($oldPath);
                Pengaturan::set($key, $request->get($key . '_url'));
            }
        }

        return redirect()->route('admin.pengaturan-kelulusan.index')
            ->with('success', '✅ Jadwal & Header (KOP) berhasil disimpan.');
    }

    public function updateIdentitas(Request $request)

    {
        $request->validate([
            'nama_lembaga'   => ['required', 'string', 'max:255'],
            'npsn'           => ['nullable', 'string', 'max:20'],
            'alamat_lembaga' => ['required', 'string'],
            'kabupaten_kota' => ['required', 'string', 'max:100'],
            'provinsi'       => ['required', 'string', 'max:100'],
            'telepon'        => ['nullable', 'string', 'max:50'],
            'fax'            => ['nullable', 'string', 'max:50'],
            'kode_pos'       => ['nullable', 'string', 'max:10'],
            'email'          => ['nullable', 'email', 'max:100'],
            'website'        => ['nullable', 'string', 'max:255'],
        ]);

        foreach (['nama_lembaga', 'npsn', 'alamat_lembaga', 'kabupaten_kota', 'provinsi', 'telepon', 'fax', 'kode_pos', 'email', 'website'] as $field) {
            Pengaturan::set($field, $request->get($field));
        }

        return redirect()->route('admin.pengaturan-kelulusan.index')
            ->with('success', '✅ Identitas Lembaga berhasil disimpan.');
    }

    // ── PARTIAL UPDATE: Card 3 — Legalisasi ────────────────────────────────────
    public function updateLegalisasi(Request $request)
    {
        $request->validate([
            'nama_kepala_sekolah'    => ['required', 'string', 'max:255'],
            'nip_kepala_sekolah'     => ['nullable', 'string', 'max:50'],
            'jabatan_penandatangan'  => ['required', 'string', 'max:255'],
            'ttd_kepala_sekolah'     => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
            'stempel_sekolah'        => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
            'ttd_kepala_sekolah_url' => ['nullable', 'string', 'max:500'],
            'stempel_sekolah_url'    => ['nullable', 'string', 'max:500'],
        ]);

        foreach (['nama_kepala_sekolah', 'nip_kepala_sekolah', 'jabatan_penandatangan'] as $field) {
            Pengaturan::set($field, $request->get($field));
        }

        foreach (['ttd_kepala_sekolah' => 'kelulusan/ttd', 'stempel_sekolah' => 'kelulusan/stempel'] as $key => $folder) {
            if ($request->hasFile($key)) {
                $oldPath = Pengaturan::get($key);
                if ($oldPath && !str_starts_with($oldPath, 'http')) Storage::disk('public')->delete($oldPath);
                Pengaturan::set($key, $request->file($key)->store($folder, 'public'));
            } elseif ($request->filled($key . '_url')) {
                $oldPath = Pengaturan::get($key);
                if ($oldPath && !str_starts_with($oldPath, 'http')) Storage::disk('public')->delete($oldPath);
                Pengaturan::set($key, $request->get($key . '_url'));
            }
        }

        return redirect()->route('admin.pengaturan-kelulusan.index')
            ->with('success', '✅ Kepala Sekolah & Legalisasi berhasil disimpan.');
    }

    // ── PARTIAL UPDATE: Card 4 — Redaksi & Konten ──────────────────────────────
    public function updateRedaksi(Request $request)
    {
        $request->validate([
            'versi_surat'         => ['required', 'string', 'in:lengkap,tanpa_data'],
            'judul_lulus'         => ['required', 'string', 'max:255'],
            'label_lulus'         => ['required', 'string', 'max:50'],
            'redaksi_lulus'       => ['required', 'string'],
            'judul_tidak_lulus'   => ['required', 'string', 'max:255'],
            'label_tidak_lulus'   => ['required', 'string', 'max:50'],
            'redaksi_tidak_lulus' => ['required', 'string'],
            'teks_pembuka'        => ['required', 'string'],
            'teks_penutup'        => ['required', 'string'],
            'footer_teks'         => ['nullable', 'string', 'max:255'],
        ]);

        foreach ([
            'versi_surat', 'judul_lulus', 'label_lulus', 'redaksi_lulus',
            'judul_tidak_lulus', 'label_tidak_lulus', 'redaksi_tidak_lulus',
            'teks_pembuka', 'teks_penutup', 'footer_teks',
        ] as $field) {
            Pengaturan::set($field, $request->get($field));
        }

        return redirect()->route('admin.pengaturan-kelulusan.index')
            ->with('success', '✅ Redaksi & Konten PDF berhasil disimpan.');
    }

    public function preview()
    {
        $pengaturan = [
            'nama_lembaga'          => Pengaturan::get('nama_lembaga', 'NAMA SEKOLAH'),
            'npsn'                  => Pengaturan::get('npsn'),
            'alamat_lembaga'        => Pengaturan::get('alamat_lembaga', 'ALAMAT SEKOLAH'),
            'kabupaten_kota'        => Pengaturan::get('kabupaten_kota', 'KOTA BANDUNG'),
            'provinsi'              => Pengaturan::get('provinsi', 'JAWA BARAT'),
            'telepon'               => Pengaturan::get('telepon'),
            'fax'                   => Pengaturan::get('fax'),
            'kode_pos'              => Pengaturan::get('kode_pos'),
            'email'                 => Pengaturan::get('email'),
            'website'               => Pengaturan::get('website'),
            'tanggal_surat'         => Pengaturan::get('tanggal_surat', date('Y-m-d')),
            'tahun_ajaran'          => Pengaturan::get('tahun_ajaran', '2025/2026'),
            'nomor_surat'           => Pengaturan::get('nomor_surat'),
            'versi_surat'           => Pengaturan::get('versi_surat', 'lengkap'),
            
            // Header
            'header_baris_1'        => Pengaturan::get('header_baris_1', 'KEMENTERIAN AGAMA REPUBLIK INDONESIA'),
            'header_baris_2'        => Pengaturan::get('header_baris_2'),
            'logo_kiri'             => $this->encodeImageToBase64($this->resolveImagePath(Pengaturan::get('logo_kiri'))) ?: $this->encodeImageToBase64(public_path('assets/images/logo-kemenag.png')),
            'logo_kanan'            => $this->encodeImageToBase64($this->resolveImagePath(Pengaturan::get('logo_kanan'))) ?: $this->encodeImageToBase64(public_path('assets/images/logo.png')),

            // Content
            'judul_lulus'           => Pengaturan::get('judul_lulus', 'SURAT KETERANGAN LULUS'),
            'judul_tidak_lulus'     => Pengaturan::get('judul_tidak_lulus', 'SURAT KETERANGAN TIDAK LULUS'),
            'teks_pembuka'          => Pengaturan::get('teks_pembuka', 'Yang bertanda tangan di bawah ini, Kepala ${nama_lembaga}, dengan ini menerangkan bahwa siswa berikut:'),
            'label_lulus'           => Pengaturan::get('label_lulus', 'LULUS'),
            'label_tidak_lulus'     => Pengaturan::get('label_tidak_lulus', 'TIDAK LULUS'),
            'redaksi_lulus'         => Pengaturan::get('redaksi_lulus', "Dinyatakan **LULUS** dari satuan pendidikan \${nama_lembaga} pada Tahun Pelajaran \${tahun_ajaran} berdasarkan kriteria kelulusan yang telah ditetapkan. Surat keterangan ini dapat digunakan sampai diterbitkannya ijazah asli."),
            'redaksi_tidak_lulus'   => Pengaturan::get('redaksi_tidak_lulus', "Dinyatakan **TIDAK LULUS** dari satuan pendidikan \${nama_lembaga} pada Tahun Pelajaran \${tahun_ajaran} berdasarkan kriteria kelulusan yang telah ditetapkan."),
            'teks_penutup'          => Pengaturan::get('teks_penutup', 'Demikian surat keterangan ini diberikan agar dapat dipergunakan sebagaimana mestinya.'),

            // Signatory
            'nama_kepala_sekolah'   => Pengaturan::get('nama_kepala_sekolah'),
            'nip_kepala_sekolah'    => Pengaturan::get('nip_kepala_sekolah'),
            'jabatan_penandatangan' => Pengaturan::get('jabatan_penandatangan', 'Kepala ${nama_lembaga}'),
            'ttd_kepala_sekolah'    => $this->encodeImageToBase64($this->resolveImagePath(Pengaturan::get('ttd_kepala_sekolah'))),
            'stempel_sekolah'       => $this->encodeImageToBase64($this->resolveImagePath(Pengaturan::get('stempel_sekolah'))),

            // Footer
            'footer_teks'           => Pengaturan::get('footer_teks', 'Dokumen ini diterbitkan secara resmi oleh Sistem Informasi Kelulusan'),
        ];

        $siswa = Siswa::first() ?: new Siswa([
            'nama_lengkap'     => 'CONTOH NAMA SISWA',
            'nisn'             => '1234567890',
            'nis'              => '2024/001',
            'kelas'            => 'XII-IPA-1',
            'jurusan'          => 'IPA',
            'status_kelulusan' => 'lulus',
            'no_peserta_ujian' => '24-10-19-3-0064-0001',
            'madrasah_asal'    => $pengaturan['nama_lembaga'],
        ]);

        $status = $siswa->status_kelulusan;
        $tanggalCetak = Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y');

        // Generate Dummy QR Code for Preview
        $renderer = new ImageRenderer(
            new RendererStyle(100, 0, null, null, Fill::uniformColor(new Gray(100), new Rgb(30, 132, 73))),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeSvg = $writer->writeString(route('kelulusan.index'));

        $pdf = Pdf::loadView('pdf.surat-kelulusan', [
            'siswa'        => $siswa,
            'pengaturan'   => $pengaturan,
            'status'       => $status,
            'tanggalCetak' => $tanggalCetak,
            'qrCodeSvg'    => $qrCodeSvg,
        ])
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled'      => true,
            'defaultFont'          => 'Arial',
        ]);

        return $pdf->stream('Preview_SKL.pdf');
    }
}
