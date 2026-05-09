<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
  <title>Sistem Informasi Kelulusan - MAN 1 Kota Bandung</title>
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
      --white:         #ffffff;
      --text-muted:    rgba(255,255,255,0.55);
      --card-bg:       rgba(13, 43, 24, 0.82);
      --card-border:   rgba(46, 204, 113, 0.18);
      --shadow:        0 24px 80px rgba(0,0,0,0.55);
      --radius:        4px;
    }

    html, body {
      height: 100%;
      overflow-x: hidden;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
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

    .page-wrapper {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 1000px;
      padding: 40px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .landing-header {
      text-align: center;
      margin-bottom: 50px;
      animation: fadeInDown 0.8s ease both;
    }
    .school-logo {
      width: 80px; height: 80px; margin-bottom: 20px;
      filter: drop-shadow(0 0 20px rgba(46,204,113,0.3));
    }
    .landing-header h1 {
      font-family: 'Amiri', serif;
      font-size: 2.5rem;
      color: #fff;
      letter-spacing: 2px;
      text-transform: uppercase;
      background: linear-gradient(135deg, #fff 40%, var(--green-glow) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 10px;
      text-shadow: 0 0 30px rgba(46,204,113,0.35);
    }
    .landing-header p {
      color: var(--green-glow);
      font-weight: 600;
      letter-spacing: 3px;
      text-transform: uppercase;
      font-size: 0.9rem;
    }

    .options-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 30px;
      width: 100%;
      animation: fadeInUp 0.8s 0.2s ease both;
    }

    .option-card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 4px;
      padding: 40px 30px;
      text-align: center;
      text-decoration: none;
      transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 20px;
      position: relative;
      overflow: hidden;
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      box-shadow: var(--shadow);
    }
    .option-card::before {
      content: '';
      position: absolute;
      top: 0; left: -100%;
      width: 100%; height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.05), transparent);
      transition: 0.5s;
    }
    .option-card:hover::before { left: 100%; }
    .option-card:hover {
      transform: translateY(-8px);
      border-color: var(--green-bright);
      box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 0 20px rgba(46,204,113,0.15);
      background: rgba(21, 92, 48, 0.3);
    }

    .option-icon {
      width: 80px; height: 80px;
      background: linear-gradient(135deg, var(--green-mid), var(--green-accent));
      border-radius: 4px;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 10px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
      transition: transform 0.3s;
    }
    .option-card:hover .option-icon { transform: scale(1.1) rotate(5deg); }
    .option-icon svg { width: 40px; height: 40px; color: #fff; }

    .option-title {
      font-family: 'Amiri', serif;
      font-size: 1.6rem;
      color: #fff;
      margin-bottom: 5px;
    }
    .option-desc {
      color: var(--text-muted);
      font-size: 0.85rem;
      line-height: 1.6;
    }

    .btn-enter {
      margin-top: 15px;
      padding: 10px 25px;
      background: var(--green-bright);
      color: #fff;
      border-radius: 4px;
      font-weight: 700;
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      opacity: 0;
      transform: translateY(10px);
      transition: all 0.3s;
      box-shadow: 0 4px 15px rgba(46,204,113,0.3);
    }
    .option-card:hover .btn-enter {
      opacity: 1;
      transform: translateY(0);
    }

    .footer {
      margin-top: 60px;
      text-align: center;
      color: rgba(255,255,255,0.2);
      font-size: 0.75rem;
      animation: fadeIn 1s 0.5s ease both;
    }

    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    @media (max-width: 768px) {
      .options-grid { grid-template-columns: 1fr; gap: 20px; }
      .landing-header h1 { font-size: 2rem; }
      .option-card { padding: 30px 20px; }
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
    <header class="landing-header">
      @php
        $schoolLogo = \App\Models\Pengaturan::get('logo_kanan');
        if ($schoolLogo && !str_starts_with($schoolLogo, 'http')) {
          $schoolLogo = \Illuminate\Support\Facades\Storage::url($schoolLogo);
        }
      @endphp
      <img src="{{ $schoolLogo ?: asset('assets/images/logo.png') }}" alt="Logo" class="school-logo">
      <h1>SISTEM INFORMASI PENGUMUMAN</h1>
      <p>MAN 1 KOTA BANDUNG</p>
    </header>

    <div class="options-grid">
      <!-- Option 1: Kelulusan Siswa XII -->
      <a href="{{ route('kelulusan.form') }}" class="option-card">
        <div class="option-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>
          </svg>
        </div>
        <div class="option-title">Kelulusan Kelas XII</div>
        <div class="option-desc">Cek status kelulusan siswa Kelas XII Tahun Ajaran {{ \App\Models\Pengaturan::get('tahun_ajaran', '2025/2026') }} melalui NISN.</div>
        <div class="btn-enter">Pilih Layanan</div>
      </a>

      <!-- Option 2: Seleksi PMBM -->
      <a href="{{ route('pmbm.index') }}" class="option-card">
        <div class="option-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
          </svg>
        </div>
        <div class="option-title">Hasil Seleksi PMBM</div>
        <div class="option-desc">Cek hasil seleksi Penerimaan Murid Baru Madrasah (PMBM) melalui Nomor Pendaftaran.</div>
        <div class="btn-enter">Pilih Layanan</div>
      </a>
    </div>

    <footer class="footer">
      &copy; {{ date('Y') }} MAN 1 KOTA BANDUNG &mdash; Dikelola secara resmi oleh Tim IT Madrasah
    </footer>
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
  </script>
</body>
</html>
