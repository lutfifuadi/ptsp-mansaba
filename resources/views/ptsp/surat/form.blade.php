<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Pengajuan Surat — PTSP MAN 1 Kota Bandung</title>
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
      display: flex; align-items: flex-start; justify-content: center;
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
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cg fill='none' stroke='rgba(46,204,113,0.08)' stroke-width='0.6'%3E%3Cpolygon points='40,4 44.6,18 59,12 50,26 65,32 50,36 59,50 44.6,44 40,58 35.4,44 21,50 30,36 15,32 30,26 21,12 35.4,18'/%3E%3C/g%3E%3C/svg%3E");
      background-size: 80px 80px; z-index: 1; pointer-events: none;
    }
    .orb { position: fixed; border-radius: 4px; filter: blur(60px); z-index: 1; pointer-events: none; }
    .orb-1 { width: 340px; height: 340px; background: radial-gradient(circle, rgba(30,132,73,0.18) 0%, transparent 70%); top: -80px; left: -80px; animation: orbFloat 12s ease-in-out infinite; }
    .orb-2 { width: 280px; height: 280px; background: radial-gradient(circle, rgba(201,168,76,0.10) 0%, transparent 70%); bottom: -60px; right: -60px; animation: orbFloat 14s ease-in-out infinite reverse; }
    @keyframes orbFloat { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(40px, 30px); } }

    .page-wrapper {
      position: relative; z-index: 10;
      width: 100%; max-width: 600px;
      padding: 32px 20px 60px;
    }

    @media (min-width: 768px) {
      .page-wrapper { max-width: 1200px; }
      .card { padding: 56px 52px; }
      .page-header h1 { font-size: 3rem; }
      .data-readonly-grid { grid-template-columns: repeat(4, 1fr); gap: 20px; }
      .form-group:has(.checkbox-group) { grid-column: span 1; }
      .form-select, .form-textarea { padding: 18px 24px; font-size: 1.15rem; }
      .btn-submit { padding: 22px; font-size: 1.2rem; }
    }

    @media (min-width: 1024px) {
      .page-wrapper { max-width: 1400px; }
    }

    .back-link {
      display: inline-flex; align-items: center; gap: 8px;
      color: var(--text-muted); text-decoration: none;
      font-size: 0.85rem; font-weight: 500;
      margin-bottom: 28px; transition: color 0.2s;
    }
    .back-link:hover { color: var(--primary); }

    .page-header { text-align: center; margin-bottom: 28px; animation: fadeInDown 0.7s ease both; }
    .school-logo { width: 60px; height: 60px; object-fit: contain; margin-bottom: 14px; filter: drop-shadow(0 0 16px var(--primary-glow)); }
    .page-header h1 {
      font-size: 1.6rem; font-weight: 800;
      background: linear-gradient(135deg, #fff 40%, var(--primary) 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      margin-bottom: 6px;
    }
    .page-header p { color: var(--text-muted); font-size: 0.875rem; }

    .steps { display: flex; align-items: center; justify-content: center; gap: 0; margin-bottom: 24px; animation: fadeIn 0.7s 0.1s ease both; }
    .step { display: flex; flex-direction: column; align-items: center; gap: 6px; }
    .step-circle { width: 32px; height: 32px; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; border: 2px solid var(--card-border); color: var(--text-muted); background: var(--card-bg); transition: all 0.3s; }
    .step.active .step-circle { background: var(--primary); border-color: var(--primary); color: #000; box-shadow: 0 0 14px var(--primary-glow); }
    .step.done .step-circle { background: var(--primary-dark); border-color: var(--primary-dark); color: #fff; }
    .step-label { font-size: 0.65rem; color: var(--text-muted); white-space: nowrap; font-weight: 500; }
    .step.active .step-label { color: var(--primary); }
    .step.done .step-label { color: var(--primary-dark); }
    .step-line { flex: 1; height: 2px; min-width: 36px; background: var(--card-border); margin-bottom: 20px; }
    .step-line.done { background: var(--primary-dark); }

    .card {
      background: var(--card-bg); border: 1px solid var(--card-border);
      border-radius: 4px; padding: 32px 28px;
      backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
      box-shadow: 0 24px 80px rgba(0,0,0,0.5);
      animation: fadeInUp 0.7s 0.2s ease both;
      margin-bottom: 16px;
    }

    .section-title {
      font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
      letter-spacing: 2px; color: var(--primary);
      margin-bottom: 16px;
      display: flex; align-items: center; gap: 10px;
    }
    .section-title::after {
      content: ''; flex: 1; height: 1px;
      background: linear-gradient(90deg, rgba(46,204,113,0.3), transparent);
    }

    /* Data Siswa (read-only) */
    .data-readonly-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 24px; }

    .data-readonly {
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.07);
      border-radius: 4px; padding: 12px 14px;
    }
    .data-readonly-label { font-size: 0.68rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; font-weight: 600; }
    .data-readonly-value { font-size: 0.9rem; font-weight: 600; color: var(--text-main); }

    .divider { height: 1px; background: var(--card-border); margin: 24px 0; }

    /* Form elements */
    .form-group { margin-bottom: 18px; }
    .form-label {
      display: block; font-size: 0.78rem; font-weight: 600;
      color: var(--text-muted); text-transform: uppercase;
      letter-spacing: 1px; margin-bottom: 8px;
    }
    .form-label span.req { color: var(--error); margin-left: 2px; }

    .form-select, .form-textarea {
      width: 100%; padding: 13px 16px;
      background: var(--input-bg);
      border: 1px solid var(--input-border);
      border-radius: 4px;
      color: var(--text-main); font-size: 0.95rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      transition: all 0.2s;
    }
    .form-select { appearance: none; cursor: pointer; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='rgba(255,255,255,0.4)' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 40px; }
    .form-select option { background: #0d2b18; color: #fff; }
    .form-select:focus, .form-textarea:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px var(--input-focus); background: rgba(46,204,113,0.05); }
    .form-select.is-invalid, .form-textarea.is-invalid { border-color: var(--error); }
    .form-textarea { resize: vertical; min-height: 100px; line-height: 1.6; }

    /* Checkbox Legalisir */
    .checkbox-group { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }

    .checkbox-item {
      display: flex; align-items: center; gap: 10px;
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 4px; padding: 12px 14px;
      cursor: pointer; transition: all 0.2s;
    }
    .checkbox-item:hover { border-color: rgba(46,204,113,0.25); background: rgba(46,204,113,0.04); }
    .checkbox-item input[type="checkbox"] { display: none; }
    .checkbox-item input[type="checkbox"]:checked + .checkbox-box {
      background: var(--primary); border-color: var(--primary);
    }
    .checkbox-item input[type="checkbox"]:checked + .checkbox-box::after {
      content: '✓'; color: #000; font-weight: 700; font-size: 0.75rem;
    }
    .checkbox-item input[type="checkbox"]:checked ~ .checkbox-label { color: var(--primary); }
    .checkbox-item:has(input:checked) { border-color: rgba(46,204,113,0.3); background: rgba(46,204,113,0.06); }

    .checkbox-box {
      width: 20px; height: 20px; border-radius: 5px; flex-shrink: 0;
      border: 2px solid rgba(255,255,255,0.2);
      display: flex; align-items: center; justify-content: center;
      transition: all 0.2s;
    }
    .checkbox-label { font-size: 0.85rem; font-weight: 500; color: var(--text-muted); transition: color 0.2s; }

    .error-msg { display: flex; align-items: center; gap: 6px; margin-top: 8px; font-size: 0.78rem; color: var(--error); }

    .hint-text { font-size: 0.75rem; color: var(--text-muted); margin-top: 6px; font-style: italic; }

    .btn-submit {
      width: 100%; padding: 16px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: #000; font-weight: 800; font-size: 0.95rem;
      border: none; border-radius: 4px; cursor: pointer;
      transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
      box-shadow: 0 8px 24px var(--primary-glow);
      margin-top: 8px; font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 12px 32px var(--primary-glow); }
    .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    .footer { margin-top: 32px; text-align: center; color: rgba(255,255,255,0.18); font-size: 0.75rem; }

    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-24px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    @media (max-width: 576px) {
      .card { padding: 24px 18px; }
      .data-readonly-grid { grid-template-columns: 1fr; }
      .checkbox-group { grid-template-columns: 1fr; }
      .step-line { min-width: 20px; }
      .step-label { font-size: 0.6rem; }
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
      Mulai Ulang
    </a>

    <header class="page-header">
      <h1>Form Pengajuan Surat</h1>
      <p>Isi detail permohonan Anda di bawah ini</p>
    </header>

    <!-- Progress Steps -->
    <div class="steps">
      <div class="step done">
        <div class="step-circle">✓</div>
        <div class="step-label">Input NISN</div>
      </div>
      <div class="step-line done"></div>
      <div class="step done">
        <div class="step-circle">✓</div>
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

      <!-- Card: Data Siswa (read-only) -->
      <div class="card">
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
      </div>

      <!-- Card: Detail Permohonan -->
      <div class="card">
        <div class="section-title">Detail Permohonan</div>

        <!-- 5. Jenis Surat -->
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
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
              {{ $errors->first('jenis_surat') }}
            </div>
          @endif
        </div>

        <!-- 6. Legalisir (opsional) -->
        <div class="form-group">
          <label class="form-label">Jenis Legalisir <span style="color:var(--text-muted);font-weight:400;text-transform:none;letter-spacing:0">(opsional, pilih jika diperlukan)</span></label>
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

        <!-- 7. Keperluan -->
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
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
              {{ $errors->first('keperluan') }}
            </div>
          @endif
        </div>

        <button type="submit" class="btn-submit" id="btn-submit">
          Kirim Permohonan
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="display:inline;margin-left:8px;vertical-align:-2px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
          </svg>
        </button>
      </div>
    </form>

  </div>

  <script>
    // Loading state saat submit
    document.getElementById('form-surat').addEventListener('submit', function() {
      const btn = document.getElementById('btn-submit');
      btn.disabled = true;
      btn.textContent = 'Mengirim Permohonan...';
    });

    // Character counter textarea
    const keperluan = document.getElementById('keperluan');
    const hint = keperluan.nextElementSibling;
    keperluan.addEventListener('input', function() {
      const remaining = 1000 - this.value.length;
      hint.textContent = `${this.value.length}/1000 karakter`;
      hint.style.color = remaining < 100 ? '#e67e22' : 'rgba(255,255,255,0.4)';
    });
  </script>
</body>
</html>
