@extends('layouts/layoutFront')

@section('title', 'Cek Status Permohonan')

@section('content')
<div class="container-xxl py-5">
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <div class="card shadow-lg border-0 p-4">
        <div class="card-body text-center">
          <div class="mb-4">
            <i class="bx bx-search-alt bx-lg text-primary"></i>
          </div>
          <h2 class="fw-bold mb-3">Lacak Permohonan Anda</h2>
          <p class="text-muted mb-4">Masukkan nomor tiket permohonan yang Anda terima melalui email atau sistem.</p>

          @if(session('error'))
          <div class="alert alert-danger mb-4">
            {{ session('error') }}
          </div>
          @endif

          <form action="{{ route('ptsp.track') }}" method="POST">
            @csrf
            <div class="input-group input-group-lg mb-4">
              <span class="input-group-text bg-white"><i class="bx bx-hash"></i></span>
              <input type="text" name="no_tiket" class="form-control" placeholder="Contoh: PTSP-A1B2C3D4" required>
            </div>
            <button type="submit" class="btn btn-primary btn-lg w-100">Cek Status Sekarang</button>
          </form>

          <div class="mt-4">
            <a href="{{ route('ptsp.index') }}" class="text-muted"><i class="bx bx-chevron-left"></i> Kembali ke Portal Layanan</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
