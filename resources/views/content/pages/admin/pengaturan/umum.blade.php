@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Pengaturan Umum - Admin')

@section('content')
  <div class="mb-4">
    <h4 class="fw-bold mb-1">Pengaturan Umum</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Pengaturan</li>
        <li class="breadcrumb-item active">Umum</li>
      </ol>
    </nav>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible mb-4" role="alert">
      <div class="d-flex">
        <i class="icon-base ti tabler-check me-2 text-success"></i>
        <div>{{ session('success') }}</div>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger alert-dismissible mb-4" role="alert">
      <div class="d-flex">
        <i class="icon-base ti tabler-alert-circle me-2 text-danger"></i>
        <div>
          <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.pengaturan.umum.update') }}" id="settingsForm">
    @csrf
    @method('PUT')

    <div class="row g-4">
      {{-- Konfigurasi Sistem --}}
      <div class="col-12 col-md-6 col-lg-7">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-header bg-label-secondary py-3">
            <h5 class="mb-0 text-secondary"><i class="icon-base ti tabler-server me-2"></i>Konfigurasi Sistem</h5>
          </div>
          <div class="card-body pt-4">
            <div class="mb-3">
              <label class="form-label fw-bold">
                <i class="icon-base ti tabler-apps me-1 text-primary"></i> Nama Aplikasi
              </label>
              <input type="text" name="app_name" class="form-control" value="{{ old('app_name', $pengaturan['app_name']) }}" placeholder="Aplikasi PTSP" required>
              <div class="form-text">Nama yang tampil di title bar dan header sistem.</div>
            </div>

            <div class="mb-0">
              <label class="form-label fw-bold">
                <i class="icon-base ti tabler-tag me-1 text-primary"></i> Versi Aplikasi
              </label>
              <input type="text" name="app_version" class="form-control" value="{{ old('app_version', $pengaturan['app_version']) }}" placeholder="1.0.0" required>
              <div class="form-text">Versi rilis aplikasi saat ini.</div>
            </div>
          </div>
        </div>
      </div>

      {{-- Integrasi WhatsApp --}}
      <div class="col-12 col-md-6 col-lg-5">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-header bg-label-secondary py-3">
            <h5 class="mb-0 text-secondary"><i class="icon-base ti tabler-brand-whatsapp me-2"></i>Integrasi WhatsApp</h5>
          </div>
          <div class="card-body pt-4">
            <div class="mb-3">
              <label class="form-label fw-bold">
                <i class="icon-base ti tabler-key me-1 text-primary"></i> API Key
              </label>
              <input type="password" name="wa_api_key" class="form-control" value="{{ old('wa_api_key', $pengaturan['wa_api_key']) }}" placeholder="Masukkan API Key WhatsApp">
              <div class="form-text">API Key dari <code>https://wa.lutfifuadi.my.id</code></div>
            </div>

            <div class="mb-0">
              <label class="form-label fw-bold">
                <i class="icon-base ti tabler-phone me-1 text-primary"></i> Nomor Pengirim (Sender)
              </label>
              <input type="text" name="wa_sender" class="form-control" value="{{ old('wa_sender', $pengaturan['wa_sender']) }}" placeholder="628xxxxxxx">
              <div class="form-text">Nomor WhatsApp yang digunakan sebagai pengirim.</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Pengaturan Dokumen --}}
    <div class="card shadow-sm border-0 mt-4">
      <div class="card-header bg-label-secondary py-3">
        <h5 class="mb-0 text-secondary"><i class="icon-base ti tabler-file-text me-2"></i>Pengaturan Dokumen</h5>
      </div>
      <div class="card-body pt-4">
        <div class="row g-3">
          <div class="col-12 col-md-4">
            <label class="form-label fw-bold">
              <i class="icon-base ti tabler-calendar me-1 text-primary"></i> Tahun Ajaran <span class="text-danger">*</span>
            </label>
            <input type="text" name="tahun_ajaran" class="form-control" value="{{ old('tahun_ajaran', $pengaturan['tahun_ajaran']) }}" placeholder="2025/2026" required>
            <div class="form-text">Variabel <code>${tahun_ajaran}</code> di redaksi surat.</div>
          </div>

          <div class="col-12 col-md-4">
            <label class="form-label fw-bold">
              <i class="icon-base ti tabler-calendar-event me-1 text-primary"></i> Tanggal Surat (Default) <span class="text-danger">*</span>
            </label>
            <input type="date" name="tanggal_surat" class="form-control" value="{{ old('tanggal_surat', $pengaturan['tanggal_surat']) }}" required>
            <div class="form-text">Tanggal default pada surat keterangan.</div>
          </div>

          <div class="col-12 col-md-4">
            <label class="form-label fw-bold">
              <i class="icon-base ti tabler-underline me-1 text-primary"></i> Teks Footer Dokumen
            </label>
            <input type="text" name="footer_teks" class="form-control" value="{{ old('footer_teks', $pengaturan['footer_teks']) }}" placeholder="Teks footer dokumen">
            <div class="form-text">Teks kecil di bagian bawah halaman PDF.</div>
          </div>
        </div>
      </div>
    {{-- Pengaturan Footer --}}
    <div class="card shadow-sm border-0 mt-4">
      <div class="card-header bg-label-secondary py-3">
        <h5 class="mb-0 text-secondary"><i class="icon-base ti tabler-layout-footer me-2"></i>Pengaturan Footer</h5>
      </div>
      <div class="card-body pt-4">
        <div class="row g-3">
          <div class="col-12 col-md-4">
            <label class="form-label fw-bold">
              <i class="icon-base ti tabler-copyright me-1 text-primary"></i> Teks Copyright
            </label>
            <input type="text" name="footer_copyright" class="form-control" value="{{ old('footer_copyright', $pengaturan['footer_copyright']) }}" placeholder="© 2026">
            <div class="form-text">Contoh: <code>© 2026</code></div>
          </div>

          <div class="col-12 col-md-4">
            <label class="form-label fw-bold">
              <i class="icon-base ti tabler-user me-1 text-primary"></i> Made By (Nama)
            </label>
            <input type="text" name="footer_made_by" class="form-control" value="{{ old('footer_made_by', $pengaturan['footer_made_by']) }}" placeholder="Pixinvent">
            <div class="form-text">Nama instansi/developer di footer.</div>
          </div>

          <div class="col-12 col-md-4">
            <label class="form-label fw-bold">
              <i class="icon-base ti tabler-link me-1 text-primary"></i> Made By (URL)
            </label>
            <input type="url" name="footer_made_by_url" class="form-control" value="{{ old('footer_made_by_url', $pengaturan['footer_made_by_url']) }}" placeholder="https://...">
            <div class="form-text">Link tujuan saat nama di atas diklik.</div>
          </div>

          <div class="col-12 mt-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="footer_show_links" id="footer_show_links" value="1" {{ old('footer_show_links', $pengaturan['footer_show_links']) == '1' ? 'checked' : '' }}>
              <label class="form-check-label fw-bold" for="footer_show_links">Tampilkan Link Footer (License, Documentation, dll.)</label>
            </div>
            <div class="form-text">Jika dinonaktifkan, link di sisi kanan footer akan disembunyikan.</div>
          </div>
        </div>
      </div>
      <div class="card-footer bg-transparent border-0 pt-0 pb-4 px-4 text-end">
        <button type="submit" class="btn btn-primary btn-lg shadow">
          <i class="icon-base ti tabler-device-floppy me-2"></i>Simpan Semua Pengaturan
        </button>
      </div>
    </div>
  </form>
@endsection

@section('page-script')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('settingsForm');
    const requiredFields = form.querySelectorAll('[required]');

    form.addEventListener('submit', function(e) {
      let valid = true;
      requiredFields.forEach(function(field) {
        if (!field.value.trim()) {
          field.classList.add('is-invalid');
          valid = false;
        } else {
          field.classList.remove('is-invalid');
        }
      });

      if (!valid) {
        e.preventDefault();
        const alertHtml =
          '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
          '<i class="icon-base ti tabler-alert-circle me-1"></i> Mohon lengkapi field yang wajib diisi.' +
          '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
          '</div>';
        const container = form.querySelector('.alert')?.parentElement || form;
        container.insertAdjacentHTML('afterbegin', alertHtml);
      }
    });

    requiredFields.forEach(function(field) {
      field.addEventListener('input', function() {
        if (this.value.trim()) {
          this.classList.remove('is-invalid');
        }
      });
    });
  });
</script>
@endsection
