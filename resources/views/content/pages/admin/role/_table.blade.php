<div class="section-head">
  <h5 class="section-head-title"><span class="dot"></span> Daftar Pengguna</h5>
  <span class="st-badge st-default">{{ $users->total() }} Total Pengguna</span>
</div>

<div class="table-responsive">
  <table class="table tbl mb-0">
    <thead>
      <tr>
        <th style="width:40px">#</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Username</th>
        <th>Role</th>
        <th class="text-end pe-4">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $index => $user)
      <tr>
        <td class="text-muted small ps-4">{{ $users->firstItem() + $index }}</td>
        <td>
          <div class="d-flex align-items-center gap-2">
            <div class="av">{{ substr($user->name, 0, 1) }}</div>
            <div class="fw-bold text-dark">{{ $user->name }}</div>
          </div>
        </td>
        <td>
          <span class="text-muted small">{{ $user->email }}</span>
        </td>
        <td>
          <span class="ticket-no">{{ $user->username }}</span>
        </td>
        <td>
          @php
            $roleClass = match($user->role) {
              'admin' => 'role-admin',
              'staff' => 'role-staff',
              default => 'role-user',
            };
          @endphp
          <span class="role-badge {{ $roleClass }}">{{ ucfirst($user->role) }}</span>
        </td>
        <td class="text-end pe-4">
          <div class="d-flex justify-content-end gap-1">
            <a href="{{ route('admin.role.edit', $user->id) }}" class="btn btn-view btn-sm" title="Edit">
              <i class="ti tabler-edit"></i>
            </a>
            @if($user->id !== auth()->id())
            <form method="POST" action="{{ route('admin.role.destroy', $user->id) }}" class="d-inline form-hapus">
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
        <td colspan="6">
          <div class="empty-state">
            <i class="ti tabler-user-off"></i>
            <p class="fw-bold">Tidak ada data pengguna.</p>
            <p>Coba sesuaikan pencarian atau tambah data baru.</p>
          </div>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="border-top py-3">
  <div class="d-flex justify-content-end">
    {{ $users->links() }}
  </div>
</div>
