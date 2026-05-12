@extends('layouts/contentNavbarLayout')

@section('title', 'Buku Tamu Online - Admin')
@section('navbar-title', 'Buku Tamu Online')

@section('content')
<style>
  .card-premium {
    border: none;
    border-radius: 12px;
    transition: all 0.3s ease;
    background: #fff;
    overflow: hidden;
  }
  .card-premium:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08) !important;
  }
  .stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
  }
  .premium-table thead th {
    background-color: #f8f9fa;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 1px;
    font-weight: 700;
    color: #4b5563;
    padding: 1.2rem 1rem;
    border-top: none;
  }
</style>

<div class="row">
  <div class="col-12">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
      <div>
        <div class="d-flex align-items-center gap-2 mb-1">
          <div class="p-2 rounded-3 bg-label-primary">
            <i class="ti tabler-book fs-3"></i>
          </div>
          <h4 class="fw-bold mb-0">Buku Tamu Online</h4>
        </div>
        <p class="text-muted mb-0">Kelola semua data kunjungan tamu yang mengisi formulir secara online.</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('admin.guest-book.rekap') }}" class="btn btn-label-success d-flex align-items-center gap-2">
          <i class="ti tabler-chart-bar fs-4"></i> Rekap & Export
        </a>
        <button type="button" class="btn btn-label-danger btn-reset-guest d-flex align-items-center gap-2">
          <i class="ti tabler-trash fs-4"></i> Reset Data
        </button>
        <a href="{{ route('buku-tamu.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2" target="_blank">
          <i class="ti tabler-external-link fs-4"></i> Form
        </a>
      </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible d-flex align-items-center mb-4" role="alert">
        <i class="ti tabler-circle-check me-2 fs-4"></i>
        <div class="fw-medium">{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row g-4 mb-4">
      <div class="col-6 col-md-3">
        <div class="card card-premium shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon bg-label-primary">
                <i class="ti tabler-users"></i>
              </div>
              <div>
                <h4 class="fw-bold mb-0">{{ $stats['total'] }}</h4>
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.65rem;">Total Tamu</small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card card-premium shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon bg-label-success">
                <i class="ti tabler-calendar-event"></i>
              </div>
              <div>
                <h4 class="fw-bold mb-0">{{ $stats['today'] }}</h4>
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.65rem;">Hari Ini</small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card card-premium shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon bg-label-info">
                <i class="ti tabler-calendar-stats"></i>
              </div>
              <div>
                <h4 class="fw-bold mb-0">{{ $stats['this_week'] }}</h4>
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.65rem;">Minggu Ini</small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card card-premium shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon bg-label-warning">
                <i class="ti tabler-calendar-due"></i>
              </div>
              <div>
                <h4 class="fw-bold mb-0">{{ $stats['this_month'] }}</h4>
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.65rem;">Bulan Ini</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Table Container --}}
    <div class="card card-premium shadow-sm border-0 overflow-hidden" id="tableContainer">
      @include('content.pages.admin.guest-book._table')
    </div>

  </div>
</div>

{{-- Modal Detail --}}
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 560px;">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
      <div class="modal-header p-4 border-bottom" style="background: linear-gradient(135deg, #fff 0%, #f5f7ff 100%);">
        <div class="d-flex align-items-center gap-3">
          <div class="detail-avatar d-flex align-items-center justify-content-center bg-primary text-white fw-bold rounded-3" id="detailAvatar" style="width: 56px; height: 56px; font-size: 1.5rem;">T</div>
          <div>
            <h5 class="modal-title fw-bold mb-1" id="detailNama">-</h5>
            <span class="badge bg-label-info" id="detailJenisInstansi" style="font-size: 0.7rem;">-</span>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div id="modalDetailContent">
          <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Memuat...</span>
            </div>
            <p class="text-muted mt-3 mb-0 small">Menarik data tamu dari server...</p>
          </div>
        </div>
      </div>
      <div class="modal-footer border-top bg-light-subtle p-3">
        <div class="d-flex gap-2 align-items-center w-100 justify-content-between">
          <small class="text-muted ps-2" id="detailWaktu">-</small>
          <button type="button" class="btn btn-label-secondary px-4 rounded-3" data-bs-dismiss="modal">
            Tutup
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .detail-field {
    padding: 1rem 0;
    border-bottom: 1px solid #f1f2f4;
  }
  .detail-field:last-child {
    border-bottom: none;
  }
  .detail-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    font-weight: 700;
    margin-bottom: 0.4rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  .detail-value {
    font-weight: 600;
    color: #1e293b;
    font-size: 0.95rem;
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  function fetchGuestBooks(url) {
    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(response => response.text())
    .then(html => { document.getElementById('tableContainer').innerHTML = html; });
  }

  window.loadDetail = function(id) {
    const content = document.getElementById('modalDetailContent');
    content.innerHTML = `<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="text-muted mt-3 mb-0 small">Menarik data tamu dari server...</p></div>`;
    const url = `{{ url('admin/buku-tamu') }}/${id}`;

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
    .then(response => { if (!response.ok) throw new Error('Gagal memuat data'); return response.json(); })
    .then(data => {
      const d = data.data;
      document.getElementById('detailAvatar').textContent = d.nama_lengkap.charAt(0).toUpperCase();
      document.getElementById('detailNama').textContent = d.nama_lengkap;
      document.getElementById('detailJenisInstansi').textContent = d.jenis_instansi;
      document.getElementById('detailWaktu').textContent = d.waktu;
      content.innerHTML = `
        <div class="detail-field"><div class="detail-label"><i class="ti tabler-brand-whatsapp text-success fs-5"></i> No. WhatsApp</div><div class="detail-value">${d.no_whatsapp}</div></div>
        <div class="detail-field"><div class="detail-label"><i class="ti tabler-map-pin text-danger fs-5"></i> Alamat</div><div class="detail-value">${d.alamat}</div></div>
        <div class="detail-field"><div class="detail-label"><i class="ti tabler-building text-info fs-5"></i> Instansi / Lembaga</div><div class="detail-value">${d.nama_instansi || '-'}</div></div>
        <div class="detail-field"><div class="detail-label"><i class="ti tabler-target text-warning fs-5"></i> Tujuan</div><div class="detail-value">${d.tujuan}</div></div>
        <div class="detail-field"><div class="detail-label"><i class="ti tabler-notes text-primary fs-5"></i> Keperluan</div><div class="detail-value">${d.keperluan}</div></div>
      `;
      const modal = new bootstrap.Modal(document.getElementById('modalDetail'));
      modal.show();
    })
    .catch(error => { content.innerHTML = `<div class="text-center py-5"><i class="ti tabler-alert-circle text-danger fs-1 mb-2"></i><p class="text-danger fw-bold mb-1">Gagal memuat data</p></div>`; });
  }

  document.addEventListener('click', function(e) {
    const pageLink = e.target.closest('.pagination a');
    if (pageLink) { e.preventDefault(); fetchGuestBooks(pageLink.href); }
    const btnDetail = e.target.closest('.btn-detail');
    if (btnDetail) { e.preventDefault(); loadDetail(btnDetail.dataset.id); }
    const btnReset = e.target.closest('.btn-reset-guest');
    if (btnReset) {
      e.preventDefault();
      if (confirm('PENTING: Anda akan menghapus SELURUH data buku tamu. Lanjutkan?')) {
        fetch(`{{ route('admin.guest-book.reset') }}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } })
        .then(response => response.json())
        .then(data => { if (data.success) { fetchGuestBooks(window.location.href); alert(data.message); } });
      }
    }
    const btnDelete = e.target.closest('.btn-delete');
    if (btnDelete) {
      if (confirm('Yakin ingin menghapus data ini?')) {
        fetch(`{{ url('admin/buku-tamu') }}/${btnDelete.dataset.id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } })
        .then(response => response.json())
        .then(data => { if (data.success) fetchGuestBooks(window.location.href); });
      }
    }
  });
});
</script>
@endsection
