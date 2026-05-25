@extends('layouts/contentNavbarLayout')

@section('title', ($permohonan->layanan ? $permohonan->layanan->nama_layanan : 'Permohonan') . ' — ' . $permohonan->no_tiket)
@section('navbar-title', 'Detail ' . ($permohonan->layanan ? $permohonan->layanan->nama_layanan : 'Permohonan'))

@section('page-style')
@include('_partials.admin-styles')
<style>
  /* ===== SHOW PAGE SPECIFIC STYLES ===== */

  .show-hero {
    background: linear-gradient(135deg, var(--p) 0%, var(--p2) 100%);
    border-radius: 5px;
    padding: 24px 28px;
    color: #fff;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
  }

  .show-hero::before {
    content: '';
    position: absolute;
    top: -30px;
    right: -30px;
    width: 130px;
    height: 130px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
    pointer-events: none;
  }

  .show-hero::after {
    content: '';
    position: absolute;
    bottom: -40px;
    right: 60px;
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    pointer-events: none;
  }

  .hero-ticket {
    font-family: 'Courier New', monospace;
    font-size: 1.3rem;
    font-weight: 800;
    letter-spacing: 2px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    padding: 6px 16px;
    border-radius: 5px;
    display: inline-block;
    margin-top: 6px;
  }

  .hero-label {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    opacity: 0.75;
    margin-bottom: 2px;
  }

  .hero-back-btn {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.3);
    color: #fff !important;
    border-radius: 5px;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 7px 16px;
    transition: background 0.15s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .hero-back-btn:hover {
    background: rgba(255,255,255,0.25);
    color: #fff !important;
  }

  /* ===== INFO PANEL ===== */

  .info-panel {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 5px;
    overflow: hidden;
    margin-bottom: 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
  }

  .info-panel-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    background: #f8fafc;
  }

  .info-panel-icon {
    width: 32px;
    height: 32px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
  }

  .info-panel-title {
    font-size: 0.82rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--text);
  }

  .info-panel-body {
    padding: 18px 20px;
  }

  /* ===== META GRID ===== */

  .meta-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  .meta-item {
    background: #f8fafc;
    border: 1px solid var(--border);
    border-radius: 4px;
    padding: 10px 14px;
    transition: border-color 0.15s;
  }

  .meta-item:hover {
    border-color: var(--p);
  }

  .meta-item-label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--muted);
    margin-bottom: 3px;
  }

  .meta-item-value {
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--text);
  }

  .meta-item-full {
    grid-column: 1 / -1;
  }

  /* ===== AVATAR ===== */

  .pemohon-avatar {
    width: 46px;
    height: 46px;
    border-radius: 5px;
    font-size: 1.1rem;
    font-weight: 900;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    text-transform: uppercase;
  }

  .pemohon-avatar.av-login {
    background: linear-gradient(135deg, var(--p) 0%, var(--p2) 100%);
    color: #fff;
  }

  .pemohon-avatar.av-public {
    background: linear-gradient(135deg, var(--indigo) 0%, #818cf8 100%);
    color: #fff;
  }

  .pemohon-name {
    font-size: 0.95rem;
    font-weight: 800;
    color: var(--text);
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .pemohon-sub {
    font-size: 0.78rem;
    color: var(--muted);
    margin-top: 1px;
  }

  /* ===== DL FORM DATA ===== */

  .form-data-row {
    display: flex;
    align-items: flex-start;
    padding: 9px 0;
    border-bottom: 1px solid #f1f5f9;
    gap: 12px;
    font-size: 0.85rem;
  }

  .form-data-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }

  .form-data-key {
    min-width: 130px;
    color: var(--muted);
    font-weight: 600;
    text-transform: capitalize;
    flex-shrink: 0;
  }

  .form-data-val {
    font-weight: 600;
    color: var(--text);
    flex: 1;
  }

  /* ===== STATUS SIDEBAR CARD ===== */

  .sidebar-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    position: sticky;
    top: 80px;
  }

  .sidebar-card-header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    background: #f8fafc;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .sidebar-card-body {
    padding: 20px;
  }

  .status-indicator {
    display: flex;
    gap: 8px;
    margin-bottom: 18px;
  }

  .status-step {
    flex: 1;
    text-align: center;
  }

  .status-step-dot {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 2px solid var(--border);
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 4px;
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--muted);
    transition: all 0.2s;
    position: relative;
  }

  .status-step-dot.active {
    border-color: var(--p);
    background: var(--p);
    color: #fff;
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15);
  }

  .status-step-dot.done {
    border-color: var(--p);
    background: #ecfdf5;
    color: var(--p);
  }

  .status-step-dot.danger {
    border-color: var(--red);
    background: #fee2e2;
    color: var(--red);
  }

  .status-step-line {
    height: 2px;
    background: var(--border);
    flex: 1;
    align-self: center;
    margin-bottom: 22px;
    transition: background 0.3s;
  }

  .status-step-line.done {
    background: var(--p);
  }

  .status-step-label {
    font-size: 0.62rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--muted);
  }

  .status-step.active .status-step-label {
    color: var(--p);
  }

  .status-step.danger .status-step-label {
    color: var(--red);
  }

  .form-select-styled {
    border: 1.5px solid var(--border);
    border-radius: 5px;
    padding: 9px 14px;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text);
    background: #fff;
    transition: border-color 0.15s, box-shadow 0.15s;
    width: 100%;
  }

  .form-select-styled:focus {
    outline: none;
    border-color: var(--p);
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
  }

  .textarea-styled {
    border: 1.5px solid var(--border);
    border-radius: 5px;
    padding: 10px 14px;
    font-size: 0.875rem;
    color: var(--text);
    background: #fff;
    transition: border-color 0.15s, box-shadow 0.15s;
    width: 100%;
    resize: vertical;
  }

  .textarea-styled:focus {
    outline: none;
    border-color: var(--p);
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
  }

  .btn-save {
    background: linear-gradient(135deg, var(--p) 0%, var(--p2) 100%);
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 0.875rem;
    font-weight: 700;
    width: 100%;
    cursor: pointer;
    transition: opacity 0.15s, transform 0.1s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    letter-spacing: 0.3px;
  }

  .btn-save:hover {
    opacity: 0.92;
    transform: translateY(-1px);
  }

  .btn-save:active {
    transform: translateY(0);
  }

  .catatan-box {
    background: #f8fafc;
    border: 1px solid var(--border);
    border-radius: 5px;
    padding: 12px 16px;
    font-size: 0.83rem;
    color: var(--text);
    line-height: 1.6;
    margin-top: 14px;
  }

  .catatan-box-label {
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--muted);
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  /* ===== FLASH ALERT ===== */

  .flash-success {
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    border-left: 4px solid var(--p);
    border-radius: 5px;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.875rem;
    color: #065f46;
    font-weight: 600;
    margin-bottom: 18px;
    animation: fadeUp 0.3s ease both;
  }

  /* ===== LABEL FORM ===== */

  .field-label {
    font-size: 0.78rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: var(--muted);
    margin-bottom: 6px;
    display: block;
  }

  /* ===== SOURCE BADGE ===== */
  .source-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .source-badge.login {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #cbd5e1;
  }

  .source-badge.publik {
    background: #ede9fe;
    color: #5b21b6;
    border: 1px solid #c4b5fd;
  }

  /* Fade-in animation for panels */
  .info-panel {
    animation: fadeUp 0.25s ease both;
  }

  .info-panel:nth-child(1) { animation-delay: 0.05s; }
  .info-panel:nth-child(2) { animation-delay: 0.10s; }
  .info-panel:nth-child(3) { animation-delay: 0.15s; }
