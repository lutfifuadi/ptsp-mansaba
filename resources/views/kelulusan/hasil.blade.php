<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Hasil Kelulusan - MAN 1 Kota Bandung</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Lora:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap"
        onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link href="https://fonts.googleapis.com/css2?family=Lora:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet"></noscript>
  <!-- Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    /* ── CELEBRATION OVERLAY ── */
    #celebrationOverlay {
      position: fixed; inset: 0; z-index: 9999;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      background: radial-gradient(ellipse at 50% 40%,
        rgba(5,25,15,0.97) 0%,
        rgba(2,12,7,0.99) 100%);
      animation: overlayIn 0.6s cubic-bezier(0.22,1,0.36,1) both;
      overflow: hidden;
    }
    #celebrationOverlay.hide {
      animation: overlayOut 0.8s cubic-bezier(0.55,0,1,0.45) forwards;
      pointer-events: none;
    }
    @keyframes overlayIn {
      from { opacity:0; }
      to   { opacity:1; }
    }
    @keyframes overlayOut {
      0%   { opacity:1; transform: scale(1); }
      100% { opacity:0; transform: scale(1.04); }
    }

    #confettiCanvas {
      position: absolute; inset: 0;
      width: 100%; height: 100%;
      pointer-events: none;
    }

    .cel-inner {
      position: relative; z-index: 2;
      text-align: center;
      padding: 0 24px;
      animation: celIn 0.9s 0.3s cubic-bezier(0.22,1,0.36,1) both;
    }
    @keyframes celIn {
      from { opacity:0; transform: translateY(32px) scale(0.92); }
      to   { opacity:1; transform: translateY(0) scale(1); }
    }

    .cel-badge {
      display: inline-flex; align-items: center; justify-content: center;
      width: 96px; height: 96px; border-radius: 4px;
      background: linear-gradient(135deg, #155c30 0%, #27ae60 50%, #2ecc71 100%);
      box-shadow:
        0 0 0 8px rgba(46,204,113,0.12),
        0 0 0 16px rgba(46,204,113,0.06),
        0 20px 60px rgba(46,204,113,0.4);
      margin: 0 auto 28px;
      animation: badgePop 0.7s 0.5s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    @keyframes badgePop {
      from { opacity:0; transform: scale(0.4) rotate(-20deg); }
      to   { opacity:1; transform: scale(1) rotate(0deg); }
    }
    .cel-badge svg { width: 48px; height: 48px; color: #fff; }

    .cel-title {
      font-family: 'Lora', Georgia, Cambria, "Times New Roman", Times, serif;
      font-size: clamp(2rem, 7vw, 3.4rem);
      font-weight: 700;
      line-height: 1.1;
      margin-bottom: 14px;
      background: linear-gradient(135deg, #fff 20%, #2ecc71 60%, #fff 100%);
      background-size: 200% auto;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      animation: shimmer 3s linear infinite, titleIn 0.8s 0.6s ease both;
    }
    @keyframes shimmer {
      0%   { background-position: 200% center; }
      100% { background-position: -200% center; }
    }
    @keyframes titleIn {
      from { opacity:0; transform: translateY(16px); }
      to   { opacity:1; transform: translateY(0); }
    }

    .cel-name {
      font-family: 'Lora', Georgia, Cambria, "Times New Roman", Times, serif;
      font-size: clamp(1.1rem, 4vw, 1.6rem);
      font-weight: 600;
      color: #f0c040;
      margin-bottom: 10px;
      animation: titleIn 0.8s 0.75s ease both;
      text-shadow: 0 0 30px rgba(240,192,64,0.5);
    }

    .cel-sub {
      font-size: clamp(0.85rem, 3vw, 1rem);
      color: rgba(255,255,255,0.65);
      max-width: 400px;
      margin: 0 auto 32px;
      line-height: 1.6;
      animation: titleIn 0.8s 0.9s ease both;
    }

    .cel-btn {
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      padding: 14px 36px;
      background: linear-gradient(135deg, #1e8449, #2ecc71);
      border: none; border-radius: 4px;
      color: #fff; font-size: 0.95rem; font-weight: 700;
      font-family: 'DM Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      cursor: pointer; letter-spacing: 0.5px;
      box-shadow: 0 8px 28px rgba(46,204,113,0.45);
      transition: transform 0.2s, box-shadow 0.2s, filter 0.2s;
      animation: titleIn 0.8s 1.1s ease both;
    }
    .cel-btn:hover { transform: translateY(-2px); box-shadow: 0 14px 36px rgba(46,204,113,0.55); filter: brightness(1.1); }
    .cel-btn:active { transform: translateY(0); }

    .cel-ring {
      position: absolute; border-radius: 4px;
      border: 1.5px solid rgba(46,204,113,0.18);
      animation: ringExpand 2s ease-out infinite;
      pointer-events: none;
    }
    .cel-ring:nth-child(1) { width: 180px; height: 180px; animation-delay: 0s; }
    .cel-ring:nth-child(2) { width: 280px; height: 280px; animation-delay: 0.5s; }
    .cel-ring:nth-child(3) { width: 380px; height: 380px; animation-delay: 1s; }
    @keyframes ringExpand {
      0%   { opacity: 0.6; transform: scale(0.85); }
      100% { opacity: 0; transform: scale(1.15); }
    }

    .cel-stars {
      position: absolute; inset: 0;
      pointer-events: none;
    }
    .cel-star {
      position: absolute; border-radius: 4px;
      background: #2ecc71;
      animation: starTwinkle 2s ease-in-out infinite;
    }
    @keyframes starTwinkle {
      0%, 100% { opacity: 0.1; transform: scale(0.8); }
      50%       { opacity: 0.7; transform: scale(1.3); }
    }

    :root {
      --bg:         #07130e;
      --bg-card:    #0c1f16;
      --bg-item:    #0f2619;
      --bg-hover:   #122d1e;
      --border:     rgba(255,255,255,0.06);
      --border-g:   rgba(46,204,113,0.18);
      --green:      #2ecc71;
      --green-dk:   #1e8449;
      --muted:      rgba(255,255,255,0.38);
      --subtle:     rgba(255,255,255,0.65);
    }

    html, body {
      width: 100%; height: 100%;
      overflow: hidden;
      font-family: 'DM Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      background: var(--bg);
      color: #fff;
      -webkit-font-smoothing: antialiased;
    }

    body::before {
      content: '';
      position: fixed; inset: 0; z-index: 0;
      background:
        radial-gradient(ellipse 55% 45% at 12% 18%, rgba(21,92,48,0.22) 0%, transparent 100%),
        radial-gradient(ellipse 45% 40% at 88% 82%, rgba(10,50,28,0.18) 0%, transparent 100%);
      pointer-events: none;
    }
    body::after {
      content: '';
      position: fixed; inset: 0; z-index: 0;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Cpath d='M30 2L34 14L46 10L38 22L50 28L38 32L46 44L34 40L30 52L26 40L14 44L22 32L10 28L22 22L14 10L26 14Z' fill='none' stroke='rgba(46,204,113,0.05)' stroke-width='0.7'/%3E%3C/svg%3E");
      background-size: 60px 60px;
      pointer-events: none;
    }

    .shell {
      position: relative; z-index: 1;
      width: 100%; height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 20px 20px;
    }

    .card {
      width: 100%; max-width: 720px;
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 4px;
      overflow: hidden;
      animation: rise 0.6s cubic-bezier(0.22,1,0.36,1) both;
    }
    @keyframes rise {
      from { opacity:0; transform:translateY(20px) scale(0.98); }
      to   { opacity:1; transform:translateY(0) scale(1); }
    }

    /* ── Header ── */
    .c-head {
      display: flex; align-items: center; justify-content: space-between;
      padding: 16px 28px;
      border-bottom: 1px solid var(--border);
    }
    .brand { display: flex; align-items: center; gap: 11px; }
    .brand-icon {
      width: 36px; height: 36px; flex-shrink: 0;
      background: linear-gradient(135deg, var(--green-dk), var(--green));
      border-radius: 4px;
      display: flex; align-items: center; justify-content: center;
    }
    .brand-icon svg { width: 18px; height: 18px; fill: #fff; }
    .brand-name {
      font-size: 0.95rem; font-weight: 600;
      letter-spacing: 0.1em; text-transform: uppercase;
      color: rgba(255,255,255,0.88); line-height: 1;
    }
    .brand-sub {
      font-size: 0.75rem; font-weight: 400;
      color: var(--muted); margin-top: 4px;
    }
    .badge-resmi {
      font-size: 0.7rem; font-weight: 600;
      letter-spacing: 0.12em; text-transform: uppercase;
      color: var(--green);
      background: rgba(46,204,113,0.07);
      border: 1px solid var(--border-g);
      padding: 5px 12px; border-radius: 4px;
    }

    /* ── Body ── */
    .c-body { padding: 28px 32px; }

    /* Status */
    .status-row {
      display: flex; align-items: center; gap: 24px;
      padding: 24px 28px;
      border: 1px solid var(--border-g);
      border-radius: 4px;
      margin-bottom: 24px;
      background: rgba(0,0,0,0.2);
    }
    .s-icon {
      width: 64px; height: 64px; flex-shrink: 0; border-radius: 4px;
      display: flex; align-items: center; justify-content: center;
    }
    .s-icon svg { width: 32px; height: 32px; color: #fff; }
    .s-icon.lulus   { background: linear-gradient(135deg,#155c30,#27ae60); animation: glow 3s ease-in-out infinite; }
    .s-icon.tidak   { background: linear-gradient(135deg,#7b1a1a,#c0392b); }
    .s-icon.pending { background: linear-gradient(135deg,#6b5b18,#d4ac0d); }
    @keyframes glow {
      0%,100%{ box-shadow:0 0 0 7px rgba(39,174,96,0.10); }
      50%    { box-shadow:0 0 0 12px rgba(39,174,96,0.05); }
    }
    .s-title {
      font-family: 'Lora', Georgia, Cambria, "Times New Roman", Times, serif;
      font-size: 1.85rem; font-weight: 700; line-height: 1.2;
    }
    .s-title.lulus   { color: var(--green); }
    .s-title.tidak   { color: #e74c3c; }
    .s-title.pending { color: #f0c040; }
    .s-desc { font-size: 1rem; color: var(--subtle); margin-top: 6px; }
    .s-desc strong { font-weight: 600; }
    .s-desc strong.lulus { color: var(--green); }
    .s-desc strong.tidak { color: #e74c3c; }

    /* Grid — value only, no labels */
    .grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
    }
    .gi {
      background: var(--bg-item);
      border: 1px solid var(--border);
      border-radius: 4px;
      padding: 14px 18px;
      font-size: 1rem; font-weight: 600;
      color: rgba(255,255,255,0.9);
      transition: background 0.18s, border-color 0.18s;
    }
    .gi:hover { background: var(--bg-hover); border-color: var(--border-g); }
    .gi.full  { grid-column: 1 / -1; }

    /* ── Footer ── */
    .c-foot {
      display: flex; align-items: center; gap: 10px;
      padding: 20px 32px 24px;
      border-top: 1px solid var(--border);
    }
    .btn-dl {
      flex: 1;
      display: flex; align-items: center; justify-content: center; gap: 8px;
      padding: 14px 20px;
      background: var(--green); color: #061a0e;
      font-family: 'DM Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      font-size: 0.95rem; font-weight: 700;
      border: none; border-radius: 4px;
      cursor: pointer; text-decoration: none;
      transition: filter 0.2s, transform 0.15s;
    }
    .btn-dl:hover { filter: brightness(1.08); transform: translateY(-1px); color: #061a0e; text-decoration: none; }
    .btn-dl svg { width: 18px; height: 18px; flex-shrink: 0; }

    .btn-bk {
      display: flex; align-items: center; justify-content: center; gap: 8px;
      padding: 14px 20px;
      background: transparent; color: var(--subtle);
      font-family: 'DM Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      font-size: 0.9rem; font-weight: 500;
      border: 1px solid var(--border); border-radius: 4px;
      cursor: pointer; text-decoration: none; white-space: nowrap;
      transition: border-color 0.18s, color 0.18s, background 0.18s;
    }
    .btn-bk:hover { border-color: var(--border-g); color: #fff; background: rgba(46,204,113,0.05); text-decoration: none; }
    .btn-bk svg { width: 14px; height: 14px; flex-shrink: 0; }

    .copy {
      margin-top: 12px;
      font-size: 0.65rem; color: rgba(255,255,255,0.14);
      letter-spacing: 0.04em; text-align: center;
    }

    /* On very small screens allow scroll */
    @media (max-height: 580px), (max-width: 480px) {
      html, body { overflow-y: auto; height: auto; }
      .shell { height: auto; min-height: 100vh; padding: 20px 14px 28px; }
      .c-head, .c-body, .c-foot { padding-left: 18px; padding-right: 18px; }
      .grid { grid-template-columns: 1fr; }
      .gi.full { grid-column: 1; }
      .c-foot { flex-direction: column; }
      .btn-dl, .btn-bk { width: 100%; }
      .badge-resmi { display: none; }
      .status-row { flex-direction: column; text-align: center; }
    }
    /* ── QR Code Section ── */
    .qr-section {
      margin-top: 20px;
      padding: 20px 24px;
      border: 1px solid var(--border-g);
      border-radius: 4px;
      background: rgba(46,204,113,0.03);
      display: flex;
      align-items: center;
      gap: 20px;
    }
    .qr-box {
      flex-shrink: 0;
      background: #fff;
      border-radius: 4px;
      padding: 8px;
      width: 112px; height: 112px;
      display: flex; align-items: center; justify-content: center;
    }
    .qr-box canvas, .qr-box img {
      display: block;
    }
    .qr-info { flex: 1; min-width: 0; }
    .qr-label {
      font-size: 0.72rem; font-weight: 600;
      letter-spacing: 0.1em; text-transform: uppercase;
      color: var(--green); margin-bottom: 6px;
    }
    .qr-title {
      font-size: 1rem; font-weight: 600;
      color: rgba(255,255,255,0.9); margin-bottom: 4px;
      line-height: 1.3;
    }
    .qr-desc {
      font-size: 0.82rem;
      color: var(--muted);
      line-height: 1.5;
    }
    .qr-link {
      display: inline-flex; align-items: center; gap: 5px;
      margin-top: 10px;
      font-size: 0.78rem; font-weight: 600;
      color: var(--green);
      text-decoration: none;
      transition: opacity 0.18s;
    }
    .qr-link:hover { opacity: 0.75; text-decoration: none; }
    .qr-link svg { width: 12px; height: 12px; flex-shrink: 0; }
    @media (max-width: 480px) {
      .qr-section { flex-direction: column; text-align: center; }
      .qr-info { width: 100%; }
    }
  </style>
</head>
<body>

@if($siswa->status_kelulusan === 'lulus')
<!-- ── CELEBRATION OVERLAY ── -->
<div id="celebrationOverlay">
  <canvas id="confettiCanvas"></canvas>

  <!-- Rings -->
  <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
    <div class="cel-ring"></div>
    <div class="cel-ring"></div>
    <div class="cel-ring"></div>
  </div>

  <!-- Stars background -->
  <div class="cel-stars" id="celStars"></div>

  <div class="cel-inner">
    <div class="cel-badge">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
      </svg>
    </div>
    <div class="cel-title">🎉 Selamat!</div>
    <div class="cel-name">{{ $siswa->nama_lengkap }}</div>
    <div class="cel-sub">
      Anda dinyatakan <strong style="color:#2ecc71">LULUS</strong> dari MAN 1 Kota Bandung.<br>
      Semoga ilmu yang didapat menjadi bekal kesuksesan di masa depan.
    </div>
    <button class="cel-btn" onclick="dismissCelebration()">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="9 18 15 12 9 6"/>
      </svg>
      Lihat Detail Kelulusan
    </button>
  </div>
</div>
@endif
  <div class="shell">
    <div class="card">

      <div class="c-head">
        <div class="brand">
          <div class="brand-icon">
            <svg viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/></svg>
          </div>
          <div>
            <div class="brand-name">MAN 1 Kota Bandung</div>
            <div class="brand-sub">Pengumuman Kelulusan &mdash; {{ \App\Models\Pengaturan::get('tahun_ajaran', '2025/2026') }}</div>
          </div>
        </div>
        <div class="badge-resmi">Resmi</div>
      </div>

      <div class="c-body">

        @if($siswa->status_kelulusan === 'lulus')
          <div class="status-row">
            <div class="s-icon lulus">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
              </svg>
            </div>
            <div>
              <div class="s-title lulus">Selamat, Anda Lulus!</div>
              <div class="s-desc">Anda dinyatakan <strong class="lulus">LULUS</strong> dari MAN 1 Kota Bandung.</div>
            </div>
          </div>

        @elseif($siswa->status_kelulusan === 'tidak_lulus')
          <div class="status-row" style="border-color:rgba(231,76,60,0.18)">
            <div class="s-icon tidak">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
              </svg>
            </div>
            <div>
              <div class="s-title tidak">Tidak Lulus</div>
              <div class="s-desc">Anda dinyatakan <strong class="tidak">TIDAK LULUS</strong> dari MAN 1 Kota Bandung.</div>
            </div>
          </div>

        @else
          <div class="status-row" style="border-color:rgba(212,172,13,0.18)">
            <div class="s-icon pending">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
              </svg>
            </div>
            <div>
              <div class="s-title pending">Menunggu</div>
              <div class="s-desc">Status kelulusan Anda belum diumumkan.</div>
            </div>
          </div>
        @endif

        <div class="grid">
          <div class="gi"><span style="color:var(--muted); font-size: 0.72rem; text-transform:uppercase; letter-spacing: 0.05em; display:block; margin-bottom: 4px;">NISN</span>{{ $siswa->nisn }}</div>
          <div class="gi"><span style="color:var(--muted); font-size: 0.72rem; text-transform:uppercase; letter-spacing: 0.05em; display:block; margin-bottom: 4px;">No. Peserta</span>{{ $siswa->no_peserta ?? '-' }}</div>
          <div class="gi full"><span style="color:var(--muted); font-size: 0.72rem; text-transform:uppercase; letter-spacing: 0.05em; display:block; margin-bottom: 4px;">Nama Lengkap</span>{{ $siswa->nama_lengkap }}</div>
        </div>

        @if($siswa->status_kelulusan === 'lulus' && $siswa->validation_token)
        <div class="qr-section">
          <div class="qr-box">
            <div id="qrcode"></div>
          </div>
          <div class="qr-info">
            <div class="qr-label">🔒 Verifikasi Digital</div>
            <div class="qr-title">QR Code Bukti Kelulusan</div>
            <div class="qr-desc">
              Scan QR Code ini untuk memverifikasi kelulusan secara online.
              Dapat digunakan oleh instansi atau sekolah lain untuk konfirmasi.
            </div>
            <a href="{{ route('kelulusan.validasi', $siswa->validation_token) }}" class="qr-link" target="_blank" rel="noopener noreferrer">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                <polyline points="15 3 21 3 21 9"/>
                <line x1="10" y1="14" x2="21" y2="3"/>
              </svg>
              Buka Link Validasi
            </a>
          </div>
        </div>
        <script>
        (function() {
          var validasiUrl = "{{ route('kelulusan.validasi', $siswa->validation_token) }}";
          new QRCode(document.getElementById('qrcode'), {
            text: validasiUrl,
            width: 96,
            height: 96,
            colorDark: '#000000',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.M
          });
        })();
        </script>
        @endif

      </div>

      <div class="c-foot">
        @if($siswa->status_kelulusan === 'lulus')
          <a href="{{ route('kelulusan.pdf', $siswa->nisn) }}" class="btn-dl" target="_blank" rel="noopener noreferrer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Download Surat Kelulusan (PDF)
          </a>
        @endif
        <a href="{{ route('kelulusan.index') }}" class="btn-bk">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
          </svg>
          Kembali
        </a>
      </div>

    </div>
    <div class="copy">&copy; {{ date('Y') }} MAN 1 Kota Bandung &mdash; Sistem Pengumuman Kelulusan</div>
  </div>

@if($siswa->status_kelulusan === 'lulus')
<script>
(function () {
  /* ── Stars ── */
  const starsContainer = document.getElementById('celStars');
  for (let i = 0; i < 30; i++) {
    const s = document.createElement('div');
    s.className = 'cel-star';
    const size = Math.random() * 4 + 2;
    s.style.cssText = [
      `width:${size}px`, `height:${size}px`,
      `top:${Math.random()*100}%`, `left:${Math.random()*100}%`,
      `animation-delay:${Math.random()*2}s`,
      `animation-duration:${1.5+Math.random()*2}s`,
      `background:${['#2ecc71','#f0c040','#ffffff','#27ae60'][Math.floor(Math.random()*4)]}`
    ].join(';');
    starsContainer.appendChild(s);
  }

  /* ── Confetti (Premium) ── */
  function fireConfetti() {
    const duration = 5 * 1000;
    const animationEnd = Date.now() + duration;
    const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 10000 };

    function randomInRange(min, max) {
      return Math.random() * (max - min) + min;
    }

    const interval = setInterval(function() {
      const timeLeft = animationEnd - Date.now();

      if (timeLeft <= 0) {
        return clearInterval(interval);
      }

      const particleCount = 50 * (timeLeft / duration);
      // since particles fall down, start a bit higher than random
      confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
      confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
    }, 250);

    /* Initial Burst */
    confetti({
      particleCount: 150,
      spread: 70,
      origin: { y: 0.6 },
      zIndex: 10000
    });
  }

  fireConfetti();

  /* ── Auto dismiss after 7s ── */
  const autoTimer = setTimeout(() => dismissCelebration(), 7000);

  window.dismissCelebration = function () {
    clearTimeout(autoTimer);
    const overlay = document.getElementById('celebrationOverlay');
    if (overlay) {
      overlay.classList.add('hide');
      overlay.addEventListener('animationend', () => overlay.remove(), { once: true });
    }
  };
})();
</script>
@endif

</body>
</html>