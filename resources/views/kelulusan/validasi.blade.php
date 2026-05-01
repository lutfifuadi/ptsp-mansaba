<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
  <title>Verifikasi Kelulusan - {{ $pengaturan['nama_lembaga'] }}</title>
  <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::get('logo_kanan') ?: asset('assets/img/favicon/favicon.ico') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Lora:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap"
        onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link href="https://fonts.googleapis.com/css2?family=Lora:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet"></noscript>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg:         #07130e;
      --bg-card:    #0c1f16;
      --bg-item:    #0f2619;
      --bg-hover:   #122d1e;
      --border:     rgba(255,255,255,0.06);
      --border-g:   rgba(46,204,113,0.18);
      --green:      #2ecc71;
      --green-dk:   #1e8449;
      --muted:      rgba(255,255,255,0.38);
      --subtle:     rgba(255,255,255,0.65);
    }

    html, body {
      width: 100%; height: 100%;
      overflow-x: hidden;
      font-family: 'DM Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      background: var(--bg);
      color: #fff;
      -webkit-font-smoothing: antialiased;
    }

    body::before {
      content: '';
      position: fixed; inset: 0; z-index: 0;
      background:
        radial-gradient(ellipse 55% 45% at 12% 18%, rgba(21,92,48,0.22) 0%, transparent 100%),
        radial-gradient(ellipse 45% 40% at 88% 82%, rgba(10,50,28,0.18) 0%, transparent 100%);
      pointer-events: none;
    }

    .shell {
      position: relative; z-index: 1;
      width: 100%; min-height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }

    .card {
      width: 100%; max-width: 600px;
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(0,0,0,0.4);
      animation: rise 0.6s cubic-bezier(0.22,1,0.36,1) both;
    }
    @keyframes rise {
      from { opacity:0; transform:translateY(20px) scale(0.98); }
      to   { opacity:1; transform:translateY(0) scale(1); }
    }

    /* ── Header ── */
    .c-head {
      display: flex; flex-direction: column; align-items: center; text-align: center;
      padding: 32px 28px 24px;
      border-bottom: 1px solid var(--border);
      background: linear-gradient(180deg, rgba(46,204,113,0.05) 0%, transparent 100%);
    }
    .shield-icon {
      width: 56px; height: 56px;
      background: linear-gradient(135deg, var(--green-dk), var(--green));
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 16px;
      box-shadow: 0 0 0 6px rgba(46,204,113,0.1);
      animation: pulse 2s infinite;
    }
    @keyframes pulse {
      0% { box-shadow: 0 0 0 0 rgba(46,204,113,0.3); }
      70% { box-shadow: 0 0 0 15px rgba(46,204,113,0); }
      100% { box-shadow: 0 0 0 0 rgba(46,204,113,0); }
    }
    .shield-icon svg { width: 28px; height: 28px; color: #fff; }
    
    .status-badge {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 6px 14px;
      background: rgba(46,204,113,0.15);
      border: 1px solid rgba(46,204,113,0.3);
      border-radius: 30px;
      color: var(--green);
      font-size: 0.85rem; font-weight: 700;
      letter-spacing: 0.05em; text-transform: uppercase;
      margin-bottom: 12px;
    }
    
    .brand-name {
      font-family: 'Lora', serif;
      font-size: 1.5rem; font-weight: 700;
      color: #fff; margin-bottom: 6px;
    }
    .brand-sub {
      font-size: 0.9rem; color: var(--subtle);
    }

    /* ── Body ── */
    .c-body { padding: 32px 32px 24px; }

    .data-group {
      margin-bottom: 24px;
    }
    .dg-label {
      font-size: 0.75rem; font-weight: 600;
      letter-spacing: 0.1em; text-transform: uppercase;
      color: var(--muted); margin-bottom: 6px;
    }
    .dg-value {
      font-size: 1.1rem; font-weight: 500;
      color: #fff;
      padding-bottom: 12px;
      border-bottom: 1px solid var(--border);
    }
    .dg-value.name {
      font-size: 1.3rem; font-weight: 700; color: var(--green);
      border-bottom: none; padding-bottom: 0; margin-bottom: 16px;
    }

    .grid-2 {
      display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
    }

    .alert-box {
      margin-top: 32px;
      padding: 16px 20px;
      background: rgba(46,204,113,0.05);
      border: 1px solid var(--border-g);
      border-radius: 8px;
      display: flex; gap: 14px;
    }
    .alert-icon svg { width: 20px; height: 20px; color: var(--green); }
    .alert-text { font-size: 0.85rem; color: rgba(255,255,255,0.8); line-height: 1.5; }

    /* ── Footer ── */
    .c-foot {
      padding: 20px 32px;
      background: rgba(0,0,0,0.2);
      border-top: 1px solid var(--border);
      text-align: center;
    }
    .btn-home {
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      padding: 12px 24px;
      background: transparent; color: #fff;
      font-size: 0.9rem; font-weight: 600;
      border: 1px solid var(--border); border-radius: 6px;
      cursor: pointer; text-decoration: none;
      transition: all 0.2s;
    }
    .btn-home:hover { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.2); }
    
    .copy {
      margin-top: 24px;
      font-size: 0.75rem; color: rgba(255,255,255,0.2);
      text-align: center;
    }

    @media (max-width: 480px) {
      .c-body { padding: 24px 20px; }
      .grid-2 { grid-template-columns: 1fr; gap: 16px; }
    }
  </style>
