@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit Guru - Admin')

@section('page-style')
@include('_partials.admin-styles')
@endsection

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1">Edit Guru</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.guru.index') }}">Data Guru</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.guru.index') }}" class="btn btn-label-secondary">
      <i class="ti tabler-arrow-left me-1"></i> Kembali
    </a>
  </div>

  <div class="panel shadow-sm">
    <div class="section-head">
      <h5 class="section-head-title"><span class="dot"></span> Edit Data: {{ $guru->nama_lengkap }}</h5>
    </div>
    <div class="panel-body pt-4">
      <form method="POST" action="{{ route('admin.guru.update', $guru->id) }}">
        @csrf @method('PUT')

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
              value="{{ old('nama_lengkap', $guru->nama_lengkap) }}" required>
            @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Bidang Studi <span class="text-danger">*</span></label>
            <input type="text" name="bidang_studi" class="form-control @error('bidang_studi') is-invalid @enderror"
              value="{{ old('bidang_studi', $guru->bidang_studi) }}" required>
            @error('bidang_studi')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">NIP</label>
            <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
              value="{{ old('nip', $guru->nip) }}" placeholder="Nomor Induk Pegawai">
            @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">NUPTK</label>
            <input type="text" name="nuptk" class="form-control @error('nuptk') is-invalid @enderror"
              value="{{ old('nuptk', $guru->nuptk) }}" placeholder="Nomor UKG / NUPTK">
            @error('nuptk')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">No. WhatsApp</label>
            <input type="text" name="no_whatsapp" class="form-control @error('no_whatsapp') is-invalid @enderror"
              value="{{ old('no_whatsapp', $guru->no_whatsapp) }}">
            @error('no_whatsapp')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Status Aktif</label>
            <div class="form-check form-switch mt-2">
              <input type="hidden" name="is_active" value="0">
              <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1"
                {{ old('is_active', $guru->is_active) ? 'checked' : '' }}>
              <label class="form-check-label" for="isActive">Guru aktif</label>
            </div>
            @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Alamat</label>
          <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"
            placeholder="Alamat lengkap">{{ old('alamat', $guru->alamat) }}</textarea>
          @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="pt-3 border-top d-flex gap-2">
          <button type="submit" class="btn btn-view">
            <i class="ti tabler-device-floppy me-1"></i> Simpan Perubahan
          </button>
          <a href="{{ route('admin.guru.index') }}" class="btn btn-label-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
@endsection
