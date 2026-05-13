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
      
      {{-- Redaksi Notifikasi WhatsApp --}}
      <div class="panel shadow-sm">
        <div class="section-head">
          <h5 class="section-head-title"><span class="dot"></span> Redaksi Notifikasi WhatsApp</h5>
        </div>
        <form method="POST" action="{{ route('admin.pengaturan.umum.templates.update') }}">
          @csrf
          @method('PUT')
          <div class="panel-body">
            <div class="mb-3">
              <div class="form-text">Gunakan placeholder berikut di dalam redaksi: <code>{no_tiket}</code>, <code>{layanan}</code>, <code>{nama}</code>, <code>{status_label}</code>, <code>{waktu}</code>, <code>{catatan}</code>.</div>
            </div>

            <div class="mb-3 row g-2 align-items-center">
              <label class="col-auto form-label fw-bold mb-0">Gaya Default</label>
              <div class="col-auto">
                <select id="wa_template_style" class="form-select">
                  <option value="">-- Pilih gaya default --</option>
                  <option value="formal">Formal</option>
                  <option value="informatif">Informatif</option>
                  <option value="lengkap">Lengkap</option>
                  <option value="ramah">Ramah</option>
                </select>
              </div>
              <div class="col-auto">
                <button type="button" id="wa_apply_style" class="btn btn-outline-secondary">Terapkan ke semua template</button>
              </div>
            </div>

            <div class="row g-3">
              <div class="col-12">
                <label class="form-label fw-bold">Template - Permohonan Baru (Petugas)</label>
                <textarea name="wa_template_baru_petugas" class="form-control" rows="4" placeholder="Template untuk notifikasi petugas">{{ old('wa_template_baru_petugas', $pengaturan['wa_template_baru_petugas'] ?? '') }}</textarea>
                <div class="form-text">Contoh: <code>{layanan}</code>, <code>{no_tiket}</code>, <code>{nama}</code></div>
              </div>

              <div class="col-12">
                <label class="form-label fw-bold">Template - Permohonan Baru (Pemohon)</label>
                <textarea name="wa_template_baru_pemohon" class="form-control" rows="4" placeholder="Template untuk notifikasi pemohon">{{ old('wa_template_baru_pemohon', $pengaturan['wa_template_baru_pemohon'] ?? '') }}</textarea>
                <div class="form-text">Pesan yang diterima pemohon setelah mengajukan permohonan.</div>
              </div>

              <div class="col-12">
                <label class="form-label fw-bold">Template - Permohonan Baru (Group WA)</label>
                <textarea name="wa_template_baru_group" class="form-control" rows="3" placeholder="Template untuk notifikasi group">{{ old('wa_template_baru_group', $pengaturan['wa_template_baru_group'] ?? '') }}</textarea>
                <div class="form-text">Pesan yang dikirim ke group WA jika dikonfigurasi.</div>
              </div>

              <div class="col-12">
                <label class="form-label fw-bold">Template - Perubahan Status (Petugas)</label>
                <textarea name="wa_template_status_petugas" class="form-control" rows="3" placeholder="Template untuk notifikasi status ke petugas">{{ old('wa_template_status_petugas', $pengaturan['wa_template_status_petugas'] ?? '') }}</textarea>
              </div>

              <div class="col-12">
                <label class="form-label fw-bold">Template - Perubahan Status (Pemohon)</label>
                <textarea name="wa_template_status_pemohon" class="form-control" rows="4" placeholder="Template untuk notifikasi status ke pemohon">{{ old('wa_template_status_pemohon', $pengaturan['wa_template_status_pemohon'] ?? '') }}</textarea>
                <div class="form-text">Sertakan <code>{catatan}</code> jika ingin menyampaikan keterangan tambahan.</div>
              </div>

              <div class="col-12">
                <label class="form-label fw-bold">Template - Perubahan Status (Group WA)</label>
                <textarea name="wa_template_status_group" class="form-control" rows="3" placeholder="Template untuk notifikasi status ke group">{{ old('wa_template_status_group', $pengaturan['wa_template_status_group'] ?? '') }}</textarea>
              </div>
            </div>
          </div>
          <div class="form-actions text-end px-4 pb-4">
            <button type="submit" class="btn btn-primary">
              <i class="ti tabler-device-floppy me-2"></i>Simpan Redaksi Notifikasi WA
            </button>
          </div>
        </form>
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
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const styleSelect = document.getElementById('wa_template_style');
    const applyBtn = document.getElementById('wa_apply_style');

    // helper to get textarea elements
    const getArea = (name) => document.querySelector(`[name="${name}"]`);

    const styles = {
      formal: {
        baru_petugas: "📌 Pemberitahuan Permohonan Baru\n\nLayanan: {layanan}\nNo. Tiket: {no_tiket}\nNama: {nama}\nStatus: {status_label}\nWaktu: {waktu}\n\nMohon tindak lanjut sesuai prosedur.",
        baru_pemohon: "Yth. {nama},\n\nPermohonan Anda untuk layanan {layanan} telah diterima dengan nomor tiket {no_tiket}.\nStatus saat ini: {status_label}.\n\nTerima kasih.\n{waktu}",
        baru_group: "📌 Permohonan Baru - {no_tiket}\nLayanan: {layanan}\nNama: {nama}\nStatus: {status_label}\nWaktu: {waktu}",
        status_petugas: "🔔 Pembaruan Status\n\nLayanan: {layanan}\nNo. Tiket: {no_tiket}\nNama: {nama}\nStatus: {status_label}\n{catatan}",
        status_pemohon: "Halo {nama},\n\nStatus permohonan Anda (No. {no_tiket}) untuk layanan {layanan} telah diperbarui menjadi: {status_label}.\n{catatan}\n\nTerima kasih.",
        status_group: "🔔 Status Permohonan - {no_tiket}\nLayanan: {layanan}\nNama: {nama}\nStatus: {status_label}\n{catatan}",
      },
      informatif: {
        baru_petugas: "📣 Ada permohonan baru:\nLayanan: {layanan}\nNo. Tiket: {no_tiket}\nNama pemohon: {nama}\nWaktu: {waktu}\nSilakan cek sistem untuk detail.",
        baru_pemohon: "Halo {nama},\nPermohonan Anda telah masuk (No. {no_tiket}) untuk layanan {layanan}.\nKami akan memberi kabar jika status berubah.",
        baru_group: "Baru: {layanan} - {no_tiket} oleh {nama} pada {waktu}",
        status_petugas: "Info: Status {no_tiket} berubah menjadi {status_label}. {catatan}",
        status_pemohon: "Pemberitahuan: Permohonan {no_tiket} sekarang berstatus {status_label}. {catatan}",
        status_group: "Status update: {no_tiket} -> {status_label}. {catatan}",
      },
      lengkap: {
        baru_petugas: "📝 Permohonan Baru Diterima\n\nDetail:\n- Layanan: {layanan}\n- No. Tiket: {no_tiket}\n- Nama: {nama}\n- Status: {status_label}\n- Waktu: {waktu}\n\nSilakan buka panel permohonan untuk melihat formulir dan lampiran.",
        baru_pemohon: "Terima kasih {nama},\nPermohonan Anda (No. {no_tiket}) untuk layanan {layanan} telah diterima pada {waktu}.\nKami akan memproses dan menginformasikan setiap perubahan status.\nJika perlu, hubungi petugas terkait.",
        baru_group: "Permohonan Baru:\n- Layanan: {layanan}\n- No: {no_tiket}\n- Pemohon: {nama}\n- Waktu: {waktu}",
        status_petugas: "🛠️ Perbaruan Status:\nLayanan: {layanan}\nNo. Tiket: {no_tiket}\nPemohon: {nama}\nStatus saat ini: {status_label}\n{catatan}\nMohon tindak lanjut jika diperlukan.",
        status_pemohon: "Halo {nama},\nPerubahan status permohonan Anda (No. {no_tiket}) untuk {layanan}: {status_label}.\n{catatan}\nTerima kasih atas perhatian Anda.",
        status_group: "Detail update:\nLayanan: {layanan}\nNo. {no_tiket}\nNama: {nama}\nStatus: {status_label}\n{catatan}",
      },
      ramah: {
        baru_petugas: "Hai tim, ada permohonan baru nih! 😊\nLayanan: {layanan}\nNo. Tiket: {no_tiket}\nNama: {nama}\nWaktu: {waktu}\nTolong ditangani ya.",
        baru_pemohon: "Halo {nama}! Terima kasih, permohonan Anda (No. {no_tiket}) untuk {layanan} sudah kami terima. Kami akan proses secepatnya.👍",
        baru_group: "Yay! Permohonan baru: {layanan} - {no_tiket} oleh {nama} pada {waktu}",
        status_petugas: "Update: Permohonan {no_tiket} sekarang {status_label}. {catatan}",
        status_pemohon: "Halo {nama}, kabar baik! Status permohonan Anda (No. {no_tiket}) berubah menjadi {status_label}. {catatan}",
        status_group: "Update status {no_tiket}: {status_label}. {catatan}",
      }
    };

    applyBtn?.addEventListener('click', function() {
      const v = styleSelect.value;
      if (!v) return;

      const s = styles[v];
      if (!s) return;

      // set values for each textarea
      getArea('wa_template_baru_petugas').value = s['baru_petugas'];
      getArea('wa_template_baru_pemohon').value = s['baru_pemohon'];
      getArea('wa_template_baru_group').value = s['baru_group'];
      getArea('wa_template_status_petugas').value = s['status_petugas'];
      getArea('wa_template_status_pemohon').value = s['status_pemohon'];
      getArea('wa_template_status_group').value = s['status_group'];
    });
  });
</script>
@endsection
