@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Update Aplikasi - Admin')

@section('page-style')
  @include('_partials.admin-styles')
  <style>
    .update-stat-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--r-lg) !important;
      padding: 1.25rem;
      transition: transform 0.18s, box-shadow 0.18s;
    }
    .update-stat-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }
    .update-stat-label {
      font-size: 0.7rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--muted);
      margin-bottom: 4px;
    }
    .update-stat-value {
      font-size: 0.95rem;
      font-weight: 700;
      color: var(--text);
      word-break: break-all;
    }
    .update-stat-icon {
      width: 38px;
      height: 38px;
      border-radius: var(--r);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      flex-shrink: 0;
    }
    .log-container {
      background: #1e293b;
      color: #e2e8f0;
      font-family: 'JetBrains Mono', 'Fira Code', 'Consolas', monospace;
      font-size: 0.8rem;
      line-height: 1.6;
      padding: 1rem 1.25rem;
      border-radius: var(--r-lg) !important;
      max-height: 400px;
      overflow-y: auto;
      white-space: pre-wrap;
      word-break: break-all;
    }
    .log-container .log-info {
      color: #38bdf8;
    }
    .log-container .log-success {
      color: #4ade80;
    }
    .log-container .log-error {
      color: #f87171;
    }
    .log-container .log-warning {
      color: #fbbf24;
    }
    .log-container::-webkit-scrollbar {
      width: 6px;
    }
    .log-container::-webkit-scrollbar-track {
      background: #334155;
      border-radius: 3px;
    }
    .log-container::-webkit-scrollbar-thumb {
      background: #475569;
      border-radius: 3px;
    }
    .version-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-weight: 800;
      font-size: 1.1rem;
      color: var(--p);
    }
    .version-badge small {
      font-size: 0.7rem;
      font-weight: 600;
      color: var(--muted);
    }
    .commit-hash {
      font-family: monospace;
      background: #f1f5f9;
      padding: 2px 8px;
      border-radius: var(--r-sm);
      font-size: 0.78rem;
      color: var(--p);
    }
  </style>
@endSection

