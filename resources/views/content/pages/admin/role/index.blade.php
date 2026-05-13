@extends('layouts/contentNavbarLayout')

@section('title', 'Manajemen Pengguna - Admin')
@section('navbar-title', 'Manajemen Pengguna')

@section('page-style')
@include('_partials.admin-styles')
<style>
  .role-badge {
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: var(--r-sm);
  }
  .role-admin {
    background: #fee2e2;
    color: #7f1d1d;
    border: 1px solid #fca5a5;
  }
  .role-staff {
    background: #e0f2fe;
    color: #075985;
    border: 1px solid #7dd3fc;
  }
</style>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
      <div>
        <h4 class="fw-bold mb-1">Manajemen Pengguna</h4>
        <p class="text-muted mb-0">Kelola pengguna dan hak akses sistem.</p>
      </div>
      <div>
        <a href="{{ route('admin.role-management.index') }}" class="btn btn-outline-primary me-2">
          <i class="ti tabler-settings me-1"></i> Kelola Role
        </a>
        <a href="{{ route('admin.role.create') }}" class="btn btn-primary">
          <i class="ti tabler-plus me-1"></i> Tambah Pengguna
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
      <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="--accent-color: var(--p); --icon-bg: #ecfdf5;">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="stat-icon">
              <i class="ti tabler-users"></i>
            </div>
            <div>
              <div class="stat-value">{{ $stats['total'] }}</div>
              <div class="stat-label">Total Pengguna</div>
            </div>
          </div>
        </div>
      </div>
      @foreach($roles as $role)
      <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="--accent-color: var(--sky); --icon-bg: #e0f2fe;">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="stat-icon">
              <i class="ti tabler-shield-check"></i>
            </div>
            <div>
              <div class="stat-value">{{ $stats[$role->name] ?? 0 }}</div>
              <div class="stat-label">{{ ucfirst($role->name) }}</div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    {{-- Search --}}
    <div class="panel mb-4">
      <div class="panel-body">
        <form method="GET" action="{{ route('admin.role.index') }}" id="filterForm">
          <div class="row g-3">
            <div class="col">
              <label class="form-label"><i class="ti tabler-search"></i> Cari Pengguna</label>
              <input type="text" name="search" id="searchInput" class="form-control" value="{{ request('search') }}" placeholder="Nama, Email, Username, atau Role...">
            </div>
            <div class="col-auto d-flex align-items-end">
              <a href="{{ route('admin.role.index') }}" class="btn btn-outline-secondary" style="min-height: 38px;">
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
      @include('content.pages.admin.role._table')
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
function fetchUsers(url) {
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
      fetchUsers(`${filterForm.action}?${params.toString()}`);
    }, 400);
  });
});

document.addEventListener('click', function(e) {
  const pageLink = e.target.closest('.pagination a');
  if (pageLink) {
    e.preventDefault();
    fetchUsers(pageLink.href);
  }

  const formHapus = e.target.closest('.form-hapus');
  if (formHapus && e.target.closest('button[type="submit"]')) {
    if (!confirm('Yakin ingin menghapus pengguna ini?')) {
      e.preventDefault();
    }
  }
});
</script>
@endsection
