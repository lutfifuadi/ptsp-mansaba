<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lacak Permohonan - PTSP MAN 1 Kota Bandung</title>
  <link rel="icon" type="image/png"
    href="{{ \App\Models\Pengaturan::get('logo_kanan') ?: asset('assets/img/favicon/favicon.ico') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap"
    rel="stylesheet">
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
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg-darker);
      color: var(--text-main);
      height: 100vh;
      overflow: hidden;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Animated Grid Background */
    .grid-bg {
      position: fixed;
      inset: 0;
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

    /* Ambient Glows */
    .glow-orb {
      position: fixed;
      border-radius: 50%;
      filter: blur(100px);
      z-index: -1;
      opacity: 0.4;
      animation: float 10s ease-in-out infinite alternate;
    }

    .glow-emerald {
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, var(--primary) 0%, transparent 70%);
      top: -100px;
      left: -100px;
    }

    .glow-gold {
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, var(--gold) 0%, transparent 70%);
      bottom: -150px;
      right: -100px;
      animation-delay: -5s;
    }

    @keyframes float {
      0% { transform: translate(0, 0) scale(1); }
      100% { transform: translate(30px, 50px) scale(1.1); }
    }

    /* Islamic Geometric Pattern Overlay */
    .islamic-pattern {
      position: fixed;
      inset: 0;
      opacity: 0.03;
      z-index: -1;
      background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M30 30L15 15H0v15l15 15-15 15v15h15L30 45l15 15h15V45L45 30l15-15V0H45L30 15zM15 45L0 60v-15l15-15v15zM45 45l15 15V45L45 30v15zM15 15L0 0v15l15 15V15zM45 15l15-15v15L45 30V15z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    /* Page Wrapper */
    .page-wrapper {
      width: 100%;
      max-width: 560px;
      margin: 0 auto;
      padding: 40px 24px;
      position: relative;
      z-index: 1;
      animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Header */
    .header {
      text-align: center;
      margin-bottom: 40px;
      animation: fadeInDown 1s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .logo-container {
      margin-bottom: 20px;
      position: relative;
      display: inline-block;
    }

    .school-logo {
      width: 80px;
      height: auto;
      position: relative;
      z-index: 2;
      filter: drop-shadow(0 0 15px rgba(255, 255, 255, 0.2));
    }

    .logo-glow {
      position: absolute;
      inset: -10px;
      background: var(--primary-glow);
      border-radius: 50%;
      filter: blur(15px);
      z-index: 1;
      animation: pulseGlow 3s infinite;
    }

    @keyframes pulseGlow {
      0%, 100% { transform: scale(1); opacity: 0.5; }
      50% { transform: scale(1.2); opacity: 0.8; }
    }

    .header h2 {
      font-family: 'Amiri', serif;
      font-size: 1.6rem;
      color: var(--gold);
      margin-bottom: 12px;
      font-weight: 400;
      opacity: 0.9;
    }

    .header h1 {
      font-size: 2rem;
      font-weight: 800;
      letter-spacing: -0.02em;
      margin-bottom: 8px;
      background: linear-gradient(135deg, #fff 30%, var(--primary-light) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .header p {
      color: var(--text-muted);
      font-size: 1rem;
    }

    /* Tracking Card */
    .tracking-card {
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-radius: 4px;
      padding: 40px 36px;
      position: relative;
      overflow: hidden;
    }

    .tracking-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--primary-light), var(--gold), transparent);
      opacity: 0.7;
    }

    .card-icon {
      width: 72px;
      height: 72px;
      border-radius: 4px;
      background: rgba(52, 211, 153, 0.1);
      border: 1px solid rgba(52, 211, 153, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary-light);
      font-size: 36px;
      margin: 0 auto 24px;
      animation: pulseGlow 3s infinite;
    }

    .card-title {
      font-size: 1.4rem;
      font-weight: 700;
      text-align: center;
      margin-bottom: 8px;
      color: var(--text-main);
    }

    .card-subtitle {
      font-size: 0.9rem;
      color: var(--text-muted);
      text-align: center;
      margin-bottom: 28px;
      line-height: 1.5;
    }

    /* Alert Error */
    .alert-error {
      background: rgba(239, 68, 68, 0.1);
      border: 1px solid rgba(239, 68, 68, 0.3);
      color: #fca5a5;
      border-radius: 4px;
      padding: 12px 16px;
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 0.9rem;
    }

    /* Form */
    .form-group {
      margin-bottom: 20px;
    }

    .form-label {
      display: block;
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--text-muted);
      margin-bottom: 8px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--primary-light);
      font-size: 20px;
      pointer-events: none;
    }

    .form-input {
      width: 100%;
      background: rgba(15, 23, 42, 0.8);
      border: 1px solid var(--glass-border);
      border-radius: 4px;
      padding: 14px 16px 14px 46px;
      color: var(--text-main);
      font-size: 1rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      transition: var(--transition);
      outline: none;
    }

    .form-input::placeholder {
      color: rgba(148, 163, 184, 0.5);
    }

    .form-input:focus {
      border-color: var(--primary-light);
      box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.15);
      background: rgba(15, 23, 42, 0.95);
    }

    /* Submit Button */
    .btn-submit {
      width: 100%;
      background: linear-gradient(135deg, var(--primary), #047857);
      border: 1px solid var(--primary-light);
      color: #fff;
      padding: 14px 28px;
      border-radius: 4px;
      font-weight: 700;
      font-size: 1rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
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

    .btn-submit:active {
      transform: translateY(0);
    }

    /* Back Link */
    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: var(--gold);
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 500;
      margin-top: 24px;
      transition: var(--transition);
      justify-content: center;
      width: 100%;
      border: 1px solid rgba(212, 175, 55, 0.2);
      padding: 10px 20px;
      border-radius: 4px;
      background: rgba(212, 175, 55, 0.05);
      backdrop-filter: blur(10px);
    }

    .back-link:hover {
      color: var(--bg-darker);
      background: var(--gold);
      border-color: var(--gold);
      box-shadow: 0 0 20px var(--gold-glow);
      transform: translateY(-1px);
    }

    /* Divider */
    .divider {
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--glass-border), transparent);
      margin: 24px 0;
    }

    /* Footer */
    .footer {
      text-align: center;
      margin-top: 32px;
      color: var(--text-muted);
      font-size: 0.8rem;
    }

    /* Animations */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Mobile */
    @media (max-width: 480px) {
      .tracking-card {
        padding: 28px 20px;
      }

      .header h1 {
        font-size: 1.6rem;
      }

      .header h2 {
        font-size: 1.3rem;
      }
    }
  </style>
