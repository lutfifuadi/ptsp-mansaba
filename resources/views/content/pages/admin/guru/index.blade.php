@php
use App\Models\Guru;
$stats = [
    'total' => Guru::count(),
    'aktif' => Guru::where('is_active', true)->count(),
    'nonaktif' => Guru::where('is_active', false)->count(),
];
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Data Guru - Admin')
@section('navbar-title', 'Data Guru')

@section('page-style')
@include('_partials.admin-styles')
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
      <div>
        <h4 class="fw-bold mb-1">Data Guru</h4>
        <p class="text-muted mb-0">Kelola informasi guru dan tenaga pendidik.</p>
      </div>
      <div class="d-flex flex-wrap gap-2">
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalImport">
          <i class="ti tabler-file-import me-1"></i> Import Excel
        </button>
        <a href="{{ route('admin.guru.create') }}" class="btn btn-primary">
          <i class="ti tabler-plus me-1"></i> Tambah Guru
        </a>
      </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible mb-4" role="alert">
        <i class="ti tabler-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible mb-4" role="alert">
        <i class="ti tabler-alert-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
      <div class="col-6 col-md-4">
        <div class="card stat-card h-100" style="--accent-color: var(--p); --icon-bg: #ecfdf5;">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="stat-icon">
              <i class="ti tabler-users-group"></i>
            </div>
            <div>
              <div class="stat-value">{{ $stats['total'] }}</div>
              <div class="stat-label">Total Guru</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4">
        <div class="card stat-card h-100" style="--accent-color: var(--indigo); --icon-bg: #eef2ff;">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="stat-icon">
              <i class="ti tabler-circle-check"></i>
            </div>
            <div>
              <div class="stat-value">{{ $stats['aktif'] }}</div>
              <div class="stat-label">Guru Aktif</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4">
        <div class="card stat-card h-100" style="--accent-color: var(--red); --icon-bg: #fee2e2;">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="stat-icon">
              <i class="ti tabler-circle-x"></i>
            </div>
            <div>
              <div class="stat-value">{{ $stats['nonaktif'] }}</div>
              <div class="stat-label">Guru Tidak Aktif</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Search --}}
    <div class="panel mb-4">
      <div class="panel-body">
        <form method="GET" action="{{ route('admin.guru.index') }}" id="filterForm">
          <div class="row g-3">
            <div class="col">
              <label class="form-label"><i class="ti tabler-search"></i> Cari Guru</label>
              <input type="text" name="search" id="searchInput" class="form-control" value="{{ request('search') }}" placeholder="Nama Lengkap, NIP, atau Bidang Studi...">
            </div>
            <div class="col-auto d-flex align-items-end">
              <a href="{{ route('admin.guru.index') }}" class="btn btn-outline-secondary" style="min-height: 38px;">
                <i class="ti tabler-refresh"></i>
              </a>
            </div>
          </div>
          <button type="submit" class="btn d-none" id="btnFilter"></button>
        </form>
      </div>
    </div>

    {{-- Tabel --}}
    <div class="panel shadow-sm" id="tableContainer">
      @include('content.pages.admin.guru._table')
    </div>

    {{-- Modal Import --}}
    <div class="modal fade" id="modalImport" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-header border-bottom p-4">
            <h5 class="modal-title fw-bold"><i class="ti tabler-file-import text-primary me-2"></i>Import Data Guru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-4">
            <div class="alert alert-primary d-flex mb-4" role="alert">
              <i class="ti tabler-info-circle me-2 fs-4"></i>
              <div class="small">
                Format kolom: <strong>nama_lengkap, nip, nuptk, bidang_studi, no_whatsapp, alamat, is_active</strong><br>
                Is Active: <code>ya</code> atau <code>tidak</code>
              </div>
            </div>
            <form method="POST" action="{{ route('admin.guru.import') }}" enctype="multipart/form-data">
              @csrf
              <div class="mb-4 text-center p-4 border rounded" style="border-style: dashed !important; background: #fcfdfe;">
                <i class="ti tabler-cloud-upload fs-1 text-muted mb-2"></i>
                <h6 class="fw-bold mb-1">Pilih File Excel/CSV</h6>
                <p class="text-muted small mb-3">Maksimum ukuran file 5MB</p>
                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".xlsx,.xls,.csv" required>
                @error('file')
                  <div class="invalid-feedback text-start">{{ $message }}</div>
                @enderror
              </div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                  <i class="ti tabler-upload me-1"></i> Mulai Import
                </button>
                <a href="{{ route('admin.guru.import.template') }}" class="btn btn-outline-primary">
                  <i class="ti tabler-download me-1"></i> Download Template
                </a>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
function fetchGurus(url) {
  fetch(url, {
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
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
      fetchGurus(`${filterForm.action}?${params.toString()}`);
    }, 400);
  });
});

document.addEventListener('click', function(e) {
  const pageLink = e.target.closest('.pagination a');
  if (pageLink) {
    e.preventDefault();
    fetchGurus(pageLink.href);
  }

  const formHapus = e.target.closest('.form-hapus');
  if (formHapus && e.target.closest('button[type="submit"]')) {
    if (!confirm('Yakin ingin menghapus data guru ini?')) {
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
