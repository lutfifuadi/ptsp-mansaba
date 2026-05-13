@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Layanan Tutup')

@section('content')
<div class="container-xxl container-p-y">
  <div class="misc-wrapper d-flex flex-column align-items-center justify-content-center text-center">
    <div class="mb-4">
      <div class="avatar avatar-xl mb-3 mx-auto">
        <span class="avatar-initial rounded-circle bg-label-warning">
          <i class="ti tabler-clock-pause fs-1"></i>
        </span>
      </div>
      <h2 class="mb-1 mx-2">Layanan Sedang Tutup</h2>
      <p class="mb-4 mx-2 text-muted">
        Mohon maaf, saat ini layanan kami sedang berada di luar jam operasional kantor. <br>
        Silakan kembali lagi pada jam kerja yang telah ditentukan.
      </p>
    </div>

    <div class="card shadow-none border mb-4" style="max-width: 400px; width: 100%;">
      <div class="card-body">
        <h5 class="card-title mb-3">Jam Operasional Hari Ini</h5>
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="fw-bold">{{ $config->nama_hari ?? 'Hari Ini' }}</span>
          @if($config && $config->is_aktif)
            <span class="badge bg-label-success">Buka</span>
          @else
            <span class="badge bg-label-danger">Tutup</span>
          @endif
        </div>
        @if($config && $config->is_aktif && $config->jam_buka)
          <div class="d-flex justify-content-between align-items-center">
            <span>Waktu Operasional:</span>
            <span class="fw-bold text-primary">{{ \Carbon\Carbon::parse($config->jam_buka)->format('H:i') }} - {{ \Carbon\Carbon::parse($config->jam_tutup)->format('H:i') }} WIB</span>
          </div>
        @else
          <div class="text-center text-danger mt-2">
            Kantor libur hari ini.
          </div>
        @endif
      </div>
    </div>

    <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
    
    <div class="mt-4">
      <img src="{{ asset('assets/img/illustrations/page-misc-under-maintenance.png') }}" alt="page-misc-under-maintenance" width="200" class="img-fluid">
    </div>
  </div>
</div>
@endsection

@section('page-style')
<style>
  .misc-wrapper {
    min-height: calc(100vh - 12rem);
  }
</style>
@endsection
