@php
  use Illuminate\Support\Facades\Auth;
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
    /* ── ROOT TOKENS ─────────────────────────────── */
    :root {
      --p: #059669;
      --p2: #047857;
      --p3: #064e3b;
      --amber: #d97706;
      --red: #dc2626;
      --indigo: #4f46e5;
      --sky: #0284c7;
      --muted: #64748b;
      --text: #0f172a;
      --surface: #ffffff;
      --bg: #f1f5f9;
      --border: #e2e8f0;
      --border2: #cbd5e1;
      --r: 4px;
      /* default radius */
      --r-sm: 3px;
      --r-lg: 5px;
      /* max per spec */
    }

    /* ── RESET OVERRIDES ─────────────────────────── */
    .card,
    .btn,
    .badge,
    .avatar-initial,
    .rounded {
      border-radius: var(--r) !important;
    }

    /* ── LAYOUT BG ───────────────────────────────── */
    .page-body {
      background: var(--bg) !important;
    }

    /* ── GREETING STRIP ──────────────────────────── */
    .greeting-strip {
      border-left: 4px solid var(--p);
      padding-left: 14px;
    }

    .greeting-strip h4 {
      font-size: 1.35rem;
      font-weight: 800;
      color: var(--text);
    }

    .date-chip {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: var(--surface);
      border: 1px solid var(--border2);
      padding: 6px 14px;
      border-radius: var(--r);
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--muted);
    }

    /* ── HERO BANNER ─────────────────────────────── */
    .hero-banner {
      background: var(--p3);
      border-radius: var(--r-lg) !important;
      position: relative;
      overflow: hidden;
      border: none;
    }

    /* Diagonal accent stripe */
    .hero-banner::before {
      content: '';
      position: absolute;
      top: 0;
      right: 120px;
      width: 3px;
      height: 100%;
      background: rgba(255, 255, 255, 0.08);
      transform: skewX(-12deg);
    }

    .hero-banner::after {
      content: '';
      position: absolute;
      top: 0;
      right: 100px;
      width: 60px;
      height: 100%;
      background: rgba(255, 255, 255, 0.04);
      transform: skewX(-12deg);
    }

    .hero-icon {
      width: 56px;
      height: 56px;
      background: var(--p);
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: var(--r);
      font-size: 1.5rem;
      color: #fff;
      flex-shrink: 0;
      box-shadow: 4px 4px 0 rgba(0, 0, 0, 0.25);
    }

    .hero-banner h3 {
      font-size: 1.5rem;
      font-weight: 800;
      color: #fff;
      margin: 0;
      letter-spacing: -0.3px;
    }

    .hero-badge {
      display: inline-block;
      background: var(--p);
      color: #fff;
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      padding: 4px 12px;
      border-radius: var(--r-sm);
      margin-bottom: 6px;
    }

    .hero-btn {
      background: #fff;
      color: var(--p3) !important;
      border: none;
      border-radius: var(--r) !important;
      font-weight: 700;
      font-size: 0.85rem;
      padding: 10px 22px;
      box-shadow: 3px 3px 0 rgba(0, 0, 0, 0.2);
      transition: transform 0.15s, box-shadow 0.15s;
      white-space: nowrap;
    }

    .hero-btn:hover {
      transform: translate(-1px, -1px);
      box-shadow: 4px 4px 0 rgba(0, 0, 0, 0.25);
      color: var(--p3) !important;
    }

    /* Decorative large number watermark */
    .hero-watermark {
      position: absolute;
      right: 160px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 6rem;
      font-weight: 900;
      line-height: 1;
      color: rgba(255, 255, 255, 0.04);
      pointer-events: none;
      user-select: none;
      letter-spacing: -6px;
    }

    /* ── STAT CARDS ───────────────────────────────── */
    .stat-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--r-lg) !important;
      border-top: 3px solid var(--accent-color, var(--p));
      transition: transform 0.18s, box-shadow 0.18s;
      position: relative;
      overflow: hidden;
    }

    .stat-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      border-color: var(--accent-color, var(--p));
      border-top-color: var(--accent-color, var(--p));
    }

    /* Faint diagonal tint */
    .stat-card::after {
      content: '';
      position: absolute;
      top: 0;
      right: -30px;
      width: 80px;
      height: 100%;
      background: linear-gradient(to right, transparent, rgba(0, 0, 0, 0.015));
      transform: skewX(-15deg);
      pointer-events: none;
    }

    .stat-icon {
      width: 42px;
      height: 42px;
      background: var(--icon-bg, #ecfdf5);
      border-radius: var(--r);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
      color: var(--accent-color, var(--p));
      flex-shrink: 0;
      transition: background 0.2s, color 0.2s;
    }

    .stat-card:hover .stat-icon {
      background: var(--accent-color, var(--p));
      color: #fff;
    }

    .stat-label {
      font-size: 0.75rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--muted);
      margin-bottom: 3px;
    }

    .stat-value {
      font-size: 1.75rem;
      font-weight: 900;
      line-height: 1.1;
      color: var(--accent-color, var(--text));
    }

    .stat-progress {
      height: 3px;
      background: var(--border);
      border-radius: 0;
      overflow: hidden;
      margin-top: 12px;
    }

    .stat-progress-bar {
      height: 100%;
      background: var(--accent-color, var(--p));
      transition: width 1s ease;
    }

    /* ── SECTION HEADER ───────────────────────────── */
    .section-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 14px 20px;
      border-bottom: 1px solid var(--border);
      background: #f8fafc;
    }

    .section-head-title {
      font-size: 0.88rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--text);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .section-head-title .dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--p);
      flex-shrink: 0;
    }

    /* ── TABLE ────────────────────────────────────── */
    .tbl th {
      background: #f8fafc !important;
      color: var(--muted) !important;
      font-weight: 800;
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      padding: 12px 16px !important;
      border-bottom: 2px solid var(--border) !important;
      border-top: none !important;
    }

    .tbl td {
      padding: 13px 16px !important;
      vertical-align: middle;
      border-bottom: 1px solid #f1f5f9 !important;
      font-size: 0.88rem;
      color: var(--text);
    }

    .tbl tbody tr {
      transition: background 0.12s;
    }

    .tbl tbody tr:hover td {
      background: #f8fafc !important;
    }

    /* Ticket number */
    .ticket-no {
      font-family: monospace;
      font-size: 0.82rem;
      font-weight: 700;
      color: var(--p);
      background: #ecfdf5;
      padding: 4px 10px;
      border-radius: var(--r-sm);
      border: 1px solid #a7f3d0;
      white-space: nowrap;
    }

    /* Avatar initial */
    .av {
      width: 30px;
      height: 30px;
      border-radius: var(--r);
      background: var(--p3);
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.8rem;
      font-weight: 800;
      flex-shrink: 0;
      text-transform: uppercase;
    }

    /* Status badges */
    .st-badge {
      font-size: 0.72rem;
      font-weight: 800;
      letter-spacing: 0.8px;
      text-transform: uppercase;
      padding: 4px 12px;
      border-radius: var(--r-sm);
    }

    .st-pending {
      background: #fef3c7;
      color: #92400e;
      border: 1px solid #fcd34d;
    }

    .st-proses {
      background: #e0f2fe;
      color: #075985;
      border: 1px solid #7dd3fc;
    }

    .st-selesai {
      background: #dcfce7;
      color: #14532d;
      border: 1px solid #86efac;
    }

    .st-ditolak {
      background: #fee2e2;
      color: #7f1d1d;
      border: 1px solid #fca5a5;
    }

    .st-default {
      background: #f1f5f9;
      color: #475569;
      border: 1px solid #cbd5e1;
    }

    /* ── QUICK ACCESS PANEL ───────────────────────── */
    .qa-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 14px;
      border: 1px solid var(--border);
      border-radius: var(--r);
      background: var(--surface);
      text-decoration: none !important;
      transition: border-color 0.15s, transform 0.15s, box-shadow 0.15s;
      border-left: 3px solid var(--qa-color, var(--p));
    }

    .qa-item:hover {
      border-color: var(--qa-color, var(--p));
      transform: translateX(3px);
      box-shadow: -3px 0 0 var(--qa-color, var(--p));
      text-decoration: none !important;
    }

    .qa-icon {
      width: 32px;
      height: 32px;
      background: var(--qa-bg, #ecfdf5);
      border-radius: var(--r);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.9rem;
      color: var(--qa-color, var(--p));
      flex-shrink: 0;
    }

    .qa-title {
      font-size: 0.78rem;
      font-weight: 700;
      color: var(--text);
      margin: 0;
    }

    .qa-sub {
      font-size: 0.68rem;
      color: var(--muted);
      margin: 0;
    }

    /* ── SHORTCUTS ────────────────────────────────── */
    .shortcut {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 16px 8px;
      border: 1px solid var(--border);
      border-radius: var(--r);
      background: #f8fafc;
      text-decoration: none !important;
      transition: background 0.15s, border-color 0.15s, transform 0.15s;
      text-align: center;
    }

    .shortcut:hover {
      background: var(--surface);
      border-color: var(--sc-color, var(--p));
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
      text-decoration: none !important;
    }

    .shortcut i {
      font-size: 1.35rem;
    }

    .shortcut span {
      font-size: 0.7rem;
      font-weight: 700;
      color: var(--text);
    }

    /* ── CARD WRAPPER ─────────────────────────────── */
    .panel {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--r-lg) !important;
      overflow: hidden;
    }

    .panel-body {
      padding: 16px 20px;
    }

    /* ── EMPTY STATE ─────────────────────────────── */
    .empty-state {
      padding: 40px 20px;
      text-align: center;
    }

    .empty-state i {
      font-size: 2.5rem;
      color: var(--border2);
      display: block;
      margin-bottom: 8px;
    }

    .empty-state p {
      font-size: 0.9rem;
      color: var(--muted);
      margin: 0;
    }

    /* ── VIEW ALL BTN ─────────────────────────────── */
    .btn-view {
      font-size: 0.78rem;
      font-weight: 700;
      letter-spacing: 0.5px;
      padding: 6px 16px;
      border-radius: var(--r-sm) !important;
      border: 1.5px solid var(--p);
      color: var(--p) !important;
      background: transparent;
      transition: background 0.15s, color 0.15s;
    }

    .btn-view:hover {
      background: var(--p);
      color: #fff !important;
    }

    /* ── TODAY CHIP ───────────────────────────────── */
    .today-chip {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      background: #ecfdf5;
      border: 1px solid #a7f3d0;
      padding: 3px 8px;
      border-radius: var(--r-sm);
      font-size: 0.7rem;
      font-weight: 700;
      color: var(--p2);
    }

    .today-chip::before {
      content: '';
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--p);
      display: inline-block;
    }

    /* ── RESPONSIVE ───────────────────────────────── */
    @media (max-width: 767px) {
      .stat-value {
        font-size: 1.45rem;
      }

      .hero-watermark {
        display: none;
      }

      .hero-banner h3 {
        font-size: 1.25rem;
      }
    }

    /* ── SUBTLE ENTRANCE ANIM ─────────────────────── */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .stat-card {
      animation: fadeUp 0.3s ease both;
    }

    .stat-card:nth-child(1) {
      animation-delay: 0.05s;
    }

    .stat-card:nth-child(2) {
      animation-delay: 0.10s;
    }

    .stat-card:nth-child(3) {
      animation-delay: 0.15s;
    }

    .stat-card:nth-child(4) {
      animation-delay: 0.20s;
    }

    .stat-card:nth-child(5) {
      animation-delay: 0.25s;
    }

    .stat-card:nth-child(6) {
      animation-delay: 0.30s;
    }

    .stat-card:nth-child(7) {
      animation-delay: 0.35s;
    }

    .stat-card:nth-child(8) {
      animation-delay: 0.40s;
    }
  </style>
