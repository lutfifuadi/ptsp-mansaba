<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Permohonan Berhasil — PTSP MAN 1 Kota Bandung</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ \App\Models\Pengaturan::get('logo_kanan') ?: asset('assets/img/favicon/favicon-32x32.png') }}" />
  <link rel="icon" type="image/png" sizes="16x16" href="{{ \App\Models\Pengaturan::get('logo_kanan') ?: asset('assets/img/favicon/favicon-16x16.png') }}" />
  <link rel="icon" type="image/x-icon" href="{{ \App\Models\Pengaturan::get('logo_kanan') ?: asset('favicon.ico') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    :root {
      --primary: #059669;
      --primary-glow: rgba(5, 150, 105, 0.5);
      --primary-light: #34d399;
      --gold: #d4af37;
      --gold-glow: rgba(212, 175, 55, 0.4);
      --bg-dark: #0f172a;
      --bg-darker: #020617;
      --glass-bg: rgba(15, 23, 42, 0.6);
      --glass-border: rgba(52, 211, 153, 0.2);
      --text-main: #f8fafc;
      --text-muted: #94a3b8;
      --error: #ef4444;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    html, body { height: 100%; overflow-x: hidden; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg-darker);
      color: var(--text-main);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
    }

    .grid-bg {
      position: fixed; inset: 0;
      background-size: 50px 50px;
      background-image:
        linear-gradient(to right, rgba(255, 255, 255, 0.02) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
      z-index: -2;
      transform: perspective(500px) rotateX(60deg) translateY(-100px) translateZ(-200px);
      animation: gridMove 20s linear infinite;
    }

    @keyframes gridMove {
      0% { background-position: 0 0; }
      100% { background-position: 0 50px; }
    }

    .glow-orb {
      position: fixed; border-radius: 50%; filter: blur(100px);
      z-index: -1; opacity: 0.4;
      animation: float 10s ease-in-out infinite alternate;
    }

    .glow-emerald {
      width: 400px; height: 400px;
      background: radial-gradient(circle, var(--primary) 0%, transparent 70%);
      top: -100px; left: -100px;
    }

    .glow-gold {
      width: 500px; height: 500px;
      background: radial-gradient(circle, var(--gold) 0%, transparent 70%);
      bottom: -150px; right: -100px;
      animation-delay: -5s;
    }

    @keyframes float {
      0% { transform: translate(0, 0) scale(1); }
      100% { transform: translate(30px, 50px) scale(1.1); }
    }

    .islamic-pattern {
      position: fixed; inset: 0; opacity: 0.03; z-index: -1;
      background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M30 30L15 15H0v15l15 15-15 15v15h15L30 45l15 15h15V45L45 30l15-15V0H45L30 15zM15 45L0 60v-15l15-15v15zM45 45l15 15V45L45 30v15zM15 15L0 0v15l15 15V15zM45 15l15-15v15L45 30V15z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .form-container {
      width: 100%; max-width: 900px;
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-radius: 4px;
      padding: 40px 36px;
      position: relative;
      overflow-y: auto;
      overflow-x: hidden;
      animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
      max-height: 95vh;
      scrollbar-width: thin;
      scrollbar-color: var(--primary-light) transparent;
    }

    .form-container::-webkit-scrollbar { width: 4px; }
    .form-container::-webkit-scrollbar-thumb { background: var(--primary-light); border-radius: 10px; }

    .form-container::before {
      content: '';
      position: absolute; top: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--primary-light), var(--gold), transparent);
      opacity: 0.7;
    }

    .form-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .form-header h1 {
      font-size: 1.8rem; font-weight: 700;
      margin-bottom: 8px; color: var(--text-main);
    }

    .form-header p {
      font-size: 0.9rem; color: var(--text-muted);
      margin-bottom: 28px; line-height: 1.5;
    }

    /* Steps */
    .steps {
      display: flex; align-items: center; justify-content: center;
      gap: 0; margin-bottom: 32px;
    }
    .step { display: flex; flex-direction: column; align-items: center; gap: 6px; }
    .step-circle {
      width: 36px; height: 36px; border-radius: 4px;
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; font-size: 0.85rem;
      border: 2px solid var(--glass-border);
      color: var(--text-muted); background: transparent;
      transition: var(--transition);
    }
    .step.done .step-circle {
      background: var(--primary); border-color: var(--primary);
      color: #fff;
    }
    .step-label { font-size: 0.7rem; color: var(--text-muted); white-space: nowrap; font-weight: 500; }
    .step.done .step-label { color: var(--primary-light); }
    .step-line { flex: 1; height: 2px; min-width: 40px; background: var(--primary); margin-bottom: 22px; }

    /* Success icon */
    .success-icon {
      width: 90px; height: 90px; border-radius: 4px;
      background: linear-gradient(135deg, var(--primary), #047857);
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 28px;
      box-shadow: 0 0 40px var(--primary-glow), 0 0 80px rgba(5, 150, 105, 0.1);
      animation: scaleIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    .success-icon i { font-size: 44px; color: #fff; }

    @keyframes scaleIn {
      from { transform: scale(0); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }

    .success-title {
      font-size: 1.75rem; font-weight: 800;
      background: linear-gradient(135deg, #fff 40%, var(--primary) 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      margin-bottom: 10px; text-align: center;
    }

    .success-subtitle {
      color: var(--text-muted); font-size: 0.9rem;
      line-height: 1.6; margin-bottom: 32px; text-align: center;
    }

    /* Ticket box */
    .ticket-box {
      background: rgba(52, 211, 153, 0.06);
      border: 1px dashed rgba(52, 211, 153, 0.3);
      border-radius: 4px; padding: 24px;
      margin-bottom: 28px; text-align: center;
    }

    .ticket-label {
      font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
      letter-spacing: 2px; color: var(--text-muted); margin-bottom: 10px;
    }

    .ticket-number {
      font-size: 2rem; font-weight: 800;
      color: var(--primary-light);
      letter-spacing: 3px;
      font-variant-numeric: tabular-nums;
      text-shadow: 0 0 24px var(--primary-glow);
    }

    .ticket-note {
      font-size: 0.78rem; color: var(--text-muted); margin-top: 10px;
    }

    /* Info steps */
    .info-steps {
      display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;
      margin-bottom: 28px;
    }

    .info-step {
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.07);
      border-radius: 4px; padding: 14px 10px;
      text-align: center;
    }

    .info-step-num {
      width: 28px; height: 28px; border-radius: 4px;
      background: rgba(52, 211, 153, 0.12);
      border: 1px solid rgba(52, 211, 153, 0.2);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.75rem; font-weight: 700; color: var(--primary-light);
      margin: 0 auto 8px;
    }

    .info-step-text {
      font-size: 0.72rem; color: var(--text-muted); line-height: 1.5;
    }

    /* Button group */
    .btn-group { display: flex; flex-direction: column; gap: 10px; }

    .btn-track {
      width: 100%; padding: 14px;
      background: linear-gradient(135deg, var(--primary), #047857);
      border: 1px solid var(--primary-light);
      color: #fff; font-weight: 700; font-size: 0.95rem;
      border-radius: 4px; cursor: pointer; text-decoration: none;
      display: flex; align-items: center; justify-content: center; gap: 8px;
      transition: var(--transition);
      box-shadow: 0 0 20px rgba(5, 150, 105, 0.2);
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .btn-track:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 30px rgba(5, 150, 105, 0.5);
      background: linear-gradient(135deg, #10b981, var(--primary));
    }

    .btn-home {
      width: 100%; padding: 13px;
      background: rgba(255, 255, 255, 0.04);
      color: var(--text-muted); font-weight: 600; font-size: 0.88rem;
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 4px; text-decoration: none;
      display: flex; align-items: center; justify-content: center; gap: 8px;
      transition: var(--transition);
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .btn-home:hover {
      border-color: rgba(255, 255, 255, 0.2);
      color: var(--text-main);
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
      .form-container { padding: 30px 20px; }
      .form-header h1 { font-size: 1.6rem; }
      body { overflow: auto; height: auto; }
      html { overflow: auto; }
      .step-line { min-width: 24px; }
      .step-label { font-size: 0.62rem; }
      .ticket-number { font-size: 1.5rem; }
      .info-steps { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>
  <div class="grid-bg"></div>
  <div class="islamic-pattern"></div>
  <div class="glow-orb glow-emerald"></div>
  <div class="glow-orb glow-gold"></div>

  <div class="form-container">
    <!-- Progress Steps -->
    <div class="steps">
      <div class="step done">
        <div class="step-circle"><i class="ti ti-check"></i></div>
        <div class="step-label">Input NISN</div>
      </div>
      <div class="step-line"></div>
      <div class="step done">
        <div class="step-circle"><i class="ti ti-check"></i></div>
        <div class="step-label">Konfirmasi</div>
      </div>
      <div class="step-line"></div>
      <div class="step done">
        <div class="step-circle"><i class="ti ti-check"></i></div>
        <div class="step-label">Form Surat</div>
      </div>
      <div class="step-line"></div>
      <div class="step done">
        <div class="step-circle"><i class="ti ti-check"></i></div>
        <div class="step-label">Selesai</div>
      </div>
    </div>

    <!-- Success Icon -->
    <div class="success-icon">
      <i class="ti ti-circle-check"></i>
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
        <i class="ti ti-search"></i> Lacak Status Permohonan
      </a>
      <a href="{{ route('ptsp.index') }}" class="btn-home">
        <i class="ti ti-home"></i> Kembali ke Portal
      </a>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.getElementById('no-tiket').style.cursor = 'pointer';
    document.getElementById('no-tiket').title = 'Klik untuk menyalin';
    document.getElementById('no-tiket').addEventListener('click', function() {
      navigator.clipboard.writeText(this.textContent.trim()).then(function() {
        var orig = this.textContent;
        this.textContent = 'Tersalin!';
        this.style.color = '#fff';
        setTimeout(function() {
          this.textContent = orig;
          this.style.color = '';
        }.bind(this), 1500);
      }.bind(this));
    });
  </script>
</body>
</html>
