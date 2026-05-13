@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit Pengguna - Admin')

@section('page-style')
@include('_partials.admin-styles')
<style>
  .role-select-card {
    cursor: pointer;
    border: 2px solid var(--border);
    border-radius: var(--r-lg);
    padding: 16px;
    text-align: center;
    transition: all 0.15s;
  }
  .role-select-card:hover {
    border-color: var(--p);
    background: #f0fdf4;
  }
  .role-select-card.active {
    border-color: var(--p);
    background: #ecfdf5;
  }
  .role-select-card .role-icon {
    font-size: 1.5rem;
    margin-bottom: 8px;
  }
  .role-select-card .role-label {
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .role-select-card .role-desc {
    font-size: 0.78rem;
    color: var(--muted);
    margin-top: 4px;
  }
</style>
@endsection

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1">Edit Pengguna</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.role.index') }}">Manajemen Pengguna</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.role.index') }}" class="btn btn-label-secondary">
      <i class="ti tabler-arrow-left me-1"></i> Kembali
    </a>
  </div>

  <div class="panel shadow-sm">
    <div class="section-head">
      <h5 class="section-head-title"><span class="dot"></span> Edit Data: {{ $user->name }}</h5>
    </div>
    <div class="panel-body pt-4">
      <form method="POST" action="{{ route('admin.role.update', $user->id) }}">
        @csrf @method('PUT')

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
              value="{{ old('name', $user->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
              value="{{ old('email', $user->email) }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Username <span class="text-danger">*</span></label>
            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
              value="{{ old('username', $user->username) }}" required>
            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Password <small class="text-muted">(Kosongkan jika tidak diubah)</small></label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
              placeholder="Minimal 8 karakter">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label fw-bold mb-3">Hak Akses (Role) <span class="text-danger">*</span></label>
          <div class="row g-3">
            @foreach($roles as $role)
            @php
              $isActive = old('role') ? (old('role') === $role->name) : $user->hasRole($role->name);
            @endphp
            <div class="col-md-4">
              <div class="role-select-card @if($isActive) active @endif" data-value="{{ $role->name }}" onclick="selectRole(this)">
                @php
                  $iconColor = match($role->name) {
                    'admin' => 'var(--red)',
                    'operator' => 'var(--p)',
                    default => 'var(--muted)',
                  };
                  $icon = match($role->name) {
                    'admin' => 'tabler-shield',
                    'operator' => 'tabler-settings',
                    default => 'tabler-user',
                  };
                @endphp
                <div class="role-icon" style="color: {{ $iconColor }};"><i class="ti {{ $icon }}"></i></div>
                <div class="role-label">{{ ucfirst($role->name) }}</div>
                <div class="role-desc">Akses sebagai {{ $role->name }}</div>
              </div>
            </div>
            @endforeach
          </div>
          <input type="hidden" name="role" id="roleInput" value="{{ old('role', $user->roles->first()?->name) }}">
          @error('role')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="pt-3 border-top d-flex gap-2">
          <button type="submit" class="btn btn-view">
            <i class="ti tabler-device-floppy me-1"></i> Simpan Perubahan
          </button>
          <a href="{{ route('admin.role.index') }}" class="btn btn-label-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('page-script')
<script>
function selectRole(el) {
  document.querySelectorAll('.role-select-card').forEach(c => c.classList.remove('active'));
  el.classList.add('active');
  document.getElementById('roleInput').value = el.dataset.value;
}
</script>
@endsection
