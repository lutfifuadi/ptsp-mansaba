@extends('layouts/contentNavbarLayout')

@section('title', 'Buku Tamu Online - Admin')
@section('navbar-title', 'Buku Tamu Online')

@section('content')
<div class="row">
  <div class="col-12">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
      <div>
        <h4 class="fw-bold mb-1">Buku Tamu Online</h4>
        <p class="text-muted mb-0">Kelola semua data kunjungan tamu yang mengisi formulir secara online.</p>
      </div>
      <div class="d-flex gap-2">
        <button type="button" class="btn btn-danger btn-reset-guest" style="border-radius:4px;">
          <i class="icon-base ti tabler-trash me-1"></i> Reset Data
        </button>
        <a href="{{ route('admin.guest-book.rekap') }}" class="btn btn-success">
          <i class="icon-base ti tabler-chart-bar me-1"></i> Rekap & Export
        </a>
        <a href="{{ route('buku-tamu.index') }}" class="btn btn-outline-secondary" target="_blank">
          <i class="icon-base ti tabler-external-link me-1"></i> Lihat Form
        </a>
      </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible mb-4" role="alert">
        <i class="icon-base ti tabler-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="avatar avatar-md bg-label-primary">
              <i class="icon-base ti tabler-users fs-4"></i>
            </div>
            <div>
              <div class="fw-bold fs-4">{{ $stats['total'] }}</div>
              <div class="text-muted small">Total Tamu</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="avatar avatar-md bg-label-success">
              <i class="icon-base ti tabler-calendar-event fs-4"></i>
            </div>
            <div>
              <div class="fw-bold fs-4">{{ $stats['today'] }}</div>
              <div class="text-muted small">Hari Ini</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="avatar avatar-md bg-label-info">
              <i class="icon-base ti tabler-calendar-week fs-4"></i>
            </div>
            <div>
              <div class="fw-bold fs-4">{{ $stats['this_week'] }}</div>
              <div class="text-muted small">Minggu Ini</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="avatar avatar-md bg-label-warning">
              <i class="icon-base ti tabler-calendar-month fs-4"></i>
            </div>
            <div>
              <div class="fw-bold fs-4">{{ $stats['this_month'] }}</div>
              <div class="text-muted small">Bulan Ini</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm overflow-hidden" id="tableContainer" style="border-radius: 4px;">
      @include('content.pages.admin.guest-book._table')
    </div>

  </div>
</div>

