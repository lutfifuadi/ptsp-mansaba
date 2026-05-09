<style>
  .table-pmbm th {
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
  .table-pmbm td {
    padding-top: 1rem !important;
    padding-bottom: 1rem !important;
    vertical-align: middle;
  }
  .table-pmbm tr:hover {
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
  .pagination-container nav > div:first-child {
    display: none !important;
  }
  .pagination-container nav > div:last-child {
    display: flex !important;
    width: 100%;
    justify-content: flex-end !important;
  }
  .pagination-container nav > div:last-child > div:first-child {
    display: none !important;
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
</style>

<div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom py-3">
  <h5 class="mb-0 fw-bold">Daftar Calon Murid</h5>
  <span class="badge bg-label-primary px-3 py-2" style="border-radius: 4px;">{{ $calonMurid->total() }} Total Calon Murid</span>
</div>

<div class="table-responsive">
  <table class="table table-hover table-pmbm mb-0">
    <thead>
      <tr>
        <th>#</th>
        <th>No. Pendaftaran</th>
        <th>Nama Lengkap / NIK</th>
        <th>Asal Sekolah</th>
        <th>Jalur Pendaftaran</th>
        <th>Kontak (Calon/Ortu)</th>
        <th>Status</th>
        <th class="text-end pe-4">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($calonMurid as $index => $c)
      <tr>
        <td class="text-muted small">{{ $calonMurid->firstItem() + $index }}</td>
        <td>
          <div class="fw-bold text-primary">{{ $c->no_pendaftaran }}</div>
          <div class="text-muted small">NISN: {{ $c->nisn ?? '-' }}</div>
        </td>
        <td>
          <div class="fw-bold text-dark">{{ $c->nama_lengkap }}</div>
          <div class="text-muted small">NIK: {{ $c->nik }}</div>
        </td>
        <td>{{ $c->asal_sekolah }}</td>
        <td>
          <span class="badge bg-label-info" style="border-radius: 4px;">{{ $c->jalur_pendaftaran }}</span>
        </td>
        <td>
          <div class="small"><i class="icon-base ti tabler-phone fs-6 me-1"></i> {{ $c->no_hp_calon ?? '-' }}</div>
          <div class="small text-muted"><i class="icon-base ti tabler-users fs-6 me-1"></i> {{ $c->no_hp_ortu }}</div>
        </td>
        <td>
          @if($c->status_kelulusan === 'Lulus')
            <span class="status-badge bg-label-success text-success">
              <i class="icon-base ti tabler-circle-check fs-5"></i> Lulus
            </span>
          @elseif($c->status_kelulusan === 'Tidak Lulus')
            <span class="status-badge bg-label-danger text-danger">
              <i class="icon-base ti tabler-circle-x fs-5"></i> Tidak Lulus
            </span>
          @else
            <span class="status-badge bg-label-warning text-warning">
              <i class="icon-base ti tabler-clock fs-5"></i> Proses
            </span>
          @endif
        </td>
        <td class="text-end pe-4">
          <div class="d-flex justify-content-end gap-1">
            <a href="{{ route('admin.pmbm.edit', $c->id) }}" class="btn btn-sm btn-icon btn-label-primary" title="Edit" style="border-radius: 4px;">
              <i class="icon-base ti tabler-edit"></i>
            </a>
            <form method="POST" action="{{ route('admin.pmbm.destroy', $c->id) }}" class="d-inline form-hapus">
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
        <td colspan="8" class="text-center py-5">
          <div class="text-muted mb-2"><i class="icon-base ti tabler-user-off fs-1"></i></div>
          <div class="fw-bold">Tidak ada data calon murid.</div>
          <div class="text-muted small">Coba sesuaikan filter atau cari kata kunci lain.</div>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="card-footer bg-white border-top py-3">
  <div class="d-flex justify-content-end">
    <div class="pagination-container">
      {{ $calonMurid->links() }}
    </div>
  </div>
</div>