</style>
@endsection

@section('content')
<div class="row">
  <div class="col-12">

    {{-- Flash --}}
    @if(session('success'))
      <div class="flash-success" role="alert">
        <i class="ti tabler-circle-check" style="font-size:1.1rem;"></i>
        {{ session('success') }}
        <button type="button" class="btn-close ms-auto" style="font-size:0.7rem;" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    {{-- Hero Header --}}
    <div class="show-hero mb-4">
      <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
        <div>
          <div class="hero-label">Permohonan Layanan PTSP</div>
          <div class="fs-6 fw-bold mb-1" style="opacity:0.9;">{{ $permohonan->layanan->nama_layanan ?? 'Permohonan' }}</div>
          <div class="hero-ticket">{{ $permohonan->no_tiket }}</div>
        </div>
        <div class="d-flex flex-column align-items-end gap-2">
          <a href="{{ $permohonan->layanan_id ? route('admin.ptsp.index', ['layanan_id' => $permohonan->layanan_id]) : route('admin.ptsp.index') }}"
             class="hero-back-btn">
            <i class="ti tabler-arrow-left"></i> Kembali
          </a>
          <div>
            @switch($permohonan->status)
              @case('pending')  <span class="st-badge st-pending">PENDING</span> @break
              @case('proses')   <span class="st-badge st-proses">DIPROSES</span> @break
              @case('selesai')  <span class="st-badge st-selesai">SELESAI</span> @break
              @case('ditolak')  <span class="st-badge st-ditolak">DITOLAK</span> @break
              @default          <span class="st-badge st-default">{{ strtoupper($permohonan->status) }}</span>
            @endswitch
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">

      {{-- ======================== LEFT COLUMN ======================== --}}
      <div class="col-12 col-md-7">

        {{-- Info Tiket --}}
        <div class="info-panel">
          <div class="info-panel-header">
            <div class="info-panel-icon" style="background:#ecfdf5; color:var(--p);">
              <i class="ti tabler-ticket"></i>
            </div>
            <div class="info-panel-title">Informasi Tiket</div>
          </div>
          <div class="info-panel-body">
            <div class="meta-grid">
              <div class="meta-item">
                <div class="meta-item-label">Layanan</div>
                <div class="meta-item-value">{{ $permohonan->layanan->nama_layanan ?? '—' }}</div>
              </div>
              <div class="meta-item">
                <div class="meta-item-label">Sumber</div>
                <div class="meta-item-value">
                  @if($permohonan->user_id)
                    <span class="source-badge login"><i class="ti tabler-user" style="font-size:0.7rem;"></i>Login</span>
                  @else
                    <span class="source-badge publik"><i class="ti tabler-world" style="font-size:0.7rem;"></i>Publik (NISN)</span>
                  @endif
                </div>
              </div>
              <div class="meta-item">
                <div class="meta-item-label">Tanggal Pengajuan</div>
                <div class="meta-item-value">{{ $permohonan->created_at->locale('id')->translatedFormat('d F Y, H:i') }}</div>
              </div>
              <div class="meta-item">
                <div class="meta-item-label">Terakhir Update</div>
                <div class="meta-item-value">{{ $permohonan->updated_at->locale('id')->diffForHumans() }}</div>
              </div>
            </div>
          </div>
        </div>

        {{-- Data Pemohon --}}
        <div class="info-panel">
          <div class="info-panel-header">
            <div class="info-panel-icon" style="background:#ede9fe; color:var(--indigo);">
              <i class="ti tabler-user-circle"></i>
            </div>
            <div class="info-panel-title">Data Pemohon</div>
          </div>
          <div class="info-panel-body">

            @if($permohonan->user_id && $permohonan->user)
              {{-- Login User --}}
              <div class="d-flex align-items-center gap-3 mb-3">
                <div class="pemohon-avatar av-login">
                  {{ mb_strtoupper(mb_substr($permohonan->user->name, 0, 1)) }}
                </div>
                <div>
                  <div class="pemohon-name">{{ $permohonan->user->name }}</div>
                  <div class="pemohon-sub"><i class="ti tabler-mail" style="font-size:0.75rem;"></i> {{ $permohonan->user->email }}</div>
                </div>
              </div>

            @elseif($permohonan->nisn)
              {{-- Public NISN --}}
              @php $siswa = $permohonan->siswa; @endphp
              <div class="d-flex align-items-center gap-3 mb-3">
                <div class="pemohon-avatar av-public">
                  {{ $siswa ? mb_strtoupper(mb_substr($siswa->nama_lengkap, 0, 1)) : '?' }}
                </div>
                <div>
                  <div class="pemohon-name">{{ mb_strtoupper($siswa->nama_lengkap ?? 'SISWA') }}</div>
                  <div class="pemohon-sub"><i class="ti tabler-id-badge" style="font-size:0.75rem;"></i> NISN: {{ $permohonan->nisn }}</div>
                </div>
              </div>
              @if($siswa)
              <div class="meta-grid">
                <div class="meta-item">
                  <div class="meta-item-label">Kelas</div>
                  <div class="meta-item-value">{{ $siswa->kelas ?? '—' }}</div>
                </div>
                <div class="meta-item">
                  <div class="meta-item-label">NISN</div>
                  <div class="meta-item-value" style="letter-spacing:1px; font-family:monospace;">{{ $siswa->nisn }}</div>
                </div>
                <div class="meta-item meta-item-full">
                  <div class="meta-item-label">Tempat &amp; Tanggal Lahir</div>
                  <div class="meta-item-value">
                    {{ $siswa->tempat_lahir ?? '—' }}
                    @if($siswa->tanggal_lahir)
                      , {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}
                    @endif
                  </div>
                </div>
              </div>
              @endif

            @elseif($permohonan->data_form && ($permohonan->data_form['nama_lengkap'] ?? null))
              {{-- Public form (no NISN) --}}
              @php $nama = $permohonan->data_form['nama_lengkap']; @endphp
              <div class="d-flex align-items-center gap-3 mb-3">
                <div class="pemohon-avatar av-public">
                  {{ mb_strtoupper(mb_substr($nama, 0, 1)) }}
                </div>
                <div>
                  <div class="pemohon-name">{{ mb_strtoupper($nama) }}</div>
                  <div class="pemohon-sub"><i class="ti tabler-globe" style="font-size:0.75rem;"></i> Pengajuan Publik</div>
                </div>
              </div>
              @if($permohonan->data_form['no_wa'] ?? null)
              <div class="meta-item" style="display:flex; align-items:center; gap:8px;">
                <div>
                  <div class="meta-item-label">No. WhatsApp</div>
                  <div class="meta-item-value">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$permohonan->data_form['no_wa']) }}" target="_blank" style="color:var(--p); text-decoration:none; font-weight:700;">
                      <i class="ti tabler-brand-whatsapp"></i> {{ $permohonan->data_form['no_wa'] }}
                    </a>
                  </div>
                </div>
              </div>
              @endif

            @else
              <p class="text-muted mb-0" style="font-size:0.875rem;">Data pemohon tidak tersedia.</p>
            @endif

          </div>
        </div>

        {{-- Detail Permohonan (data_form) --}}
        @if($permohonan->data_form)
        <div class="info-panel">
          <div class="info-panel-header">
            <div class="info-panel-icon" style="background:#fef3c7; color:#b45309;">
              <i class="ti tabler-file-description"></i>
            </div>
            <div class="info-panel-title">Detail Permohonan</div>
          </div>
          <div class="info-panel-body" style="padding-top:10px; padding-bottom:10px;">
            @foreach($permohonan->data_form as $key => $value)
              @if(!in_array($key, ['nisn','nama_lengkap','kelas','tempat_lahir','tanggal_lahir']))
                <div class="form-data-row">
                  <div class="form-data-key">{{ str_replace('_', ' ', $key) }}</div>
                  <div class="form-data-val">
                    @if(is_array($value))
                      @if(count($value) > 0)
                        {{ implode(', ', $value) }}
                      @else
                        <span style="color:var(--muted); font-style:italic;">Tidak ada</span>
                      @endif
                    @else
                      {{ $value ?? '—' }}
                    @endif
                  </div>
                </div>
              @endif
            @endforeach
          </div>
        </div>
        @endif

      </div>

      {{-- ======================== RIGHT COLUMN: Status ======================== --}}
      <div class="col-12 col-md-5">
        <div class="sidebar-card">
          <div class="sidebar-card-header">
            <div class="info-panel-icon" style="background:#e0f2fe; color:#0369a1;">
              <i class="ti tabler-adjustments-horizontal"></i>
            </div>
            <div class="info-panel-title">Update Status Permohonan</div>
          </div>
          <div class="sidebar-card-body">

            {{-- Status Timeline --}}
            <div class="d-flex align-items-center mb-20" style="margin-bottom:18px;">
              @php
                $steps = ['pending','proses','selesai'];
                $isDitolak = $permohonan->status === 'ditolak';
                $currentIdx = array_search($permohonan->status, $steps);
              @endphp

              @if(!$isDitolak)
                @foreach($steps as $i => $step)
                  <div class="status-step {{ $permohonan->status === $step ? 'active' : ($currentIdx !== false && $i < $currentIdx ? 'done' : '') }}">
                    <div class="status-step-dot {{ $permohonan->status === $step ? 'active' : ($currentIdx !== false && $i < $currentIdx ? 'done' : '') }}">
                      @if($currentIdx !== false && $i < $currentIdx)
                        <i class="ti tabler-check" style="font-size:0.65rem;"></i>
                      @else
                        {{ $i + 1 }}
                      @endif
                    </div>
                    <div class="status-step-label">
                      @if($step === 'pending') Masuk
                      @elseif($step === 'proses') Proses
                      @elseif($step === 'selesai') Selesai
                      @endif
                    </div>
                  </div>
                  @if($i < count($steps) - 1)
                    <div class="status-step-line {{ $currentIdx !== false && $i < $currentIdx ? 'done' : '' }}"></div>
                  @endif
                @endforeach
              @else
                <div style="width:100%; text-align:center;">
                  <span class="st-badge st-ditolak" style="font-size:0.8rem;">
                    <i class="ti tabler-x me-1"></i> Permohonan Ditolak
                  </span>
                </div>
              @endif
            </div>

            <form method="POST" action="{{ route('admin.ptsp.status', $permohonan->id) }}" id="formUpdateStatus">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label class="field-label" for="statusSelect">Status Permohonan</label>
                <select name="status" id="statusSelect" class="form-select-styled" required>
                  @foreach(['pending' => 'Pending — Menunggu', 'proses' => 'Sedang Diproses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'] as $val => $label)
                    <option value="{{ $val }}" {{ $permohonan->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="field-label" for="catatanAdmin">
                  Catatan Admin <span style="font-weight:400; text-transform:none; letter-spacing:0; color:var(--muted);">(opsional)</span>
                </label>
                <textarea name="catatan_admin" id="catatanAdmin" class="textarea-styled" rows="4"
                  placeholder="Tulis catatan untuk pemohon...">{{ $permohonan->catatan_admin }}</textarea>
              </div>

              <button type="submit" class="btn-save">
                <i class="ti tabler-device-floppy"></i> Simpan Perubahan
              </button>
            </form>

            @if($permohonan->catatan_admin)
            <div class="catatan-box">
              <div class="catatan-box-label">
                <i class="ti tabler-message-dots"></i> Catatan Terakhir
              </div>
              {{ $permohonan->catatan_admin }}
            </div>
            @endif

          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
