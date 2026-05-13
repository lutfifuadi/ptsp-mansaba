@extends('layouts/contentNavbarLayout')

@section('title', 'Buku Tamu Online - Admin')
@section('navbar-title', 'Buku Tamu Online')

@section('page-style')
@include('_partials.admin-styles')
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

.notif-toast {
  position: fixed;
  top: 20px;
  right: -420px;
  max-width: 400px;
  width: 100%;
  background: #ffffff;
  border-radius: 16px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.15), 0 0 0 1px rgba(5,150,105,0.1);
  z-index: 9999;
  transition: right 0.5s cubic-bezier(0.22, 1, 0.36, 1);
  overflow: hidden;
}
.notif-toast.show {
  right: 20px;
}
.notif-toast .notif-bar {
  height: 4px;
  background: linear-gradient(90deg, #059669, #34d399);
  width: 100%;
  animation: shrinkWidth 10s linear forwards;
}
@keyframes shrinkWidth {
  from { width: 100%; }
  to { width: 0%; }
}
.notif-toast .notif-body {
  padding: 20px;
}
.notif-toast .notif-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: #ecfdf5;
  color: #059669;
  font-size: 0.7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  padding: 4px 12px;
  border-radius: 20px;
  margin-bottom: 12px;
}
.notif-toast .notif-badge .pulse-dot {
  width: 8px;
  height: 8px;
  background: #059669;
  border-radius: 50%;
  animation: pulse 1.5s infinite;
}
@keyframes pulse {
  0%, 100% { transform: scale(1); opacity: 1; }
  50% { transform: scale(1.5); opacity: 0.5; }
}
.notif-toast .notif-avatar {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 1.2rem;
  flex-shrink: 0;
}
.notif-toast .notif-close {
  position: absolute;
  top: 12px;
  right: 12px;
  width: 28px;
  height: 28px;
  border: none;
  background: #f1f5f9;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #64748b;
  cursor: pointer;
  transition: all 0.2s;
}
.notif-toast .notif-close:hover {
  background: #e2e8f0;
  color: #1e293b;
}
</style>
@endsection

