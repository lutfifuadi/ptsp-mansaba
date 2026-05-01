@php
    use Carbon\Carbon;

    $isLulus = $status === 'lulus';
    
    $nama_lembaga = $pengaturan['nama_lembaga'];
    $alamat_lembaga = $pengaturan['alamat_lembaga'];
    $tahun_pelajaran = $pengaturan['tahun_ajaran'];
    
    // Header Text Config
    $header1 = $pengaturan['header_baris_1'];
    $header2 = $pengaturan['header_baris_2'] ?: mb_strtoupper($nama_lembaga);
    
    // Titles & Labels Config
    $judulDokumen = $isLulus ? $pengaturan['judul_lulus'] : $pengaturan['judul_tidak_lulus'];
    // Hapus frasa yang diminta
    $judulDokumen = str_ireplace(' DAN NILAI IJAZAH', '', $judulDokumen);
    $labelStatus = $isLulus ? $pengaturan['label_lulus'] : $pengaturan['label_tidak_lulus'];
    
    // Replace placeholders in texts
    $replaceMap = [
        '${nama_lembaga}' => $nama_lembaga,
        '${tahun_ajaran}' => $tahun_pelajaran,
    ];
    
    // Signatory Config
    $namaKepala = $pengaturan['nama_kepala_sekolah'];
    $nipKepala = $pengaturan['nip_kepala_sekolah'];
    $ttdSrc = $pengaturan['ttd_kepala_sekolah'];
    $stempelSrc = $pengaturan['stempel_sekolah'];
    $jabatanTTD = str_replace(array_keys($replaceMap), array_values($replaceMap), $pengaturan['jabatan_penandatangan']);
    
    // Logos Config
    $logoLeft = $pengaturan['logo_kiri'];
    $logoRight = $pengaturan['logo_kanan'];

    $kotaLembaga = $pengaturan['kabupaten_kota'] ?: 'Kota Bandung';
    
    // Format Tanggal Surat dari Pengaturan
    $tanggalCetak = Carbon::parse($pengaturan['tanggal_surat'] ?? date('Y-m-d'))->locale('id')->translatedFormat('d F Y');
