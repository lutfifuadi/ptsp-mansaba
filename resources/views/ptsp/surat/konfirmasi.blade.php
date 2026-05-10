<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Konfirmasi Identitas — PTSP MAN 1 Kota Bandung</title>
  <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::get('logo_kanan') ?: asset('assets/img/favicon/favicon.ico') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --primary: #2ecc71;
      --primary-dark: #27ae60;
      --primary-glow: rgba(46, 204, 113, 0.35);
      --bg-dark: #061410;
      --card-bg: rgba(13, 43, 24, 0.50);
      --card-border: rgba(46, 204, 113, 0.18);
      --text-main: #ffffff;
      --text-muted: rgba(255, 255, 255, 0.55);
      --gold: #c9a84c;
    }

    html, body { height: 100%; overflow-x: hidden; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg-dark);
      display: flex; align-items: center; justify-content: center;
      min-height: 100vh; position: relative;
    }

    .bg-layer {
      position: fixed; inset: 0;
      background:
        radial-gradient(ellipse at 20% 30%, #0f3d20 0%, transparent 55%),
        radial-gradient(ellipse at 80% 70%, #0b2e18 0%, transparent 55%),
        linear-gradient(160deg, #061410 0%, #0d2b18 50%, #061410 100%);
      animation: bgPulse 8s ease-in-out infinite alternate; z-index: 0;
    }
    @keyframes bgPulse { 0% { filter: brightness(1); } 100% { filter: brightness(1.1); } }

    .bg-pattern {
      position: fixed; inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cg fill='none' stroke='rgba(46,204,113,0.08)' stroke-width='0.6'%3E%3Cpolygon points='40,4 44.6,18 59,12 50,26 65,32 50,36 59,50 44.6,44 40,58 35.4,44 21,50 30,36 15,32 30,26 21,12 35.4,18'/%3E%3Crect x='28' y='28' width='24' height='24' transform='rotate(45 40 40)'/%3E%3Ccircle cx='40' cy='40' r='10'/%3E%3C/g%3E%3C/svg%3E");
      background-size: 80px 80px; z-index: 1; pointer-events: none;
    }
    .orb { position: fixed; border-radius: 4px; filter: blur(60px); z-index: 1; pointer-events: none; }
    .orb-1 { width: 340px; height: 340px; background: radial-gradient(circle, rgba(30,132,73,0.18) 0%, transparent 70%); top: -80px; left: -80px; animation: orbFloat 12s ease-in-out infinite; }
    .orb-2 { width: 280px; height: 280px; background: radial-gradient(circle, rgba(201,168,76,0.10) 0%, transparent 70%); bottom: -60px; right: -60px; animation: orbFloat 14s ease-in-out infinite reverse; }
    @keyframes orbFloat { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(40px, 30px); } }

    .page-wrapper {
      position: relative; z-index: 10;
      width: 100%; max-width: 520px;
      padding: 32px 20px;
    }

    @media (min-width: 768px) {
      .page-wrapper { max-width: 950px; }
      .card { padding: 64px 60px; }
      .page-header h1 { font-size: 2.8rem; }
      .data-grid { grid-template-columns: repeat(3, 1fr); gap: 24px; }
      .data-item { padding: 20px 28px; }
      .identity-badge { padding: 32px 40px; }
      .btn-yes, .btn-no { padding: 20px 32px; font-size: 1.2rem; }
    }

    @media (min-width: 1024px) {
      .page-wrapper { max-width: 1150px; }
    }

    .back-link {
      display: inline-flex; align-items: center; gap: 8px;
      color: var(--text-muted); text-decoration: none;
      font-size: 0.85rem; font-weight: 500;
      margin-bottom: 28px; transition: color 0.2s;
    }
    .back-link:hover { color: var(--primary); }

    .page-header { text-align: center; margin-bottom: 36px; animation: fadeInDown 0.7s ease both; }
    .school-logo { width: 70px; height: 70px; object-fit: contain; margin-bottom: 16px; filter: drop-shadow(0 0 16px var(--primary-glow)); }
    .page-header h1 {
      font-size: 1.8rem; font-weight: 800;
      background: linear-gradient(135deg, #fff 40%, var(--primary) 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      margin-bottom: 8px;
    }
    .page-header p { color: var(--text-muted); font-size: 0.9rem; }

    .steps { display: flex; align-items: center; justify-content: center; gap: 0; margin-bottom: 32px; animation: fadeIn 0.7s 0.1s ease both; }
    .step { display: flex; flex-direction: column; align-items: center; gap: 6px; }
    .step-circle {
      width: 36px; height: 36px; border-radius: 4px;
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; font-size: 0.85rem;
      border: 2px solid var(--card-border); color: var(--text-muted);
      background: var(--card-bg); transition: all 0.3s;
    }
    .step.active .step-circle { background: var(--primary); border-color: var(--primary); color: #000; box-shadow: 0 0 16px var(--primary-glow); }
    .step.done .step-circle { background: var(--primary-dark); border-color: var(--primary-dark); color: #fff; }
    .step-label { font-size: 0.7rem; color: var(--text-muted); white-space: nowrap; font-weight: 500; }
    .step.active .step-label { color: var(--primary); }
    .step.done .step-label { color: var(--primary-dark); }
    .step-line { flex: 1; height: 2px; min-width: 40px; background: var(--card-border); margin-bottom: 22px; }
    .step-line.done { background: var(--primary-dark); }

    .card {
      background: var(--card-bg); border: 1px solid var(--card-border);
      border-radius: 4px; padding: 36px 32px;
      backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
      box-shadow: 0 24px 80px rgba(0,0,0,0.5);
      animation: fadeInUp 0.7s 0.2s ease both;
    }

    .identity-badge {
      display: flex; align-items: center; gap: 16px;
      background: rgba(46, 204, 113, 0.06);
      border: 1px solid rgba(46, 204, 113, 0.15);
      border-radius: 4px; padding: 18px 20px;
      margin-bottom: 28px;
    }
    .identity-avatar {
      width: 50px; height: 50px; border-radius: 4px;
      background: linear-gradient(135deg, var(--primary-dark), rgba(46,204,113,0.4));
      display: flex; align-items: center; justify-content: center;
      font-weight: 800; font-size: 1.3rem; color: #fff;
      flex-shrink: 0;
    }
    .identity-name { font-weight: 700; font-size: 1.05rem; margin-bottom: 4px; }
    .identity-nisn { font-size: 0.8rem; color: var(--primary); font-weight: 600; letter-spacing: 1px; }

    .data-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 28px; }

    .data-item {
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.07);
      border-radius: 4px; padding: 14px 16px;
    }
    .data-label { font-size: 0.72rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px; font-weight: 600; }
    .data-value { font-size: 0.95rem; font-weight: 600; color: var(--text-main); }

    .question-box {
      text-align: center; margin-bottom: 24px;
    }
    .question-box p {
      color: var(--text-muted); font-size: 0.9rem; margin-bottom: 4px;
    }
    .question-box strong { color: var(--text-main); }

    .btn-group { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

    .btn-yes {
      padding: 14px; font-weight: 800; font-size: 0.9rem;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: #000; border: none; border-radius: 4px; cursor: pointer;
      transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
      box-shadow: 0 8px 24px var(--primary-glow);
    }
    .btn-yes:hover { transform: translateY(-3px); box-shadow: 0 12px 32px var(--primary-glow); }

    .btn-no {
      padding: 14px; font-weight: 700; font-size: 0.9rem;
      background: rgba(255,255,255,0.05);
      color: var(--text-muted);
      border: 1px solid rgba(255,255,255,0.12);
      border-radius: 4px; cursor: pointer; text-decoration: none;
      transition: all 0.3s; display: flex; align-items: center; justify-content: center;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .btn-no:hover { background: rgba(231, 76, 60, 0.1); border-color: rgba(231,76,60,0.3); color: #e74c3c; }

    .footer { margin-top: 32px; text-align: center; color: rgba(255,255,255,0.18); font-size: 0.75rem; animation: fadeIn 1s 0.5s ease both; }

    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-24px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    @media (max-width: 576px) {
      .card { padding: 28px 20px; }
      .data-grid { grid-template-columns: 1fr; }
      .step-line { min-width: 24px; }
      .step-label { font-size: 0.62rem; }
    }
  </style>
</head>
<body>
  <div class="bg-layer"></div>
  <div class="bg-pattern"></div>
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>

  <div class="page-wrapper">
    <a href="{{ route('ptsp.surat.cek-form') }}" class="back-link">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
      Masukkan NISN Lain
    </a>

    <header class="page-header">
      <h1>Konfirmasi Identitas</h1>
      <p>Verifikasi data sebelum mengajukan surat</p>
    </header>

    <!-- Progress Steps -->
    <div class="steps">
      <div class="step done">
        <div class="step-circle">✓</div>
        <div class="step-label">Input NISN</div>
      </div>
      <div class="step-line done"></div>
      <div class="step active">
        <div class="step-circle">2</div>
        <div class="step-label">Konfirmasi</div>
      </div>
      <div class="step-line"></div>
      <div class="step">
        <div class="step-circle">3</div>
        <div class="step-label">Form Surat</div>
      </div>
      <div class="step-line"></div>
      <div class="step">
        <div class="step-circle">4</div>
        <div class="step-label">Selesai</div>
      </div>
    </div>

    <div class="card">
      <!-- Identity Badge -->
      <div class="identity-badge">
        <div class="identity-avatar">
          {{ mb_strtoupper(mb_substr($siswa->nama_lengkap, 0, 1)) }}
        </div>
        <div>
          <div class="identity-name">{{ $siswa->nama_lengkap }}</div>
          <div class="identity-nisn">NISN: {{ $siswa->nisn }}</div>
        </div>
      </div>

      <!-- Data Grid -->
      <div class="data-grid">
        <div class="data-item">
          <div class="data-label">Kelas</div>
          <div class="data-value">{{ $siswa->kelas ?? '-' }}</div>
        </div>
        <div class="data-item">
          <div class="data-label">NISN</div>
          <div class="data-value" style="letter-spacing:1.5px">{{ $siswa->nisn }}</div>
        </div>
        <div class="data-item" style="grid-column: 1 / -1">
          <div class="data-label">Tempat & Tanggal Lahir</div>
          <div class="data-value">
            {{ $siswa->tempat_lahir ?? '-' }}
            @if($siswa->tanggal_lahir)
              , {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}
            @endif
          </div>
        </div>
      </div>

      <div class="question-box">
        <p>Apakah data di atas adalah <strong>data Anda?</strong></p>
      </div>

      <div class="btn-group">
        <a href="{{ route('ptsp.surat.form') }}" class="btn-yes" id="btn-lanjut">
          ✓ &nbsp; Ya, Lanjutkan
        </a>
        <a href="{{ route('ptsp.surat.cek-form') }}" class="btn-no">
          ✕ &nbsp; Tidak, Kembali
        </a>
      </div>
    </div>

  </div>
</body>
</html>
