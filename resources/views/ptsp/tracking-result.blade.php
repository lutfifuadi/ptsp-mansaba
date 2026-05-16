<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Hasil Pelacakan - PTSP MAN 1 Kota Bandung</title>
  <link rel="icon" type="image/png" sizes="32x32" href="{{ \App\Models\Pengaturan::get('logo_kanan') ?: asset('assets/img/favicon/favicon-32x32.png') }}" />
  <link rel="icon" type="image/png" sizes="16x16" href="{{ \App\Models\Pengaturan::get('logo_kanan') ?: asset('assets/img/favicon/favicon-16x16.png') }}" />
  <link rel="icon" type="image/x-icon" href="{{ \App\Models\Pengaturan::get('logo_kanan') ?: asset('favicon.ico') }}" />
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
      
      --status-pending: #f59e0b;
      --status-proses: #3b82f6;
      --status-selesai: #10b981;
      --status-ditolak: #ef4444;
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
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }

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

    .islamic-pattern {
      position: fixed;
      inset: 0;
      opacity: 0.03;
      z-index: -1;
      background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M30 30L15 15H0v15l15 15-15 15v15h15L30 45l15 15h15V45L45 30l15-15V0H45L30 15zM15 45L0 60v-15l15-15v15zM45 45l15 15V45L45 30v15zM15 15L0 0v15l15 15V15zM45 15l15-15v15L45 30V15z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .page-wrapper {
      width: 100%;
      max-width: 650px;
      margin: 0 auto;
      position: relative;
      z-index: 1;
      animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .result-card {
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-radius: 4px;
      padding: 40px;
      position: relative;
      overflow: hidden;
    }

    .result-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, var(--primary-light), var(--gold));
    }

    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 16px;
      border-radius: 4px;
      font-weight: 700;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 24px;
    }

    .status-pending { background: rgba(245, 158, 11, 0.1); color: var(--status-pending); border: 1px solid rgba(245, 158, 11, 0.2); }
    .status-proses { background: rgba(59, 130, 246, 0.1); color: var(--status-proses); border: 1px solid rgba(59, 130, 246, 0.2); }
    .status-selesai { background: rgba(16, 185, 129, 0.1); color: var(--status-selesai); border: 1px solid rgba(16, 185, 129, 0.2); }
    .status-ditolak { background: rgba(239, 68, 68, 0.1); color: var(--status-ditolak); border: 1px solid rgba(239, 68, 68, 0.2); }

    .header-info {
      margin-bottom: 32px;
    }

    .header-info h1 {
      font-size: 1.8rem;
      font-weight: 800;
      margin-bottom: 8px;
      background: linear-gradient(135deg, #fff 30%, var(--primary-light) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .header-info p {
      color: var(--text-muted);
      font-size: 1rem;
    }

    .info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 24px;
      margin-bottom: 32px;
    }

    .info-item {
      background: rgba(15, 23, 42, 0.4);
      padding: 16px;
      border-radius: 4px;
      border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .info-label {
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 6px;
    }

    .info-value {
      font-size: 1rem;
      font-weight: 700;
      color: var(--text-main);
    }

    .detail-section {
      margin-top: 32px;
      padding-top: 24px;
      border-top: 1px solid var(--glass-border);
    }

    .detail-title {
      font-size: 1.1rem;
      font-weight: 700;
      margin-bottom: 16px;
      color: var(--gold);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .admin-note {
      background: rgba(212, 175, 55, 0.05);
      border-left: 3px solid var(--gold);
      padding: 16px;
      border-radius: 4px;
      margin-top: 24px;
    }

    .admin-note p {
      color: var(--text-main);
      font-size: 0.95rem;
      line-height: 1.6;
    }

    .btn-container {
      display: flex;
      justify-content: space-between;
      gap: 12px;
      flex-wrap: wrap;
      margin-top: 32px;
    }

    .btn-action {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      color: var(--gold);
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 600;
      padding: 12px 24px;
      border-radius: 4px;
      border: 1px solid rgba(212, 175, 55, 0.3);
      transition: var(--transition);
      background: rgba(212, 175, 55, 0.05);
    }

    .btn-action:hover {
      background: var(--gold);
      color: var(--bg-darker);
      transform: translateY(-2px);
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 480px) {
      .info-grid { grid-template-columns: 1fr; }
      .result-card { padding: 24px; }
    }
  </style>
</head>

<body>
  <div class="grid-bg"></div>
  <div class="islamic-pattern"></div>
  <div class="glow-orb glow-emerald"></div>
  <div class="glow-orb glow-gold"></div>

  <div class="page-wrapper">
    <div class="result-card">
      <div class="status-badge status-{{ $permohonan->status }}">
        @if($permohonan->status == 'pending')
          <i class="ti ti-clock"></i> Menunggu Antrean
        @elseif($permohonan->status == 'proses')
          <i class="ti ti-refresh"></i> Sedang Diproses
        @elseif($permohonan->status == 'selesai')
          <i class="ti ti-check"></i> Selesai
        @else
          <i class="ti ti-x"></i> Ditolak
        @endif
      </div>

      <div class="header-info">
        <h1>Status Permohonan</h1>
        <p>Detail informasi pelacakan tiket <strong>{{ $permohonan->no_tiket }}</strong></p>
      </div>

      <div class="info-grid">
        <div class="info-item">
          <p class="info-label">Jenis Layanan</p>
          <p class="info-value">{{ $permohonan->layanan->nama_layanan }}</p>
        </div>
        <div class="info-item">
          <p class="info-label">Tanggal Pengajuan</p>
          <p class="info-value">{{ $permohonan->created_at->translatedFormat('d F Y') }}</p>
        </div>
        <div class="info-item">
          <p class="info-label">Nama Pemohon</p>
          <p class="info-value">
            @if($permohonan->nisn)
              {{ $permohonan->siswa->nama_lengkap ?? ($permohonan->data_form['nama_lengkap'] ?? '-') }}
            @else
              {{ $permohonan->user->name ?? ($permohonan->data_form['nama_lengkap'] ?? '-') }}
            @endif
          </p>
        </div>
        <div class="info-item">
          <p class="info-label">Waktu Terakhir Update</p>
          <p class="info-value">{{ $permohonan->updated_at->diffForHumans() }}</p>
        </div>
      </div>

      @if($permohonan->catatan_admin)
        <div class="detail-section">
          <h3 class="detail-title"><i class="ti ti-info-circle"></i> Catatan Admin</h3>
          <div class="admin-note">
            <p>{{ $permohonan->catatan_admin }}</p>
          </div>
        </div>
      @endif

      <div class="divider"></div>

      <div class="btn-container">
        <a href="{{ route('ptsp.index') }}" class="btn-action" style="border-color: rgba(52, 211, 153, 0.3); color: var(--primary-light); background: rgba(52, 211, 153, 0.05);">
          <i class="ti ti-home"></i> Kembali ke Portal
        </a>
        <a href="{{ route('ptsp.tracking') }}" class="btn-action">
          <i class="ti ti-arrow-left"></i> Kembali Lacak Tiket Lain
        </a>
      </div>
    </div>
  </div>
  @include('components.ai-chat-widget')
</body>

</html>
