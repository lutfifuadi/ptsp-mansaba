@php
  use Illuminate\Support\Facades\Auth;
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Dashboard PTSP')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
    'resources/assets/vendor/libs/swiper/swiper.scss',
  ])
@endsection


@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/apex-charts/apexcharts.js',
    'resources/assets/vendor/libs/swiper/swiper.js',
  ])
@endsection

@section('page-script')
  <script>
    window.chartDailyData    = @json($chartDailyData);
    window.chartWeeklyData   = @json($chartWeeklyData);
    window.chartCompletionRate = {{ $chartCompletionRate }};
    window.statTotal7Hari    = {{ $total7Hari }};
    window.statSelesai7Hari  = {{ $selesai7Hari }};
    window.statProses7Hari   = {{ $proses7Hari }};
    window.statPending7Hari  = {{ $pending7Hari }};
    window.statTotalTamu     = {{ $totalTamu }};
    window.statTamuHariIni   = {{ $tamuHariIni }};
    window.statTamuMingguIni = {{ $tamuMingguIni }};
    window.statTamuBulanIni  = {{ $tamuBulanIni }};
  </script>
  @vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('page-style')
  @vite('resources/assets/vendor/scss/pages/cards-advance.scss')
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
      background: linear-gradient(135deg, var(--gradient-start, var(--surface)) 0%, var(--gradient-end, var(--surface)) 100%) !important;
      border: 1px solid var(--panel-border, var(--border)) !important;
      border-radius: var(--r-lg) !important;
      transition: transform 0.18s, box-shadow 0.18s;
      position: relative;
      overflow: hidden;
      color: var(--card-text, var(--text)) !important;
    }

    .stat-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    }

    /* Faint diagonal tint */
    .stat-card::after {
      content: '';
      position: absolute;
      top: 0;
      right: -30px;
      width: 80px;
      height: 100%;
      background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.08));
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
      color: var(--icon-color, var(--p));
      flex-shrink: 0;
      transition: background 0.2s, color 0.2s;
    }

    .stat-card:hover .stat-icon {
      background: #ffffff !important;
      color: var(--gradient-end, var(--p)) !important;
    }

    .stat-label {
      font-size: 0.75rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--card-muted, var(--muted)) !important;
      margin-bottom: 3px;
    }

    .stat-value {
      font-size: 1.75rem;
      font-weight: 900;
      line-height: 1.1;
      color: var(--card-text, var(--text)) !important;
    }

    .stat-progress {
      height: 4px;
      background: var(--progress-bg, var(--border)) !important;
      border-radius: 2px;
      overflow: hidden;
      margin-top: 12px;
    }

    .stat-progress-bar {
      height: 100%;
      background: var(--progress-bar-bg, var(--p)) !important;
      transition: width 1s ease;
    }

    .stat-card .today-chip {
      background: var(--chip-bg, #ecfdf5) !important;
      border: 1px solid var(--chip-border, #a7f3d0) !important;
      color: var(--chip-color, var(--p2)) !important;
    }

    .stat-card .today-chip::before {
      background: var(--chip-color, var(--p)) !important;
    }

    /* ── SECTION HEADER ───────────────────────────── */
    .section-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 14px 20px;
      border-bottom: 1px solid var(--panel-border, var(--border)) !important;
      background: transparent !important;
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
      background: rgba(0, 0, 0, 0.02) !important;
      color: var(--muted) !important;
      font-weight: 800;
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      padding: 12px 16px !important;
      border-bottom: 2px solid var(--panel-border, var(--border)) !important;
      border-top: none !important;
    }

    .tbl td {
      padding: 13px 16px !important;
      vertical-align: middle;
      border-bottom: 1px solid var(--panel-border, #f1f5f9) !important;
      font-size: 0.88rem;
      color: var(--text);
    }

    .tbl tbody tr {
      transition: background 0.12s;
    }

    .tbl tbody tr:hover td {
      background: rgba(0, 0, 0, 0.015) !important;
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
      background: var(--surface);
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
      background: var(--panel-bg, var(--surface)) !important;
      border: 1px solid var(--panel-border, var(--border)) !important;
      border-radius: var(--r-lg) !important;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
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

    /* ── ANALYTICS ENHANCED ──────────────────────────── */
    .analytics-section {
      margin-top: 8px;
    }

    .analytics-head {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 4px;
    }

    .analytics-head-bar {
      width: 4px;
      height: 26px;
      background: var(--p);
      border-radius: 2px;
    }

    .analytics-head h5 {
      font-weight: 800;
      margin: 0;
      font-size: 1rem;
    }

    .analytics-head small {
      color: var(--muted);
      font-size: 0.78rem;
    }

    /* Chart card consistent style */
    .chart-card {
      background: var(--surface) !important;
      border: 1px solid var(--border) !important;
      border-radius: var(--r-lg) !important;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.04);
      transition: box-shadow 0.2s;
    }

    .chart-card:hover {
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }

    .chart-card .card-header {
      padding: 16px 20px 10px;
      background: transparent;
      border-bottom: 1px solid var(--border);
    }

    .chart-card .card-body {
      padding: 16px 20px;
    }

    /* Earning report style card */
    .earning-card .stat-block h2 {
      font-size: 2rem;
      font-weight: 900;
      color: var(--text);
      margin: 0;
    }

    .earning-card .badge-growth {
      font-size: 0.72rem;
      font-weight: 700;
      padding: 4px 10px;
      border-radius: var(--r-sm);
    }

    /* Tracker style */
    .tracker-stat-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .tracker-stat-list li {
      display: flex;
      gap: 16px;
      align-items: center;
      margin-bottom: 20px;
    }

    .tracker-stat-list li:last-child {
      margin-bottom: 0;
    }

    .tracker-stat-list .t-badge {
      width: 38px;
      height: 38px;
      border-radius: var(--r);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      flex-shrink: 0;
    }

    .tracker-stat-list h6 {
      font-weight: 700;
      font-size: 0.82rem;
      margin: 0 0 2px;
      color: var(--text);
    }

    .tracker-stat-list small {
      color: var(--muted);
      font-size: 0.75rem;
    }

    /* Campaign / source visit style */
    .campaign-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .campaign-list li {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 0;
      border-bottom: 1px solid var(--border);
    }

    .campaign-list li:last-child {
      border-bottom: none;
      padding-bottom: 0;
    }

    .campaign-list .c-icon {
      width: 34px;
      height: 34px;
      border-radius: var(--r);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.9rem;
      flex-shrink: 0;
      margin-right: 12px;
    }

    .campaign-list .c-label {
      font-size: 0.82rem;
      font-weight: 700;
      color: var(--text);
      margin: 0;
    }

    .campaign-list .c-sub {
      font-size: 0.7rem;
      color: var(--muted);
      margin: 0;
    }

    .campaign-list .c-val {
      font-size: 0.85rem;
      font-weight: 700;
      color: var(--text);
    }

    .growth-up {
      color: #059669;
      font-size: 0.72rem;
      font-weight: 700;
    }

    .growth-neutral {
      color: var(--muted);
      font-size: 0.72rem;
      font-weight: 700;
    }

    /* Breakdown detail box */
    .detail-box {
      border: 1px solid var(--border);
      border-radius: var(--r);
      padding: 14px 16px;
      margin-top: 14px;
    }

    .detail-box-item {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .detail-box-item h4 {
      font-size: 1.15rem;
      font-weight: 800;
      color: var(--text);
      margin: 0;
    }

    .detail-box-item .db-progress {
      height: 4px;
      background: var(--border);
      border-radius: 2px;
      overflow: hidden;
      margin-top: 6px;
    }

    .detail-box-item .db-bar {
      height: 100%;
      border-radius: 2px;
      transition: width 1s ease;
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

    {{-- ── STAT CARDS ───────────────────────────────────── --}}

    {{-- Total Permohonan --}}
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card stat-card h-100" style="
        --gradient-start: #059669;
        --gradient-end: #047857;
        --card-text: #ffffff;
        --card-muted: rgba(255,255,255,0.8);
        --icon-bg: rgba(255,255,255,0.18);
        --icon-color: #ffffff;
        --chip-bg: rgba(255,255,255,0.2);
        --chip-border: rgba(255,255,255,0.3);
        --chip-color: #ffffff;
        --panel-border: rgba(255,255,255,0.1);
      ">
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
      <div class="card stat-card h-100" style="
        --gradient-start: #d97706;
        --gradient-end: #b45309;
        --card-text: #ffffff;
        --card-muted: rgba(255,255,255,0.8);
        --icon-bg: rgba(255,255,255,0.18);
        --icon-color: #ffffff;
        --progress-bg: rgba(255,255,255,0.2);
        --progress-bar-bg: #ffffff;
        --panel-border: rgba(255,255,255,0.1);
      ">
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
      <div class="card stat-card h-100" style="
        --gradient-start: #4f46e5;
        --gradient-end: #3730a3;
        --card-text: #ffffff;
        --card-muted: rgba(255,255,255,0.8);
        --icon-bg: rgba(255,255,255,0.18);
        --icon-color: #ffffff;
        --progress-bg: rgba(255,255,255,0.2);
        --progress-bar-bg: #ffffff;
        --panel-border: rgba(255,255,255,0.1);
      ">
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
      <div class="card stat-card h-100" style="
        --gradient-start: #10b981;
        --gradient-end: #059669;
        --card-text: #ffffff;
        --card-muted: rgba(255,255,255,0.8);
        --icon-bg: rgba(255,255,255,0.18);
        --icon-color: #ffffff;
        --progress-bg: rgba(255,255,255,0.2);
        --progress-bar-bg: #ffffff;
        --panel-border: rgba(255,255,255,0.1);
      ">
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
      <div class="card stat-card h-100" style="
        --gradient-start: #dc2626;
        --gradient-end: #b91c1c;
        --card-text: #ffffff;
        --card-muted: rgba(255,255,255,0.8);
        --icon-bg: rgba(255,255,255,0.18);
        --icon-color: #ffffff;
        --panel-border: rgba(255,255,255,0.1);
      ">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-2">
            <div class="flex-grow-1">
              <p class="stat-label">Akses Publik</p>
              <div class="stat-value">{{ number_format($publik) }}</div>
            </div>
            <div class="stat-icon"><i class="ti tabler-user-search"></i></div>
          </div>
          <div class="mt-3" style="font-size:0.75rem; opacity:0.8;">Pengunjung portal publik</div>
        </div>
      </div>
    </div>

    {{-- Layanan Aktif --}}
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card stat-card h-100" style="
        --gradient-start: #0284c7;
        --gradient-end: #0369a1;
        --card-text: #ffffff;
        --card-muted: rgba(255,255,255,0.8);
        --icon-bg: rgba(255,255,255,0.18);
        --icon-color: #ffffff;
        --panel-border: rgba(255,255,255,0.1);
      ">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-2">
            <div class="flex-grow-1">
              <p class="stat-label">Layanan Aktif</p>
              <div class="stat-value">{{ number_format($totalLayanan) }}</div>
            </div>
            <div class="stat-icon"><i class="ti tabler-layout-grid-add"></i></div>
          </div>
          <div class="mt-3" style="font-size:0.75rem; opacity:0.8;">Jenis layanan tersedia</div>
        </div>
      </div>
    </div>

    {{-- Total Tamu --}}
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card stat-card h-100" style="
        --gradient-start: #7c3aed;
        --gradient-end: #6d28d9;
        --card-text: #ffffff;
        --card-muted: rgba(255,255,255,0.8);
        --icon-bg: rgba(255,255,255,0.18);
        --icon-color: #ffffff;
        --chip-bg: rgba(255,255,255,0.2);
        --chip-border: rgba(255,255,255,0.3);
        --chip-color: #ffffff;
        --panel-border: rgba(255,255,255,0.1);
      ">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-2">
            <div class="flex-grow-1">
              <p class="stat-label">Total Tamu</p>
              <div class="stat-value">{{ number_format($totalTamu) }}</div>
            </div>
            <div class="stat-icon"><i class="ti tabler-users"></i></div>
          </div>
          <div class="mt-3" style="font-size:0.75rem; opacity:0.8;">
            <span class="today-chip">+{{ $tamuHariIni }} hari ini</span>
            &middot; {{ $tamuMingguIni }} minggu ini
          </div>
        </div>
      </div>
    </div>

    {{-- Tamu Hari Ini --}}
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card stat-card h-100" style="
        --gradient-start: #0891b2;
        --gradient-end: #0e7490;
        --card-text: #ffffff;
        --card-muted: rgba(255,255,255,0.8);
        --icon-bg: rgba(255,255,255,0.18);
        --icon-color: #ffffff;
        --panel-border: rgba(255,255,255,0.1);
      ">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-2">
            <div class="flex-grow-1">
              <p class="stat-label">Tamu Hari Ini</p>
              <div class="stat-value">{{ number_format($tamuHariIni) }}</div>
            </div>
            <div class="stat-icon"><i class="ti tabler-user-check"></i></div>
          </div>
          <div class="mt-3" style="font-size:0.75rem; opacity:0.8;">
            {{ $tamuBulanIni }} tamu bulan {{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM') }}
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- ══════════════════════════════════════════════════ --}}
  {{-- ── ANALYTICS SECTION (ENHANCED) ─────────────────── --}}
  {{-- ══════════════════════════════════════════════════ --}}
  <div class="analytics-section">

    {{-- Section Header --}}
    <div class="analytics-head mb-4">
      <div class="analytics-head-bar"></div>
      <div>
        <h5>Analitik &amp; Grafik</h5>
        <small>Ringkasan statistik dan tren layanan PTSP 7 hari terakhir</small>
      </div>
    </div>

    {{-- ── ROW 1: Sparkline + Overview + Laporan Mingguan Full ── --}}
    <div class="row g-3 mb-3">

      {{-- Sparkline Harian --}}
      <div class="col-xl-3 col-sm-6">
        <div class="card chart-card h-100">
          <div class="card-header pb-0">
            <h5 class="mb-2 card-title" style="font-weight:800;">Permohonan Harian</h5>
            <p class="mb-0" style="font-size:0.78rem; color:var(--muted);">Total 7 Hari Terakhir</p>
            <h4 class="mb-0" style="font-weight:900; color:var(--p);">{{ number_format($total7Hari) }}</h4>
          </div>
          <div class="card-body px-0 pb-0">
            <div id="averageDailySales"></div>
          </div>
        </div>
      </div>

      {{-- Overview Selesai vs Proses --}}
      <div class="col-xl-3 col-sm-6">
        <div class="card chart-card h-100">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-start">
              <p class="mb-0" style="font-size:0.78rem; color:var(--muted);">Overview Layanan</p>
              <span class="badge" style="background:#dcfce7; color:#14532d; font-size:0.7rem; font-weight:800; border-radius:var(--r-sm);">+{{ $total7Hari > 0 ? round(($selesai7Hari / $total7Hari) * 100, 1) : 0 }}%</span>
            </div>
            <h4 class="card-title mb-0" style="font-weight:900;">{{ number_format($selesai7Hari) }} Selesai</h4>
            <small style="color:var(--muted); font-size:0.72rem;">dari {{ number_format($total7Hari) }} total permohonan</small>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="d-flex gap-2 align-items-center mb-2">
                  <span class="badge p-1 rounded" style="background:#dcfce7;"><i class="icon-base ti tabler-circle-check icon-sm" style="color:#059669;"></i></span>
                  <p class="mb-0" style="font-size:0.78rem; font-weight:600;">Selesai</p>
                </div>
                <h5 class="mb-0 pt-1" style="font-weight:900;">{{ $total7Hari > 0 ? round(($selesai7Hari / $total7Hari) * 100, 1) : 0 }}%</h5>
                <small style="color:var(--muted);">{{ number_format($selesai7Hari) }}</small>
              </div>
              <div class="col-2 d-flex align-items-center justify-content-center">
                <div style="width:1px; height:40px; background:var(--border);"></div>
              </div>
              <div class="col-5 text-end">
                <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                  <p class="mb-0" style="font-size:0.78rem; font-weight:600;">Proses</p>
                  <span class="badge p-1 rounded" style="background:#fef3c7;"><i class="icon-base ti tabler-clock icon-sm" style="color:#d97706;"></i></span>
                </div>
                <h5 class="mb-0 pt-1" style="font-weight:900;">{{ $total7Hari > 0 ? round(($proses7Hari / $total7Hari) * 100, 1) : 0 }}%</h5>
                <small style="color:var(--muted);">{{ number_format($proses7Hari) }}</small>
              </div>
            </div>
            <div class="mt-4">
              <div class="progress w-100" style="height:8px; border-radius:4px;">
                <div class="progress-bar" role="progressbar" style="width:{{ $total7Hari > 0 ? ($selesai7Hari / $total7Hari) * 100 : 0 }}%; background:var(--p);"></div>
                <div class="progress-bar" role="progressbar" style="width:{{ $total7Hari > 0 ? ($proses7Hari / $total7Hari) * 100 : 0 }}%; background:#d97706;"></div>
                <div class="progress-bar" role="progressbar" style="width:{{ $total7Hari > 0 ? ($pending7Hari / $total7Hari) * 100 : 0 }}%; background:#e2e8f0;"></div>
              </div>
              <div class="d-flex justify-content-between mt-2" style="font-size:0.65rem; color:var(--muted);">
                <span>Selesai · Proses · Pending</span>
                <span>Total: {{ number_format($total7Hari) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Laporan Permohonan Mingguan (Full-width Earning Reports Style) --}}
      <div class="col-xl-6">
        <div class="card chart-card earning-card h-100">
          <div class="card-header d-flex justify-content-between align-items-start">
            <div>
              <h5 class="mb-1" style="font-weight:800;">Laporan Permohonan Mingguan</h5>
              <p class="mb-0" style="font-size:0.78rem; color:var(--muted);">Ringkasan status permohonan 7 hari terakhir</p>
            </div>
          </div>
          <div class="card-body">
            <div class="d-flex gap-2 align-items-center mb-3 flex-wrap">
              <h2 class="mb-0" style="font-size:2.2rem; font-weight:900; color:var(--text);">{{ number_format($total7Hari) }}</h2>
              @if($total7Hari > 0)
                <div class="badge" style="background:#dcfce7; color:#14532d; font-size:0.7rem; font-weight:700; padding:4px 10px; border-radius:var(--r-sm);">+{{ $chartCompletionRate }}%</div>
              @endif
              <span class="ms-2" style="font-size:0.85rem; color:var(--muted);">Total permohonan 7 hari terakhir</span>
            </div>
            
            <div class="row g-3">
              <div class="col-4 detail-box-item">
                <div class="d-flex gap-2 align-items-center">
                  <div class="badge rounded p-1" style="background:#dbeafe;"><i class="icon-base ti tabler-file-analytics icon-18px" style="color:#2563eb;"></i></div>
                  <span style="font-size:0.75rem; font-weight:700;">Baru</span>
                </div>
                <h4 class="mt-2 mb-1" style="font-weight:800;">{{ number_format($pending7Hari) }}</h4>
                <div class="db-progress">
                  <div class="db-bar" style="width:{{ $total7Hari > 0 ? ($pending7Hari / $total7Hari) * 100 : 0 }}%; background:#2563eb;"></div>
                </div>
              </div>
              <div class="col-4 detail-box-item">
                <div class="d-flex gap-2 align-items-center">
                  <div class="badge rounded p-1" style="background:#e0f2fe;"><i class="icon-base ti tabler-settings-automation icon-18px" style="color:#0284c7;"></i></div>
                  <span style="font-size:0.75rem; font-weight:700;">Diproses</span>
                </div>
                <h4 class="mt-2 mb-1" style="font-weight:800;">{{ number_format($proses7Hari) }}</h4>
                <div class="db-progress">
                  <div class="db-bar" style="width:{{ $total7Hari > 0 ? ($proses7Hari / $total7Hari) * 100 : 0 }}%; background:#0284c7;"></div>
                </div>
              </div>
              <div class="col-4 detail-box-item">
                <div class="d-flex gap-2 align-items-center">
                  <div class="badge rounded p-1" style="background:#dcfce7;"><i class="icon-base ti tabler-discount-check icon-18px" style="color:var(--p);"></i></div>
                  <span style="font-size:0.75rem; font-weight:700;">Selesai</span>
                </div>
                <h4 class="mt-2 mb-1" style="font-weight:800;">{{ number_format($selesai7Hari) }}</h4>
                <div class="db-progress">
                  <div class="db-bar" style="width:{{ $total7Hari > 0 ? ($selesai7Hari / $total7Hari) * 100 : 0 }}%; background:var(--p);"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>{{-- end row 1 --}}

    {{-- ── ROW 2: Tracker + Status Tamu + Breakdown Status ── --}}
    <div class="row g-3">

      {{-- Tracker Penyelesaian (Support Tracker style - besar) --}}
      <div class="col-12 col-md-6">
        <div class="card chart-card h-100">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h5 class="mb-1" style="font-weight:800;">Tracker Penyelesaian</h5>
                <p class="mb-0" style="font-size:0.78rem; color:var(--muted);">Tingkat penyelesaian 7 hari terakhir</p>
              </div>
            </div>
          </div>
          <div class="card-body row align-items-center">
            {{-- Stats list kiri --}}
            <div class="col-12 col-sm-5">
              <div class="mb-4">
                <h2 class="mb-0" style="font-size:2.5rem; font-weight:900; color:var(--text);">{{ number_format($total7Hari) }}</h2>
                <p class="mb-0" style="font-size:0.82rem; color:var(--muted);">Total Permohonan</p>
              </div>
              <ul class="tracker-stat-list">
                <li>
                  <div class="t-badge" style="background:#dbeafe;"><i class="ti tabler-ticket" style="color:#2563eb; font-size:1rem;"></i></div>
                  <div>
                    <h6>Permohonan Baru</h6>
                    <small>{{ number_format($pending7Hari) }} pending</small>
                  </div>
                </li>
                <li>
                  <div class="t-badge" style="background:#e0f2fe;"><i class="ti tabler-settings-automation" style="color:#0284c7; font-size:1rem;"></i></div>
                  <div>
                    <h6>Sedang Diproses</h6>
                    <small>{{ number_format($proses7Hari) }} permohonan</small>
                  </div>
                </li>
                <li>
                  <div class="t-badge" style="background:#dcfce7;"><i class="ti tabler-circle-check" style="color:#059669; font-size:1rem;"></i></div>
                  <div>
                    <h6>Selesai</h6>
                    <small>{{ number_format($selesai7Hari) }} permohonan</small>
                  </div>
                </li>
              </ul>
            </div>
            {{-- Radial chart kanan --}}
            <div class="col-12 col-sm-7">
              <div id="supportTracker"></div>
            </div>
          </div>
        </div>
      </div>

      {{-- Ringkasan Status Tamu (Campaign State style) --}}
      <div class="col-12 col-md-3">
        <div class="card chart-card h-100">
          <div class="card-header">
            <h5 class="mb-1" style="font-weight:800;">Statistik Tamu</h5>
            <p class="mb-0" style="font-size:0.78rem; color:var(--muted);">Kunjungan buku tamu</p>
          </div>
          <div class="card-body">
            <ul class="campaign-list">
              <li>
                <div class="d-flex align-items-center">
                  <div class="c-icon" style="background:#f3e8ff;"><i class="ti tabler-users" style="color:#7c3aed;"></i></div>
                  <div>
                    <p class="c-label">Total Tamu</p>
                    <p class="c-sub">Semua waktu</p>
                  </div>
                </div>
                <div class="text-end">
                  <div class="c-val">{{ number_format($totalTamu) }}</div>
                </div>
              </li>
              <li>
                <div class="d-flex align-items-center">
                  <div class="c-icon" style="background:#dcfce7;"><i class="ti tabler-user-check" style="color:#059669;"></i></div>
                  <div>
                    <p class="c-label">Hari Ini</p>
                    <p class="c-sub">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM') }}</p>
                  </div>
                </div>
                <div class="text-end">
                  <div class="c-val">{{ number_format($tamuHariIni) }}</div>
                  <div class="growth-up">Live</div>
                </div>
              </li>
              <li>
                <div class="d-flex align-items-center">
                  <div class="c-icon" style="background:#e0f2fe;"><i class="ti tabler-calendar-week" style="color:#0284c7;"></i></div>
                  <div>
                    <p class="c-label">Minggu Ini</p>
                    <p class="c-sub">Sen–Min</p>
                  </div>
                </div>
                <div class="text-end">
                  <div class="c-val">{{ number_format($tamuMingguIni) }}</div>
                </div>
              </li>
              <li>
                <div class="d-flex align-items-center">
                  <div class="c-icon" style="background:#fef3c7;"><i class="ti tabler-calendar-month" style="color:#d97706;"></i></div>
                  <div>
                    <p class="c-label">Bulan Ini</p>
                    <p class="c-sub">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM YYYY') }}</p>
                  </div>
                </div>
                <div class="text-end">
                  <div class="c-val">{{ number_format($tamuBulanIni) }}</div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>

      {{-- Breakdown Status Permohonan (Source Visits style) --}}
      <div class="col-12 col-md-3">
        <div class="card chart-card h-100">
          <div class="card-header">
            <h5 class="mb-1" style="font-weight:800;">Status Permohonan</h5>
            <p class="mb-0" style="font-size:0.78rem; color:var(--muted);">{{ number_format($totalPermohonan) }} total permohonan</p>
          </div>
          <div class="card-body">
            <ul class="campaign-list">
              <li>
                <div class="d-flex align-items-center">
                  <div class="c-icon" style="background:#dbeafe;"><i class="ti tabler-folder-plus" style="color:#2563eb;"></i></div>
                  <div>
                    <p class="c-label">Total</p>
                    <p class="c-sub">Semua status</p>
                  </div>
                </div>
                <div class="text-end">
                  <div class="c-val">{{ number_format($totalPermohonan) }}</div>
                  <div class="growth-neutral">100%</div>
                </div>
              </li>
              <li>
                <div class="d-flex align-items-center">
                  <div class="c-icon" style="background:#fef3c7;"><i class="ti tabler-clock-hour-4" style="color:#d97706;"></i></div>
                  <div>
                    <p class="c-label">Pending</p>
                    <p class="c-sub">Menunggu proses</p>
                  </div>
                </div>
                <div class="text-end">
                  <div class="c-val">{{ number_format($pending) }}</div>
                  <div class="growth-neutral">{{ $totalPermohonan > 0 ? round(($pending / $totalPermohonan) * 100, 1) : 0 }}%</div>
                </div>
              </li>
              <li>
                <div class="d-flex align-items-center">
                  <div class="c-icon" style="background:#e0f2fe;"><i class="ti tabler-settings-automation" style="color:#0284c7;"></i></div>
                  <div>
                    <p class="c-label">Diproses</p>
                    <p class="c-sub">Sedang berjalan</p>
                  </div>
                </div>
                <div class="text-end">
                  <div class="c-val">{{ number_format($proses) }}</div>
                  <div class="growth-neutral">{{ $totalPermohonan > 0 ? round(($proses / $totalPermohonan) * 100, 1) : 0 }}%</div>
                </div>
              </li>
              <li>
                <div class="d-flex align-items-center">
                  <div class="c-icon" style="background:#dcfce7;"><i class="ti tabler-discount-check" style="color:#059669;"></i></div>
                  <div>
                    <p class="c-label">Selesai</p>
                    <p class="c-sub">Sudah selesai</p>
                  </div>
                </div>
                <div class="text-end">
                  <div class="c-val">{{ number_format($selesai) }}</div>
                  <div class="growth-up">{{ $totalPermohonan > 0 ? round(($selesai / $totalPermohonan) * 100, 1) : 0 }}%</div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>

    </div>{{-- end row 2 --}}

  </div>{{-- end analytics-section --}}

  {{-- ══════════════════════════════════════════════════ --}}
  {{-- ── TABEL DATA DETAIL (PALING BAWAH) ──────────────── --}}
  {{-- ══════════════════════════════════════════════════ --}}
  <div class="row g-3 mt-1">

    {{-- ── PERMOHONAN TERBARU ──────────────────────────── --}}
    <div class="col-12 col-xl-8">
      <div class="panel h-100" style="--panel-bg: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%); --panel-border: #dcfce7;">
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
                      @php
                        $name = 'N/A';
                        if($p->user_id) {
                          $name = $p->user->name ?? 'N/A';
                        } elseif($p->nisn) {
                          $name = $p->siswa->nama_lengkap ?? 'Pemohon ('.$p->nisn.')';
                        } elseif($p->data_form && ($p->data_form['nama_lengkap'] ?? null)) {
                          $name = $p->data_form['nama_lengkap'];
                        }
                        $initials = collect(explode(' ', $name))->take(2)->map(fn($n) => strtoupper(substr($n, 0, 1)))->implode('');
                      @endphp
                      <div class="av">{{ $initials }}</div>
                      <div>
                        <div style="font-weight:700; font-size:0.88rem;">{{ $name }}</div>
                        <div style="font-size:0.75rem; color:var(--muted);">{{ $p->layanan->nama_layanan ?? '—' }}</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    @php
                      $st = $p->status;
                      $sc = match ($st) {
                          'pending' => 'st-pending',
                          'proses'  => 'st-proses',
                          'selesai' => 'st-selesai',
                          'ditolak' => 'st-ditolak',
                          default   => 'st-default',
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
      <div class="panel h-100" style="--panel-bg: linear-gradient(180deg, #fffbeb 0%, #ffffff 100%); --panel-border: #fef3c7;">
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
          <div style="border-top: 1px solid var(--panel-border, var(--border)); padding-top: 14px;">
            <p style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:1px; color:var(--muted); margin-bottom:10px;">
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
      <div class="panel" style="--panel-bg: linear-gradient(180deg, #faf5ff 0%, #ffffff 100%); --panel-border: #f3e8ff;">
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

  </div>{{-- end tabel data detail --}}

@endsection
