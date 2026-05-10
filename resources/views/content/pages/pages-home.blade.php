@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Dashboard Admin')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection

@section('vendor-script')
@vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection

@section('page-style')
<style>
  /* Premium Dashboard Styles */
  .premium-banner {
    background: linear-gradient(135deg, #696cff 0%, #4f52d4 100%);
    border-radius: 4px;
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
    border-radius: 4px;
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
  .stat-card.danger::before { background: #ff3e1d; }
  .stat-card.warning::before { background: #ffab00; }
  
  .stat-icon-wrapper {
    width: 54px; height: 54px;
    border-radius: 4px;
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
  
  .announcement-card {
    background: linear-gradient(180deg, #fff 0%, #fafafa 100%);
    border: 1px solid rgba(0,0,0,0.05);
  }
  
  .quick-action-box {
    transition: all 0.2s;
    border-radius: 4px;
    background: rgba(105, 108, 255, 0.04);
    border: 1px dashed rgba(105, 108, 255, 0.3);
  }
  .quick-action-box:hover {
    background: rgba(105, 108, 255, 0.08);
    border-style: solid;
  }

  /* Responsive Adjustments */
  @media (max-width: 767.98px) {
    .premium-banner {
      padding: 1.25rem !important;
    }
    .premium-banner h4 {
      font-size: 1.1rem !important;
    }
    .premium-banner p {
      font-size: 0.9rem !important;
    }
    .stat-card .card-body {
      padding: 1rem !important;
    }
    .stat-card h3 {
      font-size: 1.25rem !important;
    }
    .stat-icon-wrapper {
      width: 42px;
      height: 42px;
      font-size: 20px;
    }
    .card-header {
      padding-top: 1rem !important;
      padding-bottom: 0.75rem !important;
    }
    .table-premium th, .table-premium td {
      padding: 0.75rem 0.5rem !important;
    }
    .ps-4 {
      padding-left: 1rem !important;
    }
    .pe-4 {
      padding-right: 1rem !important;
    }
    .gap-mobile {
      gap: 0.5rem !important;
    }
    .banner-icon-box {
      width: 48px !important;
      height: 48px !important;
      margin-right: 1rem !important;
    }
    .banner-icon-box i {
      font-size: 1.25rem !important;
    }
  }

  @media (min-width: 768px) and (max-width: 991.98px) {
    .stat-card h3 {
      font-size: 1.5rem !important;
    }
    .stat-icon-wrapper {
      width: 48px;
      height: 48px;
    }
  }
</style>
@endsection

@section('content')
<div class="row g-2 g-md-3">
  <!-- Status Pengumuman Banner -->
  <div class="col-12">
    <div class="premium-banner p-4 text-white d-flex flex-column flex-md-row justify-content-between align-items-md-center">
      <div class="d-flex align-items-center mb-3 mb-md-0 z-1">
        <div class="bg-white p-3 rounded me-4 text-primary shadow-sm banner-icon-box" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 4px !important;">
          <i class="icon-base ti tabler-antenna fs-2"></i>
        </div>
        <div>
          <h4 class="text-white mb-1 fw-bold">Status Sistem Pengumuman</h4>
          <p class="mb-0 text-white-50" style="font-size: 1.05rem;">
            Jadwal Rilis: <strong class="text-white">{{ $tglPengumuman }}</strong>
          </p>
        </div>
      </div>
      <div class="d-flex align-items-center gap-3 z-1">
        @if($statusPengumuman == '1')
          <div class="badge bg-white text-success px-3 py-2 fs-6 rounded shadow-sm d-flex align-items-center gap-2" style="border-radius: 4px !important;">
            <span class="spinner-grow spinner-grow-sm text-success" role="status" aria-hidden="true"></span>
            LIVE / AKTIF
          </div>
        @else
          <div class="badge bg-white text-danger px-3 py-2 fs-6 rounded shadow-sm d-flex align-items-center gap-2" style="border-radius: 4px !important;">
            <i class="icon-base ti tabler-lock"></i> DITUTUP
          </div>
        @endif
        <a href="{{ route('admin.pengaturan.kelulusan') }}" class="btn btn-light rounded px-4 shadow-sm fw-semibold" style="border-radius: 4px !important;">
          <i class="icon-base ti tabler-settings-2 me-1"></i> Atur
        </a>
      </div>
    </div>
  </div>

  <!-- Statistik Kelulusan -->
  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card stat-card primary h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-muted mb-1 fs-6">Total Siswa</p>
            <h3 class="mb-0 fw-bold">{{ number_format($totalSiswa) }}</h3>
          </div>
          <div class="stat-icon-wrapper bg-label-primary">
            <i class="icon-base ti tabler-users"></i>
          </div>
        </div>
        <div class="mt-3 pt-2 border-top">
          <small class="text-muted"><i class="icon-base ti tabler-database me-1"></i>Terdaftar dalam sistem</small>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card stat-card success h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-muted mb-1 fs-6">Lulus</p>
            <h3 class="mb-0 fw-bold">{{ number_format($lulus) }}</h3>
          </div>
          <div class="stat-icon-wrapper bg-label-success">
            <i class="icon-base ti tabler-shield-check"></i>
          </div>
        </div>
        <div class="mt-3 pt-2 border-top">
          <small class="text-success fw-semibold"><i class="icon-base ti tabler-trending-up me-1"></i>{{ $totalSiswa > 0 ? round(($lulus/$totalSiswa)*100, 1) : 0 }}%</small> <small class="text-muted">dari total</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card stat-card danger h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-muted mb-1 fs-6">Tidak Lulus</p>
            <h3 class="mb-0 fw-bold">{{ number_format($tidakLulus) }}</h3>
          </div>
          <div class="stat-icon-wrapper bg-label-danger">
            <i class="icon-base ti tabler-circle-x"></i>
          </div>
        </div>
        <div class="mt-3 pt-2 border-top">
          <small class="text-danger fw-semibold"><i class="icon-base ti tabler-trending-down me-1"></i>{{ $totalSiswa > 0 ? round(($tidakLulus/$totalSiswa)*100, 1) : 0 }}%</small> <small class="text-muted">dari total</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card stat-card warning h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-muted mb-1 fs-6">Belum Proses</p>
            <h3 class="mb-0 fw-bold">{{ number_format($belumDitentukan) }}</h3>
          </div>
          <div class="stat-icon-wrapper bg-label-warning">
            <i class="icon-base ti tabler-hourglass"></i>
          </div>
        </div>
        <div class="mt-3 pt-2 border-top">
          <small class="text-warning fw-semibold"><i class="icon-base ti tabler-alert-circle me-1"></i>Perlu tindakan</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Data Siswa & Pengumuman -->
  <div class="col-12 col-xl-8">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom pt-4 pb-3">
        <h5 class="card-title mb-0 fw-bold"><i class="icon-base ti tabler-user-check text-primary me-2"></i>Data Siswa Terbaru</h5>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-sm btn-label-primary rounded" style="border-radius: 4px !important;">Lihat Semua</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover table-premium mb-0">
            <thead>
              <tr>
                <th class="ps-4">NISN</th>
                <th>Nama Lengkap</th>
                <th>Status</th>
                <th class="text-end pe-4">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @if(isset($siswaTerbaru) && $siswaTerbaru->count() > 0)
                @foreach($siswaTerbaru as $s)
                <tr>
                  <td class="ps-4 text-muted fw-semibold">{{ $s->nisn }}</td>
                  <td class="fw-bold">{{ $s->nama_lengkap }}</td>
                  <td>
                    @if($s->status_kelulusan == 'lulus')
                      <span class="badge bg-label-success"><i class="icon-base ti tabler-check me-1"></i>Lulus</span>
                    @elseif($s->status_kelulusan == 'tidak_lulus')
                      <span class="badge bg-label-danger"><i class="icon-base ti tabler-x me-1"></i>Tidak Lulus</span>
                    @else
                      <span class="badge bg-label-warning"><i class="icon-base ti tabler-clock me-1"></i>Belum</span>
                    @endif
                  </td>
                  <td class="text-end pe-4">
                    <a href="{{ route('admin.siswa.edit', $s->id) }}" class="btn btn-icon btn-sm btn-text-secondary rounded" style="border-radius: 4px !important;"><i class="icon-base ti tabler-edit"></i></a>
                  </td>
                </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="4" class="text-center py-4 text-muted">Belum ada data siswa.</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-12 col-xl-4">
    <div class="card announcement-card h-100 border-0 shadow-sm">
      <div class="card-header pt-4 pb-0 bg-transparent border-0">
        <h5 class="card-title fw-bold mb-0"><i class="icon-base ti tabler-bell text-warning me-2"></i>Pengumuman Penting</h5>
      </div>
      <div class="card-body pt-3">
        <div class="d-flex mb-4">
          <div class="flex-shrink-0 me-3">
            <div class="avatar avatar-sm">
              <span class="avatar-initial rounded bg-label-warning" style="border-radius: 4px !important;"><i class="icon-base ti tabler-info-circle"></i></span>
            </div>
          </div>
          <div>
            <h6 class="mb-1 fw-bold">Persiapan Pengumuman</h6>
            <p class="mb-0 text-muted small">Pastikan semua data siswa telah di-import dan status kelulusan sudah diatur sebelum mengubah status pengumuman menjadi AKTIF.</p>
          </div>
        </div>
        
        <div class="d-flex mb-4">
          <div class="flex-shrink-0 me-3">
            <div class="avatar avatar-sm">
              <span class="avatar-initial rounded bg-label-success" style="border-radius: 4px !important;"><i class="icon-base ti tabler-shield-check"></i></span>
            </div>
          </div>
          <div>
            <h6 class="mb-1 fw-bold">Backup Data</h6>
            <p class="mb-0 text-muted small">Sistem aman. Jangan lupa untuk mendownload rekap excel setelah pengumuman selesai dilaksanakan.</p>
          </div>
        </div>

        <div class="mt-4 pt-3 border-top">
          <h6 class="fw-bold mb-3">Aksi Cepat</h6>
          <div class="row g-2">
            <div class="col-6">
              <a href="{{ route('admin.siswa.index') }}" class="d-block p-3 quick-action-box text-center text-decoration-none">
                <i class="icon-base ti tabler-users fs-3 text-primary mb-1"></i>
                <div class="fw-semibold text-dark small">Kelola Siswa</div>
              </a>
            </div>
            <div class="col-6">
              <a href="{{ route('admin.pengaturan.kelulusan') }}" class="d-block p-3 quick-action-box text-center text-decoration-none">
                <i class="icon-base ti tabler-settings fs-3 text-primary mb-1"></i>
                <div class="fw-semibold text-dark small">Pengaturan</div>
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

</div>
@endsection
