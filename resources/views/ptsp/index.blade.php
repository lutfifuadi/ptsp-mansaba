<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Portal Layanan PTSP - MAN 1 Kota Bandung</title>
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
      /* Emerald 600 */
      --primary-glow: rgba(5, 150, 105, 0.5);
      --primary-light: #34d399;
      /* Emerald 400 */
      --gold: #d4af37;
      --gold-glow: rgba(212, 175, 55, 0.4);
      --bg-dark: #0f172a;
      /* Slate 900 */
      --bg-darker: #020617;
      /* Slate 950 */
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
      min-height: 100vh;
      overflow-x: hidden;
      position: relative;
    }

    @media (min-width: 1025px) {
      body {
        height: 100vh;
        overflow-y: hidden;
      }

      .container {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-top: 20px;
        padding-bottom: 20px;
      }
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
      0% {
        background-position: 0 0;
      }

      100% {
        background-position: 0 50px;
      }
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
      0% {
        transform: translate(0, 0) scale(1);
      }

      100% {
        transform: translate(30px, 50px) scale(1.1);
      }
    }

    /* Islamic Geometric Pattern Overlay */
    .islamic-pattern {
      position: fixed;
      inset: 0;
      opacity: 0.03;
      z-index: -1;
      background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M30 30L15 15H0v15l15 15-15 15v15h15L30 45l15 15h15V45L45 30l15-15V0H45L30 15zM15 45L0 60v-15l15-15v15zM45 45l15 15V45L45 30v15zM15 15L0 0v15l15 15V15zM45 15l15-15v15L45 30V15z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 40px 24px;
      position: relative;
      z-index: 1;
    }

    /* Header Section */
    .header {
      text-align: center;
      margin-bottom: 60px;
      animation: fadeInDown 1s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .logo-container {
      margin-bottom: 24px;
      position: relative;
      display: inline-block;
    }

    .school-logo {
      width: 90px;
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

      0%,
      100% {
        transform: scale(1);
        opacity: 0.5;
      }

      50% {
        transform: scale(1.2);
        opacity: 0.8;
      }
    }

    .header h1 {
      font-size: 2.5rem;
      font-weight: 800;
      letter-spacing: -0.02em;
      margin-bottom: 12px;
      background: linear-gradient(135deg, #fff 30%, var(--primary-light) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .header h2 {
      font-family: 'Amiri', serif;
      font-size: 1.8rem;
      color: var(--gold);
      margin-bottom: 16px;
      font-weight: 400;
      opacity: 0.9;
    }

    .header p {
      color: var(--text-muted);
      font-size: 1.1rem;
      max-width: 600px;
      margin: 0 auto;
    }

    /* Actions */
    .hero-actions {
      margin-top: 32px;
      display: flex;
      justify-content: center;
      gap: 16px;
    }

    .btn-track {
      background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(212, 175, 55, 0.05));
      border: 1px solid var(--gold);
      color: var(--gold);
      padding: 12px 28px;
      border-radius: 4px;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: var(--transition);
      backdrop-filter: blur(10px);
      box-shadow: 0 0 20px rgba(212, 175, 55, 0.1);
    }

    .btn-track:hover {
      background: var(--gold);
      color: var(--bg-darker);
      box-shadow: 0 0 30px rgba(212, 175, 55, 0.4);
      transform: translateY(-2px);
    }

    /* Section Styles */
    .services-layout {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      align-items: start;
      overflow: hidden;
    }

    .services-section {
      animation: fadeInUp 1s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
    }

    .section-title {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
      margin-bottom: 32px;
    }

    .section-title h3 {
      font-size: 1.25rem;
      color: var(--text-main);
      text-transform: uppercase;
      letter-spacing: 2px;
      font-weight: 600;
    }

    .section-title::before,
    .section-title::after {
      content: '';
      height: 1px;
      width: 60px;
      background: linear-gradient(90deg, transparent, var(--primary-light), transparent);
    }

    /* Quick Menu Grid */
    .quick-menu-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
    }

    .menu-item {
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-radius: 4px;
      padding: 24px;
      text-decoration: none;
      color: var(--text-main);
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      gap: 16px;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      group: hover;
    }

    .menu-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 100%;
      background: linear-gradient(180deg, rgba(52, 211, 153, 0.1) 0%, transparent 100%);
      opacity: 0;
      transition: var(--transition);
    }

    .menu-item:hover {
      transform: translateY(-5px);
      border-color: var(--primary-light);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 20px var(--primary-glow);
    }

    .menu-item:hover::before {
      opacity: 1;
    }

    .icon-wrapper {
      width: 60px;
      height: 60px;
      border-radius: 4px;
      background: rgba(52, 211, 153, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary-light);
      font-size: 28px;
      position: relative;
      z-index: 1;
      transition: var(--transition);
      border: 1px solid rgba(52, 211, 153, 0.2);
    }

    .menu-item:hover .icon-wrapper {
      background: var(--primary-light);
      color: var(--bg-darker);
      transform: scale(1.1);
      box-shadow: 0 0 20px var(--primary-glow);
    }

    .menu-content {
      position: relative;
      z-index: 1;
    }

    .menu-content h4 {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .menu-content p {
      font-size: 0.85rem;
      color: var(--text-muted);
      line-height: 1.4;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    /* Footer */
    .footer {
      text-align: center;
      padding: 20px 0;
      color: var(--text-muted);
      font-size: 0.9rem;
      border-top: 1px solid rgba(255, 255, 255, 0.05);
      margin-top: 20px;
    }

    /* Animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Mobile Responsive */
    @media (max-width: 1024px) {
      .services-layout {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 768px) {
      .header h1 {
        font-size: 2rem;
      }

      .header h2 {
        font-size: 1.5rem;
      }

      .quick-menu-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 16px;
      }

      .menu-item {
        padding: 20px 16px;
        gap: 12px;
      }

      .icon-wrapper {
        width: 48px;
        height: 48px;
        font-size: 24px;
      }

      .menu-content h4 {
        font-size: 1rem;
      }

      .menu-content p {
        display: none;
        /* Hide desc on small mobile for compact grid */
      }
    }
  </style>
</head>

<body>
  <div class="grid-bg"></div>
  <div class="islamic-pattern"></div>
  <div class="glow-orb glow-emerald"></div>
  <div class="glow-orb glow-gold"></div>

  <div class="container">
    <header class="header">

      <h1>Portal Layanan Terpadu</h1>
      <p>Pelayanan Terpadu Satu Pintu (PTSP) MAN 1 Kota Bandung. Cepat.</p>

      <div class="hero-actions">
        <a href="{{ route('ptsp.tracking') }}" class="btn-track">
          <i class="ti ti-search"></i> Lacak Permohonan
        </a>
      </div>
    </header>

    <main class="services-layout">
      <!-- Layanan Umum -->
      <section class="services-section">
        <div class="section-title">
          <h3>Layanan Umum</h3>
        </div>
        <div class="quick-menu-grid">
          @foreach ($layananUmum as $l)
            @php
              $icon = 'ti-file-description';
              if ($l->nama_layanan == 'Buku Tamu Online') {
                  $icon = 'ti-book';
              } elseif ($l->nama_layanan == 'Pengambilan Ijazah') {
                  $icon = 'ti-certificate';
              }

              $url = route('ptsp.create', ['layanan_id' => $l->id]);
              if ($l->nama_layanan == 'Buku Tamu Online') {
                  $url = route('buku-tamu.index');
              } elseif ($l->nama_layanan == 'Pengambilan Ijazah') {
                  $url = route('ptsp.pengambilan-ijazah');
              } elseif ($l->external_url) {
                  $url = $l->external_url;
              }
            @endphp
            <a href="{{ $url }}" {!! $l->external_url ? 'target="_blank"' : '' !!} class="menu-item">
              <div class="icon-wrapper">
                <i class="ti {{ $icon }}"></i>
              </div>
              <div class="menu-content">
                <h4>{{ $l->nama_layanan }}</h4>
              </div>
            </a>
          @endforeach
        </div>
      </section>

      <!-- Layanan Siswa -->
      <section class="services-section" style="animation-delay: 0.4s;">
        <div class="section-title">
          <h3>Layanan Siswa</h3>
        </div>
        <div class="quick-menu-grid">
          @foreach ($layananSiswa as $l)
            @php
              $icon = 'ti-file-text';
              if (str_contains(strtolower($l->nama_layanan), 'legalisir')) {
                  $icon = 'ti-file-certificate';
              } elseif (str_contains(strtolower($l->nama_layanan), 'surat')) {
                  $icon = 'ti-mail';
              }

              $url = route('ptsp.create', ['layanan_id' => $l->id]);
              if (
                  str_contains(strtolower($l->nama_layanan), 'surat') ||
                  str_contains(strtolower($l->nama_layanan), 'legalisir')
              ) {
                  $url = route('ptsp.surat.cek-form');
              } elseif ($l->external_url) {
                  $url = $l->external_url;
              }
            @endphp
            <a href="{{ $url }}" {!! $l->external_url ? 'target="_blank"' : '' !!} class="menu-item">
              <div class="icon-wrapper">
                <i class="ti {{ $icon }}"></i>
              </div>
              <div class="menu-content">
                <h4>{{ $l->nama_layanan }}</h4>
              </div>
            </a>
          @endforeach
        </div>
      </section>
    </main>

    <footer class="footer">
      <p>&copy; {{ date('Y') }} MAN 1 KOTA BANDUNG. Dikelola oleh Tim IT.</p>
    </footer>
  </div>
</body>

</html>
