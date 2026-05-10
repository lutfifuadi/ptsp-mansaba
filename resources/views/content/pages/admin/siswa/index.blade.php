@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Data Siswa - Admin')

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
      <h3 class="fw-bold mb-1 text-primary">Data Siswa</h3>
      <p class="text-muted mb-0">Kelola informasi siswa, status kelulusan, dan import data massal.</p>
      <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Data Siswa</li>
        </ol>
      </nav>
    </div>
    <div class="d-flex flex-wrap gap-2">
      <button class="btn btn-outline-primary bg-white px-4" style="border-radius: 4px;" data-bs-toggle="modal" data-bs-target="#modalImport">
        <i class="icon-base ti tabler-file-import me-1"></i> Import Excel
      </button>
      <a href="{{ route('admin.siswa.create') }}" class="btn btn-premium-primary rounded" style="border-radius: 4px !important;">
        <i class="icon-base ti tabler-plus me-1"></i> Tambah Siswa
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

  {{-- Filter --}}
  <div class="card card-filter mb-4 border-0">
    <div class="card-body p-4">
      <form method="GET" action="{{ route('admin.siswa.index') }}" id="filterForm">
        <div class="row g-3">
          <div class="col-12 col-md-3">
            <div class="filter-input-group">
              <label class="filter-label"><i class="icon-base ti tabler-search"></i> Cari Siswa</label>
              <input type="text" name="search" id="searchInput" class="filter-control" value="{{ request('search') }}" placeholder="NISN atau Nama Lengkap...">
            </div>
          </div>
          <div class="col-6 col-md-2">
            <div class="filter-input-group">
              <label class="filter-label"><i class="icon-base ti tabler-gender-male"></i> Jenis Kelamin</label>
              <select name="jenis_kelamin" class="filter-control" id="filterJenisKelamin">
                <option value="">Semua JK</option>
                @foreach($jenisKelaminList as $jk)
                  <option value="{{ $jk }}" @selected(request('jenis_kelamin') == $jk)>{{ ucfirst($jk) }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-6 col-md-2">
            <div class="filter-input-group">
              <label class="filter-label"><i class="icon-base ti tabler-chalkboard"></i> Kelas</label>
              <select name="kelas" class="filter-control" id="filterKelas">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $k)
                  <option value="{{ $k }}" @selected(request('kelas') == $k)>{{ $k }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-6 col-md-2">
            <div class="filter-input-group">
              <label class="filter-label"><i class="icon-base ti tabler-school"></i> Jurusan</label>
              <select name="jurusan" class="filter-control" id="filterJurusan">
                <option value="">Semua Jurusan</option>
                @foreach($jurusanList as $j)
                  <option value="{{ $j }}" @selected(request('jurusan') == $j)>{{ $j }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-6 col-md-1">
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-label-secondary w-100 h-100 d-flex align-items-center justify-content-center" style="border-radius: 4px;">
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
    @include('content.pages.admin.siswa._table')
  </div>


{{-- Modal Import --}}
<div class="modal fade" id="modalImport" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-bottom p-4">
        <h5 class="modal-title fw-bold"><i class="icon-base ti tabler-file-import text-primary me-2"></i>Import Data Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
          <div class="alert alert-label-primary d-flex mb-4" role="alert" style="border-radius: 4px;">
          <i class="icon-base ti tabler-info-circle me-2 fs-4"></i>
          <div class="small">
            Format kolom: <strong>nisn, nis, no_peserta, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, nama_orang_tua, kelas, jurusan</strong><br>
            Jenis kelamin: <code>laki-laki</code> atau <code>perempuan</code>
          </div>
        </div>
        <form method="POST" action="{{ route('admin.siswa.import') }}" enctype="multipart/form-data">
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
// AJAX Fetch Function
function fetchStudents(url) {
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

// Live Search & Filter
let debounceTimer;
const filterForm = document.getElementById('filterForm');
const inputs = filterForm.querySelectorAll('input, select');

inputs.forEach(input => {
  input.addEventListener('input', function() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
      const formData = new FormData(filterForm);
      const params = new URLSearchParams(formData);
      fetchStudents(`${filterForm.action}?${params.toString()}`);
    }, 400);
  });
});

// Event Delegation for Table elements
document.addEventListener('click', function(e) {
  const pageLink = e.target.closest('.pagination a');
  if (pageLink) {
    e.preventDefault();
    fetchStudents(pageLink.href);
  }

  const formHapus = e.target.closest('.form-hapus');
  if (formHapus && e.target.closest('button[type="submit"]')) {
    if (!confirm('Yakin ingin menghapus data siswa ini?')) {
      e.preventDefault();
    }
  }
});

@if(session('error_import'))
  var modal = new bootstrap.Modal(document.getElementById('modalImport'));
  modal.show();
@endif
</script>
@endsection
