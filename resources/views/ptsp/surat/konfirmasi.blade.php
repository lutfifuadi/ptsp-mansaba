<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Konfirmasi Identitas — PTSP MAN 1 Kota Bandung</title>
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

    /* Identity badge */
    .identity-badge {
      display: flex; align-items: center; gap: 16px;
      background: rgba(52, 211, 153, 0.06);
      border: 1px solid rgba(52, 211, 153, 0.15);
      border-radius: 4px; padding: 18px 20px;
      margin-bottom: 28px;
    }

    .identity-avatar {
      width: 50px; height: 50px; border-radius: 4px;
      background: linear-gradient(135deg, var(--primary), rgba(52, 211, 153, 0.4));
      display: flex; align-items: center; justify-content: center;
      font-weight: 800; font-size: 1.3rem; color: #fff;
      flex-shrink: 0;
    }

    .identity-name { font-weight: 700; font-size: 1.05rem; margin-bottom: 4px; color: var(--text-main); }
    .identity-nisn { font-size: 0.8rem; color: var(--primary-light); font-weight: 600; letter-spacing: 1px; }

    /* Data grid */
    .data-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 28px; }

    .data-item {
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.07);
      border-radius: 4px; padding: 14px 16px;
    }

    .data-label {
      font-size: 0.72rem; color: var(--text-muted);
      text-transform: uppercase; letter-spacing: 1px;
      margin-bottom: 6px; font-weight: 600;
    }

    .data-value { font-size: 0.95rem; font-weight: 600; color: var(--text-main); }

    .data-input {
      width: 100%; padding: 8px 0; margin-top: 4px;
      background: transparent;
      border: none; border-bottom: 2px solid rgba(255, 255, 255, 0.15);
      color: var(--text-main); font-size: 0.95rem; font-weight: 600;
      font-family: 'Plus Jakarta Sans', sans-serif;
      outline: none; transition: var(--transition);
    }

    .data-input:focus {
      border-bottom-color: var(--primary-light);
      box-shadow: 0 2px 8px rgba(52, 211, 153, 0.1);
    }

    .data-input::placeholder {
      color: var(--text-muted); font-weight: 400; font-size: 0.85rem;
    }

    select.data-input {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      cursor: pointer;
      background: transparent url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 0 center;
      padding-right: 24px;
    }

    select.data-input option {
      background: #1e293b;
      color: #f8fafc;
    }

    .data-error {
      font-size: 0.72rem; color: var(--error);
      margin-top: 4px; font-weight: 500;
    }

    /* Question */
    .question-box { text-align: center; margin-bottom: 24px; }
    .question-box p { color: var(--text-muted); font-size: 0.9rem; margin-bottom: 4px; }
    .question-box strong { color: var(--text-main); }

    /* Button group */
    .btn-group { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

    .btn-yes {
      padding: 14px; font-weight: 800; font-size: 0.9rem;
      background: linear-gradient(135deg, var(--primary), #047857);
      border: 1px solid var(--primary-light);
      color: #fff; border-radius: 4px; cursor: pointer; text-decoration: none;
      transition: var(--transition);
      box-shadow: 0 0 20px rgba(5, 150, 105, 0.2);
      display: flex; align-items: center; justify-content: center; gap: 8px;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .btn-yes:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 30px rgba(5, 150, 105, 0.5);
      background: linear-gradient(135deg, #10b981, var(--primary));
    }

    .btn-no {
      padding: 14px; font-weight: 700; font-size: 0.9rem;
      background: rgba(255, 255, 255, 0.05);
      color: var(--text-muted);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 4px; cursor: pointer; text-decoration: none;
      transition: var(--transition);
      display: flex; align-items: center; justify-content: center; gap: 8px;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .btn-no:hover {
      background: rgba(239, 68, 68, 0.1);
      border-color: rgba(239, 68, 68, 0.3);
      color: var(--error);
    }

    .back-link {
      display: inline-flex; align-items: center; gap: 8px;
      color: var(--gold); text-decoration: none;
      font-size: 0.9rem; font-weight: 500;
      margin-bottom: 24px;
      transition: var(--transition);
    }

    .back-link:hover { color: var(--primary-light); }

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
      .data-grid { grid-template-columns: 1fr; }
      .btn-group { grid-template-columns: 1fr; }
    }

    /* Select2 Custom Styles (Dark Theme) */
    .select2-container--default .select2-selection--single {
      background-color: rgba(15, 23, 42, 0.8) !important;
      border: 1px solid var(--glass-border) !important;
      border-radius: 4px !important;
      height: auto !important;
      min-height: 45px !important;
      display: flex !important;
      align-items: center !important;
      transition: var(--transition) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: var(--text-main) !important;
      padding-left: 12px !important;
      font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
      color: var(--text-muted) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 43px !important;
    }

    .select2-dropdown {
      background-color: var(--bg-darker) !important;
      border: 1px solid var(--primary-light) !important;
      border-radius: 4px !important;
      color: var(--text-main) !important;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5) !important;
    }

    .select2-results__option--selectable {
      padding: 10px 16px !important;
      font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
      background-color: var(--primary) !important;
      color: #fff !important;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
      background-color: rgba(15, 23, 42, 0.8) !important;
      border: 1px solid var(--glass-border) !important;
      border-radius: 4px !important;
      color: var(--text-main) !important;
      padding: 8px 12px !important;
      outline: none !important;
    }
  </style>
</head>
<body>
  <div class="grid-bg"></div>
  <div class="islamic-pattern"></div>
  <div class="glow-orb glow-emerald"></div>
  <div class="glow-orb glow-gold"></div>

  <div class="form-container">
    <a href="{{ route('ptsp.surat.cek-form') }}" class="back-link">
      <i class="ti ti-arrow-left"></i> Masukkan NISN Lain
    </a>

    <div class="form-header">
      <h1>Konfirmasi Identitas</h1>
      <p>Verifikasi data sebelum mengajukan surat</p>
    </div>

    <!-- Progress Steps -->
    <div class="steps">
      <div class="step done">
        <div class="step-circle"><i class="ti ti-check"></i></div>
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

    <!-- Form Edit Data -->
    <form method="POST" action="{{ route('ptsp.surat.konfirmasi') }}" id="form-konfirmasi">
      @csrf
      <input type="hidden" name="session_token" value="{{ $token }}">

      <!-- Data Grid -->
      <div class="data-grid">
        <div class="data-item">
          <div class="data-label">Kelas</div>
          <select name="kelas" class="data-input select2" data-placeholder="Pilih kelas" required>
            <option></option>
            @foreach(config('kelas') as $k)
              <option value="{{ $k }}" {{ old('kelas', $siswa->kelas) == $k ? 'selected' : '' }}>{{ $k }}</option>
            @endforeach
          </select>
          @error('kelas')
            <div class="data-error">{{ $message }}</div>
          @enderror
        </div>
        <div class="data-item">
          <div class="data-label">NIS</div>
          <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}"
                 class="data-input" placeholder="NIS (opsional)">
          @error('nis')
            <div class="data-error">{{ $message }}</div>
          @enderror
        </div>
        <div class="data-item">
          <div class="data-label">NISN</div>
          <div class="data-value" style="letter-spacing:1.5px">{{ $siswa->nisn }}</div>
        </div>
        <div class="data-item">
          <div class="data-label">Nama Lengkap</div>
          <div class="data-value">{{ $siswa->nama_lengkap }}</div>
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
        <p>Jika data sudah sesuai, silakan lanjutkan. <strong>NIS dan Kelas</strong> dapat diedit jika belum sesuai.</p>
      </div>

      <div class="btn-group">
        <button type="submit" class="btn-yes" id="btn-lanjut">
          <i class="ti ti-check"></i> Ya, Lanjutkan
        </button>
        <a href="{{ route('ptsp.surat.cek-form') }}" class="btn-no">
          <i class="ti ti-x"></i> Tidak, Kembali
        </a>
      </div>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const select2 = $('.select2');
      if (select2.length) {
        select2.each(function() {
          var $this = $(this);
          $this.wrap('<div class="position-relative"></div>').select2({
            placeholder: $this.data('placeholder'),
            dropdownParent: $this.parent(),
            width: '100%',
            allowClear: true
          });
        });
      }

      const btnLanjut = document.getElementById('btn-lanjut');
      if (btnLanjut) {
        document.getElementById('form-konfirmasi').addEventListener('submit', function() {
          btnLanjut.disabled = true;
          btnLanjut.innerHTML = '<i class="ti ti-loader ti-spin"></i> Memproses...';
        });
      }
    });
  </script>
</body>
</html>
