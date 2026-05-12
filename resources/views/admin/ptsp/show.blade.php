@extends('layouts/contentNavbarLayout')

@section('title', ($permohonan->layanan ? $permohonan->layanan->nama_layanan : 'Permohonan') . ' — ' . $permohonan->no_tiket)
@section('navbar-title', 'Detail ' . ($permohonan->layanan ? $permohonan->layanan->nama_layanan : 'Permohonan'))

@section('page-style')
@include('_partials.admin-styles')
@endsection

@section('content')
<div class="row">
  <div class="col-12">

    {{-- Breadcrumb & Back --}}
    <div class="d-flex align-items-center gap-3 mb-4">
      <a href="{{ $permohonan->layanan_id ? route('admin.ptsp.index', ['layanan_id' => $permohonan->layanan_id]) : route('admin.ptsp.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="ti tabler-arrow-left me-1"></i> Kembali
      </a>
      <div>
        <h5 class="fw-bold mb-0">Detail {{ $permohonan->layanan->nama_layanan ?? 'Permohonan' }}</h5>
        <small class="text-muted">{{ $permohonan->no_tiket }}</small>
      </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible mb-4" role="alert">
        <i class="ti tabler-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="row g-4">

      {{-- Left: Info Permohonan --}}
      <div class="col-12 col-md-7">

        {{-- Tiket & Status --}}
        <div class="card panel shadow-sm border-0 mb-4">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <div>
                <div class="text-muted small mb-1">Nomor Tiket</div>
                <code class="fs-5 text-primary fw-bold">{{ $permohonan->no_tiket }}</code>
              </div>
              <div class="text-end">
                @switch($permohonan->status)
                  @case('pending')  <span class="st-badge st-pending">PENDING</span> @break
                  @case('proses')   <span class="st-badge st-proses">DIPROSES</span> @break
                  @case('selesai')  <span class="st-badge st-selesai">SELESAI</span> @break
                  @case('ditolak')  <span class="st-badge st-ditolak">DITOLAK</span> @break
                  @default          <span class="st-badge st-default">{{ strtoupper($permohonan->status) }}</span>
                @endswitch
              </div>
            </div>

            <hr>

            <div class="row g-3 small">
              <div class="col-6">
                <div class="text-muted mb-1">Layanan</div>
                <div class="fw-semibold">{{ $permohonan->layanan->nama_layanan ?? '—' }}</div>
              </div>
              <div class="col-6">
                <div class="text-muted mb-1">Sumber</div>
                <div>
                  @if($permohonan->user_id)
                    <span class="badge bg-label-secondary">Login</span>
                  @else
                    <span class="badge bg-label-primary">Publik (NISN)</span>
                  @endif
                </div>
              </div>
              <div class="col-6">
                <div class="text-muted mb-1">Tanggal Pengajuan</div>
                <div class="fw-semibold">{{ $permohonan->created_at->locale('id')->translatedFormat('d F Y, H:i') }}</div>
              </div>
              <div class="col-6">
                <div class="text-muted mb-1">Terakhir Update</div>
                <div class="fw-semibold">{{ $permohonan->updated_at->locale('id')->diffForHumans() }}</div>
              </div>
            </div>
          </div>
        </div>

        {{-- Data Pemohon --}}
        <div class="card panel shadow-sm border-0 mb-4">
          <div class="card-header py-3">
            <h6 class="mb-0 fw-semibold">
              <i class="ti tabler-user me-2 text-primary"></i>Data Pemohon
            </h6>
          </div>
          <div class="card-body">
            @if($permohonan->user_id && $permohonan->user)
              {{-- Login User --}}
              <div class="d-flex align-items-center gap-3 mb-3">
                <div class="avatar bg-label-secondary">
                  <span class="fw-bold">{{ mb_strtoupper(mb_substr($permohonan->user->name, 0, 1)) }}</span>
                </div>
                <div>
                  <div class="fw-semibold">{{ $permohonan->user->name }}</div>
                  <div class="text-muted small">{{ $permohonan->user->email }}</div>
                </div>
              </div>
            @elseif($permohonan->nisn)
              {{-- Public NISN --}}
              @php $siswa = $permohonan->siswa; @endphp
              <div class="d-flex align-items-center gap-3 mb-3">
                <div class="avatar bg-label-primary">
                  <span class="fw-bold">
                    {{ $siswa ? mb_strtoupper(mb_substr($siswa->nama_lengkap, 0, 1)) : '?' }}
                  </span>
                </div>
                <div>
                  <div class="fw-semibold">{{ $siswa->nama_lengkap ?? 'Siswa' }}</div>
                  <div class="text-muted small">NISN: {{ $permohonan->nisn }}</div>
                </div>
              </div>
              @if($siswa)
              <div class="row g-2 small">
                <div class="col-6">
                  <div class="bg-light rounded p-2">
                    <div class="text-muted mb-1">Kelas</div>
                    <div class="fw-semibold">{{ $siswa->kelas ?? '—' }}</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="bg-light rounded p-2">
                    <div class="text-muted mb-1">NISN</div>
                    <div class="fw-semibold" style="letter-spacing:1px">{{ $siswa->nisn }}</div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="bg-light rounded p-2">
                    <div class="text-muted mb-1">Tempat & Tanggal Lahir</div>
                    <div class="fw-semibold">
                      {{ $siswa->tempat_lahir ?? '—' }}
                      @if($siswa->tanggal_lahir)
                        , {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              @endif
            @else
              <p class="text-muted">Data pemohon tidak tersedia.</p>
            @endif
          </div>
        </div>

        {{-- Data Form --}}
        @if($permohonan->data_form)
        <div class="card panel shadow-sm border-0">
          <div class="card-header py-3">
            <h6 class="mb-0 fw-semibold">
              <i class="ti tabler-file-description me-2 text-primary"></i>Detail Permohonan
            </h6>
          </div>
          <div class="card-body">
            <dl class="row mb-0 small">
              @foreach($permohonan->data_form as $key => $value)
                @if(!in_array($key, ['nisn','nama_lengkap','kelas','tempat_lahir','tanggal_lahir']))
                  <dt class="col-5 text-muted text-capitalize">{{ str_replace('_', ' ', $key) }}</dt>
                  <dd class="col-7 fw-semibold mb-2">
                    @if(is_array($value))
                      @if(count($value) > 0)
                        {{ implode(', ', $value) }}
                      @else
                        <span class="text-muted fst-italic">Tidak ada</span>
                      @endif
                    @else
                      {{ $value ?? '—' }}
                    @endif
                  </dd>
                @endif
              @endforeach
            </dl>
          </div>
        </div>
        @endif
      </div>

      {{-- Right: Update Status --}}
      <div class="col-12 col-md-5">
        <div class="card panel shadow-sm border-0 sticky-top" style="top: 80px;">
          <div class="card-header py-3">
            <h6 class="mb-0 fw-semibold">
              <i class="ti tabler-edit me-2 text-primary"></i>Update Status
            </h6>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('admin.ptsp.status', $permohonan->id) }}">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label class="form-label fw-semibold">Status Permohonan</label>
                <select name="status" class="form-select" required>
                  @foreach(['pending' => 'Pending', 'proses' => 'Sedang Diproses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'] as $val => $label)
                    <option value="{{ $val }}" {{ $permohonan->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">Catatan Admin <span class="text-muted fw-normal">(opsional)</span></label>
                <textarea name="catatan_admin" class="form-control" rows="4" placeholder="Catatan untuk pemohon...">{{ $permohonan->catatan_admin }}</textarea>
              </div>

              <button type="submit" class="btn btn-primary w-100">
                <i class="ti tabler-device-floppy me-1"></i> Simpan Perubahan
              </button>
            </form>

            @if($permohonan->catatan_admin)
            <div class="mt-3 p-3 bg-light rounded small">
              <div class="text-muted mb-1 fw-semibold">Catatan Terakhir:</div>
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
