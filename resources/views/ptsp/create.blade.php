@extends('layouts/contentNavbarLayout')

@section('title', 'Buat Permohonan Baru')

@section('content')
<div class="row">
  <div class="col-md-8 mx-auto">
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
        <h5 class="mb-0 text-white">Formulir Pengajuan: {{ $layanan->nama_layanan }}</h5>
        <small class="text-white-50">Silakan lengkapi data di bawah ini</small>
      </div>
      <div class="card-body mt-4">
        <div class="alert alert-info mb-4">
          <h6 class="alert-heading fw-bold">Persyaratan:</h6>
          <p class="mb-0" style="white-space: pre-line;">{{ $layanan->persyaratan }}</p>
        </div>

        <form action="{{ route('ptsp.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">
          
          <div class="mb-3">
            <label class="form-label fw-bold">Nama Pemohon</label>
            <input type="text" class="form-control bg-light" value="{{ auth()->user()->name }}" readonly disabled>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Keterangan Tambahan / Informasi Pendukung</label>
            <textarea name="data_form[keterangan]" class="form-control" rows="4" placeholder="Tuliskan keterangan detail permohonan Anda..."></textarea>
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold">Unggah Berkas Pendukung (Opsional)</label>
            <input type="file" class="form-control" name="data_form[file]">
            <small class="text-muted">Format: PDF/JPG/PNG, Max: 2MB</small>
          </div>

          <hr class="my-4">

          <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('ptsp.index') }}" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-primary px-5">Kirim Permohonan <i class="ti tabler-send ms-1"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
