@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Pengaturan Kelulusan PMBM - Admin')

@section('content')
  <div class="mb-4">
    <h4 class="fw-bold mb-1">Pengaturan Kelulusan PMBM</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Pengaturan</li>
        <li class="breadcrumb-item active">Kelulusan PMBM</li>
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
      <form method="POST" action="{{ route('admin.pengaturan.pmbm.update') }}">
        @csrf
        @method('PUT')
        
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-label-primary py-3">
            <h5 class="mb-0 text-primary fw-bold"><i class="icon-base ti tabler-calendar-stats me-2"></i>Jadwal Pengumuman PMBM</h5>
          </div>
          <div class="card-body pt-4">
            <div class="mb-3 col-md-6">
              <label class="form-label fw-bold">Tanggal & Waktu Pengumuman (WIB) <span class="text-danger">*</span></label>
              <input type="datetime-local" name="pmbm_tanggal_pengumuman" class="form-control @error('pmbm_tanggal_pengumuman') is-invalid @enderror"
                value="{{ old('pmbm_tanggal_pengumuman', \Carbon\Carbon::parse($pengaturan['pmbm_tanggal_pengumuman'])->format('Y-m-d\TH:i')) }}" required>
              @error('pmbm_tanggal_pengumuman')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-label-info py-3">
            <h5 class="mb-0 text-info fw-bold"><i class="icon-base ti tabler-file-text me-2"></i>Redaksi & Konten PDF PMBM</h5>
          </div>
          <div class="card-body pt-4">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Judul Surat (Lulus Seleksi)</label>
                <input type="text" name="pmbm_judul_lulus" class="form-control" value="{{ old('pmbm_judul_lulus', $pengaturan['pmbm_judul_lulus']) }}">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Label Status (Lulus Seleksi)</label>
                <input type="text" name="pmbm_label_lulus" class="form-control" value="{{ old('pmbm_label_lulus', $pengaturan['pmbm_label_lulus']) }}">
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Redaksi Utama (Lulus) <span class="text-danger">*</span></label>
              <textarea name="pmbm_redaksi_lulus" rows="4" class="form-control" required>{{ old('pmbm_redaksi_lulus', $pengaturan['pmbm_redaksi_lulus']) }}</textarea>
              <div class="form-text small">Placeholders: <code>${nama_lembaga}</code>, <code>${tahun_ajaran}</code>, <code>**bold**</code></div>
            </div>

            <hr class="my-4">

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Judul Surat (Tidak Lulus)</label>
                <input type="text" name="pmbm_judul_tidak_lulus" class="form-control" value="{{ old('pmbm_judul_tidak_lulus', $pengaturan['pmbm_judul_tidak_lulus']) }}">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Label Status (Tidak Lulus)</label>
                <input type="text" name="pmbm_label_tidak_lulus" class="form-control" value="{{ old('pmbm_label_tidak_lulus', $pengaturan['pmbm_label_tidak_lulus']) }}">
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold">Redaksi Utama (Tidak Lulus) <span class="text-danger">*</span></label>
              <textarea name="pmbm_redaksi_tidak_lulus" rows="4" class="form-control" required>{{ old('pmbm_redaksi_tidak_lulus', $pengaturan['pmbm_redaksi_tidak_lulus']) }}</textarea>
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Teks Pembuka</label>
              <textarea name="pmbm_teks_pembuka" rows="2" class="form-control">{{ old('pmbm_teks_pembuka', $pengaturan['pmbm_teks_pembuka']) }}</textarea>
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Teks Penutup</label>
              <textarea name="pmbm_teks_penutup" rows="2" class="form-control">{{ old('pmbm_teks_penutup', $pengaturan['pmbm_teks_penutup']) }}</textarea>
            </div>
          </div>
          <div class="card-footer bg-transparent border-0 pt-0 pb-4 px-4">
            <button type="submit" class="btn btn-primary w-100">
              <i class="icon-base ti tabler-device-floppy me-2"></i> Simpan Pengaturan PMBM
            </button>
          </div>
        </div>
      </form>
    </div>

    <div class="col-12 col-lg-4">
      <div class="card shadow-sm border-0 sticky-top" style="top: 1rem;">
        <div class="card-header bg-label-info py-3">
          <h5 class="mb-0 text-info"><i class="icon-base ti tabler-eye me-2"></i>Pratinjau</h5>
        </div>
        <div class="card-body pt-4 text-center">
          <p>Lihat bagaimana hasil cetak PDF Surat Kelulusan PMBM dengan pengaturan saat ini.</p>
          <a href="{{ route('admin.pengaturan.pmbm.preview') }}" target="_blank" class="btn btn-info w-100 mb-2">
            <i class="icon-base ti tabler-file-download me-2"></i>Buka Pratinjau PDF
          </a>
          <div class="form-text">Pratinjau menggunakan data sampel calon murid pertama.</div>
        </div>
      </div>
    </div>
  </div>
@endsection
