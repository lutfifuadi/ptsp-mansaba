@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Konfigurasi PDF Kelulusan - Admin')

@section('content')
  <div class="mb-4">
    <h4 class="fw-bold mb-1">Konfigurasi Surat Kelulusan (PDF)</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Konfigurasi PDF</li>
      </ol>
    </nav>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible mb-4" role="alert">
      <div class="d-flex">
        <i class="icon-base ti tabler-check me-2 text-success"></i>
        <div>{{ session('success') }}</div>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.pengaturan-kelulusan.update') }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="row g-4">

      {{-- Section 1: Jadwal & KOP --}}
      <div class="col-12 col-lg-6">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-header bg-label-primary">
            <h5 class="mb-0 text-primary"><i class="icon-base ti tabler-settings me-2"></i>1. Jadwal & Header (KOP)</h5>
          </div>
          <div class="card-body pt-4">
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Tanggal Pengumuman (WIB) <span class="text-danger">*</span></label>
                <input type="datetime-local" name="tanggal_pengumuman" class="form-control @error('tanggal_pengumuman') is-invalid @enderror"
                  value="{{ old('tanggal_pengumuman', \Carbon\Carbon::parse($pengaturan['tanggal_pengumuman'])->format('Y-m-d\TH:i')) }}" required>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Tahun Ajaran <span class="text-danger">*</span></label>
                <input type="text" name="tahun_ajaran" class="form-control" value="{{ old('tahun_ajaran', $pengaturan['tahun_ajaran']) }}" placeholder="2025/2026" required>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Tanggal Keluar Surat <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_surat" class="form-control" value="{{ old('tanggal_surat', $pengaturan['tanggal_surat']) }}" required>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Nomor Surat (Default)</label>
              <input type="text" name="nomor_surat" class="form-control" value="{{ old('nomor_surat', $pengaturan['nomor_surat']) }}" placeholder="SKL/${nisn}/{{ date('Y') }}">
            </div>

            <hr class="my-4">

            <div class="mb-3">
              <label class="form-label fw-bold">KOP Baris 1 (Contoh: Kemenag RI)</label>
              <input type="text" name="header_baris_1" class="form-control" value="{{ old('header_baris_1', $pengaturan['header_baris_1']) }}" placeholder="KEMENTERIAN AGAMA REPUBLIK INDONESIA">
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">KOP Baris 2 (Contoh: Kantor Kota/Kab)</label>
              <input type="text" name="header_baris_2" class="form-control" value="{{ old('header_baris_2', $pengaturan['header_baris_2']) }}" placeholder="KANTOR KEMENTERIAN AGAMA KOTA BANDUNG">
              <div class="form-text small">Baris ini akan muncul tepat di atas Nama Madrasah.</div>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-bold">Logo Kiri (Instansi)</label>
                @if($pengaturan['logo_kiri'])
                   <div class="mb-2">
                     <img src="{{ str_starts_with($pengaturan['logo_kiri'], 'http') ? $pengaturan['logo_kiri'] : Storage::url($pengaturan['logo_kiri']) }}" height="50" class="border rounded p-1">
                   </div>
                @endif
                <input type="file" name="logo_kiri" class="form-control form-control-sm mb-2" accept="image/*">
                <input type="text" name="logo_kiri_url" class="form-control form-control-sm" placeholder="Atau URL S3" value="{{ str_starts_with($pengaturan['logo_kiri'], 'http') ? $pengaturan['logo_kiri'] : '' }}">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">Logo Kanan (Sekolah)</label>
                @if($pengaturan['logo_kanan'])
                   <div class="mb-2">
                     <img src="{{ str_starts_with($pengaturan['logo_kanan'], 'http') ? $pengaturan['logo_kanan'] : Storage::url($pengaturan['logo_kanan']) }}" height="50" class="border rounded p-1">
                   </div>
                @endif
                <input type="file" name="logo_kanan" class="form-control form-control-sm mb-2" accept="image/*">
                <input type="text" name="logo_kanan_url" class="form-control form-control-sm" placeholder="Atau URL S3" value="{{ str_starts_with($pengaturan['logo_kanan'], 'http') ? $pengaturan['logo_kanan'] : '' }}">
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Section 2: Identitas Lembaga --}}
      <div class="col-12 col-lg-6">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-header bg-label-info">
            <h5 class="mb-0 text-info"><i class="icon-base ti tabler-school me-2"></i>2. Identitas Lembaga</h5>
          </div>
          <div class="card-body pt-4">
            <div class="row">
              <div class="col-md-8 mb-3">
                <label class="form-label fw-bold">Nama Lembaga <span class="text-danger">*</span></label>
                <input type="text" name="nama_lembaga" class="form-control" value="{{ old('nama_lembaga', $pengaturan['nama_lembaga']) }}" required>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">NPSN</label>
                <input type="text" name="npsn" class="form-control" value="{{ old('npsn', $pengaturan['npsn']) }}">
              </div>
            </div>
            
            <div class="mb-3">
              <label class="form-label fw-bold">Alamat Lengkap</label>
              <textarea name="alamat_lembaga" rows="2" class="form-control">{{ old('alamat_lembaga', $pengaturan['alamat_lembaga']) }}</textarea>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Kabupaten/Kota <span class="text-danger">*</span></label>
                <input type="text" name="kabupaten_kota" class="form-control" value="{{ old('kabupaten_kota', $pengaturan['kabupaten_kota']) }}" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Provinsi <span class="text-danger">*</span></label>
                <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi', $pengaturan['provinsi']) }}" required>
              </div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-4"><label class="form-label fw-bold small">Telepon</label><input type="text" name="telepon" class="form-control form-control-sm" value="{{ old('telepon', $pengaturan['telepon']) }}"></div>
              <div class="col-md-4"><label class="form-label fw-bold small">Fax</label><input type="text" name="fax" class="form-control form-control-sm" value="{{ old('fax', $pengaturan['fax']) }}"></div>
              <div class="col-md-4"><label class="form-label fw-bold small">Kode Pos</label><input type="text" name="kode_pos" class="form-control form-control-sm" value="{{ old('kode_pos', $pengaturan['kode_pos']) }}"></div>
            </div>
            <div class="row g-3">
              <div class="col-md-6"><label class="form-label fw-bold small">Email</label><input type="email" name="email" class="form-control form-control-sm" value="{{ old('email', $pengaturan['email']) }}"></div>
              <div class="col-md-6"><label class="form-label fw-bold small">Website</label><input type="text" name="website" class="form-control form-control-sm" value="{{ old('website', $pengaturan['website']) }}"></div>
            </div>
          </div>
        </div>
      </div>

      {{-- Section 3: Legalisasi --}}
      <div class="col-12 col-lg-6">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-header bg-label-success">
            <h5 class="mb-0 text-success"><i class="icon-base ti tabler-user-check me-2"></i>3. Kepala Sekolah & Legalisasi</h5>
          </div>
          <div class="card-body pt-4">
            <div class="mb-3">
              <label class="form-label fw-bold">Nama Kepala Sekolah <span class="text-danger">*</span></label>
              <input type="text" name="nama_kepala_sekolah" class="form-control" value="{{ old('nama_kepala_sekolah', $pengaturan['nama_kepala_sekolah']) }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">NIP Kepala Sekolah</label>
              <input type="text" name="nip_kepala_sekolah" class="form-control" value="{{ old('nip_kepala_sekolah', $pengaturan['nip_kepala_sekolah']) }}">
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Jabatan Penandatangan</label>
              <input type="text" name="jabatan_penandatangan" class="form-control" value="{{ old('jabatan_penandatangan', $pengaturan['jabatan_penandatangan']) }}">
              <div class="form-text small">Default: <code>Kepala ${nama_lembaga}</code></div>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-bold small">Scan Tanda Tangan</label>
                @if($pengaturan['ttd_kepala_sekolah'])
                   <div class="mb-2">
                     <img src="{{ str_starts_with($pengaturan['ttd_kepala_sekolah'], 'http') ? $pengaturan['ttd_kepala_sekolah'] : Storage::url($pengaturan['ttd_kepala_sekolah']) }}" height="60" class="border rounded p-1">
                   </div>
                @endif
                <input type="file" name="ttd_kepala_sekolah" class="form-control form-control-sm mb-2" accept="image/*">
                <input type="text" name="ttd_kepala_sekolah_url" class="form-control form-control-sm" placeholder="URL TTD" value="{{ str_starts_with($pengaturan['ttd_kepala_sekolah'], 'http') ? $pengaturan['ttd_kepala_sekolah'] : '' }}">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold small">Stempel Sekolah</label>
                @if($pengaturan['stempel_sekolah'])
                   <div class="mb-2">
                     <img src="{{ str_starts_with($pengaturan['stempel_sekolah'], 'http') ? $pengaturan['stempel_sekolah'] : Storage::url($pengaturan['stempel_sekolah']) }}" height="60" class="border rounded p-1">
                   </div>
                @endif
                <input type="file" name="stempel_sekolah" class="form-control form-control-sm mb-2" accept="image/*">
                <input type="text" name="stempel_sekolah_url" class="form-control form-control-sm" placeholder="URL Stempel" value="{{ str_starts_with($pengaturan['stempel_sekolah'], 'http') ? $pengaturan['stempel_sekolah'] : '' }}">
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Section 4: Redaksi & Konten --}}
      <div class="col-12 col-lg-6">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-header bg-label-warning">
            <h5 class="mb-0 text-warning"><i class="icon-base ti tabler-file-text me-2"></i>4. Redaksi & Konten PDF</h5>
          </div>
          <div class="card-body pt-4">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Judul Dokumen (Lulus)</label>
                <input type="text" name="judul_lulus" class="form-control @error('judul_lulus') is-invalid @enderror" value="{{ old('judul_lulus', $pengaturan['judul_lulus']) }}">
                @error('judul_lulus')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Label Status (Lulus)</label>
                <input type="text" name="label_lulus" class="form-control @error('label_lulus') is-invalid @enderror" value="{{ old('label_lulus', $pengaturan['label_lulus']) }}">
                @error('label_lulus')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Redaksi Utama (Lulus) <span class="text-danger">*</span></label>
              <textarea name="redaksi_lulus" rows="3" class="form-control small @error('redaksi_lulus') is-invalid @enderror">{{ old('redaksi_lulus', $pengaturan['redaksi_lulus']) }}</textarea>
              @error('redaksi_lulus')<div class="invalid-feedback">{{ $message }}</div>@enderror
              <div class="form-text small">Placeholders: <code>${nama_lembaga}</code>, <code>${tahun_ajaran}</code>, <code>**bold**</code></div>
            </div>

            <hr class="my-3">

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Judul Dokumen (Tidak Lulus)</label>
                <input type="text" name="judul_tidak_lulus" class="form-control @error('judul_tidak_lulus') is-invalid @enderror" value="{{ old('judul_tidak_lulus', $pengaturan['judul_tidak_lulus']) }}">
                @error('judul_tidak_lulus')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Label Status (Tidak Lulus)</label>
                <input type="text" name="label_tidak_lulus" class="form-control @error('label_tidak_lulus') is-invalid @enderror" value="{{ old('label_tidak_lulus', $pengaturan['label_tidak_lulus']) }}">
                @error('label_tidak_lulus')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Redaksi Utama (Tidak Lulus) <span class="text-danger">*</span></label>
              <textarea name="redaksi_tidak_lulus" rows="3" class="form-control small @error('redaksi_tidak_lulus') is-invalid @enderror">{{ old('redaksi_tidak_lulus', $pengaturan['redaksi_tidak_lulus']) }}</textarea>
              @error('redaksi_tidak_lulus')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Teks Pembuka</label>
              <textarea name="teks_pembuka" rows="2" class="form-control small">{{ old('teks_pembuka', $pengaturan['teks_pembuka']) }}</textarea>
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Teks Penutup</label>
              <textarea name="teks_penutup" rows="2" class="form-control small">{{ old('teks_penutup', $pengaturan['teks_penutup']) }}</textarea>
            </div>

            <div class="mb-0">
              <label class="form-label fw-bold">Footer PDF</label>
              <input type="text" name="footer_teks" class="form-control" value="{{ old('footer_teks', $pengaturan['footer_teks']) }}">
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="mt-5 d-flex justify-content-center gap-3">
      <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
        <i class="icon-base ti tabler-device-floppy me-2"></i> Simpan Konfigurasi Lengkap
      </button>
      <a href="{{ route('admin.pengaturan-kelulusan.preview') }}" target="_blank" class="btn btn-label-secondary btn-lg px-5 shadow">
        <i class="icon-base ti tabler-eye me-2"></i> Pratinjau PDF (Live)
      </a>
    </div>

  </form>
@endsection
