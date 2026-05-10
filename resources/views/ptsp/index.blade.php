<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Portal Layanan PTSP - MAN 1 Kota Bandung</title>
  <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::get('logo_kanan') ?: asset('assets/img/favicon/favicon.ico') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
  <style>
    :root {
      --primary: #2ecc71;
      --primary-dark: #27ae60;
      --primary-glow: rgba(46, 204, 113, 0.4);
      --bg-dark: #061410;
      --bg-card: rgba(255, 255, 255, 0.03);
      --border-light: rgba(255, 255, 255, 0.08);
      --text-main: #ffffff;
      --text-muted: rgba(255, 255, 255, 0.6);
      --gold: #c9a84c;
      --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg-dark);
      color: var(--text-main);
      overflow: hidden; /* No scroll body */
      height: 100vh;
      width: 100vw;
    }

    /* Background Elements */
    .bg-blobs {
      position: fixed;
      inset: 0;
      z-index: -1;
      overflow: hidden;
    }
    .blob {
      position: absolute;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, var(--primary-glow) 0%, transparent 70%);
      filter: blur(80px);
      border-radius: 50%;
      opacity: 0.5;
    }
    .blob-1 { top: -200px; left: -100px; }
    .blob-2 { bottom: -200px; right: -100px; }

    .main-layout {
      display: flex;
      height: 100vh;
      width: 100vw;
    }

    /* Left Panel: Brand & Info */
    .brand-panel {
      flex: 0 0 40%;
      padding: 60px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      border-right: 1px solid var(--border-light);
      background: rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(10px);
    }

    .brand-header {
      animation: fadeInDown 0.8s ease-out;
    }

    .school-logo {
      width: 80px;
      height: auto;
      margin-bottom: 24px;
      filter: drop-shadow(0 0 20px var(--primary-glow));
    }

    .brand-header h1 {
      font-size: 3rem;
      font-weight: 800;
      line-height: 1.1;
      margin-bottom: 16px;
      background: linear-gradient(135deg, #fff 40%, var(--primary) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .brand-header p {
      font-size: 1.1rem;
      color: var(--text-muted);
      line-height: 1.6;
      max-width: 90%;
    }

    .brand-actions {
      margin-top: 40px;
      display: flex;
      flex-direction: column;
      gap: 16px;
      animation: fadeInUp 0.8s ease-out 0.2s both;
    }

    .btn-main {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      padding: 16px 32px;
      border-radius: 12px;
      font-weight: 700;
      text-decoration: none;
      transition: var(--transition);
      cursor: pointer;
    }

    .btn-track {
      background: var(--primary);
      color: #000;
      box-shadow: 0 8px 24px var(--primary-glow);
    }
    .btn-track:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 32px var(--primary-glow);
      background: var(--text-main);
    }

    .brand-footer {
      font-size: 0.85rem;
      color: rgba(255,255,255,0.2);
      animation: fadeIn 1s ease-out 0.5s both;
    }

    /* Right Panel: Services Grid */
    .services-panel {
      flex: 1;
      padding: 60px;
      overflow-y: auto; /* Internal scroll */
      scrollbar-width: thin;
      scrollbar-color: var(--primary) transparent;
    }
    .services-panel::-webkit-scrollbar { width: 6px; }
    .services-panel::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 10px; }

    .panel-content {
      max-width: 800px;
      margin: 0 auto;
    }

    .section {
      margin-bottom: 60px;
      animation: fadeIn 0.8s ease-out 0.4s both;
    }

    .section-head {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 32px;
    }
    .section-head h2 {
      font-size: 1.25rem;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: var(--gold);
      white-space: nowrap;
    }
    .section-head .divider {
      height: 1px;
      flex: 1;
      background: linear-gradient(90deg, var(--gold), transparent);
    }

    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 20px;
    }

    .service-item {
      background: var(--bg-card);
      border: 1px solid var(--border-light);
      padding: 30px;
      border-radius: 16px;
      transition: var(--transition);
      display: flex;
      flex-direction: column;
      gap: 16px;
      position: relative;
      overflow: hidden;
    }
    .service-item::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, var(--primary-glow), transparent 40%);
      opacity: 0;
      transition: var(--transition);
    }

    .service-item:hover {
      transform: translateY(-8px);
      border-color: var(--primary);
      background: rgba(255, 255, 255, 0.05);
    }
    .service-item:hover::before {
      opacity: 1;
    }

    .service-icon-box {
      width: 48px;
      height: 48px;
      background: rgba(46, 204, 113, 0.1);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary);
      font-size: 1.5rem;
      position: relative;
      z-index: 1;
    }

    .service-info {
      position: relative;
      z-index: 1;
    }
    .service-info h3 {
      font-size: 1.25rem;
      margin-bottom: 8px;
    }
    .service-info p {
      font-size: 0.95rem;
      color: var(--text-muted);
      line-height: 1.5;
    }

    .service-action {
      margin-top: auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: relative;
      z-index: 1;
    }

    .btn-apply-small {
      color: var(--primary);
      text-decoration: none;
      font-weight: 700;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: var(--transition);
    }
    .btn-apply-small:hover {
      gap: 10px;
      color: #fff;
    }

    .req-tag {
      font-size: 0.75rem;
      color: var(--gold);
      border: 1px solid var(--gold);
      padding: 2px 8px;
      border-radius: 4px;
      cursor: help;
    }

    /* Animations */
    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    /* Mobile Responsive */
    @media (max-width: 1024px) {
      body { overflow: auto; height: auto; }
      .main-layout { flex-direction: column; height: auto; }
      .brand-panel { flex: none; width: 100%; border-right: none; border-bottom: 1px solid var(--border-light); padding: 40px 20px; }
      .brand-header h1 { font-size: 2.2rem; }
      .services-panel { padding: 40px 20px; }
      .grid-container { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>
  <div class="bg-blobs">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
  </div>

  <main class="main-layout">
    <!-- Left Panel -->
    <aside class="brand-panel">
      <div class="brand-top">
        @php
          $schoolLogo = \App\Models\Pengaturan::get('logo_kanan');
          if ($schoolLogo && !str_starts_with($schoolLogo, 'http')) {
            $schoolLogo = \Illuminate\Support\Facades\Storage::url($schoolLogo);
          }
        @endphp
        <img src="{{ $schoolLogo ?: asset('assets/images/logo.png') }}" alt="Logo" class="school-logo">
        <div class="brand-header">
          <h1>Portal Layanan<br>PTSP MAN 1</h1>
          <p>Pelayanan Terpadu Satu Pintu. Cepat, Transparan, dan Tanpa Pungutan Liar.</p>
        </div>
        
        <div class="brand-actions">
          <a href="{{ route('ptsp.tracking') }}" class="btn-main btn-track">
            <i class="bx bx-search-alt-2"></i> Lacak Permohonan
          </a>
        </div>
      </div>

      <footer class="brand-footer">
        &copy; {{ date('Y') }} MAN 1 KOTA BANDUNG<br>
        Dikelola oleh Tim IT PTSP
      </footer>
    </aside>

    <!-- Right Panel -->
    <section class="services-panel">
      <div class="panel-content">
        
        <!-- Layanan Umum -->
        <div class="section">
          <div class="section-head">
            <h2>Layanan Umum</h2>
            <div class="divider"></div>
          </div>
          
          <div class="grid-container">
            @foreach($layananUmum as $l)
            <div class="service-item">
              <div class="service-icon-box">
                <i class="bx {{ $l->nama_layanan == 'Buku Tamu Online' ? 'bx-book-open' : ($l->nama_layanan == 'Pengambilan Ijazah' ? 'bx-download' : 'bx-id-card') }}"></i>
              </div>
              <div class="service-info">
                <h3>{{ $l->nama_layanan }}</h3>
                <p>{{ $l->deskripsi }}</p>
              </div>
              <div class="service-action">
                @if($l->persyaratan)
                <span class="req-tag" title="{{ $l->persyaratan }}">Persyaratan</span>
                @else
                <span></span>
                @endif

                @if($l->nama_layanan == 'Buku Tamu Online')
                <a href="{{ route('buku-tamu.index') }}" class="btn-apply-small">
                  Buka Form <i class="bx bx-book-open"></i>
                </a>
                @elseif($l->nama_layanan == 'Pengambilan Ijazah')
                <a href="{{ route('ptsp.pengambilan-ijazah') }}" class="btn-apply-small">
                  Buka Form <i class="bx bx-download"></i>
                </a>
                @elseif($l->external_url)
                <a href="{{ $l->external_url }}" target="_blank" class="btn-apply-small">
                  Buka Form <i class="bx bx-link-external"></i>
                </a>
                @else
                <a href="{{ route('ptsp.create', ['layanan_id' => $l->id]) }}" class="btn-apply-small">
                  Pilih Layanan <i class="bx bx-right-arrow-alt"></i>
                </a>
                @endif
              </div>
            </div>
            @endforeach
          </div>
        </div>

        <!-- Layanan Siswa -->
        <div class="section">
          <div class="section-head">
            <h2>Layanan Siswa</h2>
            <div class="divider"></div>
          </div>
          
          <div class="grid-container">
            @foreach($layananSiswa as $l)
            <div class="service-item">
              <div class="service-icon-box">
                <i class="bx {{ str_contains(strtolower($l->nama_layanan), 'legalisir') ? 'bx-certification' : 'bx-file-blank' }}"></i>
              </div>
              <div class="service-info">
                <h3>{{ $l->nama_layanan }}</h3>
                <p>{{ $l->deskripsi }}</p>
              </div>
              <div class="service-action">
                @if($l->persyaratan)
                <span class="req-tag" title="{{ $l->persyaratan }}">Persyaratan</span>
                @else
                <span></span>
                @endif

                @if(str_contains(strtolower($l->nama_layanan), 'surat') || str_contains(strtolower($l->nama_layanan), 'legalisir'))
                <a href="{{ route('ptsp.surat.cek-form') }}" class="btn-apply-small">
                  Ajukan Surat <i class="bx bx-right-arrow-alt"></i>
                </a>
                @elseif($l->external_url)
                <a href="{{ $l->external_url }}" target="_blank" class="btn-apply-small">
                  Buka Form <i class="bx bx-link-external"></i>
                </a>
                @else
                <a href="{{ route('ptsp.create', ['layanan_id' => $l->id]) }}" class="btn-apply-small">
                  Pilih Layanan <i class="bx bx-right-arrow-alt"></i>
                </a>
                @endif
              </div>
            </div>
            @endforeach
          </div>

        </div>

      </div>
    </section>
  </main>
</body>
</html>
