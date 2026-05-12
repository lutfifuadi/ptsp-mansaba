<div class="section-head">
  <h5 class="section-head-title"><span class="dot"></span> Daftar Guru</h5>
  <span class="st-badge st-default">{{ $gurus->total() }} Total Guru</span>
</div>

<div class="table-responsive">
  <table class="table tbl mb-0">
    <thead>
      <tr>
        <th style="width:40px">#</th>
        <th>Nama Lengkap</th>
        <th>NIP</th>
        <th>Bidang Studi</th>
        <th>Status</th>
        <th class="text-end pe-4">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($gurus as $index => $g)
      <tr>
        <td class="text-muted small ps-4">{{ $gurus->firstItem() + $index }}</td>
        <td>
          <div class="fw-bold text-dark">{{ $g->nama_lengkap }}</div>
        </td>
        <td>
          @if($g->nip)
            <span class="st-badge st-default">{{ $g->nip }}</span>
          @else
            <span class="text-muted">-</span>
          @endif
        </td>
        <td>
          <span class="st-badge st-default">{{ $g->bidang_studi }}</span>
        </td>
        <td>
          @if($g->is_active)
            <span class="st-badge st-success">Aktif</span>
          @else
            <span class="st-badge st-danger">Tidak Aktif</span>
          @endif
        </td>
        <td class="text-end pe-4">
          <div class="d-flex justify-content-end gap-1">
            <a href="{{ route('admin.guru.show', $g->id) }}" class="btn btn-view btn-sm" title="Lihat">
              <i class="ti tabler-eye"></i>
            </a>
            <a href="{{ route('admin.guru.edit', $g->id) }}" class="btn btn-view btn-sm" title="Edit">
              <i class="ti tabler-edit"></i>
            </a>
            <form method="POST" action="{{ route('admin.guru.destroy', $g->id) }}" class="d-inline form-hapus">
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
            <p class="fw-bold">Tidak ada data guru.</p>
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
    {{ $gurus->links() }}
  </div>
</div>
