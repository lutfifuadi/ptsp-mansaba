@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit Siswa - Admin')

@section('content')
  <div class="mb-4">
    <h4 class="fw-bold mb-1">Edit Siswa</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.siswa.index') }}">Data Siswa</a></li>
        <li class="breadcrumb-item active">Edit</li>
      </ol>
    </nav>
  </div>

  <div class="card" style="max-width: 600px;">
    <div class="card-header">
      <h5 class="mb-0">Edit Data: <span class="text-primary">{{ $siswa->nama_lengkap }}</span></h5>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.siswa.update', $siswa->id) }}">
        @csrf @method('PUT')

        <div class="mb-3">
          <label class="form-label fw-semibold">NISN <span class="text-danger">*</span></label>
          <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror"
            value="{{ old('nisn', $siswa->nisn) }}" maxlength="10" inputmode="numeric" required>
          @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">NIS</label>
          <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror"
            value="{{ old('nis', $siswa->nis) }}" maxlength="20">
          @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
          <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
            value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" required>
          @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror"
              value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" placeholder="Contoh: Bandung">
            @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror"
              value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
            @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Orang Tua</label>
          <input type="text" name="nama_orang_tua" class="form-control @error('nama_orang_tua') is-invalid @enderror"
            value="{{ old('nama_orang_tua', $siswa->nama_orang_tua) }}" placeholder="Nama ayah/ibu">
          @error('nama_orang_tua')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
            <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror"
              value="{{ old('kelas', $siswa->kelas) }}" required>
            @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Jurusan <span class="text-danger">*</span></label>
            <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror"
              value="{{ old('jurusan', $siswa->jurusan) }}" required>
            @error('jurusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">No. Peserta Ujian</label>
            <input type="text" name="no_peserta_ujian" class="form-control @error('no_peserta_ujian') is-invalid @enderror"
              value="{{ old('no_peserta_ujian', $siswa->no_peserta_ujian) }}" placeholder="Contoh: 24-10-19-3-0064-0001">
            @error('no_peserta_ujian')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Madrasah Asal</label>
            <input type="text" name="madrasah_asal" class="form-control @error('madrasah_asal') is-invalid @enderror"
              value="{{ old('madrasah_asal', $siswa->madrasah_asal) }}" placeholder="Nama sekolah asal">
            @error('madrasah_asal')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Status Kelulusan <span class="text-danger">*</span></label>
          <select name="status_kelulusan" class="form-select @error('status_kelulusan') is-invalid @enderror" required>
            <option value="pending" @selected(old('status_kelulusan', $siswa->status_kelulusan) === 'pending')>Pending</option>
            <option value="lulus" @selected(old('status_kelulusan', $siswa->status_kelulusan) === 'lulus')>Lulus</option>
            <option value="tidak_lulus" @selected(old('status_kelulusan', $siswa->status_kelulusan) === 'tidak_lulus')>Tidak Lulus</option>
          </select>
          @error('status_kelulusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">
            <i class="icon-base ti tabler-device-floppy me-1"></i> Simpan Perubahan
          </button>
          <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>

@endsection
