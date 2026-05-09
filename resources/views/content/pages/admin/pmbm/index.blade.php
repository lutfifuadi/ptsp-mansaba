@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Data Calon Murid PMBM - Admin')

@section('page-style')
<style>
  .card-filter {
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    border-radius: 4px;
    background: #fff;
  }
  .filter-input-group {
    background: #f9fafb;
    border: 1px solid #eef0f2;
    border-radius: 4px;
    padding: 10px 15px;
    transition: all 0.2s;
  }
  .filter-input-group:focus-within {
    border-color: #696cff;
    background: #fff;
    box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.1);
  }
  .filter-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    color: #566a7f;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 5px;
  }
  .filter-control {
    border: none;
    background: transparent;
    padding: 0;
    font-weight: 500;
    color: #32475c;
    width: 100%;
  }
  .filter-control:focus {
    outline: none;
    box-shadow: none;
  }
  .header-gradient {
    background: linear-gradient(135deg, #f5f7ff 0%, #ffffff 100%);
    border-radius: 4px;
    padding: 2rem;
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
  {{-- Header --}}
  <div class="header-gradient d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
      <h3 class="fw-bold mb-1 text-primary">Data Calon Murid PMBM</h3>
      <p class="text-muted mb-0">Kelola informasi calon murid baru, jalur pendaftaran, dan status kelulusan seleksi.</p>
      <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Data Calon Murid</li>
        </ol>
      </nav>
    </div>
    <div class="d-flex flex-wrap gap-2">
      <button class="btn btn-outline-primary bg-white px-4" style="border-radius: 4px;" data-bs-toggle="modal" data-bs-target="#modalImport">
        <i class="icon-base ti tabler-file-import me-1"></i> Import Excel
      </button>
      <a href="{{ route('admin.pmbm.create') }}" class="btn btn-premium-primary rounded" style="border-radius: 4px !important;">
        <i class="icon-base ti tabler-plus me-1"></i> Tambah Calon Murid
      </a>
    </div>
  </div>

  {{-- Alert --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible d-flex align-items-center mb-4" role="alert" style="border-radius: 4px;">
      <i class="icon-base ti tabler-circle-check me-2 fs-4"></i>
      <div>
        <h6 class="alert-heading mb-1 fw-bold">Berhasil!</h6>
        <span>{{ session('success') }}</span>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible d-flex align-items-center mb-4" role="alert" style="border-radius: 4px;">
      <i class="icon-base ti tabler-circle-x me-2 fs-4"></i>
      <div>
        <h6 class="alert-heading mb-1 fw-bold">Gagal!</h6>
        <span>{{ session('error') }}</span>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- Filter --}}
  <div class="card card-filter mb-4 border-0">
    <div class="card-body p-4">
      <form method="GET" action="{{ route('admin.pmbm.index') }}" id="filterForm">
        <div class="row g-3">
          <div class="col-12 col-md-5">
            <div class="filter-input-group">
              <label class="filter-label"><i class="icon-base ti tabler-search"></i> Cari Calon Murid</label>
              <input type="text" name="search" id="searchInput" class="filter-control" value="{{ request('search') }}" placeholder="Nama, NISN, No Pendaftaran, atau NIK...">
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="filter-input-group">
              <label class="filter-label"><i class="icon-base ti tabler-route"></i> Jalur</label>
              <select name="jalur" class="filter-control" id="filterJalur">
                <option value="">Semua Jalur</option>
                @foreach($jalurList as $j)
                  <option value="{{ $j }}" @selected(request('jalur') == $j)>{{ $j }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="filter-input-group">
              <label class="filter-label"><i class="icon-base ti tabler-info-circle"></i> Status</label>
              <select name="status" class="filter-control" id="filterStatus">
                <option value="">Semua Status</option>
                <option value="Lulus" @selected(request('status') == 'Lulus')>Lulus</option>
                <option value="Tidak Lulus" @selected(request('status') == 'Tidak Lulus')>Tidak Lulus</option>
                <option value="Proses" @selected(request('status') == 'Proses')>Proses</option>
              </select>
            </div>
          </div>
          <div class="col-12 col-md-1">
            <a href="{{ route('admin.pmbm.index') }}" class="btn btn-label-secondary w-100 h-100 d-flex align-items-center justify-content-center" style="border-radius: 4px;">
              <i class="icon-base ti tabler-refresh"></i>
            </a>
          </div>
        </div>
        <button type="submit" class="btn d-none" id="btnFilter"></button>
      </form>
    </div>
  </div>

  {{-- Tabel --}}
  <div class="card border-0 shadow-sm overflow-hidden" id="tableContainer" style="border-radius: 4px;">
    @include('content.pages.admin.pmbm._table')
  </div>

{{-- Modal Import --}}
<div class="modal fade" id="modalImport" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-bottom p-4">
        <h5 class="modal-title fw-bold"><i class="icon-base ti tabler-file-import text-primary me-2"></i>Import Data Calon Murid</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
          <div class="alert alert-label-primary d-flex mb-4" role="alert" style="border-radius: 4px;">
          <i class="icon-base ti tabler-info-circle me-2 fs-4"></i>
          <div class="small">
            Format kolom: <strong>nama_lengkap, nisn, no_pendaftaran, jalur_pendaftaran, asal_sekolah, tempat_tanggal_lahir, no_hp_calon, no_hp_ortu, nama_ortu, nik, status_kelulusan, keterangan</strong><br>
            Status: <code>Lulus</code>, <code>Tidak Lulus</code>, atau <code>Proses</code>
          </div>
        </div>
        <form method="POST" action="{{ route('admin.pmbm.import') }}" enctype="multipart/form-data">
          @csrf
          <div class="mb-4 text-center p-4 border rounded" style="border-style: dashed !important; background: #fcfdfe;">
            <i class="icon-base ti tabler-cloud-upload fs-1 text-muted mb-2"></i>
            <h6 class="fw-bold mb-1">Pilih File Excel/CSV</h6>
            <p class="text-muted small mb-3">Maksimum ukuran file 5MB</p>
            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".xlsx,.xls,.csv" required>
            @error('file')
              <div class="invalid-feedback text-start">{{ $message }}</div>
            @enderror
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-premium-primary">
              <i class="icon-base ti tabler-upload me-1"></i> Mulai Import
            </button>
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
function fetchCandidates(url) {
  fetch(url, {
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.text())
  .then(html => {
    document.getElementById('tableContainer').innerHTML = html;
  });
}

let debounceTimer;
const filterForm = document.getElementById('filterForm');
const inputs = filterForm.querySelectorAll('input, select');

inputs.forEach(input => {
  input.addEventListener('input', function() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
      const formData = new FormData(filterForm);
      const params = new URLSearchParams(formData);
      fetchCandidates(`${filterForm.action}?${params.toString()}`);
    }, 400);
  });
});

document.addEventListener('click', function(e) {
  const pageLink = e.target.closest('.pagination a');
  if (pageLink) {
    e.preventDefault();
    fetchCandidates(pageLink.href);
  }

  const formHapus = e.target.closest('.form-hapus');
  if (formHapus && e.target.closest('button[type="submit"]')) {
    if (!confirm('Yakin ingin menghapus data calon murid ini?')) {
      e.preventDefault();
    }
  }
});
</script>
@endsection
