@php
$configData = Helper::appClasses();
$selectedLayanan = old('layanan_id', $petugas->layanan->pluck('id')->toArray());
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit Petugas - Admin')

@section('page-style')
@include('_partials.admin-styles')
@endsection

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1">Edit Petugas</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.petugas.index') }}">Data Petugas</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.petugas.index') }}" class="btn btn-label-secondary">
      <i class="ti tabler-arrow-left me-1"></i> Kembali
    </a>
  </div>

  <div class="panel shadow-sm">
    <div class="section-head">
      <h5 class="section-head-title"><span class="dot"></span> Edit Data: {{ $petugas->nama_lengkap }}</h5>
    </div>
    <div class="panel-body pt-4">
      <form method="POST" action="{{ route('admin.petugas.update', $petugas->id) }}">
        @csrf @method('PUT')

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
              value="{{ old('nama_lengkap', $petugas->nama_lengkap) }}" required>
            @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">No. WhatsApp <span class="text-danger">*</span></label>
            <input type="text" name="no_whatsapp" class="form-control @error('no_whatsapp') is-invalid @enderror"
              value="{{ old('no_whatsapp', $petugas->no_whatsapp) }}" required>
            <div class="form-text">Nomor akan menerima notifikasi WA otomatis.</div>
            @error('no_whatsapp')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
              value="{{ old('email', $petugas->email) }}" placeholder="email@contoh.com">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Status Aktif</label>
            <div class="form-check form-switch mt-2">
              <input type="hidden" name="is_active" value="0">
              <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1"
                {{ old('is_active', $petugas->is_active) ? 'checked' : '' }}>
              <label class="form-check-label" for="isActive">Petugas aktif</label>
            </div>
            @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Deskripsi</label>
          <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="2"
            placeholder="Jabatan atau keterangan tambahan">{{ old('deskripsi', $petugas->deskripsi) }}</textarea>
          @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Layanan yang Ditangani</label>
          <div class="text-muted small mb-2">Pilih satu atau lebih layanan yang menjadi tanggung jawab petugas ini.</div>
          <div class="row g-2">
            @foreach($layanan as $l)
            <div class="col-md-4 col-sm-6">
              <div class="form-check">
                <input type="checkbox" name="layanan_id[]" class="form-check-input" id="layanan_{{ $l->id }}"
                  value="{{ $l->id }}" {{ in_array($l->id, $selectedLayanan) ? 'checked' : '' }}>
                <label class="form-check-label" for="layanan_{{ $l->id }}">{{ $l->nama_layanan }}</label>
              </div>
            </div>
            @endforeach
          </div>
          @error('layanan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="pt-3 border-top d-flex gap-2">
          <button type="submit" class="btn btn-view">
            <i class="ti tabler-device-floppy me-1"></i> Simpan Perubahan
          </button>
          <a href="{{ route('admin.petugas.index') }}" class="btn btn-label-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
@endsection
