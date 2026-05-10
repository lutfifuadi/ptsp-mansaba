<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Permohonan Berhasil — PTSP MAN 1 Kota Bandung</title>
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
      z-index: 0;
    }

    .bg-pattern {
      position: fixed; inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cg fill='none' stroke='rgba(46,204,113,0.08)' stroke-width='0.6'%3E%3Cpolygon points='40,4 44.6,18 59,12 50,26 65,32 50,36 59,50 44.6,44 40,58 35.4,44 21,50 30,36 15,32 30,26 21,12 35.4,18'/%3E%3C/g%3E%3C/svg%3E");
      background-size: 80px 80px; z-index: 1; pointer-events: none;
    }
    .orb { position: fixed; border-radius: 4px; filter: blur(60px); z-index: 1; pointer-events: none; }
    .orb-1 { width: 340px; height: 340px; background: radial-gradient(circle, rgba(30,132,73,0.25) 0%, transparent 70%); top: -80px; left: -80px; }
    .orb-2 { width: 280px; height: 280px; background: radial-gradient(circle, rgba(201,168,76,0.12) 0%, transparent 70%); bottom: -60px; right: -60px; }

    .page-wrapper {
      position: relative; z-index: 10;
      width: 100%; max-width: 500px;
      padding: 32px 20px;
      text-align: center;
    }

    @media (min-width: 768px) {
      .page-wrapper { max-width: 950px; }
      .card { padding: 64px 60px; }
      .success-title { font-size: 3rem; }
      .ticket-box { padding: 48px; }
      .ticket-number { font-size: 3.5rem; }
      .info-step { padding: 28px 20px; }
      .btn-track, .btn-home { padding: 20px; font-size: 1.2rem; }
    }

    @media (min-width: 1024px) {
      .page-wrapper { max-width: 1100px; }
    }

    /* Success animation */
    .success-icon {
      width: 90px; height: 90px; border-radius: 4px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 28px;
      box-shadow: 0 0 40px var(--primary-glow), 0 0 80px rgba(46,204,113,0.1);
      animation: scaleIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    .success-icon svg { width: 44px; height: 44px; color: #000; }

    @keyframes scaleIn {
      from { transform: scale(0); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }

    .steps { display: flex; align-items: center; justify-content: center; gap: 0; margin-bottom: 32px; animation: fadeIn 0.7s 0.1s ease both; }
    .step { display: flex; flex-direction: column; align-items: center; gap: 6px; }
    .step-circle { width: 32px; height: 32px; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; border: 2px solid var(--card-border); color: var(--text-muted); background: var(--card-bg); }
    .step.done .step-circle { background: var(--primary-dark); border-color: var(--primary-dark); color: #fff; }
    .step-label { font-size: 0.65rem; color: var(--text-muted); white-space: nowrap; font-weight: 500; }
    .step.done .step-label { color: var(--primary-dark); }
    .step-line { flex: 1; height: 2px; min-width: 36px; background: var(--primary-dark); margin-bottom: 20px; }

    .card {
      background: var(--card-bg); border: 1px solid var(--card-border);
      border-radius: 4px; padding: 40px 32px;
      backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
      box-shadow: 0 24px 80px rgba(0,0,0,0.5);
      animation: fadeInUp 0.6s 0.2s ease both;
    }

    .success-title {
      font-size: 1.75rem; font-weight: 800;
      background: linear-gradient(135deg, #fff 40%, var(--primary) 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      margin-bottom: 10px;
    }
    .success-subtitle {
      color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 32px;
    }

    .ticket-box {
      background: rgba(46,204,113,0.06);
      border: 1px dashed rgba(46,204,113,0.3);
      border-radius: 4px; padding: 24px;
      margin-bottom: 28px;
    }
    .ticket-label {
      font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
      letter-spacing: 2px; color: var(--text-muted); margin-bottom: 10px;
    }
    .ticket-number {
      font-size: 2rem; font-weight: 800;
      color: var(--primary);
      letter-spacing: 3px;
      font-variant-numeric: tabular-nums;
      text-shadow: 0 0 24px var(--primary-glow);
    }
    .ticket-note {
      font-size: 0.78rem; color: var(--text-muted); margin-top: 10px;
    }

    .info-steps {
      display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;
      margin-bottom: 28px;
    }
    .info-step {
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.07);
      border-radius: 4px; padding: 14px 10px;
      text-align: center;
    }
    .info-step-num {
      width: 28px; height: 28px; border-radius: 4px;
      background: rgba(46,204,113,0.12); border: 1px solid rgba(46,204,113,0.2);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.75rem; font-weight: 700; color: var(--primary);
      margin: 0 auto 8px;
    }
    .info-step-text { font-size: 0.72rem; color: var(--text-muted); line-height: 1.5; }

    .btn-group { display: flex; flex-direction: column; gap: 10px; }

    .btn-track {
      width: 100%; padding: 14px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: #000; font-weight: 800; font-size: 0.9rem;
      border: none; border-radius: 4px; cursor: pointer;
      text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;
      transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
      box-shadow: 0 8px 24px var(--primary-glow);
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .btn-track:hover { transform: translateY(-3px); box-shadow: 0 12px 32px var(--primary-glow); }

    .btn-home {
      width: 100%; padding: 13px;
      background: rgba(255,255,255,0.04);
      color: var(--text-muted); font-weight: 600; font-size: 0.88rem;
      border: 1px solid rgba(255,255,255,0.1); border-radius: 4px;
      text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;
      transition: all 0.3s;
    }
    .btn-home:hover { border-color: rgba(255,255,255,0.2); color: #fff; }

    .footer { margin-top: 32px; color: rgba(255,255,255,0.18); font-size: 0.75rem; }

    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-24px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    @media (max-width: 576px) {
      .card { padding: 28px 20px; }
      .ticket-number { font-size: 1.5rem; }
      .info-steps { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>
  <div class="bg-layer"></div>
  <div class="bg-pattern"></div>
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>

  <div class="page-wrapper">
    <!-- Progress Steps -->
    <div class="steps" style="margin-bottom:32px; animation: fadeIn 0.7s ease both;">
      <div class="step done">
        <div class="step-circle">✓</div>
        <div class="step-label">Input NISN</div>
      </div>
      <div class="step-line"></div>
      <div class="step done">
        <div class="step-circle">✓</div>
        <div class="step-label">Konfirmasi</div>
      </div>
      <div class="step-line"></div>
      <div class="step done">
        <div class="step-circle">✓</div>
        <div class="step-label">Form Surat</div>
      </div>
      <div class="step-line"></div>
      <div class="step done">
        <div class="step-circle">✓</div>
        <div class="step-label">Selesai</div>
      </div>
    </div>

    <div class="card">
      <!-- Success Icon -->
      <div class="success-icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
        </svg>
      </div>

      <div class="success-title">Permohonan Terkirim!</div>
      <div class="success-subtitle">
        Permohonan surat Anda telah berhasil dikirimkan dan sedang menunggu diproses oleh petugas PTSP.
      </div>

      <!-- Ticket Number -->
      <div class="ticket-box">
        <div class="ticket-label">Nomor Tiket Anda</div>
        <div class="ticket-number" id="no-tiket">{{ $noTiket }}</div>
        <div class="ticket-note">Simpan nomor ini untuk melacak status permohonan Anda</div>
      </div>

      <!-- Next Steps Info -->
      <div class="info-steps">
        <div class="info-step">
          <div class="info-step-num">1</div>
          <div class="info-step-text">Permohonan diterima petugas PTSP</div>
        </div>
        <div class="info-step">
          <div class="info-step-num">2</div>
          <div class="info-step-text">Surat diproses 1–3 hari kerja</div>
        </div>
        <div class="info-step">
          <div class="info-step-num">3</div>
          <div class="info-step-text">Ambil surat di ruang PTSP</div>
        </div>
      </div>

      <div class="btn-group">
        <a href="{{ route('ptsp.tracking') }}?no_tiket={{ $noTiket }}" class="btn-track">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0015.803 15.803z"/></svg>
          Lacak Status Permohonan
        </a>
        <a href="{{ route('ptsp.index') }}" class="btn-home">
          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
          Kembali ke Portal
        </a>
      </div>
    </div>

  </div>

  <script>
    // Auto-copy nomor tiket saat diklik
    document.getElementById('no-tiket').style.cursor = 'pointer';
    document.getElementById('no-tiket').title = 'Klik untuk menyalin';
    document.getElementById('no-tiket').addEventListener('click', function() {
      navigator.clipboard.writeText(this.textContent.trim()).then(() => {
        const orig = this.textContent;
        this.textContent = 'Tersalin!';
        this.style.color = '#fff';
        setTimeout(() => {
          this.textContent = orig;
          this.style.color = '';
        }, 1500);
      });
    });
  </script>
</body>
</html>
