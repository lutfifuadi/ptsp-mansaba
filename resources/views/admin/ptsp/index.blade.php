@extends('layouts/contentNavbarLayout')

@section('title', $title ?? 'Manajemen Permohonan')
@section('navbar-title', $title ?? 'Manajemen Permohonan')

@section('page-style')
@include('_partials.admin-styles')
@endsection

@section('content')
<div class="row">
  <div class="col-12">

    {{-- Header Section --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
      <div>
        <div class="d-flex align-items-center gap-2 mb-1">
          <div class="p-2 rounded-3" style="background:#ecfdf5;color:#059669;">
            <i class="ti {{ $icon ?? 'tabler-database' }} fs-3"></i>
          </div>
          <h4 class="fw-bold mb-0">{{ $title ?? 'Manajemen Permohonan' }}</h4>
        </div>
        <p class="text-muted mb-0">
          @if(isset($layanan))
            Sistem manajemen data permohonan layanan <strong>{{ $layanan->nama_layanan }}</strong>
          @else
            Pantau dan kelola semua data permohonan PTSP dalam satu dashboard terpadu.
          @endif
        </p>
      </div>
      <div class="d-flex gap-2">
        <div class="dropdown">
          <button class="btn btn-label-success dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
            <i class="ti tabler-download fs-4"></i> Export
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            <li>
              <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.ptsp.export', array_merge(['format' => 'xlsx'], isset($layanan) ? ['layanan_id' => $layanan->id] : [], request()->query())) }}">
                <i class="ti tabler-file-spreadsheet text-success fs-4"></i> Export Excel (.xlsx)
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.ptsp.export', array_merge(['format' => 'csv'], isset($layanan) ? ['layanan_id' => $layanan->id] : [], request()->query())) }}">
                <i class="ti tabler-file-text text-warning fs-4"></i> Export CSV (.csv)
              </a>
            </li>
          </ul>
        </div>
        <button type="button" class="btn btn-label-danger btn-reset-ptsp d-flex align-items-center gap-2">
          <i class="ti tabler-trash fs-4"></i> Reset
        </button>
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
      @php
        $layananId = isset($layanan) ? $layanan->id : null;
        $statPending  = \App\Models\Permohonan::where('status','pending')->when($layananId, fn($q) => $q->where('layanan_id', $layananId))->count();
        $statProses   = \App\Models\Permohonan::where('status','proses')->when($layananId, fn($q) => $q->where('layanan_id', $layananId))->count();
        $statSelesai  = \App\Models\Permohonan::where('status','selesai')->when($layananId, fn($q) => $q->where('layanan_id', $layananId))->count();
        $statTotal    = \App\Models\Permohonan::when($layananId, fn($q) => $q->where('layanan_id', $layananId))->count();
      @endphp

      <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="--accent-color: #d97706; --icon-bg: #fef3c7;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start gap-2">
              <div class="flex-grow-1">
                <p class="stat-label">Pending</p>
                <div class="stat-value">{{ $statPending }}</div>
              </div>
              <div class="stat-icon"><i class="ti tabler-clock-hour-4"></i></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="--accent-color: #4f46e5; --icon-bg: #eef2ff;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start gap-2">
              <div class="flex-grow-1">
                <p class="stat-label">Diproses</p>
                <div class="stat-value">{{ $statProses }}</div>
              </div>
              <div class="stat-icon"><i class="ti tabler-loader"></i></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="--accent-color: #059669; --icon-bg: #ecfdf5;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start gap-2">
              <div class="flex-grow-1">
                <p class="stat-label">Selesai</p>
                <div class="stat-value">{{ $statSelesai }}</div>
              </div>
              <div class="stat-icon"><i class="ti tabler-circle-check"></i></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="--accent-color: #0284c7; --icon-bg: #e0f2fe;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start gap-2">
              <div class="flex-grow-1">
                <p class="stat-label">Total Data</p>
                <div class="stat-value">{{ $statTotal }}</div>
              </div>
              <div class="stat-icon"><i class="ti tabler-list-details"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Main Content Table --}}
    <div class="card panel shadow-sm">
      <div class="section-head">
        <h5 class="section-head-title"><i class="ti tabler-table text-primary"></i> Daftar Permohonan</h5>
        <form method="GET" action="{{ url()->current() }}" class="d-flex flex-wrap gap-2">
          <div style="position:relative;">
            <i class="ti tabler-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;"></i>
            <input type="text" name="search" class="form-control" placeholder="Cari tiket, NISN, nama..." value="{{ request('search') }}" style="padding-left:38px;min-width:250px;">
          </div>
          <select name="status" class="form-select w-auto" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            @foreach(['pending','proses','selesai','ditolak'] as $s)
              <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
          </select>
          @if(request()->hasAny(['status','search']))
            <a href="{{ url()->current() }}" class="btn btn-view d-flex align-items-center">
              <i class="ti tabler-refresh me-1"></i> Reset
            </a>
          @endif
        </form>
      </div>

      <div class="table-responsive">
        <table class="table tbl mb-0">
          <thead>
            <tr>
              <th width="50">#</th>
              <th>No. Tiket</th>
              <th>Pemohon</th>
              <th>Layanan</th>
              <th>Status</th>
              <th>Waktu</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($permohonan as $p)
            <tr>
              <td class="text-muted small">{{ $loop->iteration + ($permohonan->firstItem() - 1) }}</td>
              <td>
                <span class="ticket-no">{{ $p->no_tiket }}</span>
              </td>
              <td>
                <div class="d-flex align-items-center gap-3">
                  @php
                    $initials = '';
                    $name = 'N/A';
                    if($p->user_id) {
                      $name = strtoupper($p->user->name ?? 'N/A');
                    } elseif($p->nisn) {
                      $name = strtoupper($p->siswa->nama_lengkap ?? 'Pemohon ('.$p->nisn.')');
                    } elseif($p->data_form && ($p->data_form['nama_lengkap'] ?? null)) {
                      $name = strtoupper($p->data_form['nama_lengkap']);
                    }
                    $initials = collect(explode(' ', $name))->take(2)->map(fn($n) => strtoupper(substr($n, 0, 1)))->implode('');
                  @endphp
                  <div class="av">{{ $initials }}</div>
                  <div>
                    <div class="fw-bold mb-0 text-dark" style="font-size: 0.9rem;">{{ $name }}</div>
                    @if($p->nisn)
                      <small class="text-muted">NISN: {{ $p->nisn }}</small>
                    @elseif($p->user)
                      <small class="text-muted">{{ $p->user->email }}</small>
                    @endif
                  </div>
                </div>
              </td>
              <td>
                <span class="st-badge st-default">{{ $p->layanan->nama_layanan ?? 'Umum' }}</span>
              </td>
              <td>
                <span class="st-badge st-{{ $p->status }}">{{ strtoupper($p->status) }}</span>
              </td>
              <td>
                <div class="text-dark fw-medium small">{{ $p->created_at->format('d M Y') }}</div>
                <small class="text-muted">{{ $p->created_at->format('H:i') }} WIB</small>
              </td>
              <td class="text-center">
                <a href="{{ route('admin.ptsp.show', $p->id) }}" class="btn btn-view btn-sm">
                  <i class="ti tabler-eye"></i>
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="p-0">
                <div class="empty-state">
                  <i class="ti tabler-search-off"></i>
                  <p>Tidak ada data ditemukan. Silakan sesuaikan filter atau kata kunci pencarian Anda.</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($permohonan->hasPages())
        <div class="card-footer border-top py-3 d-flex justify-content-center">
          {{ $permohonan->withQueryString()->links() }}
        </div>
      @endif
    </div>
  </div>
