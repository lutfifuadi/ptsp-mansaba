<div class="card-header d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Daftar Siswa</h5>
  <span class="badge bg-label-primary">{{ $siswa->total() }} siswa</span>
</div>
<div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th style="width:40px">
          <input type="checkbox" class="form-check-input" id="checkAll">
        </th>
        <th>#</th>
        <th>NISN</th>
        <th>NIS</th>
        <th>Nama Lengkap</th>
        <th>Kelas</th>
        <th>Jurusan</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($siswa as $index => $s)
      <tr>
        <td>
          <input type="checkbox" class="form-check-input row-check" value="{{ $s->id }}">
        </td>
        <td>{{ $siswa->firstItem() + $index }}</td>
        <td><code>{{ $s->nisn }}</code></td>
        <td>{{ $s->nis ?? '-' }}</td>
        <td class="fw-semibold">{{ $s->nama_lengkap }}</td>
        <td>{{ $s->kelas }}</td>
        <td>{{ $s->jurusan }}</td>
        <td>
          @if($s->status_kelulusan === 'lulus')
            <span class="badge bg-label-success">Lulus</span>
          @elseif($s->status_kelulusan === 'tidak_lulus')
            <span class="badge bg-label-danger">Tidak Lulus</span>
          @else
            <span class="badge bg-label-warning">Pending</span>
          @endif
        </td>
        <td>
          <div class="d-flex gap-1">
            <a href="{{ route('admin.siswa.edit', $s->id) }}" class="btn btn-sm btn-icon btn-outline-primary" title="Edit">
              <i class="icon-base ti tabler-edit"></i>
            </a>
            <form method="POST" action="{{ route('admin.siswa.destroy', $s->id) }}" class="d-inline form-hapus">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Hapus">
                <i class="icon-base ti tabler-trash"></i>
              </button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="9" class="text-center py-4 text-muted">Tidak ada data siswa.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="card-footer d-flex justify-content-between align-items-center">
  <div class="d-flex align-items-center gap-2">
    <div id="bulkActions" class="d-none d-flex gap-2 align-items-center">
      <span class="text-muted small" id="selectedCount">0 dipilih</span>
      <select id="bulkStatus" class="form-select form-select-sm" style="width:150px;">
        <option value="">Set Status...</option>
        <option value="lulus">Lulus</option>
        <option value="tidak_lulus">Tidak Lulus</option>
        <option value="pending">Pending</option>
      </select>
      <button id="btnBulkApply" class="btn btn-sm btn-primary">Terapkan</button>
    </div>
  </div>
  <div class="pagination-container">
    {{ $siswa->links() }}
  </div>
</div>
