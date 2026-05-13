@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Jam Operasional - Admin')

@section('page-style')
  @include('_partials.admin-styles')
  <style>
    .panel-body {
      padding: 1.5rem;
    }
    .section-head {
      padding: 0.6rem 1.5rem !important;
      min-height: 45px;
    }
    .section-head-title {
      margin: 0 !important;
    }
    .form-actions {
      border-top: 1px solid var(--border);
      padding-top: 1rem;
    }
    .table-jam-operasional td {
        vertical-align: middle;
    }
  </style>
@endsection

@section('content')
  <div class="mb-4">
    <h4 class="fw-bold mb-1">Jam Operasional Kantor</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Pengaturan</li>
        <li class="breadcrumb-item active">Jam Operasional</li>
      </ol>
    </nav>
  </div>

  {{-- Success alert --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible mb-4" role="alert">
      <div class="d-flex">
        <i class="ti tabler-check me-2 text-success"></i>
        <div>{{ session('success') }}</div>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.pengaturan.jam-operasional.update') }}" id="jamOperasionalForm">
    @csrf
    @method('PUT')

    <div class="d-flex flex-column gap-4">
      <div class="panel shadow-sm">
        <div class="section-head">
          <h5 class="section-head-title"><span class="dot"></span> Atur Jam Kerja</h5>
        </div>
        <div class="panel-body p-0">
          <div class="table-responsive">
            <table class="table table-hover table-jam-operasional">
              <thead class="table-light">
                <tr>
                  <th width="150">Hari</th>
                  <th width="150">Status</th>
                  <th>Jam Buka</th>
                  <th>Jam Tutup</th>
                </tr>
              </thead>
              <tbody>
                @foreach($jamOperasional as $jam)
                <tr>
                  <td class="fw-bold">{{ $jam->nama_hari }}</td>
                  <td>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" name="jam[{{ $jam->hari }}][is_aktif]" value="1" {{ $jam->is_aktif ? 'checked' : '' }}>
                      <label class="form-check-label">{{ $jam->is_aktif ? 'Buka' : 'Tutup' }}</label>
                    </div>
                  </td>
                  <td>
                    <input type="time" name="jam[{{ $jam->hari }}][jam_buka]" class="form-control" value="{{ $jam->jam_buka ? \Carbon\Carbon::parse($jam->jam_buka)->format('H:i') : '' }}" {{ !$jam->is_aktif ? 'disabled' : '' }}>
                  </td>
                  <td>
                    <input type="time" name="jam[{{ $jam->hari }}][jam_tutup]" class="form-control" value="{{ $jam->jam_tutup ? \Carbon\Carbon::parse($jam->jam_tutup)->format('H:i') : '' }}" {{ !$jam->is_aktif ? 'disabled' : '' }}>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        
        <div class="form-actions text-end px-4 pb-4">
          <button type="submit" class="btn btn-primary">
            <i class="ti tabler-device-floppy me-2"></i>Simpan Jam Operasional
          </button>
        </div>
      </div>

      <div class="alert alert-info d-flex" role="alert">
        <i class="ti tabler-info-circle me-2"></i>
        <div>
          Form pelayanan publik akan otomatis non-aktif di luar jam operasional yang ditentukan di atas. 
          Jika status hari di-set <strong>Tutup</strong>, maka form tidak akan bisa diakses pada hari tersebut.
        </div>
      </div>
    </div>
  </form>
@endsection

@section('page-script')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const switches = document.querySelectorAll('.form-check-input');
    switches.forEach(sw => {
      sw.addEventListener('change', function() {
        const row = this.closest('tr');
        const inputs = row.querySelectorAll('input[type="time"]');
        const label = this.nextElementSibling;
        
        if (this.checked) {
          inputs.forEach(input => input.disabled = false);
          label.textContent = 'Buka';
        } else {
          inputs.forEach(input => input.disabled = true);
          label.textContent = 'Tutup';
        }
      });
    });
  });
</script>
@endsection
