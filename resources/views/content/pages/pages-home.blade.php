@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Dashboard PTSP')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection

@section('vendor-script')
@vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection

@section('page-style')
<style>
  .card, .btn, .badge, .avatar-initial, .quick-action-box, .stat-icon-wrapper, .premium-banner, .rounded {
    border-radius: 4px !important;
  }

  .premium-banner {
    background: linear-gradient(135deg, #696cff 0%, #4f52d4 100%);
    box-shadow: 0 10px 30px rgba(105, 108, 255, 0.2);
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .premium-banner:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(105, 108, 255, 0.3);
  }
  .premium-banner::after {
    content: '';
    position: absolute;
    top: 0; right: 0; bottom: 0; left: 0;
    background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
    pointer-events: none;
  }
  .stat-card {
    border: none;
    transition: all 0.3s ease;
    background: #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    position: relative;
    overflow: hidden;
  }
  .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.08);
  }
  .stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 4px; height: 100%;
  }
  .stat-card.primary::before { background: #696cff; }
  .stat-card.success::before { background: #71dd37; }
  .stat-card.warning::before { background: #ffab00; }
  .stat-card.info::before { background: #03c3ec; }
  .stat-card.danger::before { background: #ff3e1d; }

  .stat-icon-wrapper {
    width: 54px; height: 54px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
  }

  .table-premium th {
    background-color: #f8f9fa !important;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 1px;
    font-weight: 600;
  }

  .quick-action-box {
    transition: all 0.2s;
    background: rgba(105, 108, 255, 0.04);
    border: 1px dashed rgba(105, 108, 255, 0.3);
  }
  .quick-action-box:hover {
    background: rgba(105, 108, 255, 0.08);
    border-style: solid;
  }

  @media (max-width: 767.98px) {
    .premium-banner { padding: 1.25rem !important; }
    .premium-banner h4 { font-size: 1.1rem !important; }
    .premium-banner p { font-size: 0.9rem !important; }
    .stat-card .card-body { padding: 1rem !important; }
    .stat-card h3 { font-size: 1.25rem !important; }
    .stat-icon-wrapper { width: 42px; height: 42px; font-size: 20px; }
    .card-header { padding-top: 1rem !important; padding-bottom: 0.75rem !important; }
    .table-premium th, .table-premium td { padding: 0.75rem 0.5rem !important; }
    .banner-icon-box { width: 48px !important; height: 48px !important; margin-right: 1rem !important; }
    .banner-icon-box i { font-size: 1.25rem !important; }
  }

  @media (min-width: 768px) and (max-width: 991.98px) {
    .stat-card h3 { font-size: 1.5rem !important; }
    .stat-icon-wrapper { width: 48px; height: 48px; }
  }
</style>
@endsection

@section('content')
<div class="row g-2 g-md-3">

  {{-- Banner Dashboard PTSP --}}
  <div class="col-12">
    <div class="premium-banner p-4 text-white d-flex flex-column flex-md-row justify-content-between align-items-md-center">
      <div class="d-flex align-items-center mb-3 mb-md-0 z-1">
        <div class="bg-white p-3 rounded me-4 text-primary shadow-sm banner-icon-box" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
          <i class="icon-base ti tabler-layout-dashboard fs-2"></i>
        </div>
        <div>
          <h4 class="text-white mb-1 fw-bold">Dashboard PTSP</h4>
          <p class="mb-0 text-white-50" style="font-size: 1.05rem;">
            Total <strong class="text-white">{{ number_format($totalPermohonan) }}</strong> permohonan &middot;
            <strong class="text-white">{{ number_format($totalLayanan) }}</strong> layanan aktif
          </p>
        </div>
      </div>
      <div class="d-flex align-items-center gap-3 z-1">
        <a href="{{ route('ptsp.index') }}" class="btn btn-light rounded px-4 shadow-sm fw-semibold" target="_blank">
          <i class="icon-base ti tabler-external-link me-1"></i> Portal Publik
        </a>
      </div>
    </div>
  </div>

  {{-- Statistik PTSP --}}
  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card stat-card primary h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-muted mb-1 fs-6">Total Permohonan</p>
            <h3 class="mb-0 fw-bold">{{ number_format($totalPermohonan) }}</h3>
          </div>
          <div class="stat-icon-wrapper bg-label-primary">
            <i class="icon-base ti tabler-file-text"></i>
          </div>
        </div>
        <div class="mt-3 pt-2 border-top">
          <small class="text-muted"><i class="icon-base ti tabler-database me-1"></i>Semua permohonan masuk</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card stat-card warning h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-muted mb-1 fs-6">Pending</p>
            <h3 class="mb-0 fw-bold">{{ number_format($pending) }}</h3>
          </div>
          <div class="stat-icon-wrapper bg-label-warning">
            <i class="icon-base ti tabler-clock"></i>
          </div>
        </div>
        <div class="mt-3 pt-2 border-top">
          <small class="text-warning fw-semibold">
            <i class="icon-base ti tabler-alert-circle me-1"></i>
            {{ $totalPermohonan > 0 ? round(($pending/$totalPermohonan)*100, 1) : 0 }}%
          </small>
          <small class="text-muted">dari total</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card stat-card info h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-muted mb-1 fs-6">Diproses</p>
            <h3 class="mb-0 fw-bold">{{ number_format($proses) }}</h3>
          </div>
          <div class="stat-icon-wrapper bg-label-info">
            <i class="icon-base ti tabler-loader"></i>
          </div>
        </div>
        <div class="mt-3 pt-2 border-top">
          <small class="text-info fw-semibold">
            <i class="icon-base ti tabler-trending-up me-1"></i>
            {{ $totalPermohonan > 0 ? round(($proses/$totalPermohonan)*100, 1) : 0 }}%
          </small>
          <small class="text-muted">dari total</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card stat-card success h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-muted mb-1 fs-6">Selesai</p>
            <h3 class="mb-0 fw-bold">{{ number_format($selesai) }}</h3>
          </div>
          <div class="stat-icon-wrapper bg-label-success">
            <i class="icon-base ti tabler-check-circle"></i>
          </div>
        </div>
        <div class="mt-3 pt-2 border-top">
          <small class="text-success fw-semibold">
            <i class="icon-base ti tabler-check me-1"></i>
            {{ $totalPermohonan > 0 ? round(($selesai/$totalPermohonan)*100, 1) : 0 }}%
          </small>
          <small class="text-muted">selesai diproses</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card stat-card danger h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-muted mb-1 fs-6">Publik (NISN)</p>
            <h3 class="mb-0 fw-bold">{{ number_format($publik) }}</h3>
          </div>
          <div class="stat-icon-wrapper bg-label-danger">
            <i class="icon-base ti tabler-id"></i>
          </div>
        </div>
        <div class="mt-3 pt-2 border-top">
          <small class="text-muted">
            <i class="icon-base ti tabler-users me-1"></i>Tanpa login
          </small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card stat-card primary h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-muted mb-1 fs-6">Layanan Aktif</p>
            <h3 class="mb-0 fw-bold">{{ number_format($totalLayanan) }}</h3>
          </div>
          <div class="stat-icon-wrapper bg-label-primary">
            <i class="icon-base ti tabler-grid"></i>
          </div>
        </div>
        <div class="mt-3 pt-2 border-top">
          <small class="text-muted">
            <i class="icon-base ti tabler-circle-check me-1"></i>Layanan tersedia
          </small>
        </div>
      </div>
    </div>
  </div>

  {{-- Tabel Permohonan Terbaru --}}
  <div class="col-12 col-xl-8">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom pt-4 pb-3">
        <h5 class="card-title mb-0 fw-bold"><i class="icon-base ti tabler-file-description text-primary me-2"></i>Permohonan Terbaru</h5>
        <a href="{{ route('admin.ptsp.index') }}" class="btn btn-sm btn-label-primary rounded">Lihat Semua</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover table-premium mb-0">
            <thead>
              <tr>
                <th class="ps-4">No. Tiket</th>
                <th>Pemohon</th>
                <th>Layanan</th>
                <th>Status</th>
                <th class="text-end pe-4">Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @if(isset($permohonanTerbaru) && $permohonanTerbaru->count() > 0)
                @foreach($permohonanTerbaru as $p)
                <tr>
                  <td class="ps-4 text-muted fw-semibold">
                    <code class="text-primary">{{ $p->no_tiket }}</code>
                  </td>
                  <td class="fw-bold">
                    @if($p->user_id)
                      {{ $p->user->name ?? 'N/A' }}
                    @elseif($p->nisn)
                      {{ $p->siswa->nama_lengkap ?? 'NISN: '.$p->nisn }}
                    @else
                      <span class="text-muted">—</span>
                    @endif
                  </td>
                  <td>
                    <span class="text-body small">{{ $p->layanan->nama_layanan ?? '—' }}</span>
                  </td>
                  <td>
                    @switch($p->status)
                      @case('pending')
                        <span class="badge bg-label-warning">Pending</span>
                        @break
                      @case('proses')
                        <span class="badge bg-label-info">Diproses</span>
                        @break
                      @case('selesai')
                        <span class="badge bg-label-success">Selesai</span>
                        @break
                      @case('ditolak')
                        <span class="badge bg-label-danger">Ditolak</span>
                        @break
                      @default
                        <span class="badge bg-label-secondary">{{ $p->status }}</span>
                    @endswitch
                  </td>
                  <td class="text-end pe-4 text-muted small">
                    {{ $p->created_at->locale('id')->diffForHumans() }}
                  </td>
                </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">Belum ada permohonan.</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- Akses Cepat PTSP --}}
  <div class="col-12 col-xl-4">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-header pt-4 pb-0 bg-transparent border-0">
        <h5 class="card-title fw-bold mb-0"><i class="icon-base ti tabler-link text-primary me-2"></i>Akses Cepat</h5>
      </div>
      <div class="card-body pt-3">

        <div class="d-flex mb-4">
          <div class="flex-shrink-0 me-3">
            <div class="avatar avatar-sm">
              <span class="avatar-initial rounded bg-label-primary"><i class="icon-base ti tabler-file-text"></i></span>
            </div>
          </div>
          <div>
            <h6 class="mb-1 fw-bold">Manajemen Permohonan</h6>
            <p class="mb-0 text-muted small">Kelola semua permohonan layanan PTSP, update status, dan lihat detail pemohon.</p>
          </div>
        </div>

        <div class="d-flex mb-4">
          <div class="flex-shrink-0 me-3">
            <div class="avatar avatar-sm">
              <span class="avatar-initial rounded bg-label-success"><i class="icon-base ti tabler-search"></i></span>
            </div>
          </div>
          <div>
            <h6 class="mb-1 fw-bold">Tracking Permohonan</h6>
            <p class="mb-0 text-muted small">Pantau status permohonan via nomor tiket yang diberikan ke pemohon.</p>
          </div>
        </div>

        <div class="d-flex mb-4">
          <div class="flex-shrink-0 me-3">
            <div class="avatar avatar-sm">
              <span class="avatar-initial rounded bg-label-warning"><i class="icon-base ti tabler-settings"></i></span>
            </div>
          </div>
          <div>
            <h6 class="mb-1 fw-bold">Pengaturan Sistem</h6>
            <p class="mb-0 text-muted small">Atur konfigurasi umum, layanan, dan preferensi sistem PTSP.</p>
          </div>
        </div>

        <div class="mt-4 pt-3 border-top">
          <h6 class="fw-bold mb-3">Menu Cepat</h6>
          <div class="row g-2">
            <div class="col-6">
              <a href="{{ route('admin.ptsp.index') }}" class="d-block p-3 quick-action-box text-center text-decoration-none">
                <i class="icon-base ti tabler-file-text fs-3 text-primary mb-1"></i>
                <div class="fw-semibold text-dark small">Permohonan</div>
              </a>
            </div>
            <div class="col-6">
              <a href="{{ route('ptsp.tracking') }}" class="d-block p-3 quick-action-box text-center text-decoration-none" target="_blank">
                <i class="icon-base ti tabler-search fs-3 text-success mb-1"></i>
                <div class="fw-semibold text-dark small">Tracking</div>
              </a>
            </div>
            <div class="col-6">
              <a href="{{ route('admin.pengaturan.umum') }}" class="d-block p-3 quick-action-box text-center text-decoration-none">
                <i class="icon-base ti tabler-settings fs-3 text-warning mb-1"></i>
                <div class="fw-semibold text-dark small">Pengaturan</div>
              </a>
            </div>
            <div class="col-6">
              <a href="{{ route('admin.siswa.index') }}" class="d-block p-3 quick-action-box text-center text-decoration-none">
                <i class="icon-base ti tabler-users fs-3 text-info mb-1"></i>
                <div class="fw-semibold text-dark small">Data Siswa</div>
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

</div>
@endsection
