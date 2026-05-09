@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Pengaturan Umum - Admin')

@section('content')
  <div class="mb-4">
    <h4 class="fw-bold mb-1">Pengaturan Umum</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Pengaturan</li>
        <li class="breadcrumb-item active">Umum</li>
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

  <div class="row">
    <div class="col-12 col-md-8 col-lg-6">
      <form method="POST" action="{{ route('admin.pengaturan.umum.update') }}">
        @csrf
        @method('PUT')
        <div class="card shadow-sm border-0">
          <div class="card-header bg-label-secondary py-3">
            <h5 class="mb-0 text-secondary"><i class="icon-base ti tabler-settings-2 me-2"></i>Konfigurasi Dasar</h5>
          </div>
          <div class="card-body pt-4">
            <div class="mb-3">
              <label class="form-label fw-bold">Tahun Ajaran <span class="text-danger">*</span></label>
              <input type="text" name="tahun_ajaran" class="form-control" value="{{ old('tahun_ajaran', $pengaturan['tahun_ajaran']) }}" placeholder="2025/2026" required>
              <div class="form-text">Digunakan sebagai variabel <code>${tahun_ajaran}</code> di redaksi surat.</div>
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Tanggal Surat (Default) <span class="text-danger">*</span></label>
              <input type="date" name="tanggal_surat" class="form-control" value="{{ old('tanggal_surat', $pengaturan['tanggal_surat']) }}" required>
              <div class="form-text">Tanggal yang akan tertera pada surat keterangan.</div>
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Teks Footer Dokumen</label>
              <input type="text" name="footer_teks" class="form-control" value="{{ old('footer_teks', $pengaturan['footer_teks']) }}">
              <div class="form-text">Teks kecil di bagian paling bawah halaman PDF.</div>
            </div>
          </div>
          <div class="card-footer bg-transparent border-0 pt-0 pb-4 px-4">
            <button type="submit" class="btn btn-primary w-100">
              <i class="icon-base ti tabler-device-floppy me-2"></i>Simpan Pengaturan Umum
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
