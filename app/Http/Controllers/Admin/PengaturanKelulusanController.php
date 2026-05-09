<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            // XII Specific
            'tanggal_pengumuman'      => Pengaturan::get('tanggal_pengumuman', '2026-05-04 00:00:00'),
            'nomor_surat'             => Pengaturan::get('nomor_surat'),
            'versi_surat'             => Pengaturan::get('versi_surat', 'lengkap'),
            'judul_lulus'             => Pengaturan::get('judul_lulus', 'SURAT KETERANGAN LULUS'),
            'judul_tidak_lulus'       => Pengaturan::get('judul_tidak_lulus', 'SURAT KETERANGAN TIDAK LULUS'),
            'teks_pembuka'            => Pengaturan::get('teks_pembuka', 'Yang bertanda tangan di bawah ini, Kepala ${nama_lembaga}, dengan ini menerangkan bahwa siswa berikut:'),
            'label_lulus'             => Pengaturan::get('label_lulus', 'LULUS'),
            'label_tidak_lulus'       => Pengaturan::get('label_tidak_lulus', 'TIDAK LULUS'),
            'teks_penutup'            => Pengaturan::get('teks_penutup', 'Demikian surat keterangan ini diberikan agar dapat dipergunakan sebagaimana mestinya.'),
            'redaksi_lulus'           => Pengaturan::get('redaksi_lulus', "Dinyatakan **LULUS** dari satuan pendidikan \${nama_lembaga} pada Tahun Pelajaran \${tahun_ajaran} berdasarkan kriteria kelulusan yang telah ditetapkan. Surat keterangan ini dapat digunakan sampai diterbitkannya ijazah asli."),
            'redaksi_tidak_lulus'     => Pengaturan::get('redaksi_tidak_lulus', "Dinyatakan **TIDAK LULUS** dari satuan pendidikan \${nama_lembaga} pada Tahun Pelajaran \${tahun_ajaran} berdasarkan kriteria kelulusan yang telah ditetapkan."),
        ];

        return view('content.pages.admin.pengaturan.kelulusan', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tanggal_pengumuman'    => ['required', 'date_format:Y-m-d\TH:i'],
            'nomor_surat'           => ['nullable', 'string', 'max:100'],
            'judul_lulus'           => ['required', 'string', 'max:255'],
            'judul_tidak_lulus'     => ['required', 'string', 'max:255'],
            'teks_pembuka'          => ['required', 'string'],
            'label_lulus'           => ['required', 'string', 'max:50'],
            'label_tidak_lulus'     => ['required', 'string', 'max:50'],
            'redaksi_lulus'         => ['required', 'string'],
            'redaksi_tidak_lulus'   => ['required', 'string'],
            'teks_penutup'          => ['required', 'string'],
            'versi_surat'           => ['required', 'string', 'in:lengkap,tanpa_data'],
        ]);

        $fields = [
            'nomor_surat', 'judul_lulus', 'judul_tidak_lulus', 'teks_pembuka',
            'label_lulus', 'label_tidak_lulus', 'redaksi_lulus', 'redaksi_tidak_lulus',
            'teks_penutup', 'versi_surat'
        ];

        foreach ($fields as $field) {
            Pengaturan::set($field, $request->get($field));
        }

        $tanggal = Carbon::createFromFormat('Y-m-d\TH:i', $request->tanggal_pengumuman, 'Asia/Jakarta');
        Pengaturan::set('tanggal_pengumuman', $tanggal->format('Y-m-d H:i:s'));

        return redirect()->back()->with('success', 'Pengaturan Kelulusan XII berhasil disimpan.');
    }

    public function updateRedaksi(Request $request)
    {
        return $this->update($request);
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
        $siswa->validation_token = $siswa->validation_token ?? 'contoh-token-validasi-123';
        $dummyUrl = route('kelulusan.validasi', ['token' => $siswa->validation_token]);

        $renderer = new ImageRenderer(
            new RendererStyle(100, 0, null, null, Fill::uniformColor(new Gray(100), new Rgb(30, 132, 73))),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeSvg = $writer->writeString($dummyUrl);

        $pdf = Pdf::loadView('pdf.surat-kelulusan', [
            'siswa'        => $siswa,
            'pengaturan'   => $pengaturan,
            'status'       => $status,
            'tanggalCetak' => $tanggalCetak,
            'qrCodeSvg'    => $qrCodeSvg,
            'validationUrl'=> $dummyUrl,
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
