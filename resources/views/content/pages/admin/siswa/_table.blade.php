<div class="section-head">
  <h5 class="section-head-title"><span class="dot"></span> Daftar Siswa</h5>
  <span class="st-badge st-default">{{ $siswa->total() }} Total Siswa</span>
</div>

<div class="table-responsive">
  <table class="table tbl mb-0">
    <thead>
      <tr>
        <th style="width:40px">#</th>
        <th>NISN / NIS</th>
        <th>Nama Lengkap</th>
        <th>Jenis Kelamin</th>
        <th>TTL</th>
        <th>Kelas & Jurusan</th>
        <th class="text-end">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($siswa as $index => $s)
      <tr>
        <td class="text-muted small">{{ $siswa->firstItem() + $index }}</td>
        <td>
          <div class="fw-bold text-dark">{{ $s->nisn }}</div>
          <div class="text-muted small">NIS: {{ $s->nis ?? '-' }}</div>
        </td>
        <td>
          <div class="fw-bold">{{ $s->nama_lengkap }}</div>
        </td>
        <td>
          @if($s->jenis_kelamin)
            <span class="st-badge st-default">
              <i class="ti {{ $s->jenis_kelamin === 'laki-laki' ? 'tabler-mars' : 'tabler-venus' }} me-1"></i>
              {{ ucfirst($s->jenis_kelamin) }}
            </span>
          @else
            <span class="text-muted">-</span>
          @endif
        </td>
        <td>
          @if($s->tempat_lahir && $s->tanggal_lahir)
            {{ $s->tempat_lahir }}, {{ \Carbon\Carbon::parse($s->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}
          @else
            <span class="text-muted">-</span>
          @endif
        </td>
        <td>
          <span class="st-badge st-default">{{ $s->kelas }}</span>
          <div class="small text-muted mt-1">{{ $s->jurusan }}</div>
        </td>
        <td class="text-end">
          <div class="d-flex justify-content-end gap-1">
            <a href="{{ route('admin.siswa.edit', $s->id) }}" class="btn btn-view btn-sm" title="Edit">
              <i class="ti tabler-edit"></i>
            </a>
            <form method="POST" action="{{ route('admin.siswa.destroy', $s->id) }}" class="d-inline form-hapus">
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
        <td colspan="7">
          <div class="empty-state">
            <i class="ti tabler-user-off"></i>
            <p class="fw-bold">Tidak ada data siswa.</p>
            <p>Coba sesuaikan filter atau cari kata kunci lain.</p>
          </div>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

@if($siswa->hasPages())
<div class="border-top d-flex align-items-center justify-content-between px-3 py-3">
  <div class="text-muted small d-none d-md-block">
    Halaman {{ $siswa->currentPage() }} dari {{ $siswa->lastPage() }}
  </div>
  <div class="d-flex justify-content-center justify-content-md-end flex-grow-1">
    {{ $siswa->links() }}
  </div>
</div>
@endif
