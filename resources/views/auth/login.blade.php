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
  <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"></noscript>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --green-deepest: #061410;
      --green-mid:     #155c30;
      --green-accent:  #1e8449;
      --green-bright:  #27ae60;
      --green-glow:    #2ecc71;
      --gold:          #c9a84c;
      --gold-light:    #f0d080;
      --white:         #ffffff;
      --text-muted:    rgba(255,255,255,0.55);
    }

    html, body { height: 100%; overflow: hidden; }

    body {
      font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      background-color: var(--green-deepest);
      height: 100vh; overflow: hidden;
      display: flex; flex-direction: column;
    }

    /* ── Background ──────────────────────────────────────── */
    .bg-layer {
      position: fixed; inset: 0;
      background: radial-gradient(ellipse at 20% 30%, #0f3d20 0%, transparent 55%),
                  radial-gradient(ellipse at 80% 70%, #0b2e18 0%, transparent 55%),
                  linear-gradient(160deg, #061410 0%, #0d2b18 50%, #061410 100%);
      animation: bgPulse 8s ease-in-out infinite alternate;
      z-index: 0;
    }
    @keyframes bgPulse { 0% { filter:brightness(1); } 100% { filter:brightness(1.12); } }

    .bg-pattern {
      position: fixed; inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cg fill='none' stroke='rgba(46,204,113,0.10)' stroke-width='0.6'%3E%3Cpolygon points='40,4 44.6,18 59,12 50,26 65,32 50,36 59,50 44.6,44 40,58 35.4,44 21,50 30,36 15,32 30,26 21,12 35.4,18'/%3E%3Crect x='28' y='28' width='24' height='24' transform='rotate(45 40 40)'/%3E%3Ccircle cx='40' cy='40' r='10'/%3E%3C/g%3E%3C/svg%3E");
      background-size: 80px 80px;
      z-index: 1; pointer-events: none;
    }
    .orb { position: fixed; border-radius: 50%; filter: blur(60px); z-index: 1; pointer-events: none; }
    .orb-1 {
      width: 380px; height: 380px;
      background: radial-gradient(circle, rgba(30,132,73,0.2) 0%, transparent 70%);
      top: -80px; left: -80px;
      animation: orbFloat1 12s ease-in-out infinite;
    }
    .orb-2 {
      width: 300px; height: 300px;
      background: radial-gradient(circle, rgba(201,168,76,0.12) 0%, transparent 70%);
      bottom: -60px; right: -60px;
      animation: orbFloat2 14s ease-in-out infinite;
    }
    @keyframes orbFloat1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(40px,30px)} }
    @keyframes orbFloat2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-30px,-40px)} }

    /* ── Split layout ────────────────────────────────────── */
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
      background: linear-gradient(to bottom, transparent, rgba(46,204,113,0.2), transparent);
    }

    .hero-bismillah {
      font-family: 'Amiri', Georgia, Cambria, "Times New Roman", Times, serif; font-size: 1.8rem;
      color: var(--gold); margin-bottom: 12px;
      text-shadow: 0 0 24px rgba(201,168,76,0.45);
      animation: fadeSlideDown 0.6s 0.1s ease both;
    }
    .hero-divider {
      display: flex; align-items: center; gap: 10px;
      margin-bottom: 32px;
      animation: fadeSlideDown 0.6s 0.15s ease both;
    }
    .hero-divider::before { content:''; flex:0 0 60px; height:1px; background:linear-gradient(to right, transparent, rgba(201,168,76,0.4)); }
    .hero-divider::after  { content:''; flex:0 0 60px; height:1px; background:linear-gradient(to left,  transparent, rgba(201,168,76,0.4)); }
    .hero-divider span { color: var(--gold); font-size: 1rem; }

    .hero-school-icon {
      width: 72px; height: 72px;
      background: linear-gradient(135deg, var(--green-mid), var(--green-accent));
      border-radius: 18px;
      display: inline-flex; align-items: center; justify-content: center;
      margin-bottom: 20px;
      box-shadow: 0 8px 28px rgba(30,132,73,0.4), 0 0 0 1px rgba(46,204,113,0.2);
      animation: fadeSlideDown 0.6s 0.2s ease both;
    }
    .hero-school-icon svg { width: 36px; height: 36px; fill: var(--white); }

    .hero-title {
      font-family: 'Amiri', Georgia, Cambria, "Times New Roman", Times, serif;
      font-size: clamp(2rem, 2.8vw, 2.8rem);
      font-weight: 700; line-height: 1.1;
      letter-spacing: 2px; text-transform: uppercase;
      background: linear-gradient(135deg, #ffffff 30%, var(--green-glow) 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
      margin-bottom: 6px;
      animation: fadeSlideDown 0.6s 0.25s ease both;
    }
    .hero-school-name {
      font-size: 0.92rem; font-weight: 600;
      text-transform: uppercase; letter-spacing: 0.15em;
      color: var(--green-glow); margin-bottom: 8px;
      animation: fadeSlideDown 0.6s 0.3s ease both;
    }
    .hero-badge {
      display: inline-block;
      background: rgba(46,204,113,0.1); border: 1px solid rgba(46,204,113,0.25);
      border-radius: 20px; padding: 3px 14px;
      font-size: 0.74rem; color: var(--green-glow);
      letter-spacing: 0.08em; margin-bottom: 28px;
      animation: fadeSlideDown 0.6s 0.32s ease both;
    }
    .hero-section-divider {
      height: 1px;
      background: linear-gradient(to right, rgba(46,204,113,0.25), transparent);
      margin-bottom: 28px;
      animation: fadeSlideDown 0.6s 0.35s ease both;
    }

    .hero-features { list-style: none; padding: 0; animation: fadeSlideDown 0.6s 0.4s ease both; }
    .hero-features li {
      display: flex; align-items: center; gap: 12px;
      margin-bottom: 14px;
      color: rgba(255,255,255,0.82); font-size: 0.9rem; font-weight: 500;
    }
    .feat-icon {
      width: 32px; height: 32px; flex-shrink: 0;
      background: rgba(46,204,113,0.12); border: 1px solid rgba(46,204,113,0.25);
      border-radius: 8px;
      display: inline-flex; align-items: center; justify-content: center;
    }
    .feat-icon svg { width: 15px; height: 15px; color: var(--green-glow); }

    .hero-footer {
      margin-top: 32px; font-size: 0.72rem;
      color: rgba(255,255,255,0.2);
      animation: fadeIn 1s 1.2s ease both;
    }

    /* RIGHT: form panel */
    .form-panel {
      flex: 0 0 42%;
      display: flex; flex-direction: column; justify-content: center;
      padding: 3rem 3.5rem;
      background: rgba(6, 20, 16, 0.55);
      backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
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
      font-family: 'Amiri', Georgia, Cambria, "Times New Roman", Times, serif; font-size: 1.7rem; font-weight: 700;
      color: var(--white); margin-bottom: 4px;
    }
    .form-sub {
      font-size: 0.875rem; color: var(--text-muted);
      margin-bottom: 24px; line-height: 1.5;
    }

    /* Alerts */
    .alert-error {
      background: rgba(231,76,60,0.12); border: 1px solid rgba(231,76,60,0.3);
      border-radius: 4px; padding: 11px 14px;
      display: flex; align-items: flex-start; gap: 10px; margin-bottom: 18px;
    }
    .alert-error svg { flex-shrink:0; color:#e74c3c; margin-top:1px; }
    .alert-error span { font-size:0.84rem; color:#ff8a80; line-height:1.4; }
    .alert-success {
      background: rgba(39,174,96,0.12); border: 1px solid rgba(39,174,96,0.3);
      border-radius: 4px; padding: 11px 14px;
      margin-bottom: 18px; font-size: 0.84rem; color: var(--green-glow);
    }

    /* Form fields */
    .form-group { margin-bottom: 18px; }
    .form-label {
      display: block; font-size: 0.8rem; font-weight: 600;
      color: rgba(255,255,255,0.75); margin-bottom: 7px;
      letter-spacing: 0.4px; text-transform: uppercase;
    }
    .form-input {
      width: 100%;
      background: rgba(6,20,16,0.75); border: 1.5px solid rgba(46,204,113,0.18);
      border-radius: 4px; padding: 13px 16px;
      font-size: 0.95rem; font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      color: var(--white);
      transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
      outline: none; -webkit-appearance: none;
    }
    .form-input::placeholder { color: rgba(255,255,255,0.22); font-size: 0.88rem; }
    .form-input:focus {
      border-color: var(--green-bright);
      background: rgba(6,20,16,0.92);
      box-shadow: 0 0 0 3px rgba(39,174,96,0.15), 0 0 18px rgba(39,174,96,0.07);
    }
    .form-input.is-invalid { border-color: rgba(231,76,60,0.55); }
    .form-error { font-size: 0.77rem; color: #ff8a80; margin-top: 5px; }

    /* Password toggle */
    .pw-wrap { position: relative; }
    .pw-wrap .form-input { padding-right: 48px; }
    .btn-toggle-pw {
      position: absolute; top: 50%; right: 13px;
      transform: translateY(-50%);
      background: none; border: none; cursor: pointer;
      color: var(--text-muted); padding: 4px;
      display: flex; align-items: center; transition: color 0.2s;
    }
    .btn-toggle-pw:hover { color: var(--green-glow); }
    .btn-toggle-pw svg { width: 17px; height: 17px; }

    /* Meta row */
    .form-row-meta {
      display: flex; justify-content: space-between; align-items: center;
      margin-bottom: 20px; flex-wrap: wrap; gap: 8px;
    }
    .check-wrap { display: flex; align-items: center; gap: 7px; cursor: pointer; }
    .check-wrap input[type="checkbox"] {
      width: 15px; height: 15px; accent-color: var(--green-bright); cursor: pointer;
    }
    .check-wrap label { font-size: 0.83rem; color: rgba(255,255,255,0.6); cursor: pointer; }
    .link-forgot {
      font-size: 0.83rem; color: var(--green-glow);
      text-decoration: none; transition: color 0.2s;
    }
    .link-forgot:hover { color: var(--gold-light); text-decoration: underline; }

    /* Submit button */
    .btn-submit {
      width: 100%; padding: 14px 24px;
      background: linear-gradient(135deg, var(--green-accent) 0%, var(--green-bright) 100%);
      border: none; border-radius: 4px;
      color: var(--white); font-size: 0.93rem; font-weight: 600;
      font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 8px;
      transition: transform 0.2s, box-shadow 0.2s, filter 0.2s;
      box-shadow: 0 6px 20px rgba(39,174,96,0.35);
      position: relative; overflow: hidden;
    }
    .btn-submit::after {
      content: ''; position: absolute; inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, transparent 60%);
      border-radius: inherit; pointer-events: none;
    }
    .btn-submit:hover:not(:disabled) {
      transform: translateY(-2px);
      box-shadow: 0 10px 32px rgba(39,174,96,0.5); filter: brightness(1.08);
    }
    .btn-submit:active:not(:disabled) { transform:translateY(0); box-shadow:0 4px 12px rgba(39,174,96,0.3); }
    .btn-submit:disabled { opacity:0.7; cursor:not-allowed; }
    .btn-submit svg { width:17px; height:17px; flex-shrink:0; }

    .form-footer-note {
      text-align: center; margin-top: 16px;
      font-size: 0.83rem; color: var(--text-muted);
    }
    .form-footer-note a { color: var(--green-glow); text-decoration: none; font-weight: 600; }
    .form-footer-note a:hover { color: var(--gold-light); text-decoration: underline; }

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
      .form-panel  { flex:1; padding:2rem 1.5rem; background:transparent; overflow-y: auto; }
      .form-panel-inner { max-width:440px; }
    }
    @media (max-width: 480px) {
      .form-panel { padding: 1.5rem 1.25rem; }
    }
  </style>
</head>
<body>
  <div class="bg-layer"></div>
  <div class="bg-pattern"></div>
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>

  <div class="split-wrap">

    {{-- ═══ KIRI: HERO PANEL ═══ --}}
    <div class="hero-panel">
      <div class="hero-bismillah">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</div>
      <div class="hero-divider"><span>✦</span></div>

      <div class="hero-school-icon">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
        </svg>
      </div>

      <div class="hero-title">Pengumuman Kelulusan</div>
      <div class="hero-school-name">{{ $namaSekolah }}</div>
      <div class="hero-badge">Tahun Ajaran {{ $tahunAjaran }}</div>

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
          Manajemen data siswa dan pengaturan kelulusan
        </li>
        <li>
          <span class="feat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
          </span>
          Pantau status kelulusan secara real-time
        </li>
        <li>
          <span class="feat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
          </span>
          Export sertifikat dan laporan PDF
        </li>
      </ul>

      <div class="hero-footer">&copy; {{ date('Y') }} {{ $namaSekolah }} &mdash; Sistem Pengumuman Kelulusan</div>
    </div>

    {{-- ═══ KANAN: FORM PANEL ═══ --}}
    <div class="form-panel">
      <div class="form-panel-inner">

        <div class="form-heading">Selamat datang</div>
        <p class="form-sub">Masuk ke panel administrasi untuk mengelola data kelulusan siswa.</p>

        @if(session('status'))
          <div class="alert-success">{{ session('status') }}</div>
        @endif

        @if($errors->any())
          <div class="alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>{{ $errors->first() }}</span>
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="formLogin">
          @csrf

          <div class="form-group">
            <label class="form-label" for="login-username">Username</label>
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
            @error('username')
              <div class="form-error">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label" for="login-password">Password</label>
            <div class="pw-wrap">
              <input
                type="password"
                id="login-password"
                name="password"
                class="form-input{{ $errors->has('password') ? ' is-invalid' : '' }}"
                placeholder="••••••••••••"
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
              <div class="form-error">{{ $message }}</div>
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
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
            </svg>
            Masuk
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