@php
use Illuminate\Support\Facades\Route;
$namaSekolah = \App\Models\Pengaturan::get('nama_sekolah', 'MAN 1 Kota Bandung');
$tahunAjaran = \App\Models\Pengaturan::get('tahun_ajaran', '2025/2026');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Login Admin &mdash; {{ $namaSekolah }}</title>
  <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::get('logo_kanan') ?: asset('assets/img/favicon/favicon.ico') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
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

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html, body { height: 100%; overflow: hidden; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg-darker);
      height: 100vh; overflow: hidden;
      display: flex; flex-direction: column;
    }

    /* Background */
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

    /* Split layout */
    .split-wrap {
      position: relative; z-index: 10;
      display: flex; flex: 1;
      height: 100vh; overflow: hidden;
    }

    /* LEFT: hero panel */
    .hero-panel {
      flex: 0 0 58%;
      display: flex; flex-direction: column; justify-content: center;
      padding: 4rem 4.5rem;
      position: relative; overflow-y: auto; overflow-x: hidden;
    }
    .hero-panel::after {
      content: '';
      position: absolute; top: 0; right: 0;
      width: 1px; height: 100%;
      background: linear-gradient(to bottom, transparent, var(--glass-border), transparent);
    }

    .hero-bismillah {
      font-family: 'Amiri', serif; font-size: 1.8rem;
      color: var(--gold); margin-bottom: 12px;
      text-shadow: 0 0 24px var(--gold-glow);
      animation: fadeSlideDown 0.6s 0.1s ease both;
    }
    .hero-divider {
      display: flex; align-items: center; gap: 10px;
      margin-bottom: 32px;
      animation: fadeSlideDown 0.6s 0.15s ease both;
    }
    .hero-divider::before { content:''; flex:0 0 60px; height:1px; background:linear-gradient(to right, transparent, rgba(212,175,55,0.4)); }
    .hero-divider::after  { content:''; flex:0 0 60px; height:1px; background:linear-gradient(to left,  transparent, rgba(212,175,55,0.4)); }
    .hero-divider span { color: var(--gold); font-size: 1rem; }

    .hero-school-icon {
      width: 72px; height: 72px;
      background: linear-gradient(135deg, var(--primary), #047857);
      border-radius: 18px;
      display: inline-flex; align-items: center; justify-content: center;
      margin-bottom: 20px;
      box-shadow: 0 8px 28px var(--primary-glow), 0 0 0 1px var(--glass-border);
      animation: fadeSlideDown 0.6s 0.2s ease both;
    }
    .hero-school-icon svg { width: 36px; height: 36px; fill: #fff; }

    .hero-title {
      font-family: 'Amiri', serif;
      font-size: clamp(2rem, 2.8vw, 2.8rem);
      font-weight: 700; line-height: 1.1;
      letter-spacing: 2px; text-transform: uppercase;
      background: linear-gradient(135deg, #ffffff 30%, var(--primary-light) 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
      margin-bottom: 6px;
      animation: fadeSlideDown 0.6s 0.25s ease both;
    }
    .hero-school-name {
      font-size: 0.92rem; font-weight: 600;
      text-transform: uppercase; letter-spacing: 0.15em;
      color: var(--primary-light); margin-bottom: 8px;
      animation: fadeSlideDown 0.6s 0.3s ease both;
    }
    .hero-badge {
      display: inline-block;
      background: rgba(52, 211, 153, 0.1); border: 1px solid rgba(52, 211, 153, 0.25);
      border-radius: 20px; padding: 3px 14px;
      font-size: 0.74rem; color: var(--primary-light);
      letter-spacing: 0.08em; margin-bottom: 28px;
      animation: fadeSlideDown 0.6s 0.32s ease both;
    }
    .hero-section-divider {
      height: 1px;
      background: linear-gradient(to right, rgba(52, 211, 153, 0.25), transparent);
      margin-bottom: 28px;
      animation: fadeSlideDown 0.6s 0.35s ease both;
    }

    .hero-features { list-style: none; padding: 0; animation: fadeSlideDown 0.6s 0.4s ease both; }
    .hero-features li {
      display: flex; align-items: center; gap: 12px;
      margin-bottom: 14px;
      color: rgba(248, 250, 252, 0.82); font-size: 0.9rem; font-weight: 500;
    }
    .feat-icon {
      width: 32px; height: 32px; flex-shrink: 0;
      background: rgba(52, 211, 153, 0.12); border: 1px solid rgba(52, 211, 153, 0.25);
      border-radius: 8px;
      display: inline-flex; align-items: center; justify-content: center;
    }
    .feat-icon svg { width: 15px; height: 15px; color: var(--primary-light); }

    .hero-footer {
      margin-top: 32px; font-size: 0.72rem;
      color: rgba(148, 163, 184, 0.3);
      animation: fadeIn 1s 1.2s ease both;
    }

    /* RIGHT: form panel */
    .form-panel {
      flex: 0 0 42%;
      display: flex; flex-direction: column; justify-content: center;
      padding: 3rem 3.5rem;
      background: var(--glass-bg);
      backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
      border-left: 1px solid var(--glass-border);
      overflow-y: auto; overflow-x: hidden;
    }
    .form-panel-inner {
      max-width: 380px; width: 100%; margin: 0 auto;
      animation: cardEnter 0.7s 0.15s cubic-bezier(0.22,1,0.36,1) both;
    }
    @keyframes cardEnter {
      from { opacity:0; transform:translateX(24px); }
      to   { opacity:1; transform:translateX(0); }
    }

    .form-heading {
      font-family: 'Amiri', serif; font-size: 1.7rem; font-weight: 700;
      color: var(--text-main); margin-bottom: 4px;
    }
    .form-sub {
      font-size: 0.875rem; color: var(--text-muted);
      margin-bottom: 24px; line-height: 1.5;
    }

    /* Alerts */
    .alert-error {
      background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.3);
      border-radius: 4px; padding: 11px 14px;
      display: flex; align-items: flex-start; gap: 10px; margin-bottom: 18px;
    }
    .alert-error i { flex-shrink:0; color:var(--error); margin-top:1px; font-size:18px; }
    .alert-error span { font-size:0.84rem; color:#ff8a80; line-height:1.4; }
    .alert-success {
      background: rgba(5,150,105,0.12); border: 1px solid rgba(5,150,105,0.3);
      border-radius: 4px; padding: 11px 14px;
      margin-bottom: 18px; font-size: 0.84rem; color: var(--primary-light);
    }

    /* Form fields */
    .form-group { margin-bottom: 18px; }

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

    .form-input {
      width: 100%;
      background: rgba(15, 23, 42, 0.8);
      border: 1px solid var(--glass-border);
      border-radius: 4px;
      padding: 14px 16px 14px 46px;
      color: var(--text-main); font-size: 1rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      transition: var(--transition); outline: none;
    }

    .form-input::placeholder { color: rgba(148, 163, 184, 0.5); }

    .form-input:focus {
      border-color: var(--primary-light);
      box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.15);
      background: rgba(15, 23, 42, 0.95);
    }

    .form-input.is-invalid { border-color: var(--error) !important; }

    .form-error {
      display: flex; align-items: center; gap: 6px;
      margin-top: 6px; font-size: 0.8rem; color: var(--error);
    }

    /* Password toggle */
    .pw-wrap .form-input { padding-right: 48px; }
    .btn-toggle-pw {
      position: absolute; top: 50%; right: 13px;
      transform: translateY(-50%);
      background: none; border: none; cursor: pointer;
      color: var(--text-muted); padding: 4px;
      display: flex; align-items: center; transition: color 0.2s;
      z-index: 3;
    }
    .btn-toggle-pw:hover { color: var(--primary-light); }
    .btn-toggle-pw svg { width: 17px; height: 17px; }

    /* Meta row */
    .form-row-meta {
      display: flex; justify-content: space-between; align-items: center;
      margin-bottom: 20px; flex-wrap: wrap; gap: 8px;
    }
    .check-wrap { display: flex; align-items: center; gap: 7px; cursor: pointer; }
    .check-wrap input[type="checkbox"] {
      width: 15px; height: 15px; accent-color: var(--primary); cursor: pointer;
    }
    .check-wrap label { font-size: 0.83rem; color: var(--text-muted); cursor: pointer; }
    .link-forgot {
      font-size: 0.83rem; color: var(--primary-light);
      text-decoration: none; transition: color 0.2s;
    }
    .link-forgot:hover { color: var(--gold); text-decoration: underline; }

    /* Submit button */
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
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 30px rgba(5, 150, 105, 0.5);
      background: linear-gradient(135deg, #10b981, var(--primary));
    }

    .btn-submit:active { transform: translateY(0); }
    .btn-submit:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

    .form-footer-note {
      text-align: center; margin-top: 16px;
      font-size: 0.83rem; color: var(--text-muted);
    }
    .form-footer-note a { color: var(--primary-light); text-decoration: none; font-weight: 600; }
    .form-footer-note a:hover { color: var(--gold); text-decoration: underline; }

    /* Spinner */
    .spinner {
      width: 17px; height: 17px;
      border: 2.5px solid rgba(255,255,255,0.3); border-top-color:#fff;
      border-radius: 50%; animation: spin 0.7s linear infinite; display: inline-block;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* Animations */
    @keyframes fadeSlideDown { from{opacity:0;transform:translateY(-10px)} to{opacity:1;transform:translateY(0)} }
    @keyframes fadeIn { from{opacity:0} to{opacity:1} }

    /* Responsive */
    @media (max-width: 1100px) {
      .hero-panel { flex:0 0 52%; padding:3rem; }
      .form-panel  { flex:0 0 48%; padding:3rem 2.5rem; }
    }
    @media (max-width: 860px) {
      .hero-panel { display: none; }
      .form-panel  { flex:1; padding:2rem 1.5rem; background:transparent; backdrop-filter:none; border-left:none; }
      .form-panel-inner { max-width:440px; }
    }
    @media (max-width: 480px) {
      .form-panel { padding: 1.5rem 1.25rem; }
    }
  </style>
</head>
<body>
  <div class="grid-bg"></div>
  <div class="islamic-pattern"></div>
  <div class="glow-orb glow-emerald"></div>
  <div class="glow-orb glow-gold"></div>

  <div class="split-wrap">

    {{-- KIRI: HERO PANEL --}}
    <div class="hero-panel">
      <div class="hero-divider" style="margin-bottom:12px"><span>✦</span></div>

      <div class="hero-school-icon">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
        </svg>
      </div>

      <div class="hero-title">Portal Layanan PTSP</div>
      <div class="hero-school-name">{{ $namaSekolah }}</div>
      <div class="hero-badge">Sistem Informasi Pelayanan</div>

      <div class="hero-section-divider"></div>

      <ul class="hero-features">
        <li>
          <span class="feat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
            </svg>
          </span>
          Keamanan login terjamin dengan CSRF protection
        </li>
        <li>
          <span class="feat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
            </svg>
          </span>
          Manajemen permohonan dan layanan siswa
        </li>
        <li>
          <span class="feat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
          </span>
          Pantau status permohonan secara real-time
        </li>
        <li>
          <span class="feat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
          </span>
          Export laporan dan administrasi layanan
        </li>
      </ul>

      <div class="hero-footer">&copy; {{ date('Y') }} {{ $namaSekolah }} &mdash; Sistem Pelayanan Terpadu Satu Pintu</div>
    </div>

    {{-- KANAN: FORM PANEL --}}
    <div class="form-panel">
      <div class="form-panel-inner">

        <div class="form-heading">Selamat datang</div>
        <p class="form-sub">Masuk ke panel administrasi untuk mengelola layanan dan permohonan PTSP.</p>

        @if(session('status'))
          <div class="alert-success">
            <i class="ti ti-circle-check"></i> {{ session('status') }}
          </div>
        @endif

        @if($errors->any())
          <div class="alert-error">
            <i class="ti ti-alert-circle"></i>
            <span>{{ $errors->first() }}</span>
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="formLogin">
          @csrf

          <div class="form-group">
            <label class="form-label" for="login-username">Username</label>
            <div class="input-wrapper">
              <i class="ti ti-user input-icon"></i>
              <input
                type="text"
                id="login-username"
                name="username"
                class="form-input{{ $errors->has('username') ? ' is-invalid' : '' }}"
                placeholder="Masukkan username"
                value="{{ old('username') }}"
                autofocus
                autocomplete="username"
                required
              />
            </div>
            @error('username')
              <div class="form-error"><i class="ti ti-alert-circle"></i> {{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label" for="login-password">Password</label>
            <div class="input-wrapper pw-wrap">
              <i class="ti ti-lock input-icon"></i>
              <input
                type="password"
                id="login-password"
                name="password"
                class="form-input{{ $errors->has('password') ? ' is-invalid' : '' }}"
                placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;"
                autocomplete="current-password"
                required
              />
              <button type="button" class="btn-toggle-pw" id="btnTogglePw" aria-label="Tampilkan / sembunyikan password">
                <svg id="iconEye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                </svg>
                <svg id="iconEyeOff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none">
                  <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>
                </svg>
              </button>
            </div>
            @error('password')
              <div class="form-error"><i class="ti ti-alert-circle"></i> {{ $message }}</div>
            @enderror
          </div>

          <div class="form-row-meta">
            <label class="check-wrap">
              <input type="checkbox" name="remember" id="remember-me" {{ old('remember') ? 'checked' : '' }} />
              <label for="remember-me">Ingat saya</label>
            </label>
            @if(Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="link-forgot">Lupa password?</a>
            @endif
          </div>

          <button type="submit" class="btn-submit" id="btnLogin">
            <i class="ti ti-login"></i> Masuk
          </button>
        </form>

        @if(Route::has('register'))
        <div class="form-footer-note">
          Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>
        @endif

      </div>
    </div>

  </div>{{-- end split-wrap --}}

  <script>
    (function () {
      const form      = document.getElementById('formLogin');
      const btn       = document.getElementById('btnLogin');
      const pwInput   = document.getElementById('login-password');
      const btnToggle = document.getElementById('btnTogglePw');
      const iconEye    = document.getElementById('iconEye');
      const iconEyeOff = document.getElementById('iconEyeOff');

      btnToggle.addEventListener('click', function () {
        const show = pwInput.type === 'password';
        pwInput.type             = show ? 'text'  : 'password';
        iconEye.style.display    = show ? 'none'  : 'block';
        iconEyeOff.style.display = show ? 'block' : 'none';
      });

      form.addEventListener('submit', function () {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner"></span> Memproses...';
      });
    })();
  </script>
</body>
</html>
