@extends('layouts/layoutMaster')

@section('title', 'Detail Tamu - Admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin / Buku Tamu /</span> Detail</h4>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Detail Kunjungan</h5>
      <a href="{{ route('admin.guest-book.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label fw-bold">Nama Lengkap</label>
          <p>{{ $guestBook->nama_lengkap }}</p>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label fw-bold">No. WhatsApp</label>
          <p>{{ $guestBook->no_whatsapp }}</p>
        </div>
        <div class="col-md-12 mb-3">
          <label class="form-label fw-bold">Alamat</label>
          <p>{{ $guestBook->alamat }}</p>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label fw-bold">Jenis Instansi</label>
          <p>{{ $guestBook->jenis_instansi }}</p>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label fw-bold">Nama Instansi</label>
          <p>{{ $guestBook->nama_instansi ?: '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label fw-bold">Tujuan</label>
          <p>{{ $guestBook->tujuan }}</p>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label fw-bold">Waktu Kunjungan</label>
          <p>{{ $guestBook->created_at->format('d F Y H:i') }} WIB</p>
        </div>
        <div class="col-md-12 mb-3">
          <label class="form-label fw-bold">Keperluan</label>
          <p>{{ $guestBook->keperluan }}</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