@section('content')
  <div class="mb-4">
    <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
      <i class="ti tabler-refresh" style="color:var(--p)"></i>
      Update Aplikasi
    </h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Update Aplikasi</li>
      </ol>
    </nav>
  </div>

  @php
    $gitUnavailable = isset($info['git_available']) && !$info['git_available'];
  @endphp

  @if ($gitUnavailable)
    <div class="alert alert-warning d-flex align-items-center gap-3" style="border-radius:var(--r-lg);background:rgba(251,191,36,0.12);border:1px solid rgba(251,191,36,0.3);color:#92400e;backdrop-filter:blur(4px)">
      <i class="ti tabler-alert-triangle" style="font-size:1.3rem;flex-shrink:0"></i>
      <div>
        <strong>Git Tidak Tersedia</strong><br>
        <small>{{ $info['error'] ?? 'Fungsi eksekusi perintah git tidak tersedia di server ini. Fitur update tidak dapat digunakan melalui panel admin.' }}</small>
      </div>
    </div>
  @endif

  <div class="row g-3 mb-3">
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="update-stat-card d-flex align-items-center gap-3">
        <div class="update-stat-icon" style="background:#ecfdf5;color:var(--p)">
          <i class="ti tabler-tag"></i>
        </div>
        <div>
          <div class="update-stat-label">Versi Aplikasi</div>
          <div class="update-stat-value version-badge">
            v{{ $appVersion }}
            <small>{{ $info['tag'] != '-' ? $info['tag'] : '' }}</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="update-stat-card d-flex align-items-center gap-3">
        <div class="update-stat-icon" style="background:#e0f2fe;color:#0284c7">
          <i class="ti tabler-git-branch"></i>
        </div>
        <div>
          <div class="update-stat-label">Branch</div>
          <div class="update-stat-value">{{ $info['branch'] }}</div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="update-stat-card d-flex align-items-center gap-3">
        <div class="update-stat-icon" style="background:#fef3c7;color:#d97706">
          <i class="ti tabler-git-commit"></i>
        </div>
        <div>
          <div class="update-stat-label">Commit Terakhir</div>
          <div class="update-stat-value">
            <span class="commit-hash">{{ ($parts = explode(' - ', $info['commit'])) ? $parts[0] : '-' }}</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="update-stat-card d-flex align-items-center gap-3">
        <div class="update-stat-icon" style="background:#f3e8ff;color:#9333ea">
          <i class="ti tabler-calendar"></i>
        </div>
        <div>
          <div class="update-stat-label">Tanggal Commit</div>
          <div class="update-stat-value" style="font-size:0.82rem">
            @php
              $commitDate = $info['commit_date'] ?? '-';
            @endphp
            @if ($commitDate && $commitDate !== '-' && $commitDate !== 'N/A')
              {{ \Carbon\Carbon::parse($commitDate)->format('d M Y H:i') }}
            @else
              {{ $commitDate }}
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="panel mb-3">
    <div class="section-head">
      <div class="section-head-title">
        <span class="dot"></span>
        Commit Terbaru
      </div>
    </div>
    <div class="panel-body">
      <div style="font-size:0.88rem;color:var(--text);font-family:monospace;background:#f8fafc;padding:10px 14px;border-radius:var(--r);border:1px solid var(--border)">
        @if (isset($info['commit']) && $info['commit'] !== 'N/A')
          {{ $info['commit'] }}
        @else
          <span style="color:var(--muted)">Tidak tersedia</span>
        @endif
      </div>
    </div>
  </div>

  <div class="panel mb-3">
    <div class="section-head">
      <div class="section-head-title">
        <span class="dot"></span>
        Console Update
      </div>
      <div class="d-flex gap-2">
        <button type="button" class="btn btn-view" id="btnCheck" onclick="checkUpdate()"
          {{ $gitUnavailable ? 'disabled title="Git tidak tersedia"' : '' }}>
          <i class="ti tabler-search me-1"></i>Cek Update
        </button>
        <button type="button" class="btn btn-view" id="btnRun" onclick="confirmUpdate()" disabled
          style="border-color:var(--amber);color:var(--amber)!important"
          {{ $gitUnavailable ? 'title="Git tidak tersedia"' : '' }}>
          <i class="ti tabler-refresh me-1"></i>Jalankan Update
        </button>
      </div>
    </div>
    <div class="panel-body">
      <div class="log-container" id="logContainer">
        <span class="log-info">[INFO]</span> {{ $gitUnavailable ? 'Git tidak tersedia. Fitur update tidak dapat digunakan.' : 'Sistem siap. Klik "Cek Update" untuk memeriksa pembaruan.' }}
      </div>
      <div class="mt-2 d-flex align-items-center gap-2" id="statusIndicator" style="display:none!important">
        <span class="st-badge st-default" id="statusBadge">Menunggu</span>
        <small style="color:var(--muted)" id="statusText">Belum ada pengecekan</small>
      </div>
    </div>
  </div>
@endsection

