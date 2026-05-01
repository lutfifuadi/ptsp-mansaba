@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tambah Siswa - Admin')

@@section('page-style')
<style>
  .header-gradient {
    background: linear-gradient(135deg, #f5f7ff 0%, #ffffff 100%);
    border-radius: 4px;
    padding: 1.5rem 2rem;
    margin-bottom: 2rem;
    border: 1px solid #eef0f2;
  }
  .btn-premium-primary {
    background: linear-gradient(135deg, #696cff 0%, #4f52d4 100%);
    border: none;
    box-shadow: 0 4px 12px rgba(105, 108, 255, 0.3);
    color: #fff;
    padding: 0.6rem 1.5rem;
    font-weight: 600;
  }
  .btn-premium-primary:hover {
    box-shadow: 0 6px 18px rgba(105, 108, 255, 0.4);
    transform: translateY(-1px);
    color: #fff;
  }
</style>
@endsection

@section('content')
  <div class="header-gradient d-flex justify-content-between align-items-center">
    <div>
      <h4 class="fw-bold mb-1 text-primary">Tambah Siswa</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.siswa.index') }}">Data Siswa</a></li>
          <li class="breadcrumb-item active">Tambah</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.siswa.index') }}" class="btn btn-label-secondary">
      <i class="icon-base ti tabler-arrow-left me-1"></i> Kembali
    </a>
  </div>

  <div class="card border-0 shadow-sm" style="max-width: 700px; border-radius: 4px;">
    <div class="card-header bg-white border-bottom py-3">
      <h5 class="mb-0 fw-bold"><i class="icon-base ti tabler-user-plus text-primary me-2"></i>Form Tambah Siswa</h5>
    </div>
    <div class="card-body pt-4">
      <form method="POST" action="{{ route('admin.siswa.store') }}">
        @csrf

        <div class="row">
          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">NISN <span class="text-danger">*</span></label>
            <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror"
              value="{{ old('nisn') }}" maxlength="10" inputmode="numeric" placeholder="10 digit angka" required style="border-radius: 4px;">
            @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">NIS</label>
            <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror"
              value="{{ old('nis') }}" maxlength="20" placeholder="Opsional" style="border-radius: 4px;">
            @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold text-primary">Nomor Peserta</label>
            <input type="text" name="no_peserta" class="form-control @error('no_peserta') is-invalid @enderror"
              value="{{ old('no_peserta') }}" placeholder="Contoh: 01-001-001-1" style="border-radius: 4px; border-left: 3px solid #696cff;">
            @error('no_peserta')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
          <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
            value="{{ old('nama_lengkap') }}" placeholder="Nama lengkap siswa" required style="border-radius: 4px;">
          @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror"
              value="{{ old('tempat_lahir') }}" placeholder="Contoh: Bandung" style="border-radius: 4px;">
            @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror"
              value="{{ old('tanggal_lahir') }}" style="border-radius: 4px;">
            @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Nama Orang Tua</label>
          <input type="text" name="nama_orang_tua" class="form-control @error('nama_orang_tua') is-invalid @enderror"
            value="{{ old('nama_orang_tua') }}" placeholder="Nama ayah/ibu" style="border-radius: 4px;">
          @error('nama_orang_tua')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Kelas <span class="text-danger">*</span></label>
            <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror"
              value="{{ old('kelas') }}" placeholder="Contoh: XII IPA 1" required style="border-radius: 4px;">
            @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Jurusan <span class="text-danger">*</span></label>
            <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror"
              value="{{ old('jurusan') }}" placeholder="Contoh: IPA" required style="border-radius: 4px;">
            @error('jurusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">No. Peserta Ujian</label>
            <input type="text" name="no_peserta_ujian" class="form-control @error('no_peserta_ujian') is-invalid @enderror"
              value="{{ old('no_peserta_ujian') }}" placeholder="Contoh: 24-10-19-3-0064-0001" style="border-radius: 4px;">
            @error('no_peserta_ujian')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Madrasah Asal</label>
            <input type="text" name="madrasah_asal" class="form-control @error('madrasah_asal') is-invalid @enderror"
              value="{{ old('madrasah_asal') }}" placeholder="Nama sekolah asal" style="border-radius: 4px;">
            @error('madrasah_asal')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label fw-bold text-primary">Status Kelulusan <span class="text-danger">*</span></label>
          <select name="status_kelulusan" class="form-select @error('status_kelulusan') is-invalid @enderror" required style="border-radius: 4px; border-left: 4px solid #696cff;">
            <option value="pending" @selected(old('status_kelulusan', 'pending') === 'pending')>Pending</option>
            <option value="lulus" @selected(old('status_kelulusan') === 'lulus')>Lulus</option>
            <option value="tidak_lulus" @selected(old('status_kelulusan') === 'tidak_lulus')>Tidak Lulus</option>
          </select>
          @error('status_kelulusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="pt-3 border-top d-flex gap-2">
          <button type="submit" class="btn btn-premium-primary">
            <i class="icon-base ti tabler-device-floppy me-1"></i> Simpan Data Siswa
          </button>
          <a href="{{ route('admin.siswa.index') }}" class="btn btn-label-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
@endsection
