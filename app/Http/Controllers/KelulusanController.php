<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\Siswa;
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

class KelulusanController extends Controller
{
    use HandlesPdfImages;
    public function index()
    {
        return view('kelulusan.cek');
    }

    public function showForm()
    {
        $tanggalPengumuman = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            Pengaturan::get('tanggal_pengumuman', '2026-05-04 00:00:00'),
            'Asia/Jakarta'
        );

        $sudahDibuka = Carbon::now('Asia/Jakarta')->gte($tanggalPengumuman);

        return view('kelulusan.form', compact('sudahDibuka', 'tanggalPengumuman'));
    }

    public function cek(Request $request)
    {
        $tanggalPengumuman = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            Pengaturan::get('tanggal_pengumuman', '2026-05-04 00:00:00'),
            'Asia/Jakarta'
        );

        if (Carbon::now('Asia/Jakarta')->lt($tanggalPengumuman)) {
            return redirect()->route('kelulusan.index');
        }

        $request->validate([
            'nisn' => ['required', 'digits:10'],
        ], [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.digits'   => 'NISN harus terdiri dari 10 digit angka.',
        ]);

        $siswa = Siswa::where('nisn', $request->nisn)->first();

        if (!$siswa) {
            return back()->withInput()->withErrors([
                'nisn' => 'NISN tidak ditemukan. Pastikan NISN yang Anda masukkan benar.',
            ]);
        }

        // Generate validation token untuk siswa lulus (jika belum ada)
        $siswa->generateValidationToken();

        // Simpan NISN ke session untuk mengizinkan download PDF
        session(['last_checked_nisn' => $siswa->nisn]);

        return view('kelulusan.hasil', compact('siswa'));
    }

    public function downloadPdf(string $nisn)
    {
        $tanggalPengumuman = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            Pengaturan::get('tanggal_pengumuman', '2026-05-04 00:00:00'),
            'Asia/Jakarta'
        );

        if (Carbon::now('Asia/Jakarta')->lt($tanggalPengumuman)) {
            abort(403, 'Pengumuman belum dibuka.');
        }

        // Proteksi: Pastikan user sudah melakukan cek NISN melalui form
        if (session('last_checked_nisn') !== $nisn) {
            return redirect()->route('kelulusan.index')->withErrors([
                'nisn' => 'Silakan masukkan NISN Anda terlebih dahulu untuk mengunduh surat.',
            ]);
        }

        $siswa = Siswa::where('nisn', $nisn)->firstOrFail();

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
            'judul_lulus'           => Pengaturan::get($siswa->tipe_kelulusan === 'PMBM' ? 'pmbm_judul_lulus' : 'judul_lulus', 'SURAT KETERANGAN LULUS'),
            'judul_tidak_lulus'     => Pengaturan::get($siswa->tipe_kelulusan === 'PMBM' ? 'pmbm_judul_tidak_lulus' : 'judul_tidak_lulus', 'SURAT KETERANGAN TIDAK LULUS'),
            'teks_pembuka'          => Pengaturan::get($siswa->tipe_kelulusan === 'PMBM' ? 'pmbm_teks_pembuka' : 'teks_pembuka', 'Yang bertanda tangan di bawah ini, Kepala ${nama_lembaga}, dengan ini menerangkan bahwa siswa berikut:'),
            'label_lulus'           => Pengaturan::get($siswa->tipe_kelulusan === 'PMBM' ? 'pmbm_label_lulus' : 'label_lulus', 'LULUS'),
            'label_tidak_lulus'     => Pengaturan::get($siswa->tipe_kelulusan === 'PMBM' ? 'pmbm_label_tidak_lulus' : 'label_tidak_lulus', 'TIDAK LULUS'),
            'redaksi_lulus'         => Pengaturan::get($siswa->tipe_kelulusan === 'PMBM' ? 'pmbm_redaksi_lulus' : 'redaksi_lulus', "Dinyatakan **LULUS** dari satuan pendidikan \${nama_lembaga} pada Tahun Pelajaran \${tahun_ajaran} berdasarkan kriteria kelulusan yang telah ditetapkan. Surat keterangan ini dapat digunakan sampai diterbitkannya ijazah asli."),
            'redaksi_tidak_lulus'   => Pengaturan::get($siswa->tipe_kelulusan === 'PMBM' ? 'pmbm_redaksi_tidak_lulus' : 'redaksi_tidak_lulus', "Dinyatakan **TIDAK LULUS** dari satuan pendidikan \${nama_lembaga} pada Tahun Pelajaran \${tahun_ajaran} berdasarkan kriteria kelulusan yang telah ditetapkan."),
            'teks_penutup'          => Pengaturan::get($siswa->tipe_kelulusan === 'PMBM' ? 'pmbm_teks_penutup' : 'teks_penutup', 'Demikian surat keterangan ini diberikan agar dapat dipergunakan sebagaimana mestinya.'),

            // Signatory
            'nama_kepala_sekolah'   => Pengaturan::get('nama_kepala_sekolah'),
            'nip_kepala_sekolah'    => Pengaturan::get('nip_kepala_sekolah'),
            'jabatan_penandatangan' => Pengaturan::get('jabatan_penandatangan', 'Kepala ${nama_lembaga}'),
            'ttd_kepala_sekolah'    => $this->encodeImageToBase64($this->resolveImagePath(Pengaturan::get('ttd_kepala_sekolah'))),
            'stempel_sekolah'       => $this->encodeImageToBase64($this->resolveImagePath(Pengaturan::get('stempel_sekolah'))),

            // Footer
            'footer_teks'           => Pengaturan::get('footer_teks', 'Dokumen ini diterbitkan secara resmi oleh Sistem Informasi Kelulusan'),
        ];

        $status = $siswa->status_kelulusan;
        $tanggalCetak = Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y');

        try {
            // Generate QR Code for Validation
            $validationUrl = route('kelulusan.validasi', ['token' => $siswa->validation_token]);
            $renderer = new ImageRenderer(
                new RendererStyle(100, 0, null, null, Fill::uniformColor(new Gray(100), new Rgb(30, 132, 73))),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $qrCodeSvg = $writer->writeString($validationUrl);

            $pdf = Pdf::loadView('pdf.surat-kelulusan', [
                'siswa'        => $siswa,
                'pengaturan'   => $pengaturan,
                'status'       => $status,
                'tanggalCetak' => $tanggalCetak,
                'qrCodeSvg'    => $qrCodeSvg,
                'validationUrl'=> $validationUrl,
            ])
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => false,
                'defaultFont'          => 'Arial',
            ]);

            return $pdf->download('Surat_Kelulusan_' . $siswa->nisn . '.pdf');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('[KelulusanController] PDF generation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghasilkan PDF. Silakan coba lagi.');
        }
    }

    /**
     * Halaman validasi publik — diakses melalui QR Code.
     * Menampilkan informasi kelulusan berdasarkan token unik.
     */
    public function validasi(string $token)
    {
        $siswa = Siswa::where('validation_token', $token)
            ->where('status_kelulusan', 'lulus')
            ->first();

        if (!$siswa) {
            abort(404, 'Token validasi tidak valid atau siswa tidak ditemukan.');
        }

        $pengaturan = [
            'nama_lembaga'        => Pengaturan::get('nama_lembaga', 'NAMA SEKOLAH'),
            'tahun_ajaran'        => Pengaturan::get('tahun_ajaran', '2025/2026'),
            'tanggal_surat'       => Pengaturan::get('tanggal_surat', date('Y-m-d')),
            'npsn'                => Pengaturan::get('npsn'),
            'alamat_lembaga'      => Pengaturan::get('alamat_lembaga'),
            'kabupaten_kota'      => Pengaturan::get('kabupaten_kota'),
            'provinsi'            => Pengaturan::get('provinsi'),
            'telepon'             => Pengaturan::get('telepon'),
            'email'               => Pengaturan::get('email'),
            'website'             => Pengaturan::get('website'),
            'header_baris_1'      => Pengaturan::get('header_baris_1'),
            'logo_kiri'           => Pengaturan::get('logo_kiri'),
            'logo_kanan'          => Pengaturan::get('logo_kanan'),
            'nama_kepala_sekolah' => Pengaturan::get('nama_kepala_sekolah'),
            'nip_kepala_sekolah'  => Pengaturan::get('nip_kepala_sekolah'),
            'jabatan_penandatangan' => Pengaturan::get('jabatan_penandatangan', 'Kepala Madrasah'),
            'nomor_surat'         => Pengaturan::get('nomor_surat'),
            'footer_teks'         => Pengaturan::get('footer_teks', 'Dokumen ini diterbitkan secara resmi oleh Sistem Informasi Kelulusan'),
        ];

        return view('kelulusan.validasi', compact('siswa', 'pengaturan'));
    }
}
