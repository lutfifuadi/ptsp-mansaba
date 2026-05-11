@extends('layouts/contentNavbarLayout')

@section('title', $selectedLayanan ? 'Manajemen ' . $selectedLayanan->nama_layanan : 'Manajemen Permohonan PTS')
@section('navbar-title', $selectedLayanan ? $selectedLayanan->nama_layanan : 'Manajemen Permohonan')

@section('content')
<div class="row">
  <div class="col-12">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
      <div>
        <h4 class="fw-bold mb-1">{{ $selectedLayanan ? $selectedLayanan->nama_layanan : 'Manajemen Permohonan' }}</h4>
        <p class="text-muted mb-0">
          @if($selectedLayanan)
            Kelola permohonan khusus layanan <strong>{{ $selectedLayanan->nama_layanan }}</strong>
          @else
            Kelola semua permohonan layanan PTSP (login & publik)
          @endif
        </p>
      </div>
      <div class="d-flex gap-2">
        <div class="dropdown">
          <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius:4px;">
            <i class="icon-base ti tabler-download me-1"></i> Export
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.ptsp.export', array_merge(['format' => 'xlsx'], request()->query())) }}">
                <i class="icon-base ti tabler-file-spreadsheet text-success me-2"></i> Export Excel (.xlsx)
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.ptsp.export', array_merge(['format' => 'csv'], request()->query())) }}">
                <i class="icon-base ti tabler-file-text text-warning me-2"></i> Export CSV (.csv)
              </a>
            </li>
          </ul>
        </div>
        <button type="button" class="btn btn-danger btn-reset-ptsp" style="border-radius:4px;">
          <i class="bx bx-trash me-1"></i> Reset Data
        </button>
        <a href="{{ route('ptsp.index') }}" class="btn btn-outline-secondary" target="_blank" style="border-radius:4px;">
          <i class="bx bx-link-external me-1"></i> Portal Publik
        </a>
      </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible mb-4" role="alert">
        <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
      @php
        $layananId = $selectedLayanan ? $selectedLayanan->id : null;
        $statPending  = \App\Models\Permohonan::where('status','pending')->when($layananId, fn($q) => $q->where('layanan_id', $layananId))->count();
        $statProses   = \App\Models\Permohonan::where('status','proses')->when($layananId, fn($q) => $q->where('layanan_id', $layananId))->count();
        $statSelesai  = \App\Models\Permohonan::where('status','selesai')->when($layananId, fn($q) => $q->where('layanan_id', $layananId))->count();
        $statPublik   = \App\Models\Permohonan::whereNull('user_id')->when($layananId, fn($q) => $q->where('layanan_id', $layananId))->count();
      @endphp

      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="avatar avatar-md bg-label-warning">
              <i class="bx bx-time fs-4"></i>
            </div>
            <div>
              <div class="fw-bold fs-4">{{ $statPending }}</div>
              <div class="text-muted small">Pending</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="avatar avatar-md bg-label-info">
              <i class="bx bx-loader-alt fs-4"></i>
            </div>
            <div>
              <div class="fw-bold fs-4">{{ $statProses }}</div>
              <div class="text-muted small">Diproses</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="avatar avatar-md bg-label-success">
              <i class="bx bx-check-circle fs-4"></i>
            </div>
            <div>
              <div class="fw-bold fs-4">{{ $statSelesai }}</div>
              <div class="text-muted small">Selesai</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="avatar avatar-md bg-label-primary">
              <i class="bx bx-globe fs-4"></i>
            </div>
            <div>
              <div class="fw-bold fs-4">{{ $statPublik }}</div>
              <div class="text-muted small">Publik (NISN)</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">
      <div class="card-header d-flex align-items-center justify-content-between py-3">
        <h6 class="mb-0 fw-semibold">Daftar Permohonan</h6>
        {{-- Filter / Search --}}
        <form method="GET" action="{{ route('admin.ptsp.index') }}" class="d-flex gap-2">
          @if(request('layanan_id'))
            <input type="hidden" name="layanan_id" value="{{ request('layanan_id') }}">
          @endif
          <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width:140px">
            <option value="">Semua Status</option>
            @foreach(['pending','proses','selesai','ditolak'] as $s)
              <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
          </select>
          <select name="sumber" class="form-select form-select-sm" onchange="this.form.submit()" style="width:140px">
            <option value="">Semua Sumber</option>
            <option value="login" {{ request('sumber') === 'login' ? 'selected' : '' }}>Login</option>
            <option value="publik" {{ request('sumber') === 'publik' ? 'selected' : '' }}>Publik (NISN)</option>
          </select>
          <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari tiket / nama..." value="{{ request('search') }}" style="width:180px">
          <button type="submit" class="btn btn-primary btn-sm">
            <i class="bx bx-search"></i>
          </button>
          @if(request()->hasAny(['status','sumber','search']))
            <a href="{{ route('admin.ptsp.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
          @endif
        </form>
      </div>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>No. Tiket</th>
              <th>Pemohon</th>
              <th>Sumber</th>
              <th>Layanan</th>
              <th>Status</th>
              <th>Tanggal</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($permohonan as $p)
            <tr>
              <td class="text-muted small">{{ $loop->iteration + ($permohonan->firstItem() - 1) }}</td>
              <td>
                <code class="text-primary fw-semibold">{{ $p->no_tiket }}</code>
              </td>
              <td>
                @if($p->user_id)
                  {{-- Login user --}}
                  <div class="d-flex align-items-center gap-2">
                    <div class="avatar avatar-xs bg-label-secondary">
                      <i class="bx bx-user"></i>
                    </div>
                    <div>
                      <div class="fw-semibold small">{{ $p->user->name ?? 'N/A' }}</div>
                      <div class="text-muted" style="font-size:0.72rem">{{ $p->user->email ?? '' }}</div>
                    </div>
                  </div>
                @elseif($p->nisn)
                  {{-- Public via NISN --}}
                  <div class="d-flex align-items-center gap-2">
                    <div class="avatar avatar-xs bg-label-primary">
                      <i class="bx bx-id-card"></i>
                    </div>
                    <div>
                      @php $siswa = $p->siswa; @endphp
                      <div class="fw-semibold small">{{ $siswa->nama_lengkap ?? 'NISN: '.$p->nisn }}</div>
                      <div class="text-muted" style="font-size:0.72rem">
                        NISN: {{ $p->nisn }}
                        @if($siswa) · {{ $siswa->kelas }} @endif
                      </div>
                    </div>
                  </div>
                @else
                  <span class="text-muted small">—</span>
                @endif
              </td>
              <td>
                @if($p->user_id)
                  <span class="badge bg-label-secondary">Login</span>
                @else
                  <span class="badge bg-label-primary">Publik</span>
                @endif
              </td>
              <td>
                <span class="text-body small">{{ $p->layanan->nama_layanan ?? '—' }}</span>
              </td>
              <td>
                @switch($p->status)
                  @case('pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                    @break
                  @case('proses')
                    <span class="badge bg-info">Diproses</span>
                    @break
                  @case('selesai')
                    <span class="badge bg-success">Selesai</span>
                    @break
                  @case('ditolak')
                    <span class="badge bg-danger">Ditolak</span>
                    @break
                  @default
                    <span class="badge bg-secondary">{{ $p->status }}</span>
                @endswitch
              </td>
              <td class="small text-muted">
                {{ $p->created_at->locale('id')->diffForHumans() }}
              </td>
              <td class="text-center">
                <a href="{{ route('admin.ptsp.show', $p->id) }}" class="btn btn-sm btn-outline-primary">
                  <i class="bx bx-show me-1"></i>Detail
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-5 text-muted">
                <i class="bx bx-inbox fs-1 d-block mb-2"></i>
                Belum ada permohonan
                @if(request()->hasAny(['status','sumber','search']))
                  yang sesuai filter
                @endif
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if($permohonan->hasPages())
        <div class="card-footer d-flex justify-content-center">
          {{ $permohonan->withQueryString()->links() }}
        </div>
      @endif
    </div>
  </div>
</div>

{{-- Modal Reset Data --}}
<div class="modal fade" id="modalReset" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius:8px;">
      <div class="modal-header border-bottom p-4" style="background:linear-gradient(135deg, #fef5f5 0%, #fff 100%);">
        <h5 class="modal-title fw-bold text-danger mb-0">
          <i class="bx bx-trash me-1"></i> Reset Data Permohonan
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="alert alert-warning d-flex align-items-center mb-4" role="alert" style="border-radius:4px;">
          <i class="bx bx-info-circle me-2 fs-4"></i>
          <div class="small">
            Pilih layanan yang datanya ingin direset. Data yang sudah dihapus <strong>tidak bisa dikembalikan</strong>.
          </div>
        </div>
        <div class="d-flex flex-column gap-2" id="layananResetList">
          @php $layananList = \App\Models\Layanan::where('is_active', true)->get(); @endphp
          @foreach($layananList as $l)
            @php $count = \App\Models\Permohonan::where('layanan_id', $l->id)->count(); @endphp
            <div class="d-flex align-items-center justify-content-between p-3 rounded" style="background:#f8f9fa;">
              <div>
                <div class="fw-semibold small">{{ $l->nama_layanan }}</div>
                <div class="text-muted small">{{ $count }} data</div>
              </div>
              <button type="button" class="btn btn-sm btn-outline-danger btn-reset-layanan" data-id="{{ $l->id }}" data-name="{{ $l->nama_layanan }}" data-count="{{ $count }}" style="border-radius:4px;" {{ $count == 0 ? 'disabled' : '' }}>
                <i class="bx bx-trash me-1"></i> Reset
              </button>
            </div>
          @endforeach
        </div>
      </div>
      <div class="modal-footer border-top bg-light p-3">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" style="border-radius:4px;">Tutup</button>
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

    if (confirm(`Yakin ingin mereset ${count} data permohonan "${name}"? Data yang dihapus tidak bisa dikembalikan.`)) {
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