@endsection

@section('content')
  <div class="row g-3">

    {{-- ── GREETING ────────────────────────────────────── --}}
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div class="greeting-strip">
          <h4 class="mb-0">Selamat {{ Helper::greeting() }}, <span
              style="color:var(--p)">{{ Auth::user()->name ?? 'Admin' }}</span>! 👋</h4>
          <p class="mb-0 small" style="color:var(--muted); margin-top:2px;">Ringkasan aktivitas PTSP hari ini.</p>
        </div>
        <div class="d-none d-md-flex">
          <div class="date-chip">
            <i class="ti tabler-calendar-event" style="font-size:0.9rem; color:var(--p)"></i>
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
          </div>
        </div>
      </div>
    </div>

    {{-- ── HERO BANNER ─────────────────────────────────── --}}
    <div class="col-12">
      <div
        class="hero-banner p-4 p-md-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div class="d-flex align-items-center gap-3 position-relative z-1">
          <div class="hero-icon">
            <i class="ti tabler-rocket"></i>
          </div>
          <div>
            <span class="hero-badge">PTSP MAN 1</span>
            <h3>Panel Kontrol PTSP</h3>
            <p class="mb-0 small" style="color: rgba(255,255,255,0.55); margin-top:2px;">
              Layanan Terpadu Satu Pintu — MAN 1 Kota Bandung
            </p>
          </div>
        </div>
        <div class="hero-watermark">PTSP</div>
        <div class="position-relative z-1">
          <a href="{{ route('ptsp.index') }}" class="hero-btn d-inline-flex align-items-center gap-2" target="_blank">
            <i class="ti tabler-world" style="font-size:0.95rem"></i> Lihat Portal
          </a>
        </div>
      </div>
    </div>

    {{-- ── STAT CARDS ───────────────────────────────────── --}}

    {{-- Total Permohonan --}}
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card stat-card h-100" style="--accent-color: var(--p); --icon-bg: #ecfdf5;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-2">
            <div class="flex-grow-1">
              <p class="stat-label">Total Permohonan</p>
              <div class="stat-value">{{ number_format($totalPermohonan) }}</div>
            </div>
            <div class="stat-icon"><i class="ti tabler-folder-plus"></i></div>
          </div>
          <div class="mt-3">
            <span class="today-chip">+{{ $permohonanTerbaru->count() }} hari ini</span>
          </div>
        </div>
      </div>
    </div>

    {{-- Pending --}}
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card stat-card h-100" style="--accent-color: #d97706; --icon-bg: #fef3c7;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-2">
            <div class="flex-grow-1">
              <p class="stat-label">Pending</p>
              <div class="stat-value">{{ number_format($pending) }}</div>
            </div>
            <div class="stat-icon"><i class="ti tabler-clock-hour-4"></i></div>
          </div>
          <div class="stat-progress">
            <div class="stat-progress-bar"
              style="width: {{ $totalPermohonan > 0 ? ($pending / $totalPermohonan) * 100 : 0 }}%"></div>
          </div>
        </div>
      </div>
    </div>

    {{-- Diproses --}}
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card stat-card h-100" style="--accent-color: #4f46e5; --icon-bg: #eef2ff;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-2">
            <div class="flex-grow-1">
              <p class="stat-label">Diproses</p>
              <div class="stat-value">{{ number_format($proses) }}</div>
            </div>
            <div class="stat-icon"><i class="ti tabler-settings-automation"></i></div>
          </div>
          <div class="stat-progress">
            <div class="stat-progress-bar"
              style="width: {{ $totalPermohonan > 0 ? ($proses / $totalPermohonan) * 100 : 0 }}%"></div>
          </div>
        </div>
      </div>
    </div>

    {{-- Selesai --}}
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card stat-card h-100" style="--accent-color: var(--p); --icon-bg: #ecfdf5;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-2">
            <div class="flex-grow-1">
              <p class="stat-label">Selesai</p>
              <div class="stat-value">{{ number_format($selesai) }}</div>
            </div>
            <div class="stat-icon"><i class="ti tabler-discount-check"></i></div>
          </div>
          <div class="stat-progress">
            <div class="stat-progress-bar"
              style="width: {{ $totalPermohonan > 0 ? ($selesai / $totalPermohonan) * 100 : 0 }}%"></div>
          </div>
        </div>
      </div>
    </div>

    {{-- Akses Publik --}}
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card stat-card h-100" style="--accent-color: #dc2626; --icon-bg: #fee2e2;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-2">
            <div class="flex-grow-1">
              <p class="stat-label">Akses Publik</p>
              <div class="stat-value">{{ number_format($publik) }}</div>
            </div>
            <div class="stat-icon"><i class="ti tabler-user-search"></i></div>
          </div>
          <div class="mt-3" style="font-size:0.75rem; color:var(--muted);">Pengunjung portal publik</div>
        </div>
      </div>
    </div>

    {{-- Layanan Aktif --}}
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card stat-card h-100" style="--accent-color: #0284c7; --icon-bg: #e0f2fe;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-2">
            <div class="flex-grow-1">
              <p class="stat-label">Layanan Aktif</p>
              <div class="stat-value">{{ number_format($totalLayanan) }}</div>
            </div>
            <div class="stat-icon"><i class="ti tabler-layout-grid-add"></i></div>
          </div>
          <div class="mt-3" style="font-size:0.75rem; color:var(--muted);">Jenis layanan tersedia</div>
        </div>
      </div>
    </div>

    {{-- Total Tamu --}}
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card stat-card h-100" style="--accent-color: #7c3aed; --icon-bg: #f3e8ff;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-2">
            <div class="flex-grow-1">
              <p class="stat-label">Total Tamu</p>
              <div class="stat-value">{{ number_format($totalTamu) }}</div>
            </div>
            <div class="stat-icon"><i class="ti tabler-users"></i></div>
          </div>
          <div class="mt-3" style="font-size:0.75rem; color:var(--muted);">
            <span class="today-chip">+{{ $tamuHariIni }} hari ini</span>
            &middot; {{ $tamuMingguIni }} minggu ini
          </div>
        </div>
      </div>
    </div>

    {{-- Tamu Hari Ini --}}
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card stat-card h-100" style="--accent-color: #0891b2; --icon-bg: #cffafe;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-2">
            <div class="flex-grow-1">
              <p class="stat-label">Tamu Hari Ini</p>
              <div class="stat-value">{{ number_format($tamuHariIni) }}</div>
            </div>
            <div class="stat-icon"><i class="ti tabler-user-check"></i></div>
          </div>
          <div class="mt-3" style="font-size:0.75rem; color:var(--muted);">
            {{ $tamuBulanIni }} tamu bulan {{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM') }}
          </div>
        </div>
      </div>
    </div>

    {{-- ── PERMOHONAN TERBARU ──────────────────────────── --}}
    <div class="col-12 col-xl-8">
      <div class="panel h-100">
        <div class="section-head">
          <div class="section-head-title">
            <span class="dot"></span>
            Permohonan Terbaru
          </div>
          <a href="{{ route('admin.ptsp.index') }}" class="btn-view">Lihat Semua →</a>
        </div>
        <div class="table-responsive">
          <table class="table tbl mb-0">
            <thead>
              <tr>
                <th class="ps-4">No. Tiket</th>
                <th>Pemohon</th>
                <th>Status</th>
                <th class="text-end pe-4">Waktu</th>
              </tr>
            </thead>
            <tbody>
              @forelse($permohonanTerbaru as $p)
                <tr>
                  <td class="ps-4">
                    <span class="ticket-no">{{ $p->no_tiket }}</span>
                  </td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="av">{{ substr($p->user->name ?? ($p->siswa->nama_lengkap ?? '?'), 0, 1) }}</div>
                      <div>
          <div style="font-weight:700; font-size:0.88rem;">
            {{ $p->user->name ?? ($p->siswa->nama_lengkap ?? 'N/A') }}</div>
            <div style="font-size:0.75rem; color:var(--muted);">{{ $p->layanan->nama_layanan ?? '—' }}</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    @php
                      $st = $p->status;
                      $sc = match ($st) {
                          'pending' => 'st-pending',
                          'proses' => 'st-proses',
                          'selesai' => 'st-selesai',
                          'ditolak' => 'st-ditolak',
                          default => 'st-default',
                      };
                    @endphp
                    <span class="st-badge {{ $sc }}">{{ strtoupper($st) }}</span>
                  </td>
                  <td class="text-end pe-4" style="font-size:0.78rem; color:var(--muted); white-space:nowrap;">
                    {{ $p->created_at->diffForHumans() }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="p-0">
                    <div class="empty-state">
                      <i class="ti tabler-inbox"></i>
                      <p>Belum ada permohonan masuk.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- ── AKSES CEPAT ──────────────────────────────────── --}}
    <div class="col-12 col-xl-4">
      <div class="panel h-100">
        <div class="section-head">
          <div class="section-head-title">
            <span class="dot" style="background:var(--amber)"></span>
            Akses Cepat
          </div>
        </div>
        <div class="panel-body">

          {{-- Quick links --}}
          <div class="d-flex flex-column gap-2 mb-4">
            <a href="{{ route('admin.ptsp.index') }}" class="qa-item" style="--qa-color: var(--p); --qa-bg: #ecfdf5;">
              <div class="qa-icon"><i class="ti tabler-clipboard-list"></i></div>
              <div>
                <p class="qa-title">Manajemen Permohonan</p>
                <p class="qa-sub">Kelola antrean dan verifikasi berkas.</p>
              </div>
              <i class="ti tabler-arrow-right ms-auto" style="font-size:0.9rem; color:var(--muted); flex-shrink:0;"></i>
            </a>

            <a href="{{ route('ptsp.tracking') }}" class="qa-item" style="--qa-color: #0284c7; --qa-bg: #e0f2fe;"
              target="_blank">
              <div class="qa-icon"><i class="ti tabler-track"></i></div>
              <div>
                <p class="qa-title">Tracking Link</p>
                <p class="qa-sub">Pantau status via nomor tiket publik.</p>
              </div>
              <i class="ti tabler-external-link ms-auto"
                style="font-size:0.9rem; color:var(--muted); flex-shrink:0;"></i>
            </a>
          </div>

          {{-- Shortcuts --}}
          <div style="border-top: 1px solid var(--border); padding-top: 14px;">
            <p
              style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:1px; color:var(--muted); margin-bottom:10px;">
              Shortcuts</p>
            <div class="row g-2">
              <div class="col-6">
                <a href="{{ route('admin.ptsp.index') }}" class="shortcut" style="--sc-color: var(--p);">
                  <i class="ti tabler-file-analytics" style="color:var(--p)"></i>
                  <span>Permohonan</span>
                </a>
              </div>
              <div class="col-6">
                <a href="{{ route('admin.siswa.index') }}" class="shortcut" style="--sc-color: #0284c7;">
                  <i class="ti tabler-users-group" style="color:#0284c7"></i>
                  <span>Data Siswa</span>
                </a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    {{-- ── BUKU TAMU TERBARU ────────────────────────────── --}}
    <div class="col-12">
      <div class="panel">
        <div class="section-head">
          <div class="section-head-title">
            <span class="dot" style="background:#7c3aed"></span>
            Buku Tamu Terbaru
          </div>
          <a href="{{ route('admin.guest-book.index') }}" class="btn-view">Lihat Semua →</a>
        </div>
        <div class="table-responsive">
          <table class="table tbl mb-0">
            <thead>
              <tr>
                <th class="ps-4">Nama</th>
                <th>Instansi</th>
                <th>Tujuan</th>
                <th class="text-end pe-4">Waktu</th>
              </tr>
            </thead>
            <tbody>
              @forelse($tamuTerbaru as $t)
                <tr>
                  <td class="ps-4">
                    <div class="d-flex align-items-center gap-2">
                      <div class="av" style="background:#7c3aed;">{{ substr($t->nama_lengkap, 0, 1) }}</div>
                      <div>
                        <div style="font-weight:700; font-size:0.88rem;">{{ $t->nama_lengkap }}</div>
                        <div style="font-size:0.75rem; color:var(--muted);">{{ $t->no_whatsapp }}</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div style="font-weight:600; font-size:0.85rem;">{{ $t->nama_instansi ?? '—' }}</div>
                    <div style="font-size:0.7rem; color:var(--muted);">{{ $t->jenis_instansi ?? '—' }}</div>
                  </td>
                  <td>
                    <span style="font-size:0.85rem;">{{ $t->tujuan }}</span>
                  </td>
                  <td class="text-end pe-4" style="font-size:0.78rem; color:var(--muted); white-space:nowrap;">
                    {{ $t->created_at->diffForHumans() }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="p-0">
                    <div class="empty-state">
                      <i class="ti tabler-book-off"></i>
                      <p>Belum ada tamu yang berkunjung.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
@endsection