</head>

<body>
  <div class="grid-bg"></div>
  <div class="islamic-pattern"></div>
  <div class="glow-orb glow-emerald"></div>
  <div class="glow-orb glow-gold"></div>

  <div class="page-wrapper">
    <!-- Header dihapus sesuai permintaan -->


    <!-- Tracking Card -->
    <div class="tracking-card">
      <div class="card-icon">
        <i class="ti ti-search"></i>
      </div>

      <h3 class="card-title">Cek Status Permohonan</h3>
      <p class="card-subtitle">Masukkan nomor tiket permohonan yang Anda terima melalui email atau sistem.</p>

      @if(session('error'))
        <div class="alert-error">
          <i class="ti ti-alert-circle"></i>
          {{ session('error') }}
        </div>
      @endif

      <form action="{{ route('ptsp.track') }}" method="POST" id="form-tracking">
        @csrf
        <div class="form-group">
          <label class="form-label" for="no_tiket">Nomor Tiket</label>
          <div class="input-wrapper">
            <i class="ti ti-hash input-icon"></i>
            <input
              type="text"
              id="no_tiket"
              name="no_tiket"
              class="form-input"
              placeholder="Contoh: PTSP-A1B2C3D4"
              required
              autocomplete="off"
            />
          </div>
        </div>

        <button type="submit" class="btn-submit" id="btn-cek-status">
          <i class="ti ti-search"></i>
          Cek Status Sekarang
        </button>
      </form>

      <div class="divider"></div>

      <a href="{{ route('ptsp.index') }}" class="back-link" id="btn-kembali-portal">
        <i class="ti ti-arrow-left"></i>
        Kembali ke Portal Layanan
      </a>
    </div>

    <!-- Footer -->
    <footer class="footer">
      <p>&copy; {{ date('Y') }} MAN 1 KOTA BANDUNG. Dikelola oleh Tim IT.</p>
    </footer>
  </div>
</body>

</html>
