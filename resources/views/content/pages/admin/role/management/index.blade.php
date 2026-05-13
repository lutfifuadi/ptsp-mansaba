@extends('layouts/contentNavbarLayout')

@section('title', 'Manajemen Role - Admin')
@section('navbar-title', 'Manajemen Role')

@section('page-style')
@include('_partials.admin-styles')
<style>
  .role-name {
    font-weight: 700;
    color: var(--p);
  }
  .permission-badge {
    font-size: 0.7rem;
    background: #f1f5f9;
    color: #475569;
    padding: 2px 8px;
    border-radius: 4px;
    margin-right: 4px;
    margin-bottom: 4px;
    display: inline-block;
  }
</style>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
      <div>
        <h4 class="fw-bold mb-1">Manajemen Role</h4>
        <p class="text-muted mb-0">Kelola role dan permission dalam sistem.</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('admin.role.index') }}" class="btn btn-outline-secondary">
          <i class="ti tabler-arrow-left me-1"></i> Kembali ke Pengguna
        </a>
        <a href="{{ route('admin.role-management.create') }}" class="btn btn-primary">
          <i class="ti tabler-plus me-1"></i> Tambah Role
        </a>
      </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible mb-4" role="alert">
        <i class="ti tabler-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible mb-4" role="alert">
        <i class="ti tabler-alert-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- Tabel --}}
    <div class="panel shadow-sm">
      <div class="section-head">
        <h5 class="section-head-title"><span class="dot"></span> Daftar Role</h5>
        <span class="st-badge st-default">{{ $roles->count() }} Total Role</span>
      </div>

      <div class="table-responsive">
        <table class="table tbl mb-0">
          <thead>
            <tr>
              <th style="width:40px">#</th>
              <th>Nama Role</th>
              <th>Permissions</th>
              <th class="text-end pe-4">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($roles as $index => $role)
            <tr>
              <td class="text-muted small ps-4">{{ $index + 1 }}</td>
              <td>
                <span class="role-name">{{ ucfirst($role->name) }}</span>
              </td>
              <td>
                @forelse($role->permissions as $permission)
                  <span class="permission-badge">{{ $permission->name }}</span>
                @empty
                  <span class="text-muted small italic">Tidak ada permission khusus</span>
                @endforelse
              </td>
              <td class="text-end pe-4">
                <div class="d-flex justify-content-end gap-1">
                  <a href="{{ route('admin.role-management.edit', $role->id) }}" class="btn btn-view btn-sm" title="Edit">
                    <i class="ti tabler-edit"></i>
                  </a>
                  @if(!in_array($role->name, ['admin', 'operator']))
                  <form method="POST" action="{{ route('admin.role-management.destroy', $role->id) }}" class="d-inline form-hapus">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                      <i class="ti tabler-trash"></i>
                    </button>
                  </form>
                  @endif
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4">
                <div class="empty-state">
                  <i class="ti tabler-shield-off"></i>
                  <p class="fw-bold">Tidak ada data role.</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
document.addEventListener('click', function(e) {
  const formHapus = e.target.closest('.form-hapus');
  if (formHapus && e.target.closest('button[type="submit"]')) {
    if (!confirm('Yakin ingin menghapus role ini? User yang memiliki role ini akan kehilangan aksesnya.')) {
      e.preventDefault();
    }
  }
});
</script>
@endsection
