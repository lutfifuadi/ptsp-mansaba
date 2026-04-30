<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Surat Kelulusan - {{ $siswa->nama_lengkap }}</title>
  <style>
    @page {
      margin: 2cm 2.5cm;
    }
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Times New Roman', Times, serif;
      font-size: 12pt;
      color: #000;
      line-height: 1.5;
    }

    /* KOP SURAT */
    .kop {
      display: table;
      width: 100%;
      border-bottom: 3px double #000;
      padding-bottom: 10px;
      margin-bottom: 16px;
    }
    .kop-logo {
      display: table-cell;
      vertical-align: middle;
      width: 80px;
      text-align: center;
    }
    .kop-logo img {
      width: 70px;
      height: 70px;
    }
    .kop-logo .logo-placeholder {
      width: 70px;
      height: 70px;
      border: 2px solid #000;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 8pt;
      text-align: center;
      color: #555;
      margin: auto;
    }
    .kop-text {
      display: table-cell;
      vertical-align: middle;
      text-align: center;
    }
    .kop-instansi {
      font-size: 9pt;
      letter-spacing: 0.5px;
    }
    .kop-nama {
      font-size: 18pt;
      font-weight: bold;
      text-transform: uppercase;
      line-height: 1.2;
    }
    .kop-alamat {
      font-size: 9pt;
      margin-top: 2px;
    }

    /* JUDUL SURAT */
    .judul-surat {
      text-align: center;
      margin: 20px 0 6px;
    }
    .judul-surat h2 {
      font-size: 14pt;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 2px;
      text-decoration: underline;
    }
    .nomor-surat {
      text-align: center;
      font-size: 11pt;
      margin-bottom: 20px;
    }

    /* BADAN SURAT */
    .pembuka {
      text-align: justify;
      margin-bottom: 14px;
    }
    .data-siswa {
      margin: 14px 0 14px 20px;
    }
    .data-siswa table {
      border-collapse: collapse;
    }
    .data-siswa td {
      padding: 3px 6px;
      vertical-align: top;
    }
    .data-siswa td:first-child {
      width: 160px;
      font-weight: normal;
    }
    .data-siswa td:nth-child(2) {
      width: 16px;
      text-align: center;
    }
    .data-siswa td:last-child {
      font-weight: bold;
    }
    .penutup {
      text-align: justify;
      margin-bottom: 14px;
    }

    /* TANDA TANGAN */
    .ttd-section {
      display: table;
      width: 100%;
      margin-top: 30px;
    }
    .ttd-kiri {
      display: table-cell;
      width: 50%;
      vertical-align: top;
    }
    .ttd-kanan {
      display: table-cell;
      width: 50%;
      vertical-align: top;
      text-align: center;
    }
    .ttd-kanan .kota-tanggal {
      margin-bottom: 6px;
      text-align: center;
    }
    .ttd-kanan .jabatan {
      font-weight: bold;
      margin-bottom: 4px;
    }
    .ttd-gambar {
      position: relative;
      height: 90px;
      margin: 4px auto;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .ttd-gambar img.ttd {
      height: 70px;
      position: relative;
      z-index: 2;
    }
    .ttd-gambar img.stempel {
      height: 80px;
      position: absolute;
      left: 20px;
      opacity: 0.8;
      z-index: 1;
    }
    .ttd-nama {
      font-weight: bold;
      text-decoration: underline;
      text-align: center;
    }
    .ttd-nip {
      font-size: 10pt;
      text-align: center;
    }

    /* FOOTER */
    .footer-surat {
      margin-top: 30px;
      border-top: 1px solid #666;
      padding-top: 6px;
      font-size: 9pt;
      color: #666;
      text-align: center;
    }
  </style>
</head>
<body>

  {{-- KOP SURAT --}}
  <div class="kop">
    <div class="kop-logo">
      <div class="logo-placeholder">LOGO</div>
    </div>
    <div class="kop-text">
      <div class="kop-instansi">KEMENTERIAN AGAMA REPUBLIK INDONESIA</div>
      <div class="kop-nama">Madrasah Aliyah Negeri 1 Kota Bandung</div>
      <div class="kop-alamat">Jl. H. Alpi No. 40, Cijerah, Bandung Kulon, Kota Bandung 40212</div>
      <div class="kop-alamat">Telp. (022) 6030138 | Website: man1kotabandung.sch.id</div>
    </div>
  </div>

  {{-- JUDUL --}}
  <div class="judul-surat">
    <h2>Surat Keterangan Lulus</h2>
  </div>
  @if($pengaturan['nomor_surat'])
  <div class="nomor-surat">Nomor: {{ $pengaturan['nomor_surat'] }}</div>
  @endif

  {{-- BADAN --}}
  <div class="pembuka">
    Yang bertanda tangan di bawah ini, Kepala Madrasah Aliyah Negeri 1 Kota Bandung, dengan ini menerangkan bahwa siswa:
  </div>

  <div class="data-siswa">
    <table>
      <tr>
        <td>Nama Lengkap</td>
        <td>:</td>
        <td>{{ strtoupper($siswa->nama_lengkap) }}</td>
      </tr>
      <tr>
        <td>NISN</td>
        <td>:</td>
        <td>{{ $siswa->nisn }}</td>
      </tr>
      @if($siswa->nis)
      <tr>
        <td>NIS</td>
        <td>:</td>
        <td>{{ $siswa->nis }}</td>
      </tr>
      @endif
      <tr>
        <td>Kelas</td>
        <td>:</td>
        <td>{{ $siswa->kelas }}</td>
      </tr>
      <tr>
        <td>Jurusan / Program</td>
        <td>:</td>
        <td>{{ $siswa->jurusan }}</td>
      </tr>
      <tr>
        <td>Tahun Ajaran</td>
        <td>:</td>
        <td>{{ $pengaturan['tahun_ajaran'] }}</td>
      </tr>
    </table>
  </div>

  <div class="pembuka">
    Telah dinyatakan <strong>LULUS</strong> dari Madrasah Aliyah Negeri 1 Kota Bandung pada Tahun Ajaran {{ $pengaturan['tahun_ajaran'] }}.
  </div>

  <div class="penutup">
    Surat keterangan ini dibuat untuk digunakan sebagaimana mestinya dan berlaku sebelum Ijazah resmi diterbitkan.
  </div>

  {{-- TANDA TANGAN --}}
  <div class="ttd-section">
    <div class="ttd-kiri"></div>
    <div class="ttd-kanan">
      <div class="kota-tanggal">Bandung, {{ $tanggalSurat }}</div>
      <div class="jabatan">Kepala Madrasah,</div>

      <div class="ttd-gambar">
        @if($pengaturan['stempel_sekolah'])
          <img src="{{ public_path('storage/' . $pengaturan['stempel_sekolah']) }}" class="stempel" alt="Stempel">
        @endif
        @if($pengaturan['ttd_kepala_sekolah'])
          <img src="{{ public_path('storage/' . $pengaturan['ttd_kepala_sekolah']) }}" class="ttd" alt="TTD">
        @endif
      </div>

      <div class="ttd-nama">{{ $pengaturan['nama_kepala_sekolah'] }}</div>
      @if($pengaturan['nip_kepala_sekolah'])
        <div class="ttd-nip">{{ $pengaturan['nip_kepala_sekolah'] }}</div>
      @endif
    </div>
  </div>

  <div class="footer-surat">
    Dokumen ini digenerate secara digital oleh sistem MAN 1 Kota Bandung pada {{ $tanggalSurat }}
  </div>

</body>
</html>
