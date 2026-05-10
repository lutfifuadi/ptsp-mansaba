<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Cek Hasil PMBM - MAN 1 Kota Bandung</title>
  <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::get('logo_kanan') ?: asset('assets/img/favicon/favicon.ico') }}" />
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
      --card-bg:       rgba(13, 43, 24, 0.42);
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
      font-family: 'Amiri', serif;
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
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.95rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.16em;
      color: var(--green-glow);
      margin-top: 4px;
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
      background: rgba(6, 20, 16, 0.4);
      border: 1.5px solid rgba(46,204,113,0.2);
      border-radius: 12px;
      padding: 14px 18px;
      font-size: 1.05rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: var(--white);
      letter-spacing: 2px;
      transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
      outline: none;
      -webkit-appearance: none;
    }
    .form-input:focus {
      border-color: var(--green-bright);
      background: rgba(6, 20, 16, 0.9);
      box-shadow: 0 0 0 3px rgba(39,174,96,0.18), 0 0 20px rgba(39,174,96,0.08);
    }
    .form-input.is-invalid { border-color: rgba(231,76,60,0.6); }

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
      font-family: 'Plus Jakarta Sans', sans-serif;
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
    .btn-secondary {
      margin-top: 15px;
      display: block; text-align: center; color: var(--text-muted); text-decoration: none; font-size: 0.85rem;
      transition: color 0.2s;
    }
    .btn-secondary:hover { color: #fff; }

    /* ── Countdown ───────────────────────────────────────────── */
    .countdown-body { animation: fadeSlideDown 0.6s 0.4s ease both; text-align: center;}
    .countdown-title { color: var(--text-muted); margin-bottom: 15px; font-size: 1.1rem; }
    .countdown-date-pill {
      background: rgba(46,204,113,0.1); border: 1px solid var(--card-border);
      padding: 12px 24px; border-radius: 4px; display: inline-block; color: #fff; font-weight: 700;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
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
    @media (max-width: 480px) {
      html, body { overflow: auto; }
      .card-islamic { padding: 26px 22px; max-width: 98%; border-radius: 12px; }
      .school-header h1 { font-size: 1.55rem; letter-spacing: 1px; }
    }
  </style>
</head>
<body>
  <div class="bg-layer"></div>
  <div class="bg-pattern"></div>
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
  <canvas id="festiveCanvas" style="position:fixed;inset:0;z-index:2;pointer-events:none;"></canvas>

  <div class="page-wrapper">
    <div class="card-islamic">

      <div class="school-header">
        <div class="school-icon">
          @php
            $schoolLogo = \App\Models\Pengaturan::get('logo_kanan');
            if ($schoolLogo && !str_starts_with($schoolLogo, 'http')) {
              $schoolLogo = \Illuminate\Support\Facades\Storage::url($schoolLogo);
            }
          @endphp
          @if($schoolLogo)
            <img src="{{ $schoolLogo }}" alt="Logo">
          @else
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z" fill="#fff"/>
            </svg>
          @endif
        </div>
        <h1>HASIL SELEKSI PMBM</h1>
        <p>MAN 1 KOTA BANDUNG</p>
      </div>

      <div class="section-divider"></div>

      @if($sudahDibuka)
        <div class="form-body">
          <p class="form-intro">Silakan masukkan Nomor Pendaftaran Anda untuk melihat hasil seleksi.</p>

          @if($errors->any())
            <div class="alert-error">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
              <span>{{ $errors->first() }}</span>
            </div>
          @endif

          <form method="POST" action="{{ route('pmbm.cek') }}" id="formPmbm">
            @csrf
            <div class="form-group">
              <label class="form-label">Nomor Pendaftaran</label>
              <input type="text" name="no_pendaftaran" class="form-input" placeholder="Contoh: PMBM-2024-001" required value="{{ old('no_pendaftaran') }}" autocomplete="off">
            </div>
            <button type="submit" class="btn-primary-islamic" id="btnSubmit">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
              </svg>
              Cek Hasil Seleksi
            </button>
            <a href="{{ route('kelulusan.index') }}" class="btn-secondary">&larr; Kembali ke Beranda</a>
          </form>
        </div>
      @else
        <div class="countdown-body">
          <p class="countdown-title">Pengumuman seleksi akan dibuka pada</p>
          <div class="countdown-date-pill">
            {{ \Carbon\Carbon::parse($tanggalPengumuman)->locale('id')->translatedFormat('l, d F Y - H:i') }} WIB
          </div>
          <p style="margin-top: 25px; color: var(--text-muted); font-size: 0.85rem;">Mohon menunggu hingga waktu yang telah ditentukan.</p>
          <a href="{{ route('kelulusan.index') }}" class="btn-secondary" style="margin-top: 30px;">&larr; Kembali ke Beranda</a>
        </div>
      @endif
    </div>

    <div class="page-footer">
      &copy; {{ date('Y') }} MAN 1 Kota Bandung &mdash; Sistem Informasi PMBM
    </div>
  </div>

  <script>
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
      const form = document.getElementById('formPmbm');
      const btn  = document.getElementById('btnSubmit');

      form.addEventListener('submit', function () {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner"></span> Memproses...';
      });
    })();
    @endif
  </script>
</body>
</html>
