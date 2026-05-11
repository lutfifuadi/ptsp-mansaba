@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Rekap Buku Tamu - Admin')

@section('page-style')
<style>
  .header-gradient {
    background: linear-gradient(135deg, #f5f7ff 0%, #ffffff 100%);
    border-radius: 4px;
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid #eef0f2;
  }
  .stat-card {
    border: none;
    border-radius: 4px;
    padding: 1.25rem;
    transition: all 0.2s;
  }
  .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
  }
  .stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
  }
  .stat-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #566a7f;
    font-weight: 600;
  }
  .stat-value {
    font-size: 1.75rem;
    font-weight: 700;
  }
  .btn-premium-primary {
    background: linear-gradient(135deg, #696cff 0%, #4f52d4 100%);
    border: none;
    box-shadow: 0 4px 12px rgba(105, 108, 255, 0.3);
    color: #fff;
    padding: 0.6rem 1.5rem;
    font-weight: 600;
    border-radius: 4px;
  }
  .btn-premium-primary:hover {
    box-shadow: 0 6px 18px rgba(105, 108, 255, 0.4);
    transform: translateY(-1px);
    color: #fff;
  }
  .btn-premium-success {
    background: linear-gradient(135deg, #28c76f 0%, #1fa85b 100%);
    border: none;
    box-shadow: 0 4px 12px rgba(40, 199, 111, 0.3);
    color: #fff;
    padding: 0.6rem 1.5rem;
    font-weight: 600;
    border-radius: 4px;
  }
  .btn-premium-success:hover {
    box-shadow: 0 6px 18px rgba(40, 199, 111, 0.4);
    transform: translateY(-1px);
    color: #fff;
  }
  .btn-premium-warning {
    background: linear-gradient(135deg, #ff9f43 0%, #e08830 100%);
    border: none;
    box-shadow: 0 4px 12px rgba(255, 159, 67, 0.3);
    color: #fff;
    padding: 0.6rem 1.5rem;
    font-weight: 600;
    border-radius: 4px;
  }
  .btn-premium-warning:hover {
    box-shadow: 0 6px 18px rgba(255, 159, 67, 0.4);
    transform: translateY(-1px);
    color: #fff;
  }
  .table-rekap th {
    background-color: #fcfdfe !important;
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 1px;
    font-weight: 700;
    color: #566a7f;
    border-top: none !important;
    padding-top: 1rem !important;
    padding-bottom: 1rem !important;
  }
  .table-rekap td {
    padding-top: 0.85rem !important;
    padding-bottom: 0.85rem !important;
    vertical-align: middle;
  }
  .table-rekap tr:hover {
    background-color: #f5f7ff !important;
  }
  .pagination-container nav > div:first-child {
    display: none !important;
  }
  .pagination-container nav > div:last-child {
    display: flex !important;
    width: 100%;
    justify-content: flex-end !important;
  }
  .pagination-container nav > div:last-child > div:first-child {
    display: none !important;
  }
  .pagination-container .pagination {
    margin-bottom: 0;
    gap: 4px;
  }
  .pagination-container .page-link {
    border: none;
    background: #f1f2f4;
    color: #566a7f;
    border-radius: 4px !important;
    margin: 0;
    padding: 0.5rem 0.85rem;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.2s;
  }
  .pagination-container .page-link:hover {
    background: #eef0f2;
    color: #696cff;
    transform: translateY(-1px);
  }
  .pagination-container .page-item.active .page-link {
    background: #696cff;
    color: #fff;
    box-shadow: 0 4px 10px rgba(105, 108, 255, 0.3);
  }
</style>
@endsection

@section('content')
  {{-- Header --}}
  <div class="header-gradient d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
      <h3 class="fw-bold mb-1 text-primary">Rekap Buku Tamu</h3>
      <p class="text-muted mb-0">Rekapitulasi dan ekspor data kunjungan tamu.</p>
      <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.guest-book.index') }}">Buku Tamu</a></li>
          <li class="breadcrumb-item active">Rekap</li>
        </ol>
      </nav>
    </div>
    <div class="d-flex flex-wrap gap-2">
      <a href="{{ route('admin.guest-book.export', 'xlsx') }}" class="btn btn-premium-success">
        <i class="icon-base ti tabler-file-spreadsheet me-1"></i> Export Excel
      </a>
      <a href="{{ route('admin.guest-book.export', 'csv') }}" class="btn btn-premium-warning">
        <i class="icon-base ti tabler-file-text me-1"></i> Export CSV
      </a>
    </div>
  </div>

  {{-- Statistik --}}
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="stat-card card bg-white shadow-sm h-100">
        <div class="d-flex align-items-center gap-3">
          <div class="stat-icon bg-label-primary">
            <i class="icon-base ti tabler-users text-primary"></i>
          </div>
          <div>
            <div class="stat-label">Total Kunjungan</div>
            <div class="stat-value text-primary">{{ $total }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="stat-card card bg-white shadow-sm h-100">
        <div class="d-flex align-items-center gap-3">
          <div class="stat-icon bg-label-success">
            <i class="icon-base ti tabler-calendar-check text-success"></i>
          </div>
          <div>
            <div class="stat-label">Hari Ini</div>
            <div class="stat-value text-success">{{ $today }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="stat-card card bg-white shadow-sm h-100">
        <div class="d-flex align-items-center gap-3">
          <div class="stat-icon bg-label-info">
            <i class="icon-base ti tabler-calendar-stats text-info"></i>
          </div>
          <div>
            <div class="stat-label">Bulan Ini</div>
            <div class="stat-value text-info">{{ $thisMonth }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Statistik Instansi --}}
  @if($instansiStats->isNotEmpty())
  <div class="card border-0 shadow-sm mb-4" style="border-radius: 4px;">
    <div class="card-header bg-white border-bottom py-3">
      <h5 class="mb-0 fw-bold"><i class="icon-base ti tabler-chart-pie me-2 text-primary"></i> Statistik Instansi</h5>
    </div>
    <div class="card-body p-4">
      <div class="row g-3">
        @foreach($instansiStats as $jenis => $count)
        <div class="col-md-4">
          <div class="d-flex align-items-center gap-3 p-3 rounded" style="background: #f8f9fa;">
            <div class="stat-icon" style="width:40px;height:40px;background:rgba(105,108,255,0.1)">
              <i class="icon-base ti tabler-building-community text-primary"></i>
            </div>
            <div>
              <div class="fw-bold small">{{ $jenis }}</div>
              <div class="text-muted small">{{ $count }} kunjungan</div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  @endif

  {{-- Tabel --}}
  <div class="card border-0 shadow-sm" style="border-radius: 4px;">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
      <h5 class="mb-0 fw-bold">Data Kunjungan Terbaru</h5>
      <span class="badge bg-label-primary px-3 py-2" style="border-radius: 4px;">{{ $guestBooks->total() }} Data</span>
    </div>
    <div class="table-responsive">
      <table class="table table-rekap mb-0">
        <thead>
          <tr>
            <th style="width:40px">#</th>
            <th>Nama</th>
            <th>Kontak</th>
            <th>Instansi</th>
            <th>Tujuan</th>
            <th>Waktu</th>
          </tr>
        </thead>
        <tbody>
          @forelse($guestBooks as $index => $gb)
          <tr>
            <td class="text-muted small ps-4">{{ $guestBooks->firstItem() + $index }}</td>
            <td class="fw-bold text-dark">{{ $gb->nama_lengkap }}</td>
            <td>
              <div class="small">{{ $gb->no_whatsapp }}</div>
              <div class="text-muted small">{{ $gb->alamat }}</div>
            </td>
            <td>
              <span class="badge bg-label-info" style="border-radius: 4px;">{{ $gb->jenis_instansi }}</span>
              @if($gb->nama_instansi)
                <div class="text-muted small mt-1">{{ $gb->nama_instansi }}</div>
              @endif
            </td>
            <td>
              <div class="fw-bold small">{{ $gb->tujuan }}</div>
              <div class="text-muted small">{{ \Illuminate\Support\Str::limit($gb->keperluan, 30) }}</div>
            </td>
            <td class="small">{{ $gb->created_at->format('d/m/Y H:i') }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5">
              <div class="text-muted mb-2"><i class="icon-base ti tabler-book-off fs-1"></i></div>
              <div class="fw-bold">Belum ada data buku tamu.</div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer bg-white border-top py-3">
      <div class="d-flex justify-content-end">
        <div class="pagination-container">
          {{ $guestBooks->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection
