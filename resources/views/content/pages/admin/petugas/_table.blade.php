<div class="section-head">
  <h5 class="section-head-title"><span class="dot"></span> Daftar Petugas</h5>
  <span class="st-badge st-default">{{ $petugas->total() }} Total Petugas</span>
</div>

<div class="table-responsive">
  <table class="table tbl mb-0">
    <thead>
      <tr>
        <th style="width:40px">#</th>
        <th>Nama Lengkap</th>
        <th>No. WhatsApp</th>
        <th>Layanan</th>
        <th>Status</th>
        <th class="text-end pe-4">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($petugas as $index => $p)
      <tr>
        <td class="text-muted small ps-4">{{ $petugas->firstItem() + $index }}</td>
        <td>
          <div class="fw-bold text-dark">{{ $p->nama_lengkap }}</div>
          @if($p->email)
            <small class="text-muted">{{ $p->email }}</small>
          @endif
        </td>
        <td>
          <span class="st-badge st-success">
            <i class="ti tabler-brand-whatsapp me-1"></i>{{ $p->no_whatsapp }}
          </span>
        </td>
        <td>
          @if($p->layanan->isNotEmpty())
            @foreach($p->layanan as $l)
              <span class="st-badge st-default">{{ $l->nama_layanan }}</span>
            @endforeach
          @else
            <span class="text-muted">-</span>
          @endif
        </td>
        <td>
          @if($p->is_active)
            <span class="st-badge st-success">Aktif</span>
          @else
            <span class="st-badge st-danger">Tidak Aktif</span>
          @endif
        </td>
        <td class="text-end pe-4">
          <div class="d-flex justify-content-end gap-1">
            <a href="{{ route('admin.petugas.show', $p->id) }}" class="btn btn-view btn-sm" title="Lihat">
              <i class="ti tabler-eye"></i>
            </a>
            <a href="{{ route('admin.petugas.edit', $p->id) }}" class="btn btn-view btn-sm" title="Edit">
              <i class="ti tabler-edit"></i>
            </a>
            <form method="POST" action="{{ route('admin.petugas.destroy', $p->id) }}" class="d-inline form-hapus">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                <i class="ti tabler-trash"></i>
              </button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6">
          <div class="empty-state">
            <i class="ti tabler-user-off"></i>
            <p class="fw-bold">Tidak ada data petugas.</p>
            <p>Coba sesuaikan pencarian atau tambah data baru.</p>
          </div>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

@if($petugas->hasPages())
<div class="border-top d-flex align-items-center justify-content-between px-3 py-3">
  <div class="text-muted small d-none d-md-block">
    Halaman {{ $petugas->currentPage() }} dari {{ $petugas->lastPage() }}
  </div>
  <div class="d-flex justify-content-center justify-content-md-end flex-grow-1">
    {{ $petugas->links() }}
  </div>
</div>
@endif
