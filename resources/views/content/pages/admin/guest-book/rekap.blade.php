@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Rekap Buku Tamu - Admin')

@section('page-style')
@include('_partials.admin-styles')
@endsection

@section('content')
  {{-- Header --}}
  <div class="panel mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 p-3">
      <div>
        <h3 class="fw-bold mb-1">Rekap Buku Tamu</h3>
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
        <a href="{{ route('admin.guest-book.export', 'xlsx') }}" class="btn btn-view">
          <i class="ti tabler-file-spreadsheet me-1"></i> Export Excel
        </a>
        <a href="{{ route('admin.guest-book.export', 'csv') }}" class="btn btn-view">
          <i class="ti tabler-file-text me-1"></i> Export CSV
        </a>
      </div>
    </div>
  </div>

  {{-- Statistik --}}
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card stat-card h-100" style="--accent-color: var(--p); --icon-bg: #ecfdf5;">
        <div class="card-body">
          <div class="d-flex align-items-center gap-3">
            <div class="stat-icon">
              <i class="ti tabler-users"></i>
            </div>
            <div>
              <div class="stat-label">Total Kunjungan</div>
              <div class="stat-value">{{ $total }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card stat-card h-100" style="--accent-color: var(--p); --icon-bg: #ecfdf5;">
        <div class="card-body">
          <div class="d-flex align-items-center gap-3">
            <div class="stat-icon">
              <i class="ti tabler-calendar-check"></i>
            </div>
            <div>
              <div class="stat-label">Hari Ini</div>
              <div class="stat-value">{{ $today }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card stat-card h-100" style="--accent-color: var(--indigo); --icon-bg: #eef2ff;">
        <div class="card-body">
          <div class="d-flex align-items-center gap-3">
            <div class="stat-icon">
              <i class="ti tabler-calendar-stats"></i>
            </div>
            <div>
              <div class="stat-label">Bulan Ini</div>
              <div class="stat-value">{{ $thisMonth }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Statistik Instansi --}}
  @if($instansiStats->isNotEmpty())
  <div class="panel mb-4">
    <div class="section-head">
      <h5 class="section-head-title"><i class="ti tabler-chart-pie"></i> Statistik Instansi</h5>
    </div>
    <div class="panel-body">
      <div class="row g-3">
        @foreach($instansiStats as $jenis => $count)
        <div class="col-md-4">
          <div class="d-flex align-items-center gap-3 p-3 rounded" style="background: #f8f9fa;">
            <div class="d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:rgba(105,108,255,0.1);border-radius:var(--r);">
              <i class="ti tabler-building-community text-primary"></i>
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
  <div class="panel">
    <div class="section-head">
      <h5 class="section-head-title">Data Kunjungan Terbaru</h5>
      <span class="badge bg-label-primary px-3 py-2" style="border-radius: 4px;">{{ $guestBooks->total() }} Data</span>
    </div>
    <div class="table-responsive">
      <table class="table tbl mb-0">
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
              <div class="text-muted mb-2"><i class="ti tabler-book-off fs-1"></i></div>
              <div class="fw-bold">Belum ada data buku tamu.</div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($guestBooks->hasPages())
    <div class="border-top d-flex justify-content-end p-3">
      {{ $guestBooks->links() }}
    </div>
    @endif
  </div>
@endsection
