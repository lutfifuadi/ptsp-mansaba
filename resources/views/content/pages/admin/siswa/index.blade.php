@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Data Siswa - Admin')

@section('content')
  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1">Data Siswa</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mb-0">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Data Siswa</li>
        </ol>
      </nav>
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalImport">
        <i class="icon-base ti tabler-upload me-1"></i> Import Excel
      </button>
      <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
        <i class="icon-base ti tabler-plus me-1"></i> Tambah Siswa
      </a>
    </div>
  </div>

  {{-- Alert --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible mb-4" role="alert">
      <i class="icon-base ti tabler-check me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- Filter --}}
  <div class="card mb-4">
    <div class="card-body">
      <form method="GET" action="{{ route('admin.siswa.index') }}" class="row g-3 align-items-end" id="filterForm">
        <div class="col-md-4">
          <label class="form-label">Cari (NISN / Nama)</label>
          <input type="text" name="search" id="searchInput" class="form-control" value="{{ request('search') }}" placeholder="Ketik NISN atau nama...">
        </div>
        <div class="col-md-2">
          <label class="form-label">Kelas</label>
          <select name="kelas" class="form-select" id="filterKelas">
            <option value="">Semua Kelas</option>
            @foreach($kelasList as $k)
              <option value="{{ $k }}" @selected(request('kelas') == $k)>{{ $k }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Jurusan</label>
          <select name="jurusan" class="form-select" id="filterJurusan">
            <option value="">Semua Jurusan</option>
            @foreach($jurusanList as $j)
              <option value="{{ $j }}" @selected(request('jurusan') == $j)>{{ $j }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Status</label>
          <select name="status" class="form-select" id="filterStatus">
            <option value="">Semua Status</option>
            <option value="lulus" @selected(request('status') == 'lulus')>Lulus</option>
            <option value="tidak_lulus" @selected(request('status') == 'tidak_lulus')>Tidak Lulus</option>
            <option value="pending" @selected(request('status') == 'pending')>Pending</option>
          </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
          <button type="submit" class="btn btn-primary w-100 d-none" id="btnFilter">Filter</button>
          <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
      </form>
    </div>
  </div>

  {{-- Tabel --}}
  <div class="card" id="tableContainer">
    @include('content.pages.admin.siswa._table')
  </div>


{{-- Modal Import --}}
<div class="modal fade" id="modalImport" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-simple">
    <div class="modal-content p-2 p-md-5">
      <div class="modal-body">
        <div class="text-center mb-4">
          <h3 class="mb-2">Import Data Siswa</h3>
          <p class="text-muted">Silakan unggah file Excel sesuai format yang ditentukan.</p>
        </div>
        <form method="POST" action="{{ route('admin.siswa.import') }}" enctype="multipart/form-data">
          @csrf
          <div class="alert alert-info d-flex align-items-center" role="alert">
            <span class="alert-icon text-info me-2">
              <i class="icon-base ti tabler-info-circle"></i>
            </span>
            <div>
              Format kolom: <strong>nisn, nis, nama_lengkap, kelas, jurusan, status_kelulusan</strong><br>
              Nilai status: <code>lulus</code>, <code>tidak_lulus</code>, atau <code>pending</code>
            </div>
          </div>
          <div class="mb-4">
            <label class="form-label fw-semibold">File Excel / CSV</label>
            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".xlsx,.xls,.csv" required>
            @error('file')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Format: xlsx, xls, csv. Maks 5MB.</div>
          </div>
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-2">
              <i class="icon-base ti tabler-upload me-1"></i> Import Data
            </button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
              Batal
            </button>
          </div>
        </form>
      </div>
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
    updateBulkUI();
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
    }, 400); // 400ms debounce
  });
});

// Event Delegation for Table elements
document.addEventListener('click', function(e) {
  // Pagination AJAX
  const pageLink = e.target.closest('.pagination a');
  if (pageLink) {
    e.preventDefault();
    fetchStudents(pageLink.href);
  }

  // Delete Confirmation
  const formHapus = e.target.closest('.form-hapus');
  if (formHapus && e.target.closest('button[type="submit"]')) {
    if (!confirm('Yakin ingin menghapus data siswa ini?')) {
      e.preventDefault();
    }
  }
  
  // Bulk Status Apply
  if (e.target && e.target.id === 'btnBulkApply') {
    const ids = Array.from(document.querySelectorAll('.row-check:checked')).map(cb => cb.value);
    const status = document.getElementById('bulkStatus').value;
    if (!status) { alert('Pilih status terlebih dahulu.'); return; }
    if (!confirm('Ubah status ' + ids.length + ' siswa menjadi "' + status + '"?')) return;

    fetch('{{ route("admin.siswa.bulk-status") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ ids, status })
    }).then(r => r.json()).then(() => window.location.reload());
  }
});

// Event Delegation for Checkboxes
document.addEventListener('change', function(e) {
  if (e.target && e.target.id === 'checkAll') {
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = e.target.checked);
    updateBulkUI();
  }
  
  if (e.target && e.target.classList.contains('row-check')) {
    updateBulkUI();
  }
});

function updateBulkUI() {
  const checked = document.querySelectorAll('.row-check:checked');
  const bulkDiv = document.getElementById('bulkActions');
  if(bulkDiv) {
      document.getElementById('selectedCount').textContent = checked.length + ' dipilih';
      bulkDiv.classList.toggle('d-none', checked.length === 0);
      bulkDiv.classList.toggle('d-flex', checked.length > 0);
  }
}

@if(session('error_import'))
  var modal = new bootstrap.Modal(document.getElementById('modalImport'));
  modal.show();
@endif
</script>
@endsection
