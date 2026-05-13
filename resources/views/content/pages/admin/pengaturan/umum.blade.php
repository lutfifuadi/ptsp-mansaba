@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Pengaturan Umum - Admin')

@section('page-style')
  @include('_partials.admin-styles')
  <style>
    .panel-body {
      padding: 1.5rem;
    }
    .section-head {
      padding: 0.6rem 1.5rem !important;
      min-height: 45px;
    }
    .section-head-title {
      margin: 0 !important;
    }
    .form-actions {
      border-top: 1px solid var(--border);
      padding-top: 1rem;
    }
  </style>
@endsection

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

  {{-- Success alert --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible mb-4" role="alert">
      <div class="d-flex">
        <i class="ti tabler-check me-2 text-success"></i>
        <div>{{ session('success') }}</div>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.pengaturan.umum.update') }}" id="settingsForm">
    @csrf
    @method('PUT')

    <div class="d-flex flex-column gap-4">
      
      <div class="row g-4">
        {{-- Konfigurasi Sistem --}}
        <div class="col-12 col-md-6 col-lg-7">
          <div class="panel shadow-sm h-100">
            <div class="section-head">
              <h5 class="section-head-title"><span class="dot"></span> Konfigurasi Sistem</h5>
            </div>
            <div class="panel-body">
              <div class="mb-3">
                <label class="form-label fw-bold">
                  <i class="ti tabler-apps me-1 text-primary"></i> Nama Aplikasi
                </label>
                <input type="text" name="app_name" class="form-control" value="{{ old('app_name', $pengaturan['app_name']) }}" placeholder="Aplikasi PTSP" required>
                <div class="form-text">Nama yang tampil di title bar dan header sistem.</div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">
                  <i class="ti tabler-tag me-1 text-primary"></i> Versi Aplikasi
                </label>
                <input type="text" name="app_version" class="form-control" value="{{ old('app_version', $pengaturan['app_version']) }}" placeholder="1.0.0" required>
                <div class="form-text">Versi rilis aplikasi saat ini.</div>
              </div>

              <div class="mb-0">
                <label class="form-label fw-bold">
                  <i class="ti tabler-clock me-1 text-primary"></i> Zona Waktu
                </label>
                <select name="app_timezone" class="form-select">
                  <option value="Asia/Jakarta" {{ $pengaturan['app_timezone'] == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB — GMT+7)</option>
                  <option value="Asia/Makassar" {{ $pengaturan['app_timezone'] == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA — GMT+8)</option>
                  <option value="Asia/Jayapura" {{ $pengaturan['app_timezone'] == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT — GMT+9)</option>
                  <option value="Asia/Pontianak" {{ $pengaturan['app_timezone'] == 'Asia/Pontianak' ? 'selected' : '' }}>Asia/Pontianak (WIB — GMT+7)</option>
                  <option value="UTC" {{ $pengaturan['app_timezone'] == 'UTC' ? 'selected' : '' }}>UTC</option>
                </select>
                <div class="form-text">Zona waktu sistem untuk menentukan waktu server.</div>
              </div>
            </div>
          </div>
        </div>

        {{-- Integrasi WhatsApp --}}
        <div class="col-12 col-md-6 col-lg-5">
          <div class="panel shadow-sm h-100">
            <div class="section-head">
              <h5 class="section-head-title"><span class="dot"></span> Integrasi WhatsApp</h5>
            </div>
            <div class="panel-body">
              <div class="mb-3">
                <label class="form-label fw-bold">
                  <i class="ti tabler-key me-1 text-primary"></i> API Key
                </label>
                <input type="password" name="wa_api_key" class="form-control" value="{{ old('wa_api_key', $pengaturan['wa_api_key']) }}" placeholder="Masukkan API Key WhatsApp">
                <div class="form-text">API Key dari <code>https://wa.lutfifuadi.my.id</code></div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">
                  <i class="ti tabler-phone me-1 text-primary"></i> Nomor Pengirim (Sender)
                </label>
                <input type="text" name="wa_sender" class="form-control" value="{{ old('wa_sender', $pengaturan['wa_sender']) }}" placeholder="628xxxxxxx">
                <div class="form-text">Nomor WhatsApp yang digunakan sebagai pengirim.</div>
              </div>

              <div class="mb-0">
                <label class="form-label fw-bold">
                  <i class="ti tabler-messages me-1 text-primary"></i> Group WA Notifikasi
                </label>
                <input type="text" name="wa_group_id" class="form-control" value="{{ old('wa_group_id', $pengaturan['wa_group_id'] ?? '') }}" placeholder="120363xxxxxx@g.us">
                <div class="form-text">ID Group WhatsApp untuk notifikasi otomatis (opsional).</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Pengaturan Dokumen --}}
      <div class="panel shadow-sm">
        <div class="section-head">
          <h5 class="section-head-title"><span class="dot"></span> Pengaturan Dokumen</h5>
        </div>
        <div class="panel-body">
          <div class="row g-3">
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold">
                <i class="ti tabler-calendar me-1 text-primary"></i> Tahun Ajaran <span class="text-danger">*</span>
              </label>
              <input type="text" name="tahun_ajaran" class="form-control" value="{{ old('tahun_ajaran', $pengaturan['tahun_ajaran']) }}" placeholder="2025/2026" required>
              <div class="form-text">Variabel <code>${tahun_ajaran}</code> di redaksi surat.</div>
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label fw-bold">
                <i class="ti tabler-calendar-event me-1 text-primary"></i> Tanggal Surat (Default) <span class="text-danger">*</span>
              </label>
              <input type="date" name="tanggal_surat" class="form-control" value="{{ old('tanggal_surat', $pengaturan['tanggal_surat']) }}" required>
              <div class="form-text">Tanggal default pada surat keterangan.</div>
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label fw-bold">
                <i class="ti tabler-underline me-1 text-primary"></i> Teks Footer Dokumen
              </label>
              <input type="text" name="footer_teks" class="form-control" value="{{ old('footer_teks', $pengaturan['footer_teks']) }}" placeholder="Teks footer dokumen">
              <div class="form-text">Teks kecil di bagian bawah halaman PDF.</div>
            </div>
          </div>
        </div>
      </div>

      {{-- Pengaturan Footer --}}
      <div class="panel shadow-sm">
        <div class="section-head">
          <h5 class="section-head-title"><span class="dot"></span> Pengaturan Footer</h5>
        </div>
        <div class="panel-body">
          <div class="row g-3">
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold">
                <i class="ti tabler-copyright me-1 text-primary"></i> Teks Copyright
              </label>
              <input type="text" name="footer_copyright" class="form-control" value="{{ old('footer_copyright', $pengaturan['footer_copyright']) }}" placeholder="© 2026">
              <div class="form-text">Contoh: <code>© 2026</code></div>
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label fw-bold">
                <i class="ti tabler-user me-1 text-primary"></i> Made By (Nama)
              </label>
              <input type="text" name="footer_made_by" class="form-control" value="{{ old('footer_made_by', $pengaturan['footer_made_by']) }}" placeholder="Pixinvent">
              <div class="form-text">Nama instansi/developer di footer.</div>
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label fw-bold">
                <i class="ti tabler-link me-1 text-primary"></i> Made By (URL)
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
        
        <div class="form-actions text-end px-4 pb-4">
          <button type="submit" class="btn btn-primary">
            <i class="ti tabler-device-floppy me-2"></i>Simpan Seluruh Pengaturan Umum
          </button>
        </div>
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
          '<i class="ti tabler-alert-circle me-1"></i> Mohon lengkapi field yang wajib diisi.' +
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
