@extends('layouts/contentNavbarLayout')

@section('title', 'Manajemen Permohonan PTSP')

@section('content')
<div class="row">
  <div class="col-12">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
      <div>
        <h4 class="fw-bold mb-1">Manajemen Permohonan</h4>
        <p class="text-muted mb-0">Kelola semua permohonan layanan PTSP (login & publik)</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('ptsp.index') }}" class="btn btn-outline-secondary" target="_blank">
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
        $allPermohonan = $permohonan->getCollection();
        $statPending  = \App\Models\Permohonan::where('status','pending')->count();
        $statProses   = \App\Models\Permohonan::where('status','proses')->count();
        $statSelesai  = \App\Models\Permohonan::where('status','selesai')->count();
        $statPublik   = \App\Models\Permohonan::whereNull('user_id')->count();
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
@endsection
