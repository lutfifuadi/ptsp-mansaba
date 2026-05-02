<style>
  .table-siswa th {
    background-color: #fcfdfe !important;
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 1px;
    font-weight: 700;
    color: #566a7f;
    border-top: none !important;
    padding-top: 1.2rem !important;
    padding-bottom: 1.2rem !important;
  }
  .table-siswa td {
    padding-top: 1rem !important;
    padding-bottom: 1rem !important;
    vertical-align: middle;
  }
  .table-siswa tr:hover {
    background-color: #f5f7ff !important;
  }
  .status-badge {
    padding: 0.5rem 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    border-radius: 4px;
  }
  .bulk-bar {
    background: #fff;
    border: 1px solid #eef0f2;
    border-radius: 4px;
    padding: 1rem 1.5rem;
    box-shadow: 0 -4px 15px rgba(0,0,0,0.05);
    z-index: 10;
  }
  /* Fix Pagination Bootstrap 5 */
  .pagination-container nav > div:first-child {
    display: none !important;
  }
  .pagination-container nav > div:last-child {
    display: flex !important;
    width: 100%;
    justify-content: flex-end !important;
  }
  .pagination-container nav > div:last-child > div:first-child {
    display: none !important; /* Hide "Showing X to Y..." */
  }
  .pagination-container .pagination {
    margin-bottom: 0;
    gap: 4px;
  }
  .pagination-container .page-link {
    border: none;
    background: #f1f2f4;
    color: #566a7f;
    border-radius: 4px !important;
    margin: 0;
    padding: 0.5rem 0.85rem;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.2s;
  }
  .pagination-container .page-link:hover {
    background: #eef0f2;
    color: #696cff;
    transform: translateY(-1px);
  }
  .pagination-container .page-item.active .page-link {
    background: #696cff;
    color: #fff;
    box-shadow: 0 4px 10px rgba(105, 108, 255, 0.3);
  }
  .pagination-container .page-item.disabled .page-link {
    background: #f8f9fa;
    color: #b4bdc6;
    pointer-events: none;
  }
</style>

<div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom py-3">
  <h5 class="mb-0 fw-bold">Daftar Siswa</h5>
  <span class="badge bg-label-primary px-3 py-2" style="border-radius: 4px;">{{ $siswa->total() }} Total Siswa</span>
</div>

<div class="table-responsive">
  <table class="table table-hover table-siswa mb-0">
    <thead>
      <tr>
        <th class="ps-4" style="width:40px">
          <input type="checkbox" class="form-check-input" id="checkAll">
        </th>
        <th>#</th>
        <th>NISN / NIS</th>
        <th>Nama Lengkap</th>
        <th>TTL</th>
        <th>Jenis Kelamin</th>
        <th>Kelas & Jurusan</th>
        <th>Status</th>
        <th class="text-end pe-4">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($siswa as $index => $s)
      <tr>
        <td class="ps-4">
          <input type="checkbox" class="form-check-input row-check" value="{{ $s->id }}">
        </td>
        <td class="text-muted small">{{ $siswa->firstItem() + $index }}</td>
        <td>
          <div class="fw-bold text-dark">{{ $s->nisn }}</div>
          <div class="text-muted small">NIS: {{ $s->nis ?? '-' }}</div>
          <div class="text-primary small fw-semibold">No. Peserta: {{ $s->no_peserta ?? '-' }}</div>
        </td>
        <td>
          <div class="fw-bold">{{ $s->nama_lengkap }}</div>
        </td>
        <td>
          @if($s->tempat_lahir && $s->tanggal_lahir)
            {{ $s->tempat_lahir }}, {{ \Carbon\Carbon::parse($s->tanggal_lahir)->translatedFormat('d F Y') }}
          @else
            -
          @endif
        </td>
        <td>
          @if($s->jenis_kelamin)
            {{ ucwords(str_replace('-', ' ', $s->jenis_kelamin)) }}
          @else
            -
          @endif
        </td>
        <td>
          <div class="badge bg-label-secondary" style="border-radius: 4px;">{{ $s->kelas }}</div>
          <div class="small text-muted mt-1">{{ $s->jurusan }}</div>
        </td>
        <td>
          @if($s->status_kelulusan === 'lulus')
            <span class="status-badge bg-label-success text-success">
              <i class="icon-base ti tabler-circle-check fs-5"></i> Lulus
            </span>
          @elseif($s->status_kelulusan === 'tidak_lulus')
            <span class="status-badge bg-label-danger text-danger">
              <i class="icon-base ti tabler-circle-x fs-5"></i> Tidak Lulus
            </span>
          @else
            <span class="status-badge bg-label-warning text-warning">
              <i class="icon-base ti tabler-clock fs-5"></i> Pending
            </span>
          @endif
        </td>
        <td class="text-end pe-4">
          <div class="d-flex justify-content-end gap-1">
            <a href="{{ route('admin.siswa.edit', $s->id) }}" class="btn btn-sm btn-icon btn-label-primary" title="Edit" style="border-radius: 4px;">
              <i class="icon-base ti tabler-edit"></i>
            </a>
            <form method="POST" action="{{ route('admin.siswa.destroy', $s->id) }}" class="d-inline form-hapus">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-icon btn-label-danger" title="Hapus" style="border-radius: 4px;">
                <i class="icon-base ti tabler-trash"></i>
              </button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="9" class="text-center py-5">
          <div class="text-muted mb-2"><i class="icon-base ti tabler-user-off fs-1"></i></div>
          <div class="fw-bold">Tidak ada data siswa.</div>
          <div class="text-muted small">Coba sesuaikan filter atau cari kata kunci lain.</div>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="card-footer bg-white border-top py-3">
  <div class="row align-items-center">
    <div class="col-md-6 mb-3 mb-md-0">
      <div id="bulkActions" class="d-none animate__animated animate__fadeInUp">
        <div class="bulk-bar d-flex align-items-center gap-3">
          <span class="badge bg-primary rounded-circle" id="selectedCount" style="width: 24px; height: 24px; padding: 0; display: flex; align-items: center; justify-content: center;">0</span>
          <span class="text-muted small fw-bold">Siswa Terpilih</span>
          <div class="vr mx-2"></div>
          <select id="bulkStatus" class="form-select form-select-sm" style="width:160px; border-radius: 4px;">
            <option value="">Set Status Ke...</option>
            <option value="lulus">Lulus</option>
            <option value="tidak_lulus">Tidak Lulus</option>
            <option value="pending">Pending</option>
          </select>
          <button id="btnBulkApply" class="btn btn-sm btn-primary px-3" style="border-radius: 4px;">Terapkan</button>
        </div>
      </div>
    </div>
    <div class="col-md-6 d-flex justify-content-md-end">
      <div class="pagination-container">
        {{ $siswa->links() }}
      </div>
    </div>
  </div>
</div>