{{-- Modal Detail --}}
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 560px;">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 8px;">
      <div class="modal-header p-4 border-bottom" style="background: linear-gradient(135deg, #f5f7ff 0%, #ffffff 100%);">
        <div class="d-flex align-items-center gap-3">
          <div class="detail-avatar d-flex align-items-center justify-content-center bg-primary text-white fw-bold rounded-circle" id="detailAvatar" style="width: 56px; height: 56px; font-size: 1.5rem;">T</div>
          <div>
            <h5 class="modal-title fw-bold mb-1" id="detailNama">-</h5>
            <span class="badge bg-label-info" id="detailJenisInstansi" style="font-size: 0.65rem;">-</span>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div id="modalDetailContent">
          <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Memuat...</span>
            </div>
            <p class="text-muted mt-2 mb-0 small">Memuat data detail...</p>
          </div>
        </div>
      </div>
      <div class="modal-footer border-top bg-light p-3">
        <div class="d-flex gap-2 align-items-center w-100 justify-content-between">
          <small class="text-muted" id="detailWaktu">-</small>
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" style="border-radius: 4px;">
            <i class="icon-base ti tabler-x me-1"></i> Tutup
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .detail-field {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f2f4;
  }
  .detail-field:last-child {
    border-bottom: none;
  }
  .detail-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #566a7f;
    font-weight: 600;
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.35rem;
  }
  .detail-value {
    font-weight: 500;
    color: #32475c;
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // AJAX Fetch Function
  function fetchGuestBooks(url) {
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

  // Load Detail Modal
  window.loadDetail = function(id) {
    const content = document.getElementById('modalDetailContent');
    content.innerHTML = `
      <div class="text-center py-4">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Memuat...</span>
        </div>
        <p class="text-muted mt-2 mb-0 small">Memuat data detail...</p>
      </div>
    `;

    const url = `{{ url('admin/buku-tamu') }}/${id}`;

    fetch(url, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      }
    })
    .then(response => {
      if (!response.ok) throw new Error('Gagal memuat data');
      return response.json();
    })
    .then(data => {
      const d = data.data;
      document.getElementById('detailAvatar').textContent = d.nama_lengkap.charAt(0).toUpperCase();
      document.getElementById('detailNama').textContent = d.nama_lengkap;
      document.getElementById('detailJenisInstansi').textContent = d.jenis_instansi;
      document.getElementById('detailWaktu').textContent = d.waktu;

      const instansiLabel = d.nama_instansi || '<span class="text-muted">-</span>';

      content.innerHTML = `
        <div class="detail-field">
          <div class="detail-label"><i class="icon-base ti tabler-phone text-success" style="font-size:0.85rem"></i> No. WhatsApp</div>
          <div class="detail-value">${d.no_whatsapp}</div>
        </div>
        <div class="detail-field">
          <div class="detail-label"><i class="icon-base ti tabler-map-pin text-danger" style="font-size:0.85rem"></i> Alamat</div>
          <div class="detail-value">${d.alamat}</div>
        </div>
        <div class="detail-field">
          <div class="detail-label"><i class="icon-base ti tabler-building-community text-info" style="font-size:0.85rem"></i> Nama Instansi / Lembaga</div>
          <div class="detail-value">${instansiLabel}</div>
        </div>
        <div class="detail-field">
          <div class="detail-label"><i class="icon-base ti tabler-target text-warning" style="font-size:0.85rem"></i> Tujuan</div>
          <div class="detail-value">${d.tujuan}</div>
        </div>
        <div class="detail-field">
          <div class="detail-label"><i class="icon-base ti tabler-clipboard-text text-primary" style="font-size:0.85rem"></i> Keperluan</div>
          <div class="detail-value">${d.keperluan}</div>
        </div>
      `;

      const modal = new bootstrap.Modal(document.getElementById('modalDetail'));
      modal.show();
    })
    .catch(error => {
      content.innerHTML = `
        <div class="text-center py-4">
          <i class="icon-base ti tabler-alert-circle text-danger fs-1 mb-2"></i>
          <p class="text-danger fw-bold mb-1">Gagal memuat data</p>
          <p class="text-muted small mb-0">${error.message}</p>
        </div>
      `;
    });
  }

  // Event Delegation for Table elements
  document.addEventListener('click', function(e) {
    const pageLink = e.target.closest('.pagination a');
    if (pageLink) {
      e.preventDefault();
      fetchGuestBooks(pageLink.href);
    }

    const btnDetail = e.target.closest('.btn-detail');
    if (btnDetail) {
      e.preventDefault();
      const id = btnDetail.dataset.id;
      loadDetail(id);
    }

    const btnReset = e.target.closest('.btn-reset-guest');
    if (btnReset) {
      e.preventDefault();
      if (confirm('Yakin ingin mereset SEMUA data buku tamu? Data yang sudah dihapus tidak bisa dikembalikan.')) {
        const url = `{{ route('admin.guest-book.reset') }}`;
        fetch(url, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            fetchGuestBooks(window.location.href);
            alert(data.message);
          } else {
            alert('Gagal: ' + data.message);
          }
        });
      }
    }

    const btnDelete = e.target.closest('.btn-delete');
    if (btnDelete) {
      if (confirm('Yakin ingin menghapus data buku tamu ini?')) {
        const id = btnDelete.dataset.id;
        const url = `{{ url('admin/buku-tamu') }}/${id}`;
        
        fetch(url, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            fetchGuestBooks(window.location.href);
          } else {
            alert('Gagal menghapus data: ' + data.message);
          }
        });
      }
    }
  });
});
</script>
@endsection
