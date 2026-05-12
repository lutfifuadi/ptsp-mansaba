@extends('layouts/layoutMaster')

@section('title', 'Detail Tamu - Admin')

@section('page-style')
  @include('_partials.admin-styles')
@endsection

@section('content')
<div class="row">
  <div class="col-12">

    <div class="d-flex align-items-center gap-3 mb-4">
      <a href="{{ route('admin.guest-book.index') }}" class="btn btn-view">
        <i class="ti tabler-arrow-left me-1"></i> Kembali
      </a>
      <div>
        <h5 class="fw-bold mb-0">Detail Kunjungan Tamu</h5>
        <small class="text-muted">{{ $guestBook->nama_lengkap }}</small>
      </div>
    </div>

    <div class="panel">
      <div class="section-head">
        <h5 class="section-head-title">
          <span class="dot"></span> Informasi Tamu
        </h5>
      </div>
      <div class="panel-body">
        <div class="row g-4">
          <div class="col-md-6">
            <div class="stat-label">Nama Lengkap</div>
            <div class="fw-bold fs-5">{{ $guestBook->nama_lengkap }}</div>
          </div>
          <div class="col-md-6">
            <div class="stat-label">No. WhatsApp</div>
            <div class="fw-bold">{{ $guestBook->no_whatsapp }}</div>
          </div>
          <div class="col-12">
            <div class="stat-label">Alamat</div>
            <div>{{ $guestBook->alamat }}</div>
          </div>
          <div class="col-md-6">
            <div class="stat-label">Jenis Instansi</div>
            <div><span class="st-badge st-default">{{ $guestBook->jenis_instansi }}</span></div>
          </div>
          <div class="col-md-6">
            <div class="stat-label">Nama Instansi</div>
            <div>{{ $guestBook->nama_instansi ?: '-' }}</div>
          </div>
          <div class="col-md-6">
            <div class="stat-label">Tujuan</div>
            <div class="fw-bold">{{ $guestBook->tujuan }}</div>
          </div>
          @if($guestBook->guru)
          <div class="col-md-6">
            <div class="stat-label">Guru Tujuan</div>
            <div class="fw-bold">{{ $guestBook->guru->nama_lengkap }}</div>
          </div>
          @endif
          <div class="col-md-6">
            <div class="stat-label">Waktu Kunjungan</div>
            <div class="fw-bold">{{ $guestBook->created_at->format('d F Y H:i') }} WIB</div>
          </div>
          <div class="col-12">
            <div class="stat-label">Keperluan</div>
            <div>{{ $guestBook->keperluan }}</div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
