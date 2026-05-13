@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Detail Petugas - Admin')

@section('page-style')
@include('_partials.admin-styles')
<style>
.detail-field {
  padding: 1rem 0;
  border-bottom: 1px solid #f1f2f4;
}
.detail-field:last-child {
  border-bottom: none;
}
.detail-label {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #64748b;
  font-weight: 700;
  margin-bottom: 0.4rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.detail-value {
  font-weight: 600;
  color: #1e293b;
  font-size: 0.95rem;
}
</style>
@endsection

@section('content')
<div class="row">
  <div class="col-12">

    <div class="d-flex align-items-center gap-3 mb-4">
      <a href="{{ route('admin.petugas.index') }}" class="btn btn-view">
        <i class="ti tabler-arrow-left me-1"></i> Kembali
      </a>
      <div>
        <h5 class="fw-bold mb-0">Detail Petugas</h5>
        <small class="text-muted">{{ $petugas->nama_lengkap }}</small>
      </div>
    </div>

    <div class="panel">
      <div class="section-head">
        <h5 class="section-head-title">
          <span class="dot"></span> Informasi Petugas
        </h5>
      </div>
      <div class="panel-body">
        <div class="row g-4">
          <div class="col-md-6">
            <div class="detail-field">
              <div class="detail-label"><i class="ti tabler-user text-primary fs-5"></i> Nama Lengkap</div>
              <div class="detail-value fs-5">{{ $petugas->nama_lengkap }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-field">
              <div class="detail-label"><i class="ti tabler-brand-whatsapp text-success fs-5"></i> No. WhatsApp</div>
              <div class="detail-value">{{ $petugas->no_whatsapp }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-field">
              <div class="detail-label"><i class="ti tabler-mail text-info fs-5"></i> Email</div>
              <div class="detail-value">{{ $petugas->email ?: '-' }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-field">
              <div class="detail-label"><i class="ti tabler-toggle-left text-danger fs-5"></i> Status</div>
              <div class="detail-value">
                @if($petugas->is_active)
                  <span class="st-badge st-success">Aktif</span>
                @else
                  <span class="st-badge st-danger">Tidak Aktif</span>
                @endif
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="detail-field">
              <div class="detail-label"><i class="ti tabler-notes text-warning fs-5"></i> Deskripsi</div>
              <div class="detail-value">{{ $petugas->deskripsi ?: '-' }}</div>
            </div>
          </div>
          <div class="col-12">
            <div class="detail-field">
              <div class="detail-label"><i class="ti tabler-layout-grid text-primary fs-5"></i> Layanan yang Ditangani</div>
              <div class="detail-value">
                @if($petugas->layanan->isNotEmpty())
                  @foreach($petugas->layanan as $l)
                    <span class="st-badge st-default">{{ $l->nama_layanan }}</span>
                  @endforeach
                @else
                  -
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex gap-2 mt-4">
      <a href="{{ route('admin.petugas.edit', $petugas->id) }}" class="btn btn-view">
        <i class="ti tabler-edit me-1"></i> Edit Data Petugas
      </a>
      <a href="{{ route('admin.petugas.index') }}" class="btn btn-label-secondary">Kembali</a>
    </div>

  </div>
</div>
@endsection
