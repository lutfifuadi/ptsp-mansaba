@php
use App\Models\Petugas;
$stats = [
    'total' => Petugas::count(),
    'aktif' => Petugas::where('is_active', true)->count(),
    'nonaktif' => Petugas::where('is_active', false)->count(),
];
@endphp

@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Data Petugas - Admin')
@section('navbar-title', 'Data Petugas')

@section('page-style')
@include('_partials.admin-styles')
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
      <div>
        <h4 class="fw-bold mb-1">Data Petugas</h4>
        <p class="text-muted mb-0">Kelola petugas penanggung jawab layanan dan nomor WhatsApp notifikasi.</p>
      </div>
      <div class="d-flex flex-wrap gap-2">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
          <i class="ti tabler-plus me-1"></i> Tambah Petugas
        </button>
      </div>
    </div>

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

    <div class="row g-3 mb-4">
      <div class="col-6 col-md-4">
        <div class="card stat-card h-100" style="--accent-color: var(--p); --icon-bg: #ecfdf5;">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="stat-icon">
              <i class="ti tabler-users-group"></i>
            </div>
            <div>
              <div class="stat-value">{{ $stats['total'] }}</div>
              <div class="stat-label">Total Petugas</div>
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
              <div class="stat-label">Petugas Aktif</div>
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
              <div class="stat-label">Petugas Tidak Aktif</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="panel mb-4">
      <div class="panel-body">
        <form method="GET" action="{{ route('admin.petugas.index') }}" id="filterForm">
          <div class="row g-3">
            <div class="col">
              <label class="form-label"><i class="ti tabler-search"></i> Cari Petugas</label>
              <input type="text" name="search" id="searchInput" class="form-control" value="{{ request('search') }}" placeholder="Nama Lengkap, No. WhatsApp, atau Email...">
            </div>
            <div class="col-auto d-flex align-items-end">
              <a href="{{ route('admin.petugas.index') }}" class="btn btn-outline-secondary" style="min-height: 38px;">
                <i class="ti tabler-refresh"></i>
              </a>
            </div>
          </div>
          <button type="submit" class="btn d-none" id="btnFilter"></button>
        </form>
      </div>
    </div>

    <div class="panel shadow-sm" id="tableContainer">
      @include('content.pages.admin.petugas._table')
    </div>

    {{-- Modal Tambah Petugas --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-header border-bottom p-4">
            <h5 class="modal-title fw-bold"><i class="ti tabler-user-plus text-primary me-2"></i>Tambah Petugas</h5>
          </div>
          <div class="modal-body p-4">
            <form id="formTambahPetugas">
              @csrf

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                  <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama lengkap petugas" required>
                  <div class="invalid-feedback"></div>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label fw-bold">No. WhatsApp <span class="text-danger">*</span></label>
                  <input type="text" name="no_whatsapp" class="form-control" placeholder="Contoh: 628123456789" required>
                  <div class="form-text">Nomor akan menerima notifikasi WA otomatis.</div>
                  <div class="invalid-feedback"></div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-bold">Email</label>
                  <input type="email" name="email" class="form-control" placeholder="email@contoh.com (opsional)">
                  <div class="invalid-feedback"></div>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label fw-bold">Status Aktif</label>
                  <div class="form-check form-switch mt-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" class="form-check-input" id="isActiveModal" value="1" checked>
                    <label class="form-check-label" for="isActiveModal">Petugas aktif</label>
                  </div>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="2" placeholder="Jabatan atau keterangan tambahan (opsional)"></textarea>
                <div class="invalid-feedback"></div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Layanan yang Ditangani</label>
                <div class="text-muted small mb-2">Pilih satu atau lebih layanan yang menjadi tanggung jawab petugas ini.</div>
                <div class="row g-2">
                  @foreach($layanan as $l)
                  <div class="col-md-4 col-sm-6">
                    <div class="form-check">
                      <input type="checkbox" name="layanan_id[]" class="form-check-input" id="modalLayanan_{{ $l->id }}" value="{{ $l->id }}">
                      <label class="form-check-label" for="modalLayanan_{{ $l->id }}">{{ $l->nama_layanan }}</label>
                    </div>
                  </div>
                  @endforeach
                </div>
                <div class="invalid-feedback"></div>
              </div>

              <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">
                  <i class="ti tabler-device-floppy me-1"></i> Simpan
                </button>
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
function fetchPetugas(url) {
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
      fetchPetugas(`${filterForm.action}?${params.toString()}`);
    }, 400);
  });
});

document.addEventListener('click', function(e) {
  const pageLink = e.target.closest('.pagination a');
  if (pageLink) {
    e.preventDefault();
    fetchPetugas(pageLink.href);
  }

  const formHapus = e.target.closest('.form-hapus');
  if (formHapus && e.target.closest('button[type="submit"]')) {
    if (!confirm('Yakin ingin menghapus data petugas ini?')) {
      e.preventDefault();
    }
  }
});

// Modal form submission
document.getElementById('formTambahPetugas').addEventListener('submit', function(e) {
  e.preventDefault();

  const form = this;
  const btn = form.querySelector('button[type="submit"]');
  const formData = new FormData(form);

  btn.disabled = true;
  btn.innerHTML = '<i class="ti tabler-loader ti-spin me-1"></i> Menyimpan...';

  form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
  form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

  fetch('{{ route("admin.petugas.store") }}', {
    method: 'POST',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Accept': 'application/json',
    },
    body: formData
  })
  .then(response => response.json().then(data => ({ status: response.status, data })))
  .then(({ status, data }) => {
    if (status === 200 && data.success) {
      const modal = bootstrap.Modal.getInstance(document.getElementById('modalTambah'));
      modal.hide();
      form.reset();
      fetchPetugas('{{ route("admin.petugas.index") }}');

      const alertHtml = '<div class="alert alert-success alert-dismissible mb-4" role="alert">' +
        '<i class="ti tabler-circle-check me-2"></i>' + data.message +
        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
      document.querySelector('.col-12').insertAdjacentHTML('afterbegin', alertHtml);
    } else if (status === 422 && data.errors) {
      Object.keys(data.errors).forEach(field => {
        const input = form.querySelector(`[name="${field}"]`) || form.querySelector(`[name="${field}[]"]`);
        if (input) {
          input.classList.add('is-invalid');
          const feedback = input.closest('.mb-3')?.querySelector('.invalid-feedback')
            || input.parentElement?.querySelector('.invalid-feedback');
          if (feedback) feedback.textContent = data.errors[field][0];
        }
      });
    }
  })
  .catch(() => {
    alert('Terjadi kesalahan. Silakan coba lagi.');
  })
  .finally(() => {
    btn.disabled = false;
    btn.innerHTML = '<i class="ti tabler-device-floppy me-1"></i> Simpan';
  });
});
</script>
@endsection
