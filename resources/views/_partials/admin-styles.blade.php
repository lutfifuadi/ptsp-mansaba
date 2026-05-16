@once
@php
  $themePrimary = \App\Models\Pengaturan::get('theme_primary', '#059669');
  $themePrimaryDark = \App\Models\Pengaturan::get('theme_primary_dark', '#047857');
  $themePrimaryDarker = \App\Models\Pengaturan::get('theme_primary_darker', '#064e3b');
  $themeAccent = \App\Models\Pengaturan::get('theme_accent', '#d97706');
  $themeDanger = \App\Models\Pengaturan::get('theme_danger', '#dc2626');
  $themeInfo = \App\Models\Pengaturan::get('theme_info', '#4f46e5');
  $themeSuccess = \App\Models\Pengaturan::get('theme_success', '#0284c7');
  $themeMuted = \App\Models\Pengaturan::get('theme_muted', '#64748b');
  $themeText = \App\Models\Pengaturan::get('theme_text', '#0f172a');
  $themeSurface = \App\Models\Pengaturan::get('theme_surface', '#ffffff');
  $themeBackground = \App\Models\Pengaturan::get('theme_background', '#f1f5f9');
  $themeBorder = \App\Models\Pengaturan::get('theme_border', '#e2e8f0');
  $themeBorderLight = \App\Models\Pengaturan::get('theme_border_light', '#cbd5e1');
@endphp
<style>
  :root {
    --p: {{ $themePrimary }};
    --p2: {{ $themePrimaryDark }};
    --p3: {{ $themePrimaryDarker }};
    --amber: {{ $themeAccent }};
    --red: {{ $themeDanger }};
    --indigo: {{ $themeInfo }};
    --sky: {{ $themeSuccess }};
    --muted: {{ $themeMuted }};
    --text: {{ $themeText }};
    --surface: {{ $themeSurface }};
    --bg: {{ $themeBackground }};
    --border: {{ $themeBorder }};
    --border2: {{ $themeBorderLight }};
    --r: 4px;
    --r-sm: 3px;
    --r-lg: 5px;
  }

  .card,
  .btn,
  .badge,
  .avatar-initial,
  .rounded {
    border-radius: var(--r) !important;
  }

  .page-body {
    background: var(--bg) !important;
  }

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

  .tbl th {
    background: #f8fafc !important;
    color: var(--muted) !important;
    font-weight: 800;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    padding: 12px 20px !important;
    border-bottom: 2px solid var(--border) !important;
    border-top: none !important;
  }

  .tbl td {
    padding: 12px 20px !important;
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

  .st-success {
    background: #dcfce7;
    color: #14532d;
    border: 1px solid #86efac;
  }

  .st-danger {
    background: #fee2e2;
    color: #7f1d1d;
    border: 1px solid #fca5a5;
  }

  .panel {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r-lg) !important;
    overflow: hidden;
  }

  .panel-body {
    padding: 16px 20px;
  }

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

  .stat-card:nth-child(1) { animation-delay: 0.05s; }
  .stat-card:nth-child(2) { animation-delay: 0.10s; }
  .stat-card:nth-child(3) { animation-delay: 0.15s; }
  .stat-card:nth-child(4) { animation-delay: 0.20s; }
  .stat-card:nth-child(5) { animation-delay: 0.25s; }
  .stat-card:nth-child(6) { animation-delay: 0.30s; }

  .pagination {
    gap: 2px;
  }

  .pagination .page-link {
    border-radius: var(--r) !important;
    border: 1px solid var(--border);
    color: var(--text);
    font-size: 0.8rem;
    font-weight: 600;
    padding: 6px 12px;
    min-width: 32px;
    text-align: center;
    transition: all 0.15s;
  }

  .pagination .page-link:hover {
    background: var(--bg);
    border-color: var(--p);
    color: var(--p);
  }

  .pagination .page-item.active .page-link {
    background: var(--p);
    border-color: var(--p);
    color: #fff;
    font-weight: 700;
  }

  .pagination .page-item.disabled .page-link {
    opacity: 0.4;
    pointer-events: none;
  }

  .pagination .page-item:first-child .page-link,
  .pagination .page-item:last-child .page-link {
    padding: 6px 10px;
  }
</style>
@endonce
