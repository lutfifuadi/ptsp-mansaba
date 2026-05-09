<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Hasil Seleksi PMBM - MAN 1 Kota Bandung</title>
  <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::get('logo_kanan') ?: asset('assets/img/favicon/favicon.ico') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Lora:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap"
        onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link href="https://fonts.googleapis.com/css2?family=Lora:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet"></noscript>
  <!-- Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    /* ── CELEBRATION OVERLAY ── */
    #celebrationOverlay {
      position: fixed; inset: 0; z-index: 9999;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      background: radial-gradient(ellipse at 50% 40%, rgba(5,25,15,0.97) 0%, rgba(2,12,7,0.99) 100%);
      animation: overlayIn 0.6s cubic-bezier(0.22,1,0.36,1) both;
      overflow: hidden;
    }
    #celebrationOverlay.hide {
      animation: overlayOut 0.8s cubic-bezier(0.55,0,1,0.45) forwards;
      pointer-events: none;
    }
    @keyframes overlayIn { from { opacity:0; } to { opacity:1; } }
    @keyframes overlayOut { 0% { opacity:1; transform: scale(1); } 100% { opacity:0; transform: scale(1.04); } }

    .cel-inner { position: relative; z-index: 2; text-align: center; padding: 0 24px; animation: celIn 0.9s 0.3s cubic-bezier(0.22,1,0.36,1) both; }
    @keyframes celIn { from { opacity:0; transform: translateY(32px) scale(0.92); } to { opacity:1; transform: translateY(0) scale(1); } }

    .cel-badge {
      display: inline-flex; align-items: center; justify-content: center;
      width: 96px; height: 96px; border-radius: 4px;
      background: linear-gradient(135deg, #155c30 0%, #27ae60 50%, #2ecc71 100%);
      box-shadow: 0 0 0 8px rgba(46,204,113,0.12), 0 0 0 16px rgba(46,204,113,0.06), 0 20px 60px rgba(46,204,113,0.4);
      margin: 0 auto 28px;
    }
    .cel-badge svg { width: 48px; height: 48px; color: #fff; }

    .cel-title {
      font-family: 'Lora', serif; font-size: clamp(2rem, 7vw, 3.4rem); font-weight: 700; line-height: 1.1; margin-bottom: 14px;
      background: linear-gradient(135deg, #fff 20%, #2ecc71 60%, #fff 100%); background-size: 200% auto;
      -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
      animation: shimmer 3s linear infinite;
    }
    @keyframes shimmer { 0% { background-position: 200% center; } 100% { background-position: -200% center; } }

    .cel-name { font-family: 'Lora', serif; font-size: clamp(1.1rem, 4vw, 1.6rem); font-weight: 600; color: #f0c040; margin-bottom: 10px; text-shadow: 0 0 30px rgba(240,192,64,0.5); }
    .cel-sub { font-size: clamp(0.85rem, 3vw, 1rem); color: rgba(255,255,255,0.65); max-width: 400px; margin: 0 auto 32px; line-height: 1.6; }
    .cel-btn {
      display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 14px 36px;
      background: linear-gradient(135deg, #1e8449, #2ecc71); border: none; border-radius: 4px;
      color: #fff; font-size: 0.95rem; font-weight: 700; cursor: pointer;
      box-shadow: 0 8px 28px rgba(46,204,113,0.45); transition: transform 0.2s;
    }
    .cel-btn:hover { transform: translateY(-2px); filter: brightness(1.1); }

    /* ... REST OF CSS ... */
    :root {
      --bg: #07130e; --bg-card: #0c1f16; --bg-item: #0f2619; --bg-hover: #122d1e;
      --border: rgba(255,255,255,0.06); --border-g: rgba(46,204,113,0.18);
      --green: #2ecc71; --green-dk: #1e8449; --muted: rgba(255,255,255,0.38); --subtle: rgba(255,255,255,0.65);
    }
    html, body { width: 100%; height: 100%; overflow: hidden; background: var(--bg); color: #fff; font-family: 'DM Sans', sans-serif; }
    body::before { content: ''; position: fixed; inset: 0; z-index: 0; background: radial-gradient(ellipse 55% 45% at 12% 18%, rgba(21,92,48,0.22) 0%, transparent 100%), radial-gradient(ellipse 45% 40% at 88% 82%, rgba(10,50,28,0.18) 0%, transparent 100%); pointer-events: none; }

    .shell { position: relative; z-index: 1; width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; }
    .card { width: 100%; max-width: 720px; background: var(--bg-card); border: 1px solid var(--border); border-radius: 4px; overflow: hidden; animation: rise 0.6s cubic-bezier(0.22,1,0.36,1) both; }
    @keyframes rise { from { opacity:0; transform:translateY(20px) scale(0.98); } to { opacity:1; transform:translateY(0) scale(1); } }

    .c-head { display: flex; align-items: center; justify-content: space-between; padding: 16px 28px; border-bottom: 1px solid var(--border); }
    .brand { display: flex; align-items: center; gap: 11px; }
    .brand-icon { width: 36px; height: 36px; background: linear-gradient(135deg, var(--green-dk), var(--green)); border-radius: 4px; display: flex; align-items: center; justify-content: center; }
    .brand-icon svg { width: 18px; height: 18px; fill: #fff; }
    .brand-name { font-size: 0.95rem; font-weight: 600; text-transform: uppercase; color: rgba(255,255,255,0.88); }
    
    .c-body { padding: 28px 32px; }
    .status-row { display: flex; align-items: center; gap: 24px; padding: 24px 28px; border: 1px solid var(--border-g); border-radius: 4px; margin-bottom: 24px; background: rgba(0,0,0,0.2); }
    .s-icon { width: 64px; height: 64px; border-radius: 4px; display: flex; align-items: center; justify-content: center; }
    .s-icon.lulus { background: linear-gradient(135deg,#155c30,#27ae60); box-shadow:0 0 0 7px rgba(39,174,96,0.10); }
    .s-icon.tidak { background: linear-gradient(135deg,#7b1a1a,#c0392b); }
    .s-title { font-family: 'Lora', serif; font-size: 1.85rem; font-weight: 700; }
    .s-title.lulus { color: var(--green); }
    .s-title.tidak { color: #e74c3c; }

    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .gi { background: var(--bg-item); border: 1px solid var(--border); border-radius: 4px; padding: 14px 18px; }
    .gi span { color: var(--muted); font-size: 0.72rem; text-transform: uppercase; display: block; margin-bottom: 4px; }
    .gi.full { grid-column: 1 / -1; }

    .c-foot { display: flex; align-items: center; gap: 10px; padding: 20px 32px 24px; border-top: 1px solid var(--border); }
    .btn-dl { flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 14px 20px; background: var(--green); color: #061a0e; font-weight: 700; border-radius: 4px; text-decoration: none; transition: transform 0.2s; }
    .btn-dl:hover { transform: translateY(-1px); filter: brightness(1.08); }
    .btn-bk { display: flex; align-items: center; justify-content: center; gap: 8px; padding: 14px 20px; background: transparent; color: var(--subtle); border: 1px solid var(--border); border-radius: 4px; text-decoration: none; transition: all 0.2s; }
    .btn-bk:hover { border-color: var(--border-g); color: #fff; background: rgba(46,204,113,0.05); }

    @media (max-width: 480px) { .shell { overflow-y: auto; display: block; } .card { margin-top: 20px; } .grid { grid-template-columns: 1fr; } .c-foot { flex-direction: column; } .status-row { flex-direction: column; text-align: center; } }
  </style>
</head>
<body>

@if(strtolower($calon->status_kelulusan) === 'lulus')
<!-- ── CELEBRATION OVERLAY ── -->
<div id="celebrationOverlay">
  <div class="cel-inner">
    <div class="cel-badge">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
      </svg>
    </div>
    <div class="cel-title">🎉 Selamat!</div>
    <div class="cel-name">{{ $calon->nama_lengkap }}</div>
    <div class="cel-sub">
      Anda dinyatakan <strong style="color:#2ecc71">LULUS SELEKSI</strong> PMBM MAN 1 Kota Bandung.<br>
      Selamat bergabung di keluarga besar kami!
    </div>
    <button class="cel-btn" onclick="dismissCelebration()">
      Lihat Detail Hasil Seleksi
    </button>
  </div>
</div>
@endif

  <div class="shell">
    <div class="card">
      <div class="c-head">
        <div class="brand">
          <div class="brand-icon">
            <svg viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/></svg>
          </div>
          <div>
            <div class="brand-name">MAN 1 Kota Bandung</div>
            <div class="brand-sub">Hasil Seleksi PMBM &mdash; {{ \App\Models\Pengaturan::get('tahun_ajaran', '2025/2026') }}</div>
          </div>
        </div>
      </div>

      <div class="c-body">
        @if(strtolower($calon->status_kelulusan) === 'lulus')
          <div class="status-row">
            <div class="s-icon lulus">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
              <div class="s-title lulus">Selamat, Anda Lulus!</div>
              <div class="s-desc">Anda dinyatakan <strong class="lulus">LULUS SELEKSI</strong> PMBM MAN 1 Kota Bandung.</div>
            </div>
          </div>
        @elseif(strtolower($calon->status_kelulusan) === 'tidak lulus')
          <div class="status-row" style="border-color:rgba(231,76,60,0.18)">
            <div class="s-icon tidak">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </div>
            <div>
              <div class="s-title tidak">Tidak Lulus Seleksi</div>
              <div class="s-desc">Anda dinyatakan <strong class="tidak">TIDAK LULUS SELEKSI</strong> PMBM MAN 1 Kota Bandung.</div>
            </div>
          </div>
        @else
          <div class="status-row" style="border-color:rgba(212,172,13,0.18)">
            <div class="s-icon" style="background: linear-gradient(135deg,#6b5b18,#d4ac0d);">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
              <div class="s-title" style="color: #f0c040;">Dalam Proses</div>
              <div class="s-desc">Status pendaftaran Anda saat ini masih dalam tahap <strong>PROSES</strong>.</div>
            </div>
          </div>
        @endif

        <div class="grid">
          <div class="gi"><span>No. Pendaftaran</span>{{ $calon->no_pendaftaran }}</div>
          <div class="gi"><span>NISN</span>{{ $calon->nisn ?? '-' }}</div>
          <div class="gi full"><span>Nama Lengkap</span>{{ $calon->nama_lengkap }}</div>
          <div class="gi"><span>Jalur Pendaftaran</span>{{ $calon->jalur_pendaftaran }}</div>
          <div class="gi"><span>Asal Sekolah</span>{{ $calon->asal_sekolah }}</div>
        </div>
      </div>

      <div class="c-foot">
        @if(strtolower($calon->status_kelulusan) === 'lulus')
          <a href="{{ route('pmbm.pdf', $calon->no_pendaftaran) }}" class="btn-dl" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Download Bukti Kelulusan (PDF)
          </a>
        @endif
        <a href="{{ route('pmbm.index') }}" class="btn-bk">Kembali</a>
      </div>
    </div>
  </div>

@if(strtolower($calon->status_kelulusan) === 'lulus')
<script>
(function () {
  /* ── Confetti ── */
  function fireConfetti() {
    const duration = 5 * 1000;
    const animationEnd = Date.now() + duration;
    const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 10000 };

    const interval = setInterval(function() {
      const timeLeft = animationEnd - Date.now();
      if (timeLeft <= 0) return clearInterval(interval);
      const particleCount = 50 * (timeLeft / duration);
      confetti(Object.assign({}, defaults, { particleCount, origin: { x: Math.random(), y: Math.random() - 0.2 } }));
    }, 250);

    confetti({ particleCount: 150, spread: 70, origin: { y: 0.6 }, zIndex: 10000 });
  }

  fireConfetti();

  window.dismissCelebration = function () {
    const overlay = document.getElementById('celebrationOverlay');
    if (overlay) {
      overlay.classList.add('hide');
      overlay.addEventListener('animationend', () => overlay.remove(), { once: true });
    }
  };
})();
</script>
@endif
</body>
</html>
