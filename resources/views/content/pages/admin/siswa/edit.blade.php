@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit Siswa - Admin')

@section('page-style')
  @include('_partials.admin-styles')
  <style>
    .panel-body {
      padding: 1.5rem;
    }

    .section-head {
      padding: 0.6rem 1.5rem !important;
      min-height: 45px;
    }

    .section-head-title {
      margin: 0 !important;
    }

    .form-actions {
      border-top: 1px solid var(--border);
      padding-top: 1.25rem;
      margin-top: 1.25rem;
    }
  </style>
@endsection

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1">Edit Siswa</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mb-0">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.siswa.index') }}">Data Siswa</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.siswa.index') }}" class="btn btn-label-secondary">
      <i class="ti tabler-arrow-left me-1"></i> Kembali
    </a>
  </div>

  <div class="panel shadow-sm">
    <div class="section-head">
      <h5 class="section-head-title"><span class="dot"></span> Edit Data: {{ $siswa->nama_lengkap }}</h5>
    </div>
    <div class="panel-body">
      <form method="POST" action="{{ route('admin.siswa.update', $siswa->id) }}">
        @csrf @method('PUT')

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">NISN <span class="text-danger">*</span></label>
            <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror"
              value="{{ old('nisn', $siswa->nisn) }}" maxlength="10" inputmode="numeric" required>
            @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">NIS</label>
            <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror"
              value="{{ old('nis', $siswa->nis) }}" maxlength="20">
            @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
          <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
            value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" required>
          @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror"
              value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" placeholder="Contoh: Bandung">
            @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror"
              value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
            @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
              <option value="">Pilih jenis kelamin</option>
              <option value="laki-laki" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) === 'laki-laki')>Laki-laki</option>
              <option value="perempuan" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) === 'perempuan')>Perempuan</option>
            </select>
            @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Kelas <span class="text-danger">*</span></label>
            <select name="kelas" class="form-select @error('kelas') is-invalid @enderror" required>
              <option value="">Pilih kelas</option>
              @foreach(config('kelas') as $k)
                <option value="{{ $k }}" {{ old('kelas', $siswa->kelas) == $k ? 'selected' : '' }}>{{ $k }}</option>
              @endforeach
            </select>
            @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Jurusan <span class="text-danger">*</span></label>
            <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror"
              value="{{ old('jurusan', $siswa->jurusan) }}" required>
            @error('jurusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="form-actions text-end">
          <a href="{{ route('admin.siswa.index') }}" class="btn btn-label-secondary me-2">Batal</a>
          <button type="submit" class="btn btn-primary">
            <i class="ti tabler-device-floppy me-1"></i> Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
