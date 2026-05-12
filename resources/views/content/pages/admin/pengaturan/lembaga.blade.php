@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Pengaturan Lembaga - Admin')

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
      padding-top: 1rem;
    }
    .upload-box {
      border: 1.5px dashed var(--border2);
      border-radius: var(--r-lg);
      padding: 1.25rem;
      background: #faf9ff;
      text-align: center;
      transition: all .2s;
    }
    .upload-box:hover {
      border-color: var(--p);
      background: #f5f3ff;
    }
    .upload-box .preview-img {
      height: 64px;
      object-fit: contain;
      border-radius: var(--r);
      margin-bottom: 10px;
      border: 1px solid var(--border);
      padding: 4px;
      background: #fff;
    }
    .upload-box label.upload-btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: .78rem;
      font-weight: 600;
      color: var(--p);
      cursor: pointer;
      margin-bottom: 6px;
    }
    .upload-box input[type=file] {
      display: none;
    }
    .upload-box .url-input {
      font-size: .78rem;
      margin-top: 8px;
    }
    .upload-box .img-label {
      font-size: .72rem;
      color: #888;
      margin-bottom: 8px;
      display: block;
    }
  </style>
@endsection

@section('content')
  <div>

    {{-- Page title --}}
    <div class="mb-4">
      <h4 class="fw-bold mb-1">Pengaturan Lembaga</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mb-0">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item">Pengaturan</li>
          <li class="breadcrumb-item active">Lembaga</li>
        </ol>
      </nav>
    </div>

    {{-- Success alert --}}
    @if (session('success'))
      <div class="alert alert-success alert-dismissible mb-4" role="alert">
        <div class="d-flex">
          <i class="ti tabler-check me-2 text-success"></i>
          <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.pengaturan.lembaga.update') }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="d-flex flex-column gap-4">

        {{-- ══════════════════════════════════════════ --}}
        {{-- 1 · IDENTITAS LEMBAGA                      --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="panel shadow-sm">
          <div class="section-head">
            <h5 class="section-head-title"><span class="dot"></span> Identitas Lembaga</h5>
          </div>
          <div class="panel-body">

            {{-- Nama & NPSN --}}
            <div class="row g-3 mb-3">
              <div class="col-md-8">
                <label class="form-label fw-bold">Nama Lembaga <span class="text-danger">*</span></label>
                <input type="text" name="nama_lembaga" id="nama_lembaga" class="form-control"
                  value="{{ old('nama_lembaga', $pengaturan['nama_lembaga'] ?? '') }}" required
                  placeholder="Masukkan nama lengkap lembaga">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-bold">NPSN</label>
                <input type="text" name="npsn" class="form-control" value="{{ old('npsn', $pengaturan['npsn'] ?? '') }}"
                  placeholder="— —">
              </div>
            </div>

            {{-- Alamat --}}
            <div class="mb-3">
              <label class="form-label fw-bold">Alamat Lengkap <span class="text-danger">*</span></label>
              <textarea name="alamat_lembaga" class="form-control" required placeholder="Jl. .... No. ..., Kelurahan, Kecamatan">{{ old('alamat_lembaga', $pengaturan['alamat_lembaga'] ?? '') }}</textarea>
            </div>

            {{-- Kab & Provinsi --}}
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label fw-bold">Kabupaten / Kota <span class="text-danger">*</span></label>
                <input type="text" name="kabupaten_kota" class="form-control"
                  value="{{ old('kabupaten_kota', $pengaturan['kabupaten_kota'] ?? '') }}" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">Provinsi <span class="text-danger">*</span></label>
                <input type="text" name="provinsi" class="form-control"
                  value="{{ old('provinsi', $pengaturan['provinsi'] ?? '') }}" required>
              </div>
            </div>

            <hr class="my-3">

            {{-- Kontak --}}
            <div class="row g-3">
              <div class="col-md-3">
                <label class="form-label fw-bold">Telepon</label>
                <input type="text" name="telepon" class="form-control"
                  value="{{ old('telepon', $pengaturan['telepon'] ?? '') }}" placeholder="022-xxxxxxx">
              </div>
              <div class="col-md-3">
                <label class="form-label fw-bold">Fax</label>
                <input type="text" name="fax" class="form-control" value="{{ old('fax', $pengaturan['fax'] ?? '') }}"
                  placeholder="022-xxxxxxx">
              </div>
              <div class="col-md-2">
                <label class="form-label fw-bold">Kode Pos</label>
                <input type="text" name="kode_pos" class="form-control"
                  value="{{ old('kode_pos', $pengaturan['kode_pos'] ?? '') }}" placeholder="40xxx">
              </div>
              <div class="col-md-2">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control"
                  value="{{ old('email', $pengaturan['email'] ?? '') }}" placeholder="info@sekolah.sch.id">
              </div>
              <div class="col-md-2">
                <label class="form-label fw-bold">Website</label>
                <input type="text" name="website" class="form-control"
                  value="{{ old('website', $pengaturan['website'] ?? '') }}" placeholder="https://sekolah.sch.id">
              </div>
            </div>

          </div>
        </div>

        {{-- ══════════════════════════════════════════ --}}
        {{-- 2 · HEADER (KOP) & LOGO                    --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="panel shadow-sm">
          <div class="section-head">
            <h5 class="section-head-title"><span class="dot"></span> Header (KOP) &amp; Logo</h5>
          </div>
          <div class="panel-body">

            {{-- KOP lines --}}
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label fw-bold">KOP Baris 1</label>
                <input type="text" name="header_baris_1" class="form-control"
                  value="{{ old('header_baris_1', $pengaturan['header_baris_1'] ?? '') }}"
                  placeholder="KEMENTERIAN AGAMA REPUBLIK INDONESIA">
                <div class="form-text">Contoh: nama kementerian / instansi induk</div>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">KOP Baris 2</label>
                <input type="text" name="header_baris_2" class="form-control"
                  value="{{ old('header_baris_2', $pengaturan['header_baris_2'] ?? '') }}"
                  placeholder="KANTOR KEMENTERIAN AGAMA KOTA BANDUNG">
                <div class="form-text">Contoh: nama kantor / UPT</div>
              </div>
            </div>

            <hr class="my-3">

            {{-- Logos --}}
            <div class="row g-4 mt-1">
              {{-- Logo Kiri --}}
              <div class="col-md-6">
                <label class="form-label fw-bold">Logo Kiri (Instansi)</label>
                <div class="upload-box">
                  @if ($pengaturan['logo_kiri'] ?? null)
                    <img
                      src="{{ str_starts_with($pengaturan['logo_kiri'], 'http')
                          ? $pengaturan['logo_kiri']
                          : Storage::url($pengaturan['logo_kiri']) }}"
                      class="preview-img" alt="Logo Kiri">
                  @else
                    <i class="ti tabler-photo" style="font-size:2rem;color:#ccc;margin-bottom:8px;display:block;"></i>
                  @endif
                  <label class="upload-btn" for="logo_kiri_file">
                    <i class="ti tabler-upload" style="font-size:.9rem;"></i> Pilih File
                  </label>
                  <input type="file" id="logo_kiri_file" name="logo_kiri" accept="image/*">
                  <div>
                    <input type="text" name="logo_kiri_url" class="form-control url-input"
                      placeholder="Atau tempel URL gambar"
                      value="{{ str_starts_with($pengaturan['logo_kiri'] ?? '', 'http') ? $pengaturan['logo_kiri'] : '' }}">
                  </div>
                </div>
              </div>

              {{-- Logo Kanan --}}
              <div class="col-md-6">
                <label class="form-label fw-bold">Logo Kanan (Sekolah)</label>
                <div class="upload-box">
                  @if ($pengaturan['logo_kanan'] ?? null)
                    <img
                      src="{{ str_starts_with($pengaturan['logo_kanan'], 'http')
                          ? $pengaturan['logo_kanan']
                          : Storage::url($pengaturan['logo_kanan']) }}"
                      class="preview-img" alt="Logo Kanan">
                  @else
                    <i class="ti tabler-photo" style="font-size:2rem;color:#ccc;margin-bottom:8px;display:block;"></i>
                  @endif
                  <label class="upload-btn" for="logo_kanan_file">
                    <i class="ti tabler-upload" style="font-size:.9rem;"></i> Pilih File
                  </label>
                  <input type="file" id="logo_kanan_file" name="logo_kanan" accept="image/*">
                  <div>
                    <input type="text" name="logo_kanan_url" class="form-control url-input"
                      placeholder="Atau tempel URL gambar"
                      value="{{ str_starts_with($pengaturan['logo_kanan'] ?? '', 'http') ? $pengaturan['logo_kanan'] : '' }}">
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        {{-- ══════════════════════════════════════════ --}}
        {{-- 3 · KEPALA SEKOLAH & LEGALISASI            --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="panel shadow-sm">
          <div class="section-head">
            <h5 class="section-head-title"><span class="dot"></span> Kepala Sekolah &amp; Legalisasi</h5>
          </div>
          <div class="panel-body">

            <div class="row g-3 mb-3">
              <div class="col-md-5">
                <label class="form-label fw-bold">Nama Kepala Sekolah <span class="text-danger">*</span></label>
                <input type="text" name="nama_kepala_sekolah" class="form-control"
                  value="{{ old('nama_kepala_sekolah', $pengaturan['nama_kepala_sekolah'] ?? '') }}" required
                  placeholder="Nama lengkap beserta gelar">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-bold">NIP Kepala Sekolah</label>
                <input type="text" name="nip_kepala_sekolah" class="form-control"
                  value="{{ old('nip_kepala_sekolah', $pengaturan['nip_kepala_sekolah'] ?? '') }}"
                  placeholder="19xxxxxxxxxxxxxx">
              </div>
              <div class="col-md-3">
                <label class="form-label fw-bold">Jabatan Penandatangan</label>
                <input type="text" name="jabatan_penandatangan" class="form-control"
                  value="{{ old('jabatan_penandatangan', $pengaturan['jabatan_penandatangan'] ?? '') }}"
                  placeholder="Kosongkan = default">
                <div class="form-text">Default: <code>Kepala <span id="nama_lembaga_preview">{{ $pengaturan['nama_lembaga'] ?? 'Lembaga' }}</span></code></div>
              </div>
            </div>

            <hr class="my-3">

            {{-- TTD & Stempel --}}
            <div class="row g-4 mt-1">
              {{-- Tanda Tangan --}}
              <div class="col-md-6">
                <label class="form-label fw-bold">Scan Tanda Tangan</label>
                <div class="upload-box">
                  @if ($pengaturan['ttd_kepala_sekolah'] ?? null)
                    <img
                      src="{{ str_starts_with($pengaturan['ttd_kepala_sekolah'], 'http')
                          ? $pengaturan['ttd_kepala_sekolah']
                          : Storage::url($pengaturan['ttd_kepala_sekolah']) }}"
                      class="preview-img" alt="TTD">
                  @else
                    <i class="ti tabler-writing" style="font-size:2rem;color:#ccc;margin-bottom:8px;display:block;"></i>
                  @endif
                  <label class="upload-btn" for="ttd_file">
                    <i class="ti tabler-upload" style="font-size:.9rem;"></i> Pilih File
                  </label>
                  <input type="file" id="ttd_file" name="ttd_kepala_sekolah" accept="image/*">
                  <div>
                    <input type="text" name="ttd_kepala_sekolah_url" class="form-control url-input"
                      placeholder="Atau tempel URL gambar TTD"
                      value="{{ str_starts_with($pengaturan['ttd_kepala_sekolah'] ?? '', 'http') ? $pengaturan['ttd_kepala_sekolah'] : '' }}">
                  </div>
                </div>
              </div>

              {{-- Stempel --}}
              <div class="col-md-6">
                <label class="form-label fw-bold">Stempel Sekolah</label>
                <div class="upload-box">
                  @if ($pengaturan['stempel_sekolah'] ?? null)
                    <img
                      src="{{ str_starts_with($pengaturan['stempel_sekolah'], 'http')
                          ? $pengaturan['stempel_sekolah']
                          : Storage::url($pengaturan['stempel_sekolah']) }}"
                      class="preview-img" alt="Stempel">
                  @else
                    <i class="ti tabler-stamp" style="font-size:2rem;color:#ccc;margin-bottom:8px;display:block;"></i>
                  @endif
                  <label class="upload-btn" for="stempel_file">
                    <i class="ti tabler-upload" style="font-size:.9rem;"></i> Pilih File
                  </label>
                  <input type="file" id="stempel_file" name="stempel_sekolah" accept="image/*">
                  <div>
                    <input type="text" name="stempel_sekolah_url" class="form-control url-input"
                      placeholder="Atau tempel URL gambar stempel"
                      value="{{ str_starts_with($pengaturan['stempel_sekolah'] ?? '', 'http') ? $pengaturan['stempel_sekolah'] : '' }}">
                  </div>
                </div>
              </div>
            </div>

          </div> {{-- End panel-body --}}
 
          <div class="form-actions text-end px-4 pb-4">
            <button type="submit" class="btn btn-primary">
              <i class="ti tabler-device-floppy me-2"></i>
              Simpan Seluruh Pengaturan Lembaga
            </button>
          </div>
        </div> {{-- End panel --}}

    </div>{{-- /d-flex --}}
  </form>

  </div>
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const namaLembagaInput = document.getElementById('nama_lembaga');
      const namaLembagaPreview = document.getElementById('nama_lembaga_preview');

      if (namaLembagaInput && namaLembagaPreview) {
        namaLembagaInput.addEventListener('input', function() {
          namaLembagaPreview.textContent = this.value || '...';
        });
      }

      // Handle file previews
      const setupPreview = (fileId, urlName) => {
        const fileInput = document.getElementById(fileId);
        const urlInput = document.querySelector(`input[name="${urlName}"]`);
        const previewImg = fileInput.closest('.upload-box').querySelector('.preview-img');
        const previewIcon = fileInput.closest('.upload-box').querySelector('.tabler-photo, .tabler-writing, .tabler-stamp');

        const updatePreview = (src) => {
          if (previewImg) {
            previewImg.src = src;
          } else if (previewIcon) {
            const newImg = document.createElement('img');
            newImg.className = 'preview-img';
            newImg.src = src;
            previewIcon.replaceWith(newImg);
          }
        };

        fileInput.addEventListener('change', function() {
          if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => updatePreview(e.target.result);
            reader.readAsDataURL(this.files[0]);
          }
        });

        if (urlInput) {
          urlInput.addEventListener('input', function() {
            if (this.value.startsWith('http')) {
              updatePreview(this.value);
            }
          });
        }
      };

      setupPreview('logo_kiri_file', 'logo_kiri_url');
      setupPreview('logo_kanan_file', 'logo_kanan_url');
      setupPreview('ttd_file', 'ttd_kepala_sekolah_url');
      setupPreview('stempel_file', 'stempel_sekolah_url');
    });
  </script>
@endsection