@section('content')
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
        <div class="card stat-card h-100" style="--accent-color: var(--p); --icon-bg: #ecfdf5;">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon">
                <i class="ti tabler-users"></i>
              </div>
              <div>
                <div class="stat-label">Total Tamu</div>
                <div class="stat-value">{{ $stats['total'] }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="--accent-color: var(--p); --icon-bg: #ecfdf5;">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon">
                <i class="ti tabler-calendar-event"></i>
              </div>
              <div>
                <div class="stat-label">Hari Ini</div>
                <div class="stat-value">{{ $stats['today'] }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="--accent-color: var(--indigo); --icon-bg: #eef2ff;">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon">
                <i class="ti tabler-calendar-stats"></i>
              </div>
              <div>
                <div class="stat-label">Minggu Ini</div>
                <div class="stat-value">{{ $stats['this_week'] }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="--accent-color: var(--amber); --icon-bg: #fef3c7;">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon">
                <i class="ti tabler-calendar-due"></i>
              </div>
              <div>
                <div class="stat-label">Bulan Ini</div>
                <div class="stat-value">{{ $stats['this_month'] }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Table Container --}}
    <div class="panel shadow-sm" id="tableContainer">
      @include('content.pages.admin.guest-book._table')
    </div>

  </div>
</div>

{{-- Notification Toast --}}
<div class="notif-toast" id="notifToast">
  <div class="notif-bar" id="notifBar"></div>
  <div class="notif-body">
    <button type="button" class="notif-close" id="notifClose" title="Tutup">
      <i class="ti tabler-x fs-6"></i>
    </button>
    <div class="notif-badge">
      <span class="pulse-dot"></span>
      <span id="notifBadgeText">Kunjungan Baru</span>
    </div>
    <div class="d-flex gap-3">
      <div class="notif-avatar bg-primary text-white" id="notifAvatar">T</div>
      <div class="flex-grow-1 min-width-0">
        <div class="fw-bold text-dark mb-1" id="notifNama" style="font-size: 1rem;">-</div>
        <div class="d-flex align-items-center gap-2 text-muted small mb-2">
          <i class="ti tabler-clock fs-6"></i>
          <span id="notifWaktu">-</span>
        </div>
        <div class="d-flex align-items-center gap-2 mb-1">
          <i class="ti tabler-target text-warning fs-6"></i>
          <span class="text-dark small fw-medium" id="notifTujuan">-</span>
        </div>
        <div class="text-muted small text-truncate" id="notifKeperluan">-</div>
        <div class="d-flex gap-2 mt-3">
          <button class="btn btn-sm btn-primary rounded-3 d-flex align-items-center gap-1" id="notifDetailBtn">
            <i class="ti tabler-eye fs-6"></i> Lihat Detail
          </button>
          <button class="btn btn-sm btn-label-secondary rounded-3" id="notifDismissBtn">
            Tutup
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Modal Reset Konfirmasi --}}
<div class="modal fade" id="modalReset" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
      <div class="modal-body text-center p-4 pt-5 pb-4">
        <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 rounded-3 mb-3" style="width: 72px; height: 72px;">
          <i class="ti tabler-alert-triangle text-danger" style="font-size: 2.2rem;"></i>
        </div>
        <h5 class="fw-bold mb-2">Reset Semua Data?</h5>
        <p class="text-muted small mb-0" style="max-width: 320px; margin: 0 auto;">
          Tindakan ini akan menghapus <strong>seluruh data buku tamu</strong> secara permanen. Data yang sudah dihapus <strong class="text-danger">tidak dapat dikembalikan</strong>.
        </p>
      </div>
      <div class="d-flex border-top">
        <button type="button" class="btn btn-lg flex-fill border-0 rounded-0 py-3 fw-semibold text-muted" data-bs-dismiss="modal" style="background: #f8fafc;">Batal</button>
        <button type="button" class="btn btn-lg flex-fill border-0 rounded-0 py-3 fw-semibold text-white" id="btnResetConfirm" style="background: #dc2626;">Ya, Reset Semua</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal Detail --}}
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 560px;">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
      <div class="modal-header p-4 border-bottom">
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
      const modal = new bootstrap.Modal(document.getElementById('modalReset'));
      modal.show();
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

  // --- Reset Handler ---
  document.getElementById('btnResetConfirm').addEventListener('click', function() {
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Mereset...';
    fetch(`{{ route('admin.guest-book.reset') }}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        bootstrap.Modal.getInstance(document.getElementById('modalReset')).hide();
        fetchGuestBooks(window.location.href);
      }
    })
    .finally(() => { btn.disabled = false; btn.textContent = 'Ya, Reset Semua'; });
  });

  // --- Polling Notifikasi ---
  let latestId = {{ $guestBooks->first() ? $guestBooks->first()->id : 0 }};
  let notifTimeout = null;

  function showNotif(entry) {
    const toast = document.getElementById('notifToast');
    const bar = document.getElementById('notifBar');

    document.getElementById('notifAvatar').textContent = entry.nama_lengkap.charAt(0).toUpperCase();
    document.getElementById('notifNama').textContent = entry.nama_lengkap;
    document.getElementById('notifWaktu').textContent = entry.waktu;
    document.getElementById('notifTujuan').textContent = entry.tujuan;
    document.getElementById('notifKeperluan').textContent = entry.keperluan;

    document.getElementById('notifDetailBtn').onclick = function() {
      hideNotif();
      loadDetail(entry.id);
    };

    toast.classList.add('show');

    bar.style.animation = 'none';
    void bar.offsetWidth;
    bar.style.animation = 'shrinkWidth 12s linear forwards';

    if (notifTimeout) clearTimeout(notifTimeout);
    notifTimeout = setTimeout(hideNotif, 12000);
  }

  function hideNotif() {
    document.getElementById('notifToast').classList.remove('show');
    if (notifTimeout) { clearTimeout(notifTimeout); notifTimeout = null; }
  }

  document.getElementById('notifClose').addEventListener('click', hideNotif);
  document.getElementById('notifDismissBtn').addEventListener('click', hideNotif);

  function pollLatest() {
    fetch(`{{ url('admin/buku-tamu/latest') }}?after_id=${latestId}`, {
      headers: { 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(response => {
      if (response.success && response.total_new > 0) {
        const entries = response.data;
        latestId = response.latest_id;
        showNotif(entries[entries.length - 1]);
        setTimeout(() => fetchGuestBooks(window.location.href), 1000);
      }
    })
    .catch(() => {});
  }

  setInterval(pollLatest, 30000);
  setTimeout(pollLatest, 5000);
});
</script>
@endsection
