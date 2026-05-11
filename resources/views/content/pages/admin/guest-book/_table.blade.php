@php use Illuminate\Support\Str; @endphp

<div class="card-header d-flex justify-content-between align-items-center py-3">
  <h6 class="mb-0 fw-semibold">Daftar Kunjungan</h6>
  <span class="badge bg-label-primary">{{ $guestBooks->total() }} Total</span>
</div>

<div class="table-responsive text-nowrap">
  <table class="table table-hover align-middle mb-0">
    <thead class="table-light">
      <tr>
        <th style="width:40px">#</th>
        <th>Waktu</th>
        <th>Nama Tamu</th>
        <th>Kontak & Alamat</th>
        <th>Instansi</th>
        <th>Tujuan & Keperluan</th>
        <th class="text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($guestBooks as $index => $gb)
      <tr>
        <td class="text-muted small">{{ $guestBooks->firstItem() + $index }}</td>
        <td class="small">
          <div class="fw-semibold text-dark">{{ $gb->created_at->format('d/m/Y') }}</div>
          <div class="text-muted" style="font-size: 0.75rem;">{{ $gb->created_at->format('H:i') }} WIB</div>
        </td>
        <td>
          <div class="fw-semibold text-primary">{{ $gb->nama_lengkap }}</div>
        </td>
        <td>
          <div class="small fw-semibold"><i class="icon-base ti tabler-brand-whatsapp text-success me-1"></i>{{ $gb->no_whatsapp }}</div>
          <div class="small text-muted text-truncate" style="max-width: 150px;" title="{{ $gb->alamat }}">{{ $gb->alamat }}</div>
        </td>
        <td>
          <div class="badge bg-label-info mb-1">{{ $gb->jenis_instansi }}</div>
          <div class="small text-muted text-truncate" style="max-width: 150px;" title="{{ $gb->nama_instansi ?: '-' }}">{{ $gb->nama_instansi ?: '-' }}</div>
        </td>
        <td>
          <div class="fw-semibold small text-truncate" style="max-width: 150px;" title="{{ $gb->tujuan }}">{{ $gb->tujuan }}</div>
          <div class="text-muted small text-truncate" style="max-width: 150px;" title="{{ $gb->keperluan }}">{{ $gb->keperluan }}</div>
        </td>
        <td class="text-center">
          <div class="d-flex justify-content-center gap-1">
            <button type="button" class="btn btn-sm btn-icon btn-outline-primary btn-detail" data-id="{{ $gb->id }}" title="Detail">
              <i class="icon-base ti tabler-eye"></i>
            </button>
            <button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-delete" data-id="{{ $gb->id }}" title="Hapus">
              <i class="icon-base ti tabler-trash"></i>
            </button>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" class="text-center py-5 text-muted">
          <i class="icon-base ti tabler-book-off fs-1 d-block mb-2"></i>
          Belum ada data buku tamu.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

@if($guestBooks->hasPages())
<div class="card-footer d-flex justify-content-center py-3">
  {{ $guestBooks->links() }}
</div>
@endif
