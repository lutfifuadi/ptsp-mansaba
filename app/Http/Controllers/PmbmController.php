<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\CalonMurid;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\HandlesPdfImages;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Color\Gray;
use BaconQrCode\Writer;

class PmbmController extends Controller
{
    use HandlesPdfImages;

    public function index()
    {
        $tanggalPengumuman = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            Pengaturan::get('pmbm_tanggal_pengumuman', '2026-05-04 00:00:00'),
            'Asia/Jakarta'
        );

        $sudahDibuka = Carbon::now('Asia/Jakarta')->gte($tanggalPengumuman);

        return view('pmbm.cek', compact('sudahDibuka', 'tanggalPengumuman'));
    }

    public function cek(Request $request)
    {
        $tanggalPengumuman = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            Pengaturan::get('pmbm_tanggal_pengumuman', '2026-05-04 00:00:00'),
            'Asia/Jakarta'
        );

        if (Carbon::now('Asia/Jakarta')->lt($tanggalPengumuman)) {
            return redirect()->route('pmbm.index');
        }

        $request->validate([
            'no_pendaftaran' => ['required', 'string'],
        ], [
            'no_pendaftaran.required' => 'Nomor Pendaftaran wajib diisi.',
        ]);

        $calon = CalonMurid::where('no_pendaftaran', $request->no_pendaftaran)->first();

        if (!$calon) {
            return back()->withInput()->withErrors([
                'no_pendaftaran' => 'Nomor Pendaftaran tidak ditemukan. Pastikan data yang Anda masukkan benar.',
            ]);
        }

        // Simpan ke session untuk mengizinkan download PDF
        session(['last_checked_pmbm' => $calon->no_pendaftaran]);

        return view('pmbm.hasil', compact('calon'));
    }

    public function downloadPdf(string $no_pendaftaran)
    {
        $tanggalPengumuman = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            Pengaturan::get('pmbm_tanggal_pengumuman', '2026-05-04 00:00:00'),
            'Asia/Jakarta'
        );

        if (Carbon::now('Asia/Jakarta')->lt($tanggalPengumuman)) {
            abort(403, 'Pengumuman belum dibuka.');
        }

        if (session('last_checked_pmbm') !== $no_pendaftaran) {
            return redirect()->route('pmbm.index')->withErrors([
                'no_pendaftaran' => 'Silakan masukkan Nomor Pendaftaran Anda terlebih dahulu.',
            ]);
        }

        $calon = CalonMurid::where('no_pendaftaran', $no_pendaftaran)->firstOrFail();

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
            
            // Header
            'header_baris_1'        => Pengaturan::get('header_baris_1', 'KEMENTERIAN AGAMA REPUBLIK INDONESIA'),
            'header_baris_2'        => Pengaturan::get('header_baris_2'),
            'logo_kiri'             => $this->encodeImageToBase64($this->resolveImagePath(Pengaturan::get('logo_kiri'))) ?: $this->encodeImageToBase64(public_path('assets/images/logo-kemenag.png')),
            'logo_kanan'            => $this->encodeImageToBase64($this->resolveImagePath(Pengaturan::get('logo_kanan'))) ?: $this->encodeImageToBase64(public_path('assets/images/logo.png')),

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
            'ttd_kepala_sekolah'    => $this->encodeImageToBase64($this->resolveImagePath(Pengaturan::get('ttd_kepala_sekolah'))),
            'stempel_sekolah'       => $this->encodeImageToBase64($this->resolveImagePath(Pengaturan::get('stempel_sekolah'))),

            // Footer
            'footer_teks'           => Pengaturan::get('footer_teks', 'Dokumen ini diterbitkan secara resmi oleh Sistem Informasi Kelulusan'),
        ];

        $status = strtolower($calon->status_kelulusan);
        $tanggalCetak = Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y');

        try {
            // Kita pakai view yang sama 'pdf.surat-kelulusan' karena logic-nya sudah generic menggunakan data $siswa
            // Kita bungkus $calon ke dalam object yang mirip $siswa agar view tidak error
            $siswaMock = (object) [
                'nama_lengkap'     => $calon->nama_lengkap,
                'nisn'             => $calon->nisn,
                'nis'              => $calon->no_pendaftaran, // No Pendaftaran dipetakan ke NIS
                'no_peserta'       => $calon->no_pendaftaran,
                'kelas'            => '-',
                'jurusan'          => $calon->jalur_pendaftaran,
                'madrasah_asal'    => $calon->asal_sekolah,
                'status_kelulusan' => $status,
                'tipe_kelulusan'   => 'PMBM',
            ];

            $pdf = Pdf::loadView('pdf.surat-kelulusan', [
                'siswa'        => $siswaMock,
                'pengaturan'   => $pengaturan,
                'status'       => $status,
                'tanggalCetak' => $tanggalCetak,
                'qrCodeSvg'    => null, // PMBM mungkin belum ada QR validasi otomatis
                'validationUrl'=> null,
            ])
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => false,
                'defaultFont'          => 'Arial',
            ]);

            return $pdf->download('Hasil_Seleksi_PMBM_' . $calon->no_pendaftaran . '.pdf');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('[PmbmController] PDF generation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghasilkan PDF. Silakan coba lagi.');
        }
    }
}