</div>

{{-- Modal Reset Data --}}
<div class="modal fade" id="modalReset" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius:15px; overflow: hidden;">
      <div class="modal-header p-4">
        <div class="d-flex align-items-center gap-3">
          <div class="p-2 rounded-3" style="background:#fee2e2;color:#dc2626;">
            <i class="ti tabler-alert-triangle fs-3"></i>
          </div>
          <div>
            <h5 class="modal-title fw-bold text-danger mb-0">Reset Data Permohonan</h5>
            <small class="text-muted">Penghapusan data permanen</small>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <p class="text-muted mb-4">Pilih layanan yang datanya ingin direset secara massal. Tindakan ini <strong>tidak dapat dibatalkan</strong>.</p>

        <div class="d-flex flex-column gap-3" id="layananResetList">
          @php $layananList = \App\Models\Layanan::where('is_active', true)->get(); @endphp
          @foreach($layananList as $l)
            @php $count = \App\Models\Permohonan::where('layanan_id', $l->id)->count(); @endphp
            <div class="d-flex align-items-center justify-content-between p-3 rounded-3 border border-dashed border-light" style="background:#f8f9fa;">
              <div>
                <div class="fw-bold text-dark">{{ $l->nama_layanan }}</div>
                <span class="st-badge st-default">{{ $count }} Record</span>
              </div>
              <button type="button" class="btn btn-sm btn-label-danger btn-reset-layanan" data-id="{{ $l->id }}" data-name="{{ $l->nama_layanan }}" data-count="{{ $count }}" {{ $count == 0 ? 'disabled' : '' }}>
                <i class="ti tabler-trash me-1"></i> Reset
              </button>
            </div>
          @endforeach
        </div>
      </div>
      <div class="modal-footer border-top-0 p-4">
        <button type="button" class="btn btn-label-secondary w-100 py-2 rounded-3" data-bs-dismiss="modal">Batalkan</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('click', function(e) {
  const btnOpenReset = e.target.closest('.btn-reset-ptsp');
  if (btnOpenReset) {
    e.preventDefault();
    const modal = new bootstrap.Modal(document.getElementById('modalReset'));
    modal.show();
  }

  const btnResetLayanan = e.target.closest('.btn-reset-layanan');
  if (btnResetLayanan) {
    e.preventDefault();
    const id = btnResetLayanan.dataset.id;
    const name = btnResetLayanan.dataset.name;
    const count = btnResetLayanan.dataset.count;

    if (confirm(`PENTING: Anda akan menghapus ${count} data permohonan dari layanan "${name}". Data ini akan hilang selamanya. Lanjutkan?`)) {
      const url = `{{ url('admin/ptsp/reset') }}/${id}`;
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
          alert(data.message);
          location.reload();
        } else {
          alert('Gagal: ' + data.message);
        }
      });
    }
  }
});
</script>
@endsection