@endphp
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>{{ $judulDokumen }} – {{ $siswa->nama_lengkap ?? 'Siswa' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        html,
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #1a1a1a;
            line-height: 1.45;
            margin: 3mm 5mm;
            padding: 0;
        }

        body {
            padding: 20px;
        }

        /* ---- KOP ---- */
        .kop-wrap {
            width: 100%;
            box-sizing: border-box;
            border-bottom: 3px double #1a1a1a;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }

        /* ---- JUDUL ---- */
        .doc-title-wrap {
            text-align: center;
            margin: 10px 0 6px;
        }

        /* ---- DATA TABLE ---- */
        .table-wrapper {
            border: 1px solid #dde5ef;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 12px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
        }

        .data-table td {
            padding: 4px 8px;
            vertical-align: top;
        }

        .data-table td.label {
            width: 38%;
            font-weight: bold;
            color: #333;
        }

        .data-table td.sep {
            width: 4%;
            text-align: center;
        }

        .data-table td.value {
            width: 58%;
        }

        .data-table tr.odd td {
            background: rgba(247, 249, 252, 0.6);
        }

        .data-table tr.even td {
            background: transparent;
        }

        .data-table tr td {
            border-bottom: 1px solid #dde5ef;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-section-head {
            background: #1e8449;
            color: #fff;
            font-weight: bold;
            font-size: 8.5pt;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 5px 10px;
            margin: 15px 0 5px;
            border-radius: 4px;
        }

        /* ---- TEKS KETERANGAN ---- */
        .keterangan-box {
            font-size: 9.5pt;
            line-height: 1.8;
            margin: 10px 0;
            text-align: justify;
        }

        /* ---- TTD ---- */
        .ttd-wrap {
            margin-top: 20px;
            text-align: right;
        }

        .ttd-inner {
            display: inline-block;
            width: 250px;
            text-align: center;
        }

        .ttd-space {
            height: 80px;
            display: block;
        }

        /* ---- FOOTER ---- */
        .doc-footer {
            margin-top: 16px;
            font-size: 7.5pt;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 5px;
            text-align: center;
        }

        /* ---- NOMOR BOX ---- */
        .nomor-box {
            border: 2px solid #1a4a80;
            background: #f0f5ff;
            padding: 5px 14px;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>

<body>

    {{-- ── WATERMARK (LOGO SEKOLAH) ── --}}
    @if ($logoRight)
        <div
            style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 350px; z-index: -1000; opacity: 0.1; text-align: center;">
            <img src="{{ $logoRight }}" style="width: 100%; height: auto;" alt="Watermark">
        </div>
    @endif

    <div class="kop-wrap">
        <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
            <tr>
                {{-- Logo Kiri --}}
                <td style="width:35px; text-align:left; vertical-align:middle; padding:0;">
                    @if ($logoLeft)
                        <img src="{{ $logoLeft }}" style="max-width:115px; max-height:115px; display:inline-block;"
                            alt="Logo Left">
                    @endif
                </td>

                {{-- Teks Tengah --}}
                <td style="text-align:center; vertical-align:middle; padding:0;">
                    <div style="font-size:11pt; text-transform:uppercase; font-weight:bold; white-space:nowrap;">
                        {{ $header1 ?: 'KEMENTERIAN AGAMA REPUBLIK INDONESIA' }}
                    </div>
                    <div style="font-size:11pt; text-transform:uppercase; font-weight:bold; margin-top:1px; white-space:nowrap;">
                        {{ $header2 ?: 'KANTOR KEMENTERIAN AGAMA KOTA BANDUNG' }}
                    </div>
                    <div style="font-size:14pt; font-weight:bold; text-transform:uppercase; margin-top:2px; white-space:nowrap;">
                        {{ $nama_lembaga }}
                    </div>
                    <div style="font-size:8pt; margin-top:3px; white-space:nowrap;">
                        {{ $alamat_lembaga }}
                    </div>
                    <div style="font-size:8pt; margin-top:1px; white-space:nowrap;">
                        Telp. {{ $pengaturan['telepon'] ?: '—' }} @if($pengaturan['fax']) Fax. {{ $pengaturan['fax'] }} @endif @if($pengaturan['kode_pos']) KP {{ $pengaturan['kode_pos'] }} @endif | {{ $pengaturan['email'] ?: '—' }} | {{ $pengaturan['website'] ?: '—' }}
                    </div>
                </td>

                {{-- Logo Kanan --}}
                <td style="width:35px; text-align:right; vertical-align:middle; padding:0;">
                    @if ($logoRight)
                        <img src="{{ $logoRight }}" style="max-width:115px; max-height:115px; display:inline-block;"
                            alt="Logo Right">
                    @endif
                </td>
            </tr>
        </table>
    </div>

    {{-- ── JUDUL & SUBTITLE ── --}}
    <div class="doc-title-wrap">
        <div style="font-size:14pt; font-weight:bold; text-transform:uppercase; text-decoration: underline;">
            {{ $judulDokumen }}
        </div>
        <div style="font-size:12pt; font-weight:bold; text-transform:uppercase; margin-top: 2px;">
            {{ $nama_lembaga }}
        </div>
        <div style="margin-top: 0;">
            <div style="font-size:11pt; font-weight:bold; text-transform:uppercase;">
                TAHUN AJARAN {{ $tahun_pelajaran }}
            </div>
            <div style="font-size:11pt; font-weight:bold; margin-top: 2px;">
                Nomor : {{ $pengaturan['nomor_surat'] ?: '0001/Ma.10.19.0064/PP.01.1/'.date('Y') }}
            </div>
        </div>
    </div>

    <div class="keterangan-box">
        Yang bertanda tangan di bawah ini, Kepala <strong>{{ $nama_lembaga }}</strong> :
    </div>

    {{-- ── DATA LEMBAGA ── --}}
    <div class="table-wrapper">
        <table class="data-table">
            <tr>
                <td class="label">NPSN Madrasah</td>
                <td class="sep">:</td>
                <td class="value">{{ $pengaturan['npsn'] ?: '—' }}</td>
            </tr>
            <tr>
                <td class="label">Kabupaten/Kota</td>
                <td class="sep">:</td>
                <td class="value">{{ $kotaLembaga }}</td>
            </tr>
            <tr>
                <td class="label">Provinsi</td>
                <td class="sep">:</td>
                <td class="value">{{ $pengaturan['provinsi'] ?: 'Jawa Barat' }}</td>
            </tr>
        </table>
    </div>

    <div class="keterangan-box" style="margin: 5px 0;">
        Menerangkan bahwa :
    </div>

    {{-- ── DATA SISWA ── --}}
    <div class="data-section-head">Data Peserta Didik</div>
    <div class="table-wrapper">
        <table class="data-table">
            <tr class="odd">
                <td class="label">Nama Lengkap</td>
                <td class="sep">:</td>
                <td class="value"><strong>{{ strtoupper($siswa->nama_lengkap) }}</strong></td>
            </tr>
            <tr class="even">
                <td class="label">NISN</td>
                <td class="sep">:</td>
                <td class="value">{{ $siswa->nisn ?: '—' }}</td>
            </tr>
            <tr class="odd">
                <td class="label">NIS (Nomor Induk Sekolah)</td>
                <td class="sep">:</td>
                <td class="value">{{ $siswa->nis ?: '—' }}</td>
            </tr>
            <tr class="even">
                <td class="label">Nomor Peserta</td>
                <td class="sep">:</td>
                <td class="value">{{ $siswa->no_peserta ?: '—' }}</td>
            </tr>
            <tr class="odd">
                <td class="label">Madrasah Asal</td>
                <td class="sep">:</td>
                <td class="value">{{ $siswa->madrasah_asal ?: $nama_lembaga }}</td>
            </tr>
        </table>
    </div>

    <div class="keterangan-box">
        Dinyatakan <strong>{{ $isLulus ? 'LULUS' : 'TIDAK LULUS' }}</strong> dari satuan pendidikan berdasarkan kriteria kelulusan <strong>{{ $nama_lembaga }}</strong> Tahun Ajaran <strong>{{ $tahun_pelajaran }}</strong>.
    </div>

    <div class="keterangan-box" style="margin-top: 0;">
        Demikian surat keterangan ini diberikan agar dapat dipergunakan sebagaimana mestinya.
    </div>


    {{-- ── TTD & QR CODE ── --}}
    <div style="margin-top: 20px;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                {{-- QR Code di sebelah kiri --}}
                <td style="width: 45%; vertical-align: bottom; text-align: left; padding-left: 20px;">
                    @if (isset($qrCodeSvg))
                        <div style="border: 1px solid #1e8449; border-radius: 6px; background-color: #f0fff4; padding: 10px; display: inline-block; width: 120px; text-align: center;">
                            <div style="font-size: 7pt; font-weight: bold; color: #1e8449; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 2px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                E-Verified
                            </div>
                            <img src="data:image/svg+xml;base64,{{ base64_encode($qrCodeSvg) }}" style="width: 100px; height: 100px; display: block; margin: 0 auto;" alt="QR Verification">
                            <div style="font-size: 6pt; color: #1e8449; margin-top: 5px; font-style: italic; line-height: 1.2;">
                                Pindai untuk verifikasi<br>keaslian dokumen.
                            </div>
                        </div>
                    @endif
                </td>

                {{-- TTD di sebelah kanan --}}
                <td style="width: 60%; vertical-align: top; text-align: right;">
                    <div class="ttd-inner" style="position: relative; display: inline-block; width: 250px; text-align: center;">
                        <div style="font-size:9pt;">{{ $kotaLembaga }}, {{ $tanggalCetak }}</div>
                        <div style="font-size:8.5pt; margin-top:2px;">{{ $jabatanTTD }},</div>

                        {{-- TTD Kepala Sekolah --}}
                        @if ($ttdSrc)
                            <div style="height: 80px; display: flex; align-items: center; justify-content: center; overflow: visible;">
                                <img src="{{ $ttdSrc }}" style="max-height: 115px; max-width: 420px; display: block; margin-top: -15px;" alt="TTD">
                            </div>
                        @else
                            <span class="ttd-space"></span>
                        @endif

                        <div style="font-size:9.5pt; font-weight:bold; text-decoration: underline; white-space: nowrap;">
                            {{ $namaKepala ?: '..........................................' }}</div>
                        <div style="font-size:9pt;">NIP. {{ $nipKepala ?: '..........................................' }}</div>

                        {{-- Stempel --}}
                        @if ($stempelSrc)
                            <div style="position: absolute; left: -45px; top: 10px; z-index: 50; opacity: 1;">
                                <img src="{{ $stempelSrc }}" style="max-width: 140px; max-height: 140px;" alt="Stempel">
                            </div>
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ── FOOTER ── --}}
    <div class="doc-footer">
        Dicetak pada: {{ $tanggalCetak }} &nbsp;|&nbsp;
        {{ $pengaturan['footer_teks'] }} &nbsp;|&nbsp;
        Nomor: {{ $pengaturan['nomor_surat'] ?: 'SKL/'.$siswa->nisn.'/'.date('Y') }}
    </div>

</body>

</html>
