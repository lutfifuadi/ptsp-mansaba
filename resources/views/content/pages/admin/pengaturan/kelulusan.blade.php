@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Pengaturan Kelulusan XII - Admin')

@section('content')
  <div class="mb-4">
    <h4 class="fw-bold mb-1">Pengaturan Kelulusan XII</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Pengaturan</li>
        <li class="breadcrumb-item active">Kelulusan XII</li>
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

  <div class="row g-4">
    <div class="col-12 col-lg-8">
      <form method="POST" action="{{ route('admin.pengaturan.kelulusan.update') }}">
        @csrf
        @method('PUT')
        <div class="card shadow-sm border-0 mb-4">
          <div class="card-header bg-label-warning py-3">
            <h5 class="mb-0 text-warning"><i class="icon-base ti tabler-calendar-time me-2"></i>Jadwal Pengumuman XII</h5>
          </div>
          <div class="card-body pt-4">
            <div class="mb-3 col-md-6">
              <label class="form-label fw-bold">Tanggal & Waktu Pengumuman (WIB) <span class="text-danger">*</span></label>
              <input type="datetime-local" name="tanggal_pengumuman" class="form-control @error('tanggal_pengumuman') is-invalid @enderror"
                value="{{ old('tanggal_pengumuman', \Carbon\Carbon::parse($pengaturan['tanggal_pengumuman'])->format('Y-m-d\TH:i')) }}" required>
              @error('tanggal_pengumuman')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
        </div>

        <div class="card shadow-sm border-0">
          <div class="card-header bg-label-primary py-3">
            <h5 class="mb-0 text-primary"><i class="icon-base ti tabler-file-description me-2"></i>Redaksi & Konten PDF XII</h5>
          </div>
          <div class="card-body pt-4">
            <div class="mb-3">
              <label class="form-label fw-bold">Versi Surat <span class="text-danger">*</span></label>
              <select name="versi_surat" class="form-select @error('versi_surat') is-invalid @enderror">
                <option value="lengkap" {{ old('versi_surat', $pengaturan['versi_surat'] ?? 'lengkap') === 'lengkap' ? 'selected' : '' }}>Lengkap (Dengan NPSN & Alamat Lengkap)</option>
                <option value="tanpa_data" {{ old('versi_surat', $pengaturan['versi_surat'] ?? '') === 'tanpa_data' ? 'selected' : '' }}>Sederhana (Tanpa Data Detail Lembaga)</option>
              </select>
              @error('versi_surat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Nomor Surat (Default)</label>
              <input type="text" name="nomor_surat" class="form-control" value="{{ old('nomor_surat', $pengaturan['nomor_surat']) }}" placeholder="SKL/${nisn}/{{ date('Y') }}">
            </div>

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
              <textarea name="redaksi_lulus" rows="4" class="form-control @error('redaksi_lulus') is-invalid @enderror">{{ old('redaksi_lulus', $pengaturan['redaksi_lulus']) }}</textarea>
              <div class="form-text small">Placeholders: <code>${nama_lembaga}</code>, <code>${tahun_ajaran}</code>, <code>**bold**</code></div>
            </div>

            <hr class="my-4">

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Judul Dokumen (Tidak Lulus)</label>
                <input type="text" name="judul_tidak_lulus" class="form-control @error('judul_tidak_lulus') is-invalid @enderror" value="{{ old('judul_tidak_lulus', $pengaturan['judul_tidak_lulus']) }}">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Label Status (Tidak Lulus)</label>
                <input type="text" name="label_tidak_lulus" class="form-control @error('label_tidak_lulus') is-invalid @enderror" value="{{ old('label_tidak_lulus', $pengaturan['label_tidak_lulus']) }}">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Redaksi Utama (Tidak Lulus) <span class="text-danger">*</span></label>
              <textarea name="redaksi_tidak_lulus" rows="4" class="form-control @error('redaksi_tidak_lulus') is-invalid @enderror">{{ old('redaksi_tidak_lulus', $pengaturan['redaksi_tidak_lulus']) }}</textarea>
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Teks Pembuka</label>
              <textarea name="teks_pembuka" rows="2" class="form-control">{{ old('teks_pembuka', $pengaturan['teks_pembuka']) }}</textarea>
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Teks Penutup</label>
              <textarea name="teks_penutup" rows="2" class="form-control">{{ old('teks_penutup', $pengaturan['teks_penutup']) }}</textarea>
            </div>
          </div>
          <div class="card-footer bg-transparent border-0 pt-0 pb-4 px-4">
            <button type="submit" class="btn btn-primary w-100">
              <i class="icon-base ti tabler-device-floppy me-2"></i>Simpan Pengaturan XII
            </button>
          </div>
        </div>
      </form>
    </div>

    <div class="col-12 col-lg-4">
      <div class="card shadow-sm border-0 sticky-top" style="top: 1rem;">
        <div class="card-header bg-label-info">
          <h5 class="mb-0 text-info"><i class="icon-base ti tabler-eye me-2"></i>Pratinjau</h5>
        </div>
        <div class="card-body pt-4 text-center">
          <p>Lihat bagaimana hasil cetak PDF Surat Kelulusan XII dengan pengaturan saat ini.</p>
          <a href="{{ route('admin.pengaturan.kelulusan.preview') }}" target="_blank" class="btn btn-info w-100 mb-2">
            <i class="icon-base ti tabler-file-download me-2"></i>Buka Pratinjau PDF
          </a>
          <div class="form-text">Pratinjau menggunakan data sampel siswa pertama.</div>
        </div>
      </div>
    </div>
  </div>
@endsection