</head>
<body>

  <div class="shell">
    <div class="card">
      
      <div class="c-head">
        <div class="shield-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            <path d="m9 12 2 2 4-4"/>
          </svg>
        </div>
        <div class="status-badge">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          Dokumen Valid
        </div>
        <div class="brand-name">Bukti Kelulusan Resmi</div>
        <div class="brand-sub">{{ $pengaturan['nama_lembaga'] }} &mdash; {{ $pengaturan['tahun_ajaran'] }}</div>
      </div>

      <div class="c-body">
        
        <div class="data-group">
          <div class="dg-label">Nama Siswa</div>
          <div class="dg-value name">{{ $siswa->nama_lengkap }}</div>
        </div>

        <div class="grid-2">
          <div class="data-group">
            <div class="dg-label">NISN</div>
            <div class="dg-value">{{ $siswa->nisn }}</div>
          </div>
          <div class="data-group">
            <div class="dg-label">Nomor Peserta</div>
            <div class="dg-value text-primary fw-bold">{{ $siswa->no_peserta ?? '-' }}</div>
          </div>
        </div>

        <div class="grid-2">
          <div class="data-group">
            <div class="dg-label">Kelas</div>
            <div class="dg-value">{{ $siswa->kelas }}</div>
          </div>
          <div class="data-group">
            <div class="dg-label">Jurusan</div>
            <div class="dg-value">{{ $siswa->jurusan }}</div>
          </div>
        </div>

        <div class="alert-box">
          <div class="alert-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
          </div>
          <div class="alert-text">
            Dokumen elektronik ini resmi diterbitkan oleh sistem kelulusan <strong>{{ $pengaturan['nama_lembaga'] }}</strong>. Siswa yang bersangkutan dinyatakan sah dan berstatus <strong>LULUS</strong> pada tahun ajaran {{ $pengaturan['tahun_ajaran'] }}.
          </div>
        </div>

      </div>

      <div class="c-foot">
        <a href="{{ route('kelulusan.index') }}" class="btn-home">
          Ke Halaman Utama
        </a>
      </div>

    </div>
    
    <div class="copy">&copy; {{ date('Y') }} {{ $pengaturan['nama_lembaga'] }} &mdash; Sistem Verifikasi Kelulusan</div>
  </div>

</body>
</html>