@section('page-script')
<script>
  let updateAvailable = false;

  function appendLog(text, type = 'info') {
    const log = document.getElementById('logContainer');
    const line = document.createElement('div');
    line.innerHTML = `<span class="log-${type}">[${type.toUpperCase()}]</span> ${text}`;
    log.appendChild(line);
    log.scrollTop = log.scrollHeight;
  }

  function setLoading(btn, loading) {
    if (loading) {
      btn.disabled = true;
      btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Memproses...';
    } else {
      btn.disabled = false;
      btn.innerHTML = btn.id === 'btnCheck'
        ? '<i class="ti tabler-search me-1"></i>Cek Update'
        : '<i class="ti tabler-refresh me-1"></i>Jalankan Update';
    }
  }

  function updateStatus(label, text, type) {
    const badge = document.getElementById('statusBadge');
    const txt = document.getElementById('statusText');
    const indicator = document.getElementById('statusIndicator');
    indicator.style.display = 'flex';
    badge.className = `st-badge st-${type}`;
    badge.textContent = label;
    txt.textContent = text;
  }

  function checkUpdate() {
    const btn = document.getElementById('btnCheck');
    setLoading(btn, true);
    appendLog('Memeriksa pembaruan dari remote...', 'info');
    updateStatus('Memeriksa', 'Mengecek ketersediaan update...', 'default');

    fetch('{{ route("admin.update.check") }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json',
      }
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        if (data.has_update) {
          updateAvailable = true;
          document.getElementById('btnRun').disabled = false;
          appendLog(`Pembaruan tersedia! (${data.pending_commits.length} commit menunggu)`, 'success');
          appendLog(`Remote: ${data.remote_commit} | Local: ${data.local_commit}`, 'info');
          if (data.pending_commits.length > 0) {
            appendLog('Commit yang akan ditarik:', 'info');
            data.pending_commits.forEach(c => appendLog(`  ${c}`, 'info'));
          }
          updateStatus('Tersedia', `${data.pending_commits.length} commit baru`, 'pending');
        } else {
          updateAvailable = false;
          document.getElementById('btnRun').disabled = true;
          appendLog('Aplikasi sudah yang terbaru.', 'warning');
          updateStatus('Terkini', 'Tidak ada pembaruan', 'success');
        }
      } else {
        appendLog('Gagal memeriksa: ' + data.message, 'error');
        updateStatus('Error', 'Gagal memeriksa', 'danger');
      }
    })
    .catch(err => {
      appendLog('Error koneksi: ' + err.message, 'error');
      updateStatus('Error', 'Gagal terhubung', 'danger');
    })
    .finally(() => {
      setLoading(btn, false);
    });
  }

  function confirmUpdate() {
    if (!updateAvailable) {
      appendLog('Tidak ada pembaruan untuk dijalankan.', 'warning');
      return;
    }

    const confirmed = confirm(
      'PERINGATAN!\n\n' +
      'Proses update akan menjalankan:\n' +
      '- git pull\n' +
      '- php artisan migrate\n' +
      '- cache clear\n\n' +
      'Pastikan sudah backup database.\n' +
      'Lanjutkan update?'
    );

    if (!confirmed) {
      appendLog('Update dibatalkan oleh admin.', 'warning');
      return;
    }

    runUpdate();
  }

  function runUpdate() {
    const btnRun = document.getElementById('btnRun');
    const btnCheck = document.getElementById('btnCheck');
    setLoading(btnRun, true);
    btnCheck.disabled = true;
    updateAvailable = false;
    appendLog('', 'info');
    appendLog('================================================', 'info');
    appendLog('MEMULAI PROSES UPDATE...', 'info');
    appendLog('================================================', 'info');
    updateStatus('Proses', 'Sedang menjalankan update...', 'default');

    fetch('{{ route("admin.update.run") }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      }
    })
    .then(res => {
      const reader = res.body.getReader();
      const decoder = new TextDecoder();
      const log = document.getElementById('logContainer');

      function readStream() {
        reader.read().then(({ done, value }) => {
          if (done) {
            appendLog('', 'info');
            appendLog('Proses update selesai.', 'success');
            updateStatus('Selesai', 'Update selesai', 'success');
            setLoading(btnRun, false);
            btnCheck.disabled = false;
            return;
          }
          const text = decoder.decode(value, { stream: true });
          const lines = text.split('\n');
          lines.forEach(line => {
            if (line.trim()) {
              const entry = document.createElement('div');
              entry.textContent = line;
              log.appendChild(entry);
            }
          });
          log.scrollTop = log.scrollHeight;
          readStream();
        });
      }
      readStream();
    })
    .catch(err => {
      appendLog('Error: ' + err.message, 'error');
      updateStatus('Error', 'Update gagal', 'danger');
      setLoading(btnRun, false);
      btnCheck.disabled = false;
    });
  }
</script>
@endSection
