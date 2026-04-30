@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Pengaturan Kelulusan - Admin')

@section('content')
  <div class="mb-4">
    <h4 class="fw-bold mb-1">Pengaturan Kelulusan</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Pengaturan Kelulusan</li>
      </ol>
    </nav>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible mb-4" role="alert">
      <i class="icon-base ti tabler-check me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.pengaturan-kelulusan.update') }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="row g-4">

      {{-- Pengaturan Pengumuman --}}
      <div class="col-12 col-lg-6">
        <div class="card h-100">
          <div class="card-header">
            <h5 class="mb-0"><i class="icon-base ti tabler-calendar me-2"></i>Pengaturan Pengumuman</h5>
          </div>
          <div class="card-body">

            <div class="mb-3">
              <label class="form-label fw-semibold">Tanggal & Waktu Pengumuman (WIB) <span class="text-danger">*</span></label>
              <input type="datetime-local"
                name="tanggal_pengumuman"
                class="form-control @error('tanggal_pengumuman') is-invalid @enderror"
                value="{{ old('tanggal_pengumuman', \Carbon\Carbon::parse($pengaturan['tanggal_pengumuman'])->format('Y-m-d\TH:i')) }}"
                required>
              @error('tanggal_pengumuman')<div class="invalid-feedback">{{ $message }}</div>@enderror
              <div class="form-text">Waktu menggunakan zona WIB (UTC+7).</div>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
              <input type="text" name="tahun_ajaran"
                class="form-control @error('tahun_ajaran') is-invalid @enderror"
                value="{{ old('tahun_ajaran', $pengaturan['tahun_ajaran']) }}"
                placeholder="2025/2026" required>
              @error('tahun_ajaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Nomor Surat</label>
              <input type="text" name="nomor_surat"
                class="form-control @error('nomor_surat') is-invalid @enderror"
                value="{{ old('nomor_surat', $pengaturan['nomor_surat']) }}"
                placeholder="Contoh: 421/001/MAN1-BDG/2026">
              @error('nomor_surat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

          </div>
        </div>
      </div>

      {{-- Pengaturan Kepala Sekolah --}}
      <div class="col-12 col-lg-6">
        <div class="card h-100">
          <div class="card-header">
            <h5 class="mb-0"><i class="icon-base ti tabler-user-check me-2"></i>Kepala Sekolah</h5>
          </div>
          <div class="card-body">

            <div class="mb-3">
              <label class="form-label fw-semibold">Nama Kepala Sekolah <span class="text-danger">*</span></label>
              <input type="text" name="nama_kepala_sekolah"
                class="form-control @error('nama_kepala_sekolah') is-invalid @enderror"
                value="{{ old('nama_kepala_sekolah', $pengaturan['nama_kepala_sekolah']) }}" required>
              @error('nama_kepala_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">NIP Kepala Sekolah</label>
              <input type="text" name="nip_kepala_sekolah"
                class="form-control @error('nip_kepala_sekolah') is-invalid @enderror"
                value="{{ old('nip_kepala_sekolah', $pengaturan['nip_kepala_sekolah']) }}"
                placeholder="NIP. ...">
              @error('nip_kepala_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Tanda Tangan Kepala Sekolah</label>
              @if($pengaturan['ttd_kepala_sekolah'])
                <div class="mb-2">
                  <img src="{{ Storage::url($pengaturan['ttd_kepala_sekolah']) }}" alt="TTD" style="max-height:80px; border:1px solid #ddd; padding:4px; border-radius:4px;">
                </div>
              @endif
              <input type="file" name="ttd_kepala_sekolah"
                class="form-control @error('ttd_kepala_sekolah') is-invalid @enderror"
                accept="image/jpeg,image/png">
              @error('ttd_kepala_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
              <div class="form-text">Format: JPG/PNG. Maks 1MB. Gunakan latar belakang transparan atau putih.</div>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Stempel Sekolah</label>
              @if($pengaturan['stempel_sekolah'])
                <div class="mb-2">
                  <img src="{{ Storage::url($pengaturan['stempel_sekolah']) }}" alt="Stempel" style="max-height:80px; border:1px solid #ddd; padding:4px; border-radius:4px;">
                </div>
              @endif
              <input type="file" name="stempel_sekolah"
                class="form-control @error('stempel_sekolah') is-invalid @enderror"
                accept="image/jpeg,image/png">
              @error('stempel_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
              <div class="form-text">Format: JPG/PNG. Maks 1MB.</div>
            </div>

          </div>
        </div>
      </div>

    </div>

    <div class="mt-4">
      <button type="submit" class="btn btn-primary">
        <i class="icon-base ti tabler-device-floppy me-1"></i> Simpan Pengaturan
      </button>
    </div>

  </form>

@endsection
