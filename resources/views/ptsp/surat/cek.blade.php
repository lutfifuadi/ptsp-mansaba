<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pengajuan Surat — PTSP MAN 1 Kota Bandung</title>
  <meta name="description" content="Ajukan surat keterangan siswa secara online menggunakan NISN. Layanan PTSP MAN 1 Kota Bandung.">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::get('logo_kanan') ?: asset('assets/img/favicon/favicon.ico') }}" />
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
    .step.active .step-circle {
      background: var(--primary); border-color: var(--primary);
      color: #fff; box-shadow: 0 0 16px var(--primary-glow);
    }
    .step.done .step-circle {
      background: var(--primary); border-color: var(--primary);
      color: #fff;
    }
    .step-label { font-size: 0.7rem; color: var(--text-muted); white-space: nowrap; font-weight: 500; }
    .step.active .step-label { color: var(--primary-light); }
    .step.done .step-label { color: var(--primary-light); }
    .step-line { flex: 1; height: 2px; min-width: 40px; background: var(--glass-border); margin-bottom: 22px; }
    .step-line.done { background: var(--primary); }

    .form-group { margin-bottom: 20px; }

    .form-label {
      display: block; font-size: 0.85rem; font-weight: 600;
      color: var(--text-muted); margin-bottom: 8px;
      text-transform: uppercase; letter-spacing: 1px;
    }

    .input-wrapper { position: relative; }

    .input-icon {
      position: absolute; left: 14px; top: 50%;
      transform: translateY(-50%);
      color: var(--primary-light); font-size: 20px;
      pointer-events: none; z-index: 2;
    }

    .form-control {
      width: 100%;
      background: rgba(15, 23, 42, 0.8);
      border: 1px solid var(--glass-border);
      border-radius: 4px;
      padding: 14px 16px 14px 46px;
      color: var(--text-main); font-size: 1rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      transition: var(--transition); outline: none;
    }

    .form-control::placeholder { color: rgba(148, 163, 184, 0.5); }

    .form-control:focus {
      border-color: var(--primary-light);
      box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.15);
      background: rgba(15, 23, 42, 0.95);
    }

    .form-control.no-icon { padding-left: 16px; }
    .form-control.is-invalid { border-color: var(--error) !important; }

    .error-msg {
      display: flex; align-items: center; gap: 6px;
      margin-top: 8px; font-size: 0.8rem; color: var(--error);
    }

    .nisn-hint {
      font-size: 0.8rem; color: var(--text-muted);
      margin-top: 8px; display: flex; align-items: center; gap: 6px;
    }

    .btn-submit {
      width: 100%;
      background: linear-gradient(135deg, var(--primary), #047857);
      border: 1px solid var(--primary-light);
      color: #fff;
      padding: 14px 28px;
      border-radius: 4px;
      font-weight: 700; font-size: 1rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      gap: 10px;
      transition: var(--transition);
      box-shadow: 0 0 20px rgba(5, 150, 105, 0.2);
      letter-spacing: 0.5px;
      margin-top: 20px;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 30px rgba(5, 150, 105, 0.5);
      background: linear-gradient(135deg, #10b981, var(--primary));
    }

    .btn-submit:active { transform: translateY(0); }
    .btn-submit:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

    .divider {
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--glass-border), transparent);
      margin: 24px 0;
    }

    .back-link {
      display: inline-flex; align-items: center; gap: 8px;
      color: var(--gold); text-decoration: none;
      font-size: 0.9rem; font-weight: 500;
      margin-bottom: 24px;
      transition: var(--transition);
    }

    .back-link:hover {
      color: var(--primary-light);
    }

    .info-note {
      display: flex; gap: 12px; align-items: flex-start;
      background: rgba(212, 175, 55, 0.05);
      border: 1px solid rgba(212, 175, 55, 0.15);
      border-radius: 4px; padding: 14px 16px;
      margin-top: 24px;
    }

    .info-note i { font-size: 20px; color: var(--gold); flex-shrink: 0; margin-top: 1px; }
    .info-note p { font-size: 0.82rem; color: var(--text-muted); line-height: 1.6; }
    .info-note strong { color: var(--text-main); }

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
    }
  </style>
</head>
<body>
  <div class="grid-bg"></div>
  <div class="islamic-pattern"></div>
  <div class="glow-orb glow-emerald"></div>
  <div class="glow-orb glow-gold"></div>

  <div class="form-container">
    <a href="{{ route('ptsp.index') }}" class="back-link">
      <i class="ti ti-arrow-left"></i> Kembali ke Portal
    </a>

    <div class="form-header">
      <h1>Pengajuan Surat</h1>
      <p>Layanan Pembuatan Surat & Legalisir — PTSP MAN 1 Kota Bandung</p>
    </div>

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

    <form id="form-nisn" method="POST" action="{{ route('ptsp.surat.cek') }}">
      @csrf
      <div class="form-group">
        <label for="nisn" class="form-label">Nomor Induk Siswa Nasional (NISN)</label>
        <div class="input-wrapper">
          <i class="ti ti-id input-icon"></i>
          <input
            type="text"
            id="nisn"
            name="nisn"
            class="form-control {{ $errors->has('nisn') ? 'is-invalid' : '' }}"
            placeholder="Contoh: 1234567890"
            value="{{ old('nisn') }}"
            inputmode="numeric"
            maxlength="10"
            autocomplete="off"
            autofocus
          >
        </div>
        @if ($errors->has('nisn'))
          <div class="error-msg">
            <i class="ti ti-alert-circle"></i>
            {{ $errors->first('nisn') }}
          </div>
        @else
          <div class="nisn-hint">
            <i class="ti ti-info-circle"></i>
            NISN terdiri dari 10 digit angka
          </div>
        @endif
      </div>

      <button type="submit" class="btn-submit" id="btn-cek">
        <i class="ti ti-arrow-right"></i> Verifikasi NISN
      </button>
    </form>

    <div class="divider"></div>

    <div class="info-note">
      <i class="ti ti-alert-triangle"></i>
      <p>Layanan ini hanya untuk <strong>siswa aktif MAN 1 Kota Bandung</strong>. Data Anda hanya digunakan untuk keperluan pembuatan surat dan tidak dibagikan kepada pihak lain.</p>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.getElementById('nisn').addEventListener('input', function() {
      this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });

    document.getElementById('form-nisn').addEventListener('submit', function() {
      const btn = document.getElementById('btn-cek');
      btn.disabled = true;
      btn.innerHTML = '<i class="ti ti-loader ti-spin"></i> Memverifikasi...';
    });
  </script>
  @include('components.closed-service-modal')
</body>
</html>
