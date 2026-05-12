@extends('layouts/contentNavbarLayout')

@section('title', $title ?? 'Manajemen Permohonan')
@section('navbar-title', $title ?? 'Manajemen Permohonan')

@section('content')
<style>
  :root {
    --primary-premium: #059669;
    --primary-glow: rgba(5, 150, 105, 0.15);
    --gold-premium: #d4af37;
    --glass-bg: rgba(255, 255, 255, 0.9);
  }

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

  .premium-table tbody td {
    padding: 1rem;
    vertical-align: middle;
  }

  .badge-premium {
    padding: 0.5em 1em;
    font-weight: 600;
    border-radius: 6px;
    font-size: 0.75rem;
  }

  .btn-premium-gradient {
    background: linear-gradient(135deg, var(--primary-premium) 0%, #10b981 100%);
    color: white;
    border: none;
    box-shadow: 0 4px 15px var(--primary-glow);
  }

  .btn-premium-gradient:hover {
    background: linear-gradient(135deg, #047857 0%, #059669 100%);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px var(--primary-glow);
  }

  .search-wrapper {
    position: relative;
  }

  .search-wrapper .ti {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
  }

  .search-wrapper input {
    padding-left: 38px;
    border-radius: 8px;
  }
</style>

<div class="row">
  <div class="col-12">

    {{-- Header Section --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
      <div>
        <div class="d-flex align-items-center gap-2 mb-1">
          <div class="p-2 rounded-3 bg-label-success">
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
              <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.ptsp.export', array_merge(['format' => 'xlsx'], request()->query())) }}">
                <i class="ti tabler-file-spreadsheet text-success fs-4"></i> Export Excel (.xlsx)
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.ptsp.export', array_merge(['format' => 'csv'], request()->query())) }}">
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
        <div class="card card-premium shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon bg-label-warning">
                <i class="ti tabler-clock"></i>
              </div>
              <div>
                <h4 class="fw-bold mb-0">{{ $statPending }}</h4>
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Pending</small>
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
                <i class="ti tabler-loader"></i>
              </div>
              <div>
                <h4 class="fw-bold mb-0">{{ $statProses }}</h4>
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Diproses</small>
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
                <i class="ti tabler-circle-check"></i>
              </div>
              <div>
                <h4 class="fw-bold mb-0">{{ $statSelesai }}</h4>
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Selesai</small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card card-premium shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3">
              <div class="stat-icon bg-label-primary">
                <i class="ti tabler-list-details"></i>
              </div>
              <div>
                <h4 class="fw-bold mb-0">{{ $statTotal }}</h4>
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Total Data</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Main Content Table --}}
    <div class="card card-premium shadow-sm border-0">
      <div class="card-header border-bottom py-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
          <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
            <i class="ti tabler-table text-primary"></i> Daftar Permohonan
          </h5>
          
          <form method="GET" action="{{ url()->current() }}" class="d-flex flex-wrap gap-2">
            <div class="search-wrapper">
              <i class="ti tabler-search"></i>
              <input type="text" name="search" class="form-control" placeholder="Cari tiket, NISN, nama..." value="{{ request('search') }}" style="min-width: 250px;">
            </div>
            
            <select name="status" class="form-select w-auto" onchange="this.form.submit()">
              <option value="">Semua Status</option>
              @foreach(['pending','proses','selesai','ditolak'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
              @endforeach
            </select>

            @if(request()->hasAny(['status','search']))
              <a href="{{ url()->current() }}" class="btn btn-label-secondary d-flex align-items-center">
                <i class="ti tabler-refresh me-1"></i> Reset
              </a>
            @endif
          </form>
        </div>
      </div>
      
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 premium-table">
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
                <div class="fw-bold text-primary">{{ $p->no_tiket }}</div>
                <small class="text-muted d-flex align-items-center gap-1">
                  @if($p->user_id) <i class="ti tabler-user-check fs-6 text-success"></i> Login @else <i class="ti tabler-world fs-6 text-info"></i> Publik @endif
                </small>
              </td>
              <td>
                <div class="d-flex align-items-center gap-3">
                  @php
                    $initials = '';
                    $name = 'N/A';
                    if($p->user_id) {
                      $name = $p->user->name ?? 'N/A';
                    } elseif($p->nisn) {
                      $name = $p->siswa->nama_lengkap ?? 'Pemohon ('.$p->nisn.')';
                    }
                    $initials = collect(explode(' ', $name))->take(2)->map(fn($n) => strtoupper(substr($n, 0, 1)))->implode('');
                  @endphp
                  <div class="avatar avatar-sm bg-label-{{ $p->user_id ? 'success' : 'info' }} rounded-3 d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                    {{ $initials }}
                  </div>
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
                <span class="badge bg-label-secondary badge-premium">
                  {{ $p->layanan->nama_layanan ?? 'Umum' }}
                </span>
              </td>
              <td>
                @php
                  $color = 'secondary';
                  $iconStatus = 'tabler-dots';
                  switch($p->status) {
                    case 'pending': $color = 'warning'; $iconStatus = 'tabler-clock'; break;
                    case 'proses': $color = 'info'; $iconStatus = 'tabler-loader'; break;
                    case 'selesai': $color = 'success'; $iconStatus = 'tabler-circle-check'; break;
                    case 'ditolak': $color = 'danger'; $iconStatus = 'tabler-circle-x'; break;
                  }
                @endphp
                <span class="badge bg-label-{{ $color }} badge-premium d-inline-flex align-items-center gap-1">
                  <i class="ti {{ $iconStatus }} fs-6"></i> {{ strtoupper($p->status) }}
                </span>
              </td>
              <td>
                <div class="text-dark fw-medium small">{{ $p->created_at->format('d M Y') }}</div>
                <small class="text-muted">{{ $p->created_at->format('H:i') }} WIB</small>
              </td>
              <td class="text-center">
                <a href="{{ route('admin.ptsp.show', $p->id) }}" class="btn btn-icon btn-label-primary rounded-3">
                  <i class="ti tabler-eye"></i>
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center py-5">
                <div class="mb-3">
                  <i class="ti tabler-search-off fs-1 text-muted opacity-50"></i>
                </div>
                <h5 class="text-muted">Tidak ada data ditemukan</h5>
                <p class="text-muted small mb-0">Silakan sesuaikan filter atau kata kunci pencarian Anda.</p>
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
      <div class="modal-header p-4" style="background:linear-gradient(135deg, #fff 0%, #fef2f2 100%);">
        <div class="d-flex align-items-center gap-3">
          <div class="p-2 rounded-3 bg-label-danger">
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
            <div class="d-flex align-items-center justify-content-between p-3 rounded-3 border border-dashed border-light bg-light-subtle">
              <div>
                <div class="fw-bold text-dark">{{ $l->nama_layanan }}</div>
                <div class="badge bg-label-secondary small rounded-pill">{{ $count }} Record</div>
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
