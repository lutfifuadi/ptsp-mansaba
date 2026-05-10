<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pengajuan Surat — PTSP MAN 1 Kota Bandung</title>
  <meta name="description" content="Ajukan surat keterangan siswa secara online menggunakan NISN. Layanan PTSP MAN 1 Kota Bandung.">
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
      --input-bg: rgba(255, 255, 255, 0.05);
      --input-border: rgba(255, 255, 255, 0.12);
      --input-focus: rgba(46, 204, 113, 0.4);
      --error: #e74c3c;
    }

    html, body { height: 100%; overflow-x: hidden; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg-dark);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      position: relative;
    }

    .bg-layer {
      position: fixed; inset: 0;
      background:
        radial-gradient(ellipse at 20% 30%, #0f3d20 0%, transparent 55%),
        radial-gradient(ellipse at 80% 70%, #0b2e18 0%, transparent 55%),
        linear-gradient(160deg, #061410 0%, #0d2b18 50%, #061410 100%);
      animation: bgPulse 8s ease-in-out infinite alternate;
      z-index: 0;
    }
    @keyframes bgPulse {
      0% { filter: brightness(1); }
      100% { filter: brightness(1.1); }
    }

    .bg-pattern {
      position: fixed; inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cg fill='none' stroke='rgba(46,204,113,0.08)' stroke-width='0.6'%3E%3Cpolygon points='40,4 44.6,18 59,12 50,26 65,32 50,36 59,50 44.6,44 40,58 35.4,44 21,50 30,36 15,32 30,26 21,12 35.4,18'/%3E%3Crect x='28' y='28' width='24' height='24' transform='rotate(45 40 40)'/%3E%3Ccircle cx='40' cy='40' r='10'/%3E%3C/g%3E%3C/svg%3E");
      background-size: 80px 80px;
      z-index: 1; pointer-events: none;
    }

    .orb { position: fixed; border-radius: 4px; filter: blur(60px); z-index: 1; pointer-events: none; }
    .orb-1 {
      width: 340px; height: 340px;
      background: radial-gradient(circle, rgba(30,132,73,0.18) 0%, transparent 70%);
      top: -80px; left: -80px;
      animation: orbFloat 12s ease-in-out infinite;
    }
    .orb-2 {
      width: 280px; height: 280px;
      background: radial-gradient(circle, rgba(201,168,76,0.10) 0%, transparent 70%);
      bottom: -60px; right: -60px;
      animation: orbFloat 14s ease-in-out infinite reverse;
    }
    @keyframes orbFloat {
      0%, 100% { transform: translate(0, 0); }
      50% { transform: translate(40px, 30px); }
    }

    .page-wrapper {
      position: relative; z-index: 10;
      width: 100%; max-width: 520px;
      padding: 32px 20px;
    }

    @media (min-width: 768px) {
      .page-wrapper { max-width: 950px; }
      .card { padding: 64px 60px; }
      .page-header h1 { font-size: 2.8rem; }
      .form-input { padding: 20px 28px; font-size: 1.3rem; }
      .btn-submit { padding: 22px; font-size: 1.2rem; }
    }

    @media (min-width: 1024px) {
      .page-wrapper { max-width: 1150px; }
    }

    .back-link {
      display: inline-flex; align-items: center; gap: 8px;
      color: var(--text-muted); text-decoration: none;
      font-size: 0.85rem; font-weight: 500;
      margin-bottom: 28px;
      transition: color 0.2s;
    }
    .back-link:hover { color: var(--primary); }

    .page-header {
      text-align: center;
      margin-bottom: 36px;
      animation: fadeInDown 0.7s ease both;
    }
    .school-logo {
      width: 70px; height: 70px; object-fit: contain;
      margin-bottom: 16px;
      filter: drop-shadow(0 0 16px var(--primary-glow));
    }
    .page-header h1 {
      font-size: 1.8rem; font-weight: 800;
      background: linear-gradient(135deg, #fff 40%, var(--primary) 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      margin-bottom: 8px;
    }
    .page-header p {
      color: var(--text-muted); font-size: 0.9rem; line-height: 1.6;
    }

    /* Progress Steps */
    .steps {
      display: flex; align-items: center; justify-content: center;
      gap: 0; margin-bottom: 32px;
      animation: fadeIn 0.7s 0.1s ease both;
    }
    .step {
      display: flex; flex-direction: column; align-items: center; gap: 6px;
      position: relative;
    }
    .step-circle {
      width: 36px; height: 36px; border-radius: 4px;
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; font-size: 0.85rem;
      border: 2px solid var(--card-border);
      color: var(--text-muted);
      background: var(--card-bg);
      transition: all 0.3s;
    }
    .step.active .step-circle {
      background: var(--primary); border-color: var(--primary);
      color: #000; box-shadow: 0 0 16px var(--primary-glow);
    }
    .step.done .step-circle {
      background: var(--primary-dark); border-color: var(--primary-dark);
      color: #fff;
    }
    .step-label {
      font-size: 0.7rem; color: var(--text-muted);
      white-space: nowrap; font-weight: 500;
    }
    .step.active .step-label { color: var(--primary); }
    .step-line {
      flex: 1; height: 2px; min-width: 40px;
      background: var(--card-border);
      margin-bottom: 22px;
    }

    /* Card */
    .card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 4px;
      padding: 36px 32px;
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      box-shadow: 0 24px 80px rgba(0,0,0,0.5);
      animation: fadeInUp 0.7s 0.2s ease both;
    }

    .card-icon {
      width: 56px; height: 56px;
      background: linear-gradient(135deg, rgba(46,204,113,0.15), rgba(46,204,113,0.05));
      border: 1px solid var(--card-border);
      border-radius: 4px;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 24px;
    }
    .card-icon svg { width: 28px; height: 28px; color: var(--primary); }

    .card h2 { font-size: 1.25rem; font-weight: 700; margin-bottom: 6px; }
    .card > p { color: var(--text-muted); font-size: 0.875rem; margin-bottom: 28px; line-height: 1.6; }

    /* Form */
    .form-group { margin-bottom: 20px; }
    .form-label {
      display: block; font-size: 0.8rem; font-weight: 600;
      color: var(--text-muted); text-transform: uppercase;
      letter-spacing: 1px; margin-bottom: 8px;
    }
    .form-input {
      width: 100%; padding: 14px 18px;
      background: var(--input-bg);
      border: 1px solid var(--input-border);
      border-radius: 4px;
      color: var(--text-main); font-size: 1rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      transition: all 0.2s;
      letter-spacing: 2px;
    }
    .form-input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px var(--input-focus);
      background: rgba(46, 204, 113, 0.05);
    }
    .form-input::placeholder { color: rgba(255,255,255,0.2); letter-spacing: 0; }
    .form-input.is-invalid { border-color: var(--error); }

    .error-msg {
      display: flex; align-items: center; gap: 6px;
      margin-top: 8px; font-size: 0.8rem; color: var(--error);
    }

    .nisn-hint {
      font-size: 0.78rem; color: var(--text-muted);
      margin-top: 8px; display: flex; align-items: center; gap: 6px;
    }

    .btn-submit {
      width: 100%; padding: 15px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: #000; font-weight: 800; font-size: 0.95rem;
      border: none; border-radius: 4px; cursor: pointer;
      transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
      margin-top: 8px;
      box-shadow: 0 8px 24px var(--primary-glow);
    }
    .btn-submit:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 32px var(--primary-glow);
    }
    .btn-submit:active { transform: translateY(0); }

    .divider {
      height: 1px; background: var(--card-border);
      margin: 24px 0;
    }

    .info-note {
      display: flex; gap: 12px; align-items: flex-start;
      background: rgba(201, 168, 76, 0.06);
      border: 1px solid rgba(201, 168, 76, 0.2);
      border-radius: 4px; padding: 14px 16px;
    }
    .info-note svg { width: 18px; height: 18px; color: var(--gold); flex-shrink: 0; margin-top: 1px; }
    .info-note p { font-size: 0.82rem; color: rgba(255,255,255,0.6); line-height: 1.6; }

    .footer {
      margin-top: 32px; text-align: center;
      color: rgba(255,255,255,0.18); font-size: 0.75rem;
      animation: fadeIn 1s 0.5s ease both;
    }

    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-24px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    @media (max-width: 576px) {
      .card { padding: 28px 20px; }
      .page-header h1 { font-size: 1.5rem; }
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
    <a href="{{ route('ptsp.index') }}" class="back-link">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
      Kembali ke Portal
    </a>

    <header class="page-header">
      <h1>Pengajuan Surat</h1>
      <p>Layanan Pembuatan Surat & Legalisir — PTSP MAN 1 Kota Bandung</p>
    </header>

    <!-- Progress Steps -->
    <div class="steps">
      <div class="step active">
        <div class="step-circle">1</div>
        <div class="step-label">Input NISN</div>
      </div>
      <div class="step-line"></div>
      <div class="step">
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
      <form id="form-nisn" method="POST" action="{{ route('ptsp.surat.cek') }}">
        @csrf
        <div class="form-group">
          <label for="nisn" class="form-label">Nomor Induk Siswa Nasional (NISN)</label>
          <input
            type="text"
            id="nisn"
            name="nisn"
            class="form-input {{ $errors->has('nisn') ? 'is-invalid' : '' }}"
            placeholder="Contoh: 1234567890"
            value="{{ old('nisn') }}"
            inputmode="numeric"
            maxlength="10"
            autocomplete="off"
            autofocus
          >
          @if ($errors->has('nisn'))
            <div class="error-msg">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
              </svg>
              {{ $errors->first('nisn') }}
            </div>
          @else
            <div class="nisn-hint">
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
              </svg>
              NISN terdiri dari 10 digit angka
            </div>
          @endif
        </div>

        <button type="submit" class="btn-submit" id="btn-cek">
          Verifikasi NISN
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="display:inline;margin-left:6px;vertical-align:-2px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
          </svg>
        </button>
      </form>

      <div class="divider"></div>

      <div class="info-note">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
        </svg>
        <p>Layanan ini hanya untuk <strong style="color:#fff">siswa aktif MAN 1 Kota Bandung</strong>. Data Anda hanya digunakan untuk keperluan pembuatan surat dan tidak dibagikan kepada pihak lain.</p>
      </div>
    </div>

  </div>

  <script>
    // Hanya izinkan angka
    document.getElementById('nisn').addEventListener('input', function() {
      this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });

    // Loading state saat submit
    document.getElementById('form-nisn').addEventListener('submit', function() {
      const btn = document.getElementById('btn-cek');
      btn.disabled = true;
      btn.textContent = 'Memverifikasi...';
    });
  </script>
</body>
</html>
