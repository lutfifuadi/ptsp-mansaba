@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah Role - Admin')
@section('navbar-title', 'Tambah Role')

@section('page-style')
@include('_partials.admin-styles')
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <div>
        <h4 class="fw-bold mb-1">Tambah Role Baru</h4>
        <p class="text-muted mb-0">Definisikan role baru dalam sistem.</p>
      </div>
      <a href="{{ route('admin.role-management.index') }}" class="btn btn-outline-secondary">
        <i class="ti tabler-arrow-left me-1"></i> Kembali
      </a>
    </div>

    <div class="panel shadow-sm">
      <div class="panel-body p-4">
        <form action="{{ route('admin.role-management.store') }}" method="POST">
          @csrf
          <div class="mb-4">
            <label class="form-label fw-bold" for="name">Nama Role <span class="text-danger">*</span></label>
            <div class="input-group input-group-merge">
              <span class="input-group-text"><i class="ti tabler-shield"></i></span>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Contoh: editor, supervisor" value="{{ old('name') }}" required />
            </div>
            @error('name')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <div class="form-text">Gunakan huruf kecil dan tanpa spasi (misal: super_admin).</div>
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold mb-3">Permissions</label>
            <div class="row g-3">
              @forelse($permissions as $permission)
                <div class="col-md-4">
                  <div class="form-check custom-option custom-option-basic">
                    <label class="form-check-label custom-option-content" for="permission_{{ $permission->id }}">
                      <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->id }}">
                      <span class="custom-option-header">
                        <span class="fw-medium">{{ $permission->name }}</span>
                      </span>
                    </label>
                  </div>
                </div>
              @empty
                <div class="col-12">
                  <div class="alert alert-info">
                    <i class="ti tabler-info-circle me-2"></i> Belum ada permission yang didefinisikan di database.
                  </div>
                </div>
              @endforelse
            </div>
          </div>

          <div class="mt-4 pt-3 border-top d-flex justify-content-end">
            <button type="submit" class="btn btn-primary px-5">
              <i class="ti tabler-device-floppy me-1"></i> Simpan Role
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
