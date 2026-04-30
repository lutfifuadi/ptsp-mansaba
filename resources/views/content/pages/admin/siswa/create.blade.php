@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tambah Siswa - Admin')

@section('content')
  <div class="mb-4">
    <h4 class="fw-bold mb-1">Tambah Siswa</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.siswa.index') }}">Data Siswa</a></li>
        <li class="breadcrumb-item active">Tambah</li>
      </ol>
    </nav>
  </div>

  <div class="card" style="max-width: 600px;">
    <div class="card-header">
      <h5 class="mb-0">Form Tambah Siswa</h5>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.siswa.store') }}">
        @csrf

        <div class="mb-3">
          <label class="form-label fw-semibold">NISN <span class="text-danger">*</span></label>
          <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror"
            value="{{ old('nisn') }}" maxlength="10" inputmode="numeric" placeholder="10 digit angka" required>
          @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">NIS (Nomor Induk Sekolah)</label>
          <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror"
            value="{{ old('nis') }}" maxlength="20" placeholder="Opsional">
          @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
          <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
            value="{{ old('nama_lengkap') }}" placeholder="Nama lengkap siswa" required>
          @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
            <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror"
              value="{{ old('kelas') }}" placeholder="Contoh: XII IPA 1" required>
            @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Jurusan <span class="text-danger">*</span></label>
            <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror"
              value="{{ old('jurusan') }}" placeholder="Contoh: IPA" required>
            @error('jurusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Status Kelulusan <span class="text-danger">*</span></label>
          <select name="status_kelulusan" class="form-select @error('status_kelulusan') is-invalid @enderror" required>
            <option value="pending" @selected(old('status_kelulusan', 'pending') === 'pending')>Pending</option>
            <option value="lulus" @selected(old('status_kelulusan') === 'lulus')>Lulus</option>
            <option value="tidak_lulus" @selected(old('status_kelulusan') === 'tidak_lulus')>Tidak Lulus</option>
          </select>
          @error('status_kelulusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">
            <i class="icon-base ti tabler-device-floppy me-1"></i> Simpan
          </button>
          <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>

@endsection
