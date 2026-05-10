<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Pengajuan Surat — PTSP MAN 1 Kota Bandung</title>
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
      align-items: flex-start;
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

    /* Section title */
    .section-title {
      font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
      letter-spacing: 2px; color: var(--primary-light);
      margin-bottom: 16px;
      display: flex; align-items: center; gap: 10px;
    }

    .section-title::after {
      content: ''; flex: 1; height: 1px;
      background: linear-gradient(90deg, rgba(52, 211, 153, 0.3), transparent);
    }

    /* Data read-only grid */
    .data-readonly-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 24px; }

    .data-readonly {
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.07);
      border-radius: 4px; padding: 12px 14px;
    }

    .data-readonly-label {
      font-size: 0.68rem; color: var(--text-muted);
      text-transform: uppercase; letter-spacing: 1px;
      margin-bottom: 5px; font-weight: 600;
    }

    .data-readonly-value { font-size: 0.9rem; font-weight: 600; color: var(--text-main); }

    .divider {
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--glass-border), transparent);
      margin: 24px 0;
    }

    /* Form elements */
    .form-group { margin-bottom: 18px; }

    .form-label {
      display: block; font-size: 0.85rem; font-weight: 600;
      color: var(--text-muted); margin-bottom: 8px;
      text-transform: uppercase; letter-spacing: 1px;
    }

    .form-label span.req { color: var(--error); margin-left: 2px; }

    .form-select {
      width: 100%; padding: 14px 16px;
      background: rgba(15, 23, 42, 0.8);
      border: 1px solid var(--glass-border);
      border-radius: 4px;
      color: var(--text-main); font-size: 1rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      transition: var(--transition); outline: none;
      appearance: none; cursor: pointer;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='rgba(255,255,255,0.4)' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 14px center;
      padding-right: 40px;
    }

    .form-select option { background: var(--bg-darker); color: var(--text-main); }

    .form-select:focus {
      border-color: var(--primary-light);
      box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.15);
      background: rgba(15, 23, 42, 0.95);
    }

    .form-select.is-invalid { border-color: var(--error) !important; }

    .form-textarea {
      width: 100%; padding: 14px 16px;
      background: rgba(15, 23, 42, 0.8);
      border: 1px solid var(--glass-border);
      border-radius: 4px;
      color: var(--text-main); font-size: 1rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      transition: var(--transition); outline: none;
      resize: vertical; min-height: 100px; line-height: 1.6;
    }

    .form-textarea::placeholder { color: rgba(148, 163, 184, 0.5); }

    .form-textarea:focus {
      border-color: var(--primary-light);
      box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.15);
      background: rgba(15, 23, 42, 0.95);
    }

    .form-textarea.is-invalid { border-color: var(--error) !important; }

    .error-msg {
      display: flex; align-items: center; gap: 6px;
      margin-top: 8px; font-size: 0.8rem; color: var(--error);
    }

    .hint-text {
      font-size: 0.78rem; color: var(--text-muted);
      margin-top: 6px; font-style: italic;
    }

    /* Checkbox group */
    .checkbox-group { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }

    .checkbox-item {
      display: flex; align-items: center; gap: 10px;
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 4px; padding: 12px 14px;
      cursor: pointer; transition: var(--transition);
    }

    .checkbox-item:hover { border-color: rgba(52, 211, 153, 0.25); background: rgba(52, 211, 153, 0.04); }
    .checkbox-item input[type="checkbox"] { display: none; }

    .checkbox-item input[type="checkbox"]:checked + .checkbox-box {
      background: var(--primary); border-color: var(--primary);
    }

    .checkbox-item input[type="checkbox"]:checked + .checkbox-box::after {
      content: '\2713'; color: #fff; font-weight: 700; font-size: 0.75rem;
    }

    .checkbox-item input[type="checkbox"]:checked ~ .checkbox-label { color: var(--primary-light); }
    .checkbox-item:has(input:checked) { border-color: rgba(52, 211, 153, 0.3); background: rgba(52, 211, 153, 0.06); }

    .checkbox-box {
      width: 20px; height: 20px; border-radius: 4px; flex-shrink: 0;
      border: 2px solid rgba(255, 255, 255, 0.2);
      display: flex; align-items: center; justify-content: center;
      transition: var(--transition);
    }

    .checkbox-label { font-size: 0.85rem; font-weight: 500; color: var(--text-muted); transition: color 0.2s; }

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
      .data-readonly-grid { grid-template-columns: 1fr; }
      .checkbox-group { grid-template-columns: 1fr; }
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
      <i class="ti ti-arrow-left"></i> Mulai Ulang
    </a>

    <div class="form-header">
      <h1>Form Pengajuan Surat</h1>
      <p>Isi detail permohonan Anda di bawah ini</p>
    </div>

    <!-- Progress Steps -->
    <div class="steps">
      <div class="step done">
        <div class="step-circle"><i class="ti ti-check"></i></div>
        <div class="step-label">Input NISN</div>
      </div>
      <div class="step-line done"></div>
      <div class="step done">
        <div class="step-circle"><i class="ti ti-check"></i></div>
        <div class="step-label">Konfirmasi</div>
      </div>
      <div class="step-line done"></div>
      <div class="step active">
        <div class="step-circle">3</div>
        <div class="step-label">Form Surat</div>
      </div>
      <div class="step-line"></div>
      <div class="step">
        <div class="step-circle">4</div>
        <div class="step-label">Selesai</div>
      </div>
    </div>

    <form method="POST" action="{{ route('ptsp.surat.store') }}" id="form-surat">
      @csrf

      <!-- Data Siswa (read-only) -->
      <div class="section-title">Data Siswa</div>

      <div class="data-readonly-grid">
        <div class="data-readonly">
          <div class="data-readonly-label">Nama Lengkap</div>
          <div class="data-readonly-value">{{ $siswa->nama_lengkap }}</div>
        </div>
        <div class="data-readonly">
          <div class="data-readonly-label">Kelas</div>
          <div class="data-readonly-value">{{ $siswa->kelas ?? '-' }}</div>
        </div>
        <div class="data-readonly">
          <div class="data-readonly-label">NISN</div>
          <div class="data-readonly-value" style="letter-spacing:1.5px">{{ $siswa->nisn }}</div>
        </div>
        <div class="data-readonly">
          <div class="data-readonly-label">Tempat & Tanggal Lahir</div>
          <div class="data-readonly-value" style="font-size:0.82rem">
            {{ $siswa->tempat_lahir ?? '-' }}
            @if($siswa->tanggal_lahir)
              , {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}
            @endif
          </div>
        </div>
      </div>

      <div class="divider"></div>

      <!-- Detail Permohonan -->
      <div class="section-title">Detail Permohonan</div>

      <!-- Jenis Surat -->
      <div class="form-group">
        <label for="jenis_surat" class="form-label">
          Jenis Surat yang Diperlukan <span class="req">*</span>
        </label>
        <select
          id="jenis_surat"
          name="jenis_surat"
          class="form-select {{ $errors->has('jenis_surat') ? 'is-invalid' : '' }}"
          required
        >
          <option value="" disabled {{ old('jenis_surat') ? '' : 'selected' }}>-- Pilih Jenis Surat --</option>
          @foreach([
            'Surat Keterangan Siswa',
            'SKKB (Surat Keterangan Kelakuan Baik)',
            'Surat Rekomendasi',
            'SKL (Surat Keterangan Lulus)',
            'Surat Dispensasi',
            'Surat Pengantar',
            'Surat Tugas',
            'Nama Kegiatan / Rekomendasi',
          ] as $jenis)
            <option value="{{ $jenis }}" {{ old('jenis_surat') === $jenis ? 'selected' : '' }}>
              {{ $jenis }}
            </option>
          @endforeach
        </select>
        @if ($errors->has('jenis_surat'))
          <div class="error-msg">
            <i class="ti ti-alert-circle"></i>
            {{ $errors->first('jenis_surat') }}
          </div>
        @endif
      </div>

      <!-- Legalisir -->
      <div class="form-group">
        <label class="form-label">
          Jenis Legalisir
          <span style="color:var(--text-muted);font-weight:400;text-transform:none;letter-spacing:0;font-size:0.75rem">(opsional, pilih jika diperlukan)</span>
        </label>
        <div class="checkbox-group">
          @foreach(['Raport', 'SKKB', 'Ijazah'] as $item)
            <label class="checkbox-item" for="legalisir_{{ strtolower($item) }}">
              <input
                type="checkbox"
                id="legalisir_{{ strtolower($item) }}"
                name="legalisir[]"
                value="{{ $item }}"
                {{ in_array($item, old('legalisir', [])) ? 'checked' : '' }}
              >
              <span class="checkbox-box"></span>
              <span class="checkbox-label">{{ $item }}</span>
            </label>
          @endforeach
        </div>
      </div>

      <!-- Keperluan -->
      <div class="form-group">
        <label for="keperluan" class="form-label">
          Keperluan / Keterangan <span class="req">*</span>
        </label>
        <textarea
          id="keperluan"
          name="keperluan"
          class="form-textarea {{ $errors->has('keperluan') ? 'is-invalid' : '' }}"
          placeholder="Jelaskan keperluan surat yang Anda butuhkan..."
          required
          maxlength="1000"
        >{{ old('keperluan') }}</textarea>
        <div class="hint-text">Maksimal 1000 karakter. Jelaskan dengan jelas tujuan pembuatan surat.</div>
        @if ($errors->has('keperluan'))
          <div class="error-msg">
            <i class="ti ti-alert-circle"></i>
            {{ $errors->first('keperluan') }}
          </div>
        @endif
      </div>

      <button type="submit" class="btn-submit" id="btn-submit">
        <i class="ti ti-send"></i> Kirim Permohonan
      </button>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.getElementById('form-surat').addEventListener('submit', function() {
      const btn = document.getElementById('btn-submit');
      btn.disabled = true;
      btn.innerHTML = '<i class="ti ti-loader ti-spin"></i> Mengirim Permohonan...';
    });

    const keperluan = document.getElementById('keperluan');
    const hint = keperluan.nextElementSibling;
    keperluan.addEventListener('input', function() {
      const remaining = 1000 - this.value.length;
      hint.textContent = this.value.length + '/1000 karakter';
      hint.style.color = remaining < 100 ? '#e67e22' : 'var(--text-muted)';
    });
  </script>
</body>
</html>
