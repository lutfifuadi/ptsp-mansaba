<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Hasil Kelulusan - MAN 1 Kota Bandung</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
      --cream:         #f5f0e8;
      --white:         #ffffff;
      --text-muted:    rgba(255,255,255,0.55);
      --card-bg:       rgba(13, 43, 24, 0.82);
      --card-border:   rgba(46, 204, 113, 0.18);
      --shadow:        0 24px 80px rgba(0,0,0,0.55);
      --radius:        4px;
    }

    html, body {
      height: 100%;
      overflow: hidden;
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

    /* ── Background layers ───────────────────────────────── */
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
    .bg-pattern {
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cg fill='none' stroke='rgba(46,204,113,0.10)' stroke-width='0.6'%3E%3Cpolygon points='40,4 44.6,18 59,12 50,26 65,32 50,36 59,50 44.6,44 40,58 35.4,44 21,50 30,36 15,32 30,26 21,12 35.4,18'/%3E%3Crect x='28' y='28' width='24' height='24' transform='rotate(45 40 40)'/%3E%3Ccircle cx='40' cy='40' r='10'/%3E%3C/g%3E%3C/svg%3E");
      background-size: 80px 80px;
      z-index: 1;
      pointer-events: none;
    }
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

    /* ── Page wrapper ────────────────────────────────────── */
    .page-wrapper {
      position: relative;
      z-index: 10;
      width: 100%;
      padding: 16px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    /* ── Card ────────────────────────────────────────────── */
    .card-islamic {
      width: 100%;
      max-width: 640px;
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: var(--radius);
      padding: 32px 36px;
      box-shadow: var(--shadow), inset 0 1px 0 rgba(46,204,113,0.12);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      animation: cardEnter 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    @keyframes cardEnter {
      from { opacity: 0; transform: translateY(28px) scale(0.97); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ── Compact school header ───────────────────────────── */
    .school-mini {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 18px;
      animation: fadeSlideDown 0.5s 0.1s ease both;
    }
    .school-mini-icon {
      width: 36px; height: 36px;
      background: linear-gradient(135deg, var(--green-mid), var(--green-accent));
      border-radius: 9px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .school-mini-icon svg { width: 18px; height: 18px; fill: white; }
    .school-mini-info { text-align: left; }
    .school-mini-info h6 {
      font-family: 'Amiri', serif;
      font-size: 1.15rem;
      font-weight: 700;
      line-height: 1.2;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      background: linear-gradient(135deg, #ffffff 30%, var(--green-glow) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      text-shadow: none;
    }
    .school-mini-info span {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.78rem;
      font-weight: 600;
      color: var(--white);
      letter-spacing: 0.18em;
      text-transform: uppercase;
      display: inline-block;
      margin-top: 4px;
    }

    /* ── Divider ─────────────────────────────────────────── */
    .section-divider {
      height: 1px;
      background: linear-gradient(to right, transparent, rgba(46,204,113,0.25), transparent);
      margin: 14px 0;
    }

    /* ── Status block ────────────────────────────────────── */
    .status-block {
      text-align: center;
      padding: 20px 0 16px;
      animation: statusEnter 0.6s 0.2s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    @keyframes statusEnter {
      from { opacity: 0; transform: scale(0.85); }
      to   { opacity: 1; transform: scale(1); }
    }

    /* Lulus */
    .status-lulus .status-badge {
      width: 72px; height: 72px;
      background: linear-gradient(135deg, #1a5c2e, #27ae60);
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 12px;
      box-shadow: 0 0 0 8px rgba(39,174,96,0.12), 0 8px 28px rgba(39,174,96,0.35);
      animation: luluyPulse 2.5s ease-in-out infinite;
    }
    @keyframes luluyPulse {
      0%, 100% { box-shadow: 0 0 0 8px rgba(39,174,96,0.12), 0 8px 28px rgba(39,174,96,0.35); }
      50%       { box-shadow: 0 0 0 14px rgba(39,174,96,0.08), 0 12px 36px rgba(39,174,96,0.45); }
    }
    .status-lulus .status-badge svg { width: 34px; height: 34px; color: white; }
    .status-lulus h3 {
      font-family: 'Amiri', serif;
      font-size: 1.55rem;
      font-weight: 700;
      color: var(--green-glow);
      margin-bottom: 6px;
      text-shadow: 0 0 20px rgba(46,204,113,0.3);
    }
    .status-lulus p { font-size: 0.85rem; color: var(--text-muted); }
    .status-lulus p strong { color: var(--green-glow); }

    /* Tidak Lulus */
    .status-tidak .status-badge {
      width: 72px; height: 72px;
      background: linear-gradient(135deg, #6b1818, #c0392b);
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 12px;
      box-shadow: 0 8px 28px rgba(192,57,43,0.35);
    }
    .status-tidak .status-badge svg { width: 34px; height: 34px; color: white; }
    .status-tidak h3 {
      font-family: 'Amiri', serif;
      font-size: 1.55rem;
      font-weight: 700;
      color: #e74c3c;
      margin-bottom: 6px;
    }
    .status-tidak p { font-size: 0.85rem; color: var(--text-muted); }
    .status-tidak p strong { color: #e74c3c; }

    /* Menunggu */
    .status-pending .status-badge {
      width: 72px; height: 72px;
      background: linear-gradient(135deg, #6b5b18, #d4ac0d);
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 12px;
      box-shadow: 0 8px 28px rgba(212,172,13,0.3);
    }
    .status-pending .status-badge svg { width: 34px; height: 34px; color: white; }
    .status-pending h3 {
      font-family: 'Amiri', serif;
      font-size: 1.55rem;
      font-weight: 700;
      color: #f0c040;
      margin-bottom: 6px;
    }
    .status-pending p { font-size: 0.85rem; color: var(--text-muted); }

    /* ── Data table ──────────────────────────────────────── */
    .data-section {
      animation: fadeSlideUp 0.5s 0.35s ease both;
    }
    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(10px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .data-title {
      font-size: 0.68rem;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      color: var(--green-glow);
      font-weight: 600;
      margin-bottom: 10px;
    }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table tr td {
      padding: 7px 0;
      border-bottom: 1px solid rgba(46,204,113,0.07);
      vertical-align: top;
    }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table .td-label {
      font-size: 0.78rem;
      color: var(--text-muted);
      width: 120px;
      padding-right: 10px;
    }
    .data-table .td-value {
      font-size: 0.88rem;
      font-weight: 600;
      color: rgba(255,255,255,0.88);
    }

    /* ── Action buttons ──────────────────────────────────── */
    .action-section {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-top: 18px;
      animation: fadeSlideUp 0.5s 0.45s ease both;
    }
    .btn-download {
      width: 100%;
      padding: 14px 20px;
      background: linear-gradient(135deg, var(--green-accent), var(--green-bright));
      border: none;
      border-radius: 12px;
      color: white;
      font-size: 0.92rem;
      font-weight: 600;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      text-decoration: none;
      transition: transform 0.2s, box-shadow 0.2s, filter 0.2s;
      box-shadow: 0 6px 20px rgba(39,174,96,0.35);
      position: relative;
      overflow: hidden;
    }
    .btn-download::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, transparent 60%);
      border-radius: inherit;
      pointer-events: none;
    }
    .btn-download:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 32px rgba(39,174,96,0.5);
      filter: brightness(1.08);
      color: white;
      text-decoration: none;
    }
    .btn-download svg { width: 17px; height: 17px; }

    .btn-back {
      width: 100%;
      padding: 12px 20px;
      background: transparent;
      border: 1.5px solid rgba(46,204,113,0.25);
      border-radius: 12px;
      color: rgba(255,255,255,0.65);
      font-size: 0.88rem;
      font-weight: 500;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      text-decoration: none;
      transition: border-color 0.2s, color 0.2s, background 0.2s;
    }
    .btn-back:hover {
      border-color: rgba(46,204,113,0.5);
      color: rgba(255,255,255,0.9);
      background: rgba(46,204,113,0.06);
      text-decoration: none;
    }
    .btn-back svg { width: 16px; height: 16px; }

    /* ── Footer ──────────────────────────────────────────── */
    .page-footer {
      margin-top: 14px;
      text-align: center;
      color: rgba(255,255,255,0.2);
      font-size: 0.7rem;
    }

    /* ── Animations ──────────────────────────────────────── */
    @keyframes fadeSlideDown {
      from { opacity: 0; transform: translateY(-10px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Responsive ──────────────────────────────────────── */
    @media (min-width: 992px) {
      .card-islamic { padding: 40px 50px; }
    }
    @media (max-width: 480px) {
      html, body { overflow: auto; }
      .card-islamic { padding: 22px 18px; max-width: 98%; border-radius: 16px; }
      .status-lulus h3, .status-tidak h3, .status-pending h3 { font-size: 1.3rem; }
      .data-table .td-label { width: 100px; }
    }
  </style>
</head>
<body>
  <div class="bg-layer"></div>
  <div class="bg-pattern"></div>
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>

  <div class="page-wrapper">
    <div class="card-islamic">

      {{-- Compact school header --}}
      <div class="school-mini">
        <div class="school-mini-icon">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
          </svg>
        </div>
        <div class="school-mini-info">
          <h6>PENGUMUMAN KELULUSAN</h6>
          <span>MAN 1 Kota Bandung &mdash; {{ \App\Models\Pengaturan::get('tahun_ajaran', '2025/2026') }}</span>
        </div>
      </div>

      <div class="section-divider"></div>

      {{-- Status Block --}}
      @if($siswa->status_kelulusan === 'lulus')
        <div class="status-block status-lulus">
          <div class="status-badge">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
              <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
          </div>
          <h3>SELAMAT, ANDA LULUS!</h3>
          <p>Anda dinyatakan <strong>LULUS</strong> dari MAN 1 Kota Bandung.</p>
        </div>

      @elseif($siswa->status_kelulusan === 'tidak_lulus')
        <div class="status-block status-tidak">
          <div class="status-badge">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <line x1="18" y1="6" x2="6" y2="18"/>
              <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
          </div>
          <h3>TIDAK LULUS</h3>
          <p>Anda dinyatakan <strong>TIDAK LULUS</strong> dari MAN 1 Kota Bandung.</p>
        </div>

      @else
        <div class="status-block status-pending">
          <div class="status-badge">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
          </div>
          <h3>MENUNGGU</h3>
          <p>Status kelulusan Anda belum diumumkan.</p>
        </div>
      @endif

      <div class="section-divider"></div>

      {{-- Data Siswa --}}
      <div class="data-section">
        <div class="data-title">Data Siswa</div>
        <table class="data-table">
          <tbody>
            <tr>
              <td class="td-label">NISN</td>
              <td class="td-value">{{ $siswa->nisn }}</td>
            </tr>
            @if($siswa->nis)
            <tr>
              <td class="td-label">NIS</td>
              <td class="td-value">{{ $siswa->nis }}</td>
            </tr>
            @endif
            <tr>
              <td class="td-label">Nama Lengkap</td>
              <td class="td-value">{{ $siswa->nama_lengkap }}</td>
            </tr>
            <tr>
              <td class="td-label">Kelas</td>
              <td class="td-value">{{ $siswa->kelas }}</td>
            </tr>
            <tr>
              <td class="td-label">Jurusan</td>
              <td class="td-value">{{ $siswa->jurusan }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      {{-- Action Buttons --}}
      <div class="action-section">
        @if($siswa->status_kelulusan === 'lulus')
          <a href="{{ route('kelulusan.pdf', $siswa->nisn) }}" class="btn-download" target="_blank" rel="noopener noreferrer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
              <polyline points="7 10 12 15 17 10"/>
              <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Download Surat Kelulusan (PDF)
          </a>
        @endif
        <a href="{{ route('kelulusan.index') }}" class="btn-back">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
          </svg>
          Kembali ke Halaman Cek
        </a>
      </div>

    </div>

    <div class="page-footer">
      &copy; {{ date('Y') }} MAN 1 Kota Bandung &mdash; Sistem Pengumuman Kelulusan
    </div>
  </div>
</body>
</html>
