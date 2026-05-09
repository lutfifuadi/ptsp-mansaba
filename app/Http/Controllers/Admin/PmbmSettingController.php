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

class PmbmSettingController extends Controller
{
    use HandlesPdfImages;
    public function index()
    {
        $pengaturan = [
            'pmbm_tanggal_pengumuman' => Pengaturan::get('pmbm_tanggal_pengumuman', '2026-05-04 00:00:00'),
            'pmbm_judul_lulus'        => Pengaturan::get('pmbm_judul_lulus', 'SURAT KETERANGAN LULUS SELEKSI'),
            'pmbm_judul_tidak_lulus'  => Pengaturan::get('pmbm_judul_tidak_lulus', 'SURAT KETERANGAN TIDAK LULUS SELEKSI'),
            'pmbm_teks_pembuka'       => Pengaturan::get('pmbm_teks_pembuka', 'Yang bertanda tangan di bawah ini, Kepala ${nama_lembaga}, dengan ini menerangkan bahwa calon siswa berikut:'),
            'pmbm_label_lulus'        => Pengaturan::get('pmbm_label_lulus', 'LULUS SELEKSI'),
            'pmbm_label_tidak_lulus'  => Pengaturan::get('pmbm_label_tidak_lulus', 'TIDAK LULUS SELEKSI'),
            'pmbm_redaksi_lulus'      => Pengaturan::get('pmbm_redaksi_lulus', "Dinyatakan **LULUS SELEKSI** Penerimaan Murid Baru Madrasah pada Tahun Pelajaran \${tahun_ajaran} berdasarkan kriteria seleksi yang telah ditetapkan."),
            'pmbm_redaksi_tidak_lulus' => Pengaturan::get('pmbm_redaksi_tidak_lulus', "Dinyatakan **TIDAK LULUS SELEKSI** Penerimaan Murid Baru Madrasah pada Tahun Pelajaran \${tahun_ajaran}."),
            'pmbm_teks_penutup'       => Pengaturan::get('pmbm_teks_penutup', 'Demikian surat keterangan ini diberikan agar dapat dipergunakan sebagaimana mestinya.'),
        ];

        return view('content.pages.admin.pengaturan.pmbm', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'pmbm_tanggal_pengumuman' => ['required', 'date_format:Y-m-d\TH:i'],
            'pmbm_judul_lulus'        => ['required', 'string', 'max:255'],
            'pmbm_judul_tidak_lulus'  => ['required', 'string', 'max:255'],
            'pmbm_teks_pembuka'       => ['required', 'string'],
            'pmbm_label_lulus'        => ['required', 'string', 'max:50'],
            'pmbm_label_tidak_lulus'  => ['required', 'string', 'max:50'],
            'pmbm_redaksi_lulus'      => ['required', 'string'],
            'pmbm_redaksi_tidak_lulus' => ['required', 'string'],
            'pmbm_teks_penutup'       => ['required', 'string'],
        ]);

        $fields = [
            'pmbm_judul_lulus', 'pmbm_judul_tidak_lulus', 'pmbm_teks_pembuka', 'pmbm_label_lulus', 'pmbm_label_tidak_lulus',
            'pmbm_redaksi_lulus', 'pmbm_redaksi_tidak_lulus', 'pmbm_teks_penutup'
        ];

        foreach ($fields as $field) {
            Pengaturan::set($field, $request->get($field));
        }

        $tanggal = Carbon::createFromFormat('Y-m-d\TH:i', $request->pmbm_tanggal_pengumuman, 'Asia/Jakarta');
        Pengaturan::set('pmbm_tanggal_pengumuman', $tanggal->format('Y-m-d H:i:s'));

        return redirect()->back()->with('success', 'Pengaturan PMBM berhasil disimpan.');
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
            'ttd_kepala_sekolah'    => $this->encodeImageToBase64($this->resolveImagePath(Pengaturan::get('ttd_kepala_sekolah'))),
            'stempel_sekolah'       => $this->encodeImageToBase64($this->resolveImagePath(Pengaturan::get('stempel_sekolah'))),

            // Content PMBM
            'judul_lulus'           => Pengaturan::get('pmbm_judul_lulus', 'SURAT KETERANGAN LULUS SELEKSI'),
            'judul_tidak_lulus'     => Pengaturan::get('pmbm_judul_tidak_lulus', 'SURAT KETERANGAN TIDAK LULUS SELEKSI'),
            'teks_pembuka'          => Pengaturan::get('pmbm_teks_pembuka', 'Yang bertanda tangan di bawah ini, Kepala ${nama_lembaga}, dengan ini menerangkan bahwa calon siswa berikut:'),
            'label_lulus'           => Pengaturan::get('pmbm_label_lulus', 'LULUS SELEKSI'),
            'label_tidak_lulus'     => Pengaturan::get('pmbm_label_tidak_lulus', 'TIDAK LULUS SELEKSI'),
            'redaksi_lulus'         => Pengaturan::get('pmbm_redaksi_lulus', "Dinyatakan **LULUS SELEKSI** Penerimaan Murid Baru Madrasah pada Tahun Pelajaran \${tahun_ajaran} berdasarkan kriteria seleksi yang telah ditetapkan."),
            'redaksi_tidak_lulus'   => Pengaturan::get('pmbm_redaksi_tidak_lulus', "Dinyatakan **TIDAK LULUS SELEKSI** Penerimaan Murid Baru Madrasah pada Tahun Pelajaran \${tahun_ajaran}."),
            'teks_penutup'          => Pengaturan::get('pmbm_teks_penutup', 'Demikian surat keterangan ini diberikan agar dapat dipergunakan sebagaimana mestinya.'),

            // Signatory
            'nama_kepala_sekolah'   => Pengaturan::get('nama_kepala_sekolah'),
            'nip_kepala_sekolah'    => Pengaturan::get('nip_kepala_sekolah'),
            'jabatan_penandatangan' => Pengaturan::get('jabatan_penandatangan', 'Kepala ${nama_lembaga}'),

            // Footer
            'footer_teks'           => Pengaturan::get('footer_teks', 'Dokumen ini diterbitkan secara resmi oleh Sistem Informasi Kelulusan'),
        ];

        $siswa = Siswa::where('tipe_kelulusan', 'PMBM')->first() ?: new Siswa([
            'nama_lengkap'     => 'CONTOH NAMA CALON SISWA',
            'nisn'             => '9988776655',
            'nis'              => '2024/PMBM/001',
            'kelas'            => '-',
            'jurusan'          => 'IPA',
            'status_kelulusan' => 'lulus',
            'tipe_kelulusan'   => 'PMBM',
            'no_peserta_ujian' => 'PMBM-2024-001',
            'madrasah_asal'    => 'SMP NEGERI CONTOH',
        ]);

        $status = $siswa->status_kelulusan;
        $tanggalCetak = Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y');

        // Generate Dummy QR Code for Preview
        $siswa->validation_token = $siswa->validation_token ?? 'preview-pmbm-token-123';
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

        return $pdf->stream('Preview_PMBM.pdf');
    }
}
