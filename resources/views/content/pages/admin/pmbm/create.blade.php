@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tambah Calon Murid PMBM - Admin')

@section('page-style')
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
      <h4 class="fw-bold mb-1 text-primary">Tambah Calon Murid PMBM</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.pmbm.index') }}">Data Calon Murid</a></li>
          <li class="breadcrumb-item active">Tambah</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.pmbm.index') }}" class="btn btn-label-secondary">
      <i class="icon-base ti tabler-arrow-left me-1"></i> Kembali
    </a>
  </div>

  <div class="card border-0 shadow-sm" style="border-radius: 4px;">
    <div class="card-header bg-white border-bottom py-3">
      <h5 class="mb-0 fw-bold"><i class="icon-base ti tabler-user-plus text-primary me-2"></i>Form Tambah Calon Murid</h5>
    </div>
    <div class="card-body pt-4">
      <form method="POST" action="{{ route('admin.pmbm.store') }}">
        @csrf

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
              value="{{ old('nama_lengkap') }}" placeholder="Nama lengkap calon murid" required style="border-radius: 4px;">
            @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">NIK <span class="text-danger">*</span></label>
            <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
              value="{{ old('nik') }}" maxlength="16" inputmode="numeric" placeholder="16 digit NIK" required style="border-radius: 4px;">
            @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="row">
          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">Nomor Pendaftaran <span class="text-danger">*</span></label>
            <input type="text" name="no_pendaftaran" class="form-control @error('no_pendaftaran') is-invalid @enderror"
              value="{{ old('no_pendaftaran') }}" placeholder="Contoh: PMBM-2026-001" required style="border-radius: 4px; border-left: 3px solid #696cff;">
            @error('no_pendaftaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">NISN</label>
            <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror"
              value="{{ old('nisn') }}" maxlength="10" inputmode="numeric" placeholder="10 digit NISN (Opsional)" style="border-radius: 4px;">
            @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">Jalur Pendaftaran <span class="text-danger">*</span></label>
            <input type="text" name="jalur_pendaftaran" class="form-control @error('jalur_pendaftaran') is-invalid @enderror"
              value="{{ old('jalur_pendaftaran') }}" placeholder="Contoh: Prestasi / Reguler" required style="border-radius: 4px;">
            @error('jalur_pendaftaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Asal Sekolah <span class="text-danger">*</span></label>
            <input type="text" name="asal_sekolah" class="form-control @error('asal_sekolah') is-invalid @enderror"
              value="{{ old('asal_sekolah') }}" placeholder="Nama sekolah asal" required style="border-radius: 4px;">
            @error('asal_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Tempat Tanggal Lahir <span class="text-danger">*</span></label>
            <input type="text" name="tempat_tanggal_lahir" class="form-control @error('tempat_tanggal_lahir') is-invalid @enderror"
              value="{{ old('tempat_tanggal_lahir') }}" placeholder="Contoh: Bandung, 12 Januari 2012" required style="border-radius: 4px;">
            @error('tempat_tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="row">
          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">Nama Orang Tua <span class="text-danger">*</span></label>
            <input type="text" name="nama_ortu" class="form-control @error('nama_ortu') is-invalid @enderror"
              value="{{ old('nama_ortu') }}" placeholder="Nama Ayah/Ibu" required style="border-radius: 4px;">
            @error('nama_ortu')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">No. Kontak Calon Murid</label>
            <input type="text" name="no_hp_calon" class="form-control @error('no_hp_calon') is-invalid @enderror"
              value="{{ old('no_hp_calon') }}" placeholder="Opsional" style="border-radius: 4px;">
            @error('no_hp_calon')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold">No. Kontak Orang Tua <span class="text-danger">*</span></label>
            <input type="text" name="no_hp_ortu" class="form-control @error('no_hp_ortu') is-invalid @enderror"
              value="{{ old('no_hp_ortu') }}" placeholder="Wajib diisi" required style="border-radius: 4px;">
            @error('no_hp_ortu')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold text-primary">Status Kelulusan Seleksi <span class="text-danger">*</span></label>
            <select name="status_kelulusan" class="form-select @error('status_kelulusan') is-invalid @enderror" required style="border-radius: 4px; border-left: 4px solid #696cff;">
              <option value="Proses" @selected(old('status_kelulusan', 'Proses') === 'Proses')>Proses</option>
              <option value="Lulus" @selected(old('status_kelulusan') === 'Lulus')>Lulus</option>
              <option value="Tidak Lulus" @selected(old('status_kelulusan') === 'Tidak Lulus')>Tidak Lulus</option>
            </select>
            @error('status_kelulusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Keterangan Tambahan</label>
            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="1" placeholder="Opsional" style="border-radius: 4px;">{{ old('keterangan') }}</textarea>
            @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="pt-3 border-top d-flex gap-2">
          <button type="submit" class="btn btn-premium-primary">
            <i class="icon-base ti tabler-device-floppy me-1"></i> Simpan Calon Murid
          </button>
          <a href="{{ route('admin.pmbm.index') }}" class="btn btn-label-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
@endsection
