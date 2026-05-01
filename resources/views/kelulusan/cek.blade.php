<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Cek Kelulusan - MAN 1 Kota Bandung</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"></noscript>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --green-deepest: #061410;
      --green-deep:    #0a1f12;
      --green-dark:    #0d2b18;
      --green-mid:     #155c30;
      --green-accent:  #1e8449;
      --green-bright:  #27ae60;
      --green-glow:    #2ecc71;
      --gold:          #c9a84c;
      --gold-light:    #f0d080;
      --cream:         #f5f0e8;
      --white:         #ffffff;
      --text-muted:    rgba(255,255,255,0.55);
      --card-bg:       rgba(13, 43, 24, 0.82);
      --card-border:   rgba(46, 204, 113, 0.18);
      --shadow:        0 24px 80px rgba(0,0,0,0.55);
      --radius:        4px;
    }

    html, body {
      height: 100%;
      overflow: hidden;
    }

    body {
      font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      background-color: var(--green-deepest);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      position: relative;
    }

    /* ── Animated gradient background ───────────────────────── */
    .bg-layer {
      position: fixed;
      inset: 0;
      background: radial-gradient(ellipse at 20% 30%, #0f3d20 0%, transparent 55%),
                  radial-gradient(ellipse at 80% 70%, #0b2e18 0%, transparent 55%),
                  linear-gradient(160deg, #061410 0%, #0d2b18 50%, #061410 100%);
      animation: bgPulse 8s ease-in-out infinite alternate;
      z-index: 0;
    }
    @keyframes bgPulse {
      0%   { filter: brightness(1); }
      100% { filter: brightness(1.12); }
    }

    /* ── Islamic geometric pattern overlay ──────────────────── */
    .bg-pattern {
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cg fill='none' stroke='rgba(46,204,113,0.10)' stroke-width='0.6'%3E%3Cpolygon points='40,4 44.6,18 59,12 50,26 65,32 50,36 59,50 44.6,44 40,58 35.4,44 21,50 30,36 15,32 30,26 21,12 35.4,18'/%3E%3Crect x='28' y='28' width='24' height='24' transform='rotate(45 40 40)'/%3E%3Ccircle cx='40' cy='40' r='10'/%3E%3C/g%3E%3C/svg%3E");
      background-size: 80px 80px;
      opacity: 1;
      z-index: 1;
      pointer-events: none;
    }

    /* ── Floating orbs ───────────────────────────────────────── */
    .orb {
      position: fixed;
      border-radius: 50%;
      filter: blur(60px);
      z-index: 1;
      pointer-events: none;
    }
    .orb-1 {
      width: 340px; height: 340px;
      background: radial-gradient(circle, rgba(30,132,73,0.18) 0%, transparent 70%);
      top: -80px; left: -80px;
      animation: orbFloat1 12s ease-in-out infinite;
    }
    .orb-2 {
      width: 280px; height: 280px;
      background: radial-gradient(circle, rgba(201,168,76,0.10) 0%, transparent 70%);
      bottom: -60px; right: -60px;
      animation: orbFloat2 14s ease-in-out infinite;
    }
    @keyframes orbFloat1 {
      0%, 100% { transform: translate(0,0); }
      50%       { transform: translate(40px, 30px); }
    }
    @keyframes orbFloat2 {
      0%, 100% { transform: translate(0,0); }
      50%       { transform: translate(-30px, -40px); }
    }

    /* ── Page wrapper ────────────────────────────────────────── */
    .page-wrapper {
      position: relative;
      z-index: 10;
      width: 100%;
      padding: 16px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    /* ── Card ────────────────────────────────────────────────── */
    .card-islamic {
      width: 100%;
      max-width: 850px;
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: var(--radius);
      padding: 36px 40px;
      box-shadow: var(--shadow), inset 0 1px 0 rgba(46,204,113,0.12);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      animation: cardEnter 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    @keyframes cardEnter {
      from { opacity: 0; transform: translateY(28px) scale(0.97); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ── Bismillah ───────────────────────────────────────────── */
    .bismillah {
      font-family: 'Amiri', Georgia, Cambria, "Times New Roman", Times, serif;
      font-size: 1.5rem;
      color: var(--gold);
      text-align: center;
      margin-bottom: 18px;
      letter-spacing: 0.5px;
      text-shadow: 0 0 20px rgba(201,168,76,0.4);
      animation: fadeSlideDown 0.6s 0.2s ease both;
    }

    /* ── Divider ─────────────────────────────────────────────── */
    .divider-ornament {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 20px;
      animation: fadeSlideDown 0.6s 0.3s ease both;
    }
    .divider-ornament::before,
    .divider-ornament::after {
      content: '';
      flex: 1;
      height: 1px;
      background: linear-gradient(to right, transparent, rgba(201,168,76,0.4), transparent);
    }
    .divider-ornament span {
      color: var(--gold);
      font-size: 1rem;
    }

    /* ── School header ───────────────────────────────────────── */
    .school-header {
      text-align: center;
      margin-bottom: 22px;
      animation: fadeSlideDown 0.6s 0.35s ease both;
    }
    .school-icon {
      width: 64px; height: 64px;
      background: linear-gradient(135deg, var(--green-mid), var(--green-accent));
      border-radius: 16px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 12px;
      box-shadow: 0 8px 24px rgba(30,132,73,0.35), 0 0 0 1px rgba(46,204,113,0.2);
      overflow: hidden;
    }
    .school-icon img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      display: block;
    }
    .school-icon svg { width: 32px; height: 32px; fill: var(--white); }
    .school-header h1 {
      font-family: 'Amiri', Georgia, Cambria, "Times New Roman", Times, serif;
      font-size: 2rem;
      font-weight: 700;
      color: var(--white);
      line-height: 1.2;
      margin-bottom: 4px;
      letter-spacing: 2px;
      text-transform: uppercase;
      text-shadow: 0 0 30px rgba(46,204,113,0.35), 0 2px 8px rgba(0,0,0,0.4);
      background: linear-gradient(135deg, #ffffff 30%, var(--green-glow) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .school-header p {
      font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      font-size: 0.95rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.16em;
      color: var(--green-glow);
      margin-top: 4px;
    }
    .school-header .tahun {
      display: inline-block;
      background: rgba(46,204,113,0.12);
      border: 1px solid rgba(46,204,113,0.25);
      border-radius: 20px;
      padding: 2px 12px;
      font-size: 0.75rem;
      color: var(--green-glow);
      margin-top: 6px;
    }

    /* ── Section divider ─────────────────────────────────────── */
    .section-divider {
      height: 1px;
      background: linear-gradient(to right, transparent, rgba(46,204,113,0.25), transparent);
      margin: 18px 0;
    }

    /* ── Alert error ─────────────────────────────────────────── */
    .alert-error {
      background: rgba(231,76,60,0.12);
      border: 1px solid rgba(231,76,60,0.3);
      border-radius: 10px;
      padding: 12px 16px;
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin-bottom: 18px;
      animation: fadeSlideDown 0.4s ease both;
    }
    .alert-error svg { flex-shrink: 0; color: #e74c3c; margin-top: 1px; }
    .alert-error span { font-size: 0.85rem; color: #ff8a80; line-height: 1.4; }

    /* ── Form elements ───────────────────────────────────────── */
    .form-body { animation: fadeSlideDown 0.6s 0.4s ease both; }

    .form-intro {
      text-align: center;
      color: var(--text-muted);
      font-size: 0.875rem;
      margin-bottom: 20px;
      line-height: 1.5;
    }

    .form-group { margin-bottom: 20px; }
    .form-label {
      display: block;
      font-size: 0.82rem;
      font-weight: 600;
      color: rgba(255,255,255,0.8);
      margin-bottom: 8px;
      letter-spacing: 0.4px;
      text-transform: uppercase;
    }
    .form-input {
      width: 100%;
      background: rgba(6, 20, 16, 0.7);
      border: 1.5px solid rgba(46,204,113,0.2);
      border-radius: 12px;
      padding: 14px 18px;
      font-size: 1.05rem;
      font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      color: var(--white);
      letter-spacing: 2px;
      transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
      outline: none;
      -webkit-appearance: none;
    }
    .form-input::placeholder { color: rgba(255,255,255,0.25); letter-spacing: 1px; font-size: 0.9rem; }
    .form-input:focus {
      border-color: var(--green-bright);
      background: rgba(6, 20, 16, 0.9);
      box-shadow: 0 0 0 3px rgba(39,174,96,0.18), 0 0 20px rgba(39,174,96,0.08);
    }
    .form-input.is-invalid { border-color: rgba(231,76,60,0.6); }
    .form-hint { font-size: 0.75rem; color: var(--text-muted); margin-top: 6px; }
    .form-error { font-size: 0.78rem; color: #ff8a80; margin-top: 6px; }

    /* ── Button ──────────────────────────────────────────────── */
    .btn-primary-islamic {
      width: 100%;
      padding: 15px 24px;
      background: linear-gradient(135deg, var(--green-accent) 0%, var(--green-bright) 100%);
      border: none;
      border-radius: 12px;
      color: var(--white);
      font-size: 0.95rem;
      font-weight: 600;
      font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: transform 0.2s, box-shadow 0.2s, filter 0.2s;
      box-shadow: 0 6px 20px rgba(39,174,96,0.35);
      position: relative;
      overflow: hidden;
    }
    .btn-primary-islamic::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, transparent 60%);
      border-radius: inherit;
      pointer-events: none;
    }
    .btn-primary-islamic:hover:not(:disabled) {
      transform: translateY(-2px);
      box-shadow: 0 10px 32px rgba(39,174,96,0.5);
      filter: brightness(1.08);
    }
    .btn-primary-islamic:active:not(:disabled) {
      transform: translateY(0);
      box-shadow: 0 4px 12px rgba(39,174,96,0.3);
    }
    .btn-primary-islamic:disabled {
      opacity: 0.7;
      cursor: not-allowed;
    }
    .btn-primary-islamic svg { width: 18px; height: 18px; }

    /* ── Countdown ───────────────────────────────────────────── */
    .countdown-body { animation: fadeSlideDown 0.6s 0.4s ease both; }
    .countdown-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 16px;
    }
    .countdown-icon svg {
      width: 56px; height: 56px;
      color: var(--gold);
      filter: drop-shadow(0 0 12px rgba(201,168,76,0.5));
      animation: pulse 2s ease-in-out infinite;
    }
    @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 1; }
      50%       { transform: scale(1.06); opacity: 0.85; }
    }
    .countdown-title {
      font-family: 'Amiri', Georgia, Cambria, "Times New Roman", Times, serif;
      font-size: 1.15rem;
      color: rgba(255,255,255,0.85);
      text-align: center;
      margin-bottom: 6px;
    }
    .countdown-date {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      margin-bottom: 24px;
    }
    .countdown-date-pill {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(46,204,113,0.08);
      border: 1px solid rgba(46,204,113,0.22);
      border-radius: 4px;
      padding: 10px 20px;
    }
    .countdown-date-pill svg {
      width: 15px; height: 15px;
      color: var(--gold);
      flex-shrink: 0;
    }
    .countdown-date-pill span {
      font-size: 1rem;
      font-weight: 700;
      color: var(--white);
      letter-spacing: 0.2px;
    }
    .countdown-time-pill {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(201,168,76,0.08);
      border: 1px solid rgba(201,168,76,0.22);
      border-radius: 4px;
      padding: 7px 18px;
    }
    .countdown-time-pill svg {
      width: 13px; height: 13px;
      color: var(--gold);
      flex-shrink: 0;
    }
    .countdown-time-pill span {
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--gold-light);
      letter-spacing: 0.5px;
    }
    .countdown-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 10px;
      margin-bottom: 16px;
    }
    .cd-box {
      background: rgba(6, 20, 16, 0.7);
      border: 1px solid rgba(46,204,113,0.2);
      border-radius: 12px;
      padding: 14px 8px 10px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .cd-box::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, var(--green-accent), var(--green-glow));
    }
    .cd-num {
      font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      font-size: 1.9rem;
      font-weight: 700;
      color: var(--white);
      line-height: 1;
      display: block;
      transition: transform 0.15s;
    }
    .cd-num.flip {
      animation: flip 0.3s ease;
    }
    @keyframes flip {
      0%   { transform: translateY(-4px); opacity: 0.4; }
      100% { transform: translateY(0); opacity: 1; }
    }
    .cd-label {
      font-size: 0.68rem;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.8px;
      margin-top: 4px;
      display: block;
    }
    .countdown-note {
      text-align: center;
      color: var(--text-muted);
      font-size: 0.78rem;
      line-height: 1.5;
    }

    /* ── Footer ──────────────────────────────────────────────── */
    .page-footer {
      margin-top: 14px;
      text-align: center;
      color: rgba(255,255,255,0.2);
      font-size: 0.7rem;
      animation: fadeIn 1s 1s ease both;
    }

    /* ── Spinner ─────────────────────────────────────────────── */
    .spinner {
      width: 18px; height: 18px;
      border: 2.5px solid rgba(255,255,255,0.3);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin 0.7s linear infinite;
      display: inline-block;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ── Animations ──────────────────────────────────────────── */
    @keyframes fadeSlideDown {
      from { opacity: 0; transform: translateY(-12px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to   { opacity: 1; }
    }

    /* ── Responsive ──────────────────────────────────────────── */
    @media (min-width: 992px) {
      .card-islamic { padding: 44px 52px; }
    }
    @media (max-width: 480px) {
      html, body { overflow: auto; }
      .card-islamic { padding: 26px 22px; max-width: 98%; border-radius: 16px; }
      .school-header h1 { font-size: 1.55rem; letter-spacing: 1px; }
      .bismillah { font-size: 1.3rem; }
      .cd-num { font-size: 1.5rem; }
      .countdown-grid { gap: 7px; }
      .cd-box { padding: 10px 5px 8px; }
    }
    @media (max-width: 360px) {
      .card-islamic { padding: 20px 16px; }
      .countdown-grid { gap: 5px; }
      .cd-num { font-size: 1.3rem; }
    }
  </style>
</head>
<body>
  <div class="bg-layer"></div>
  <div class="bg-pattern"></div>
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
  <canvas id="festiveCanvas" style="position:fixed;inset:0;z-index:2;pointer-events:none;"></canvas>

  @php
    $schoolLogo = \App\Models\Pengaturan::get('logo_kanan');
    if ($schoolLogo && !str_starts_with($schoolLogo, 'http')) {
      $schoolLogo = \Illuminate\Support\Facades\Storage::url($schoolLogo);
    }
  @endphp

  <div class="page-wrapper">
    <div class="card-islamic">

      {{-- School Header --}}
      <div class="school-header">
        <div class="school-icon">
          @if($schoolLogo)
            <img src="{{ $schoolLogo }}" alt="Logo Sekolah">
          @else
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
            </svg>
          @endif
        </div>
        <h1>PENGUMUMAN KELULUSAN</h1>
        <p>MAN 1 Kota Bandung</p>
        <span class="tahun">Tahun Ajaran {{ \App\Models\Pengaturan::get('tahun_ajaran', '2025/2026') }}</span>
      </div>

      <div class="section-divider"></div>

      @if($sudahDibuka)
        {{-- ─── FORM CEK NISN ─────────────────────────────── --}}
        <div class="form-body">
          <p class="form-intro">Masukkan NISN Anda untuk melihat pengumuman hasil kelulusan.</p>

          @if($errors->any())
            <div class="alert-error">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
              </svg>
              <span>{{ $errors->first() }}</span>
            </div>
          @endif

          <form method="POST" action="{{ route('kelulusan.cek') }}" id="formCekNisn">
            @csrf
            <div class="form-group">
              <label class="form-label" for="nisn">Nomor Induk Siswa Nasional (NISN)</label>
              <input
                type="text"
                id="nisn"
                name="nisn"
                class="form-input @error('nisn') is-invalid @enderror"
                placeholder="Masukkan 10 digit NISN"
                value="{{ old('nisn') }}"
                maxlength="10"
                inputmode="numeric"
                autocomplete="off"
                required
              />
              @error('nisn')
                <div class="form-error">{{ $message }}</div>
              @else
                <div class="form-hint">Contoh: 1234567890</div>
              @enderror
            </div>
            <button type="submit" class="btn-primary-islamic" id="btnCek">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
              </svg>
              Cek Kelulusan
            </button>
          </form>
        </div>

      @else
        {{-- ─── COUNTDOWN TIMER ────────────────────────────── --}}
        <div class="countdown-body">
          <div class="countdown-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
          </div>
          <p class="countdown-title">Pengumuman akan dibuka pada</p>
          <div class="countdown-date">
            <div class="countdown-date-pill">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
              <span>{{ \Carbon\Carbon::parse($tanggalPengumuman)->locale('id')->translatedFormat('l, d F Y') }}</span>
            </div>
            <div class="countdown-time-pill">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
              </svg>
              <span>Pukul {{ \Carbon\Carbon::parse($tanggalPengumuman)->format('H:i') }} WIB</span>
            </div>
          </div>
          <div class="countdown-grid" id="countdown">
            <div class="cd-box">
              <span class="cd-num" id="cd-hari">00</span>
              <span class="cd-label">Hari</span>
            </div>
            <div class="cd-box">
              <span class="cd-num" id="cd-jam">00</span>
              <span class="cd-label">Jam</span>
            </div>
            <div class="cd-box">
              <span class="cd-num" id="cd-menit">00</span>
              <span class="cd-label">Menit</span>
            </div>
            <div class="cd-box">
              <span class="cd-num" id="cd-detik">00</span>
              <span class="cd-label">Detik</span>
            </div>
          </div>
          <p class="countdown-note">Halaman ini akan otomatis terbuka saat waktunya tiba. Mohon bersabar.</p>
        </div>
      @endif

    </div>

    <div class="page-footer">
      &copy; {{ date('Y') }} MAN 1 Kota Bandung &mdash; Sistem Pengumuman Kelulusan
    </div>
  </div>

  <script>
    @if(!$sudahDibuka)
    (function () {
      const targetTime = new Date("{{ $tanggalPengumuman->toIso8601String() }}").getTime();
      const elHari  = document.getElementById('cd-hari');
      const elJam   = document.getElementById('cd-jam');
      const elMenit = document.getElementById('cd-menit');
      const elDetik = document.getElementById('cd-detik');

      function setVal(el, val) {
        const str = String(val).padStart(2, '0');
        if (el.textContent !== str) {
          el.textContent = str;
          el.classList.remove('flip');
          void el.offsetWidth; // reflow
          el.classList.add('flip');
        }
      }

      function updateCountdown() {
        const diff = targetTime - Date.now();
        if (diff <= 0) { window.location.reload(); return; }
        setVal(elHari,  Math.floor(diff / 86400000));
        setVal(elJam,   Math.floor((diff % 86400000) / 3600000));
        setVal(elMenit, Math.floor((diff % 3600000) / 60000));
        setVal(elDetik, Math.floor((diff % 60000) / 1000));
      }

      updateCountdown();
      setInterval(updateCountdown, 1000);
    })();
    @endif

    /* ── Festive Background Particles ── */
    (function() {
      const canvas = document.getElementById('festiveCanvas');
      const ctx = canvas.getContext('2d');
      let W, H, particles = [];

      function resize() {
        W = canvas.width = window.innerWidth;
        H = canvas.height = window.innerHeight;
      }
      window.addEventListener('resize', resize);
      resize();

      class Particle {
        constructor() {
          this.reset();
        }
        reset() {
          this.x = Math.random() * W;
          this.y = Math.random() * H;
          this.size = Math.random() * 2 + 1;
          this.speedX = (Math.random() - 0.5) * 0.5;
          this.speedY = Math.random() * 0.5 + 0.2;
          this.color = Math.random() > 0.5 ? '#c9a84c' : '#2ecc71'; // Gold or Green
          this.opacity = Math.random() * 0.5 + 0.2;
        }
        update() {
          this.x += this.speedX;
          this.y += this.speedY;
          if (this.y > H) {
            this.y = -10;
            this.x = Math.random() * W;
          }
        }
        draw() {
          ctx.beginPath();
          ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
          ctx.fillStyle = this.color;
          ctx.globalAlpha = this.opacity;
          ctx.fill();
        }
      }

      for (let i = 0; i < 60; i++) particles.push(new Particle());

      function animate() {
        ctx.clearRect(0, 0, W, H);
        particles.forEach(p => {
          p.update();
          p.draw();
        });
        requestAnimationFrame(animate);
      }
      animate();
    })();

    @if($sudahDibuka)
    (function () {
      const input = document.getElementById('nisn');
      const form  = document.getElementById('formCekNisn');
      const btn   = document.getElementById('btnCek');

      input.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
      });

      form.addEventListener('submit', function () {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner"></span> Memproses...';
      });
    })();
    @endif
  </script>
</body>
</html>
