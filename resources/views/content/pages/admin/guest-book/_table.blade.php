@php use Illuminate\Support\Str; @endphp

<div class="section-head">
  <h6 class="section-head-title"><i class="ti tabler-list text-primary"></i> Daftar Kunjungan</h6>
  <span class="badge bg-label-primary rounded-pill px-3">{{ $guestBooks->total() }} Total Record</span>
</div>

<div class="table-responsive">
  <table class="table tbl mb-0">
    <thead>
      <tr>
        <th width="50">#</th>
        <th>Waktu</th>
        <th>Nama Tamu</th>
        <th>Instansi</th>
        <th>Keperluan</th>
        <th class="text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($guestBooks as $index => $gb)
      <tr>
        <td class="text-muted small">{{ $guestBooks->firstItem() + $index }}</td>
        <td>
          <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $gb->created_at->format('d M Y') }}</div>
          <div class="text-muted small d-flex align-items-center gap-1">
            <i class="ti tabler-clock fs-6"></i> {{ $gb->created_at->format('H:i') }} WIB
          </div>
        </td>
        <td>
          <div class="fw-bold text-primary">{{ $gb->nama_lengkap }}</div>
          <div class="text-muted small d-flex align-items-center gap-1">
            <i class="ti tabler-brand-whatsapp fs-6 text-success"></i> {{ $gb->no_whatsapp }}
          </div>
        </td>
        <td>
          <div class="badge bg-label-info mb-1" style="font-size: 0.7rem;">{{ $gb->jenis_instansi }}</div>
          <div class="text-muted small text-truncate" style="max-width: 150px;">{{ $gb->nama_instansi ?: '-' }}</div>
        </td>
        <td>
          <div class="fw-bold text-dark small text-truncate" style="max-width: 200px;">{{ $gb->tujuan }}</div>
          <div class="text-muted small text-truncate" style="max-width: 200px;">{{ $gb->keperluan }}</div>
        </td>
        <td class="text-center">
          <div class="d-flex justify-content-center gap-2">
            <button type="button" class="btn btn-icon btn-label-primary rounded-3 btn-detail" data-id="{{ $gb->id }}" title="Detail">
              <i class="ti tabler-eye"></i>
            </button>
            <button type="button" class="btn btn-icon btn-label-danger rounded-3 btn-delete" data-id="{{ $gb->id }}" title="Hapus">
              <i class="ti tabler-trash"></i>
            </button>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" class="text-center py-5">
          <div class="mb-3 opacity-20">
            <i class="ti tabler-book-off fs-1"></i>
          </div>
          <h5 class="text-muted">Belum ada kunjungan</h5>
          <p class="text-muted small mb-0">Data tamu akan muncul di sini setelah ada yang mengisi formulir.</p>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

@if($guestBooks->hasPages())
<div class="border-top d-flex justify-content-center py-4">
  {{ $guestBooks->links() }}
</div>
@endif
