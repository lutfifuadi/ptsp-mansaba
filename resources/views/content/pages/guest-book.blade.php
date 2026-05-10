<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Buku Tamu Online - MAN 1 Kota Bandung</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::get('logo_kanan') ?: asset('assets/img/favicon/favicon.ico') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  
  <style>
    :root {
      --primary: #2ecc71;
      --primary-dark: #27ae60;
      --primary-glow: rgba(46, 204, 113, 0.4);
      --bg-dark: #061410;
      --bg-card: rgba(255, 255, 255, 0.05);
      --border-light: rgba(255, 255, 255, 0.1);
      --text-main: #ffffff;
      --text-muted: rgba(255, 255, 255, 0.6);
      --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
      --border-radius: 4px; /* Updated to 4px */
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      overflow-x: hidden; /* Prevent horizontal scroll */
      overflow-y: hidden;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg-dark);
      color: var(--text-main);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
    }

    /* Background Blobs */
    .blob {
      position: fixed;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, var(--primary-glow) 0%, transparent 70%);
      filter: blur(80px);
      border-radius: 50%;
      z-index: -1;
      opacity: 0.5;
    }
    .blob-1 { top: -200px; left: -100px; }
    .blob-2 { bottom: -200px; right: -100px; }

    .form-container {
      width: 100%;
      max-width: 900px; /* Wider for PC/Desktop */
      background: var(--bg-card);
      backdrop-filter: blur(20px);
      border: 1px solid var(--border-light);
      border-radius: var(--border-radius);
      padding: 40px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
      animation: fadeInUp 0.8s ease-out;
      max-height: 95vh;
      overflow-y: auto;
      overflow-x: hidden; /* Prevent horizontal scroll in container */
      scrollbar-width: thin;
      scrollbar-color: var(--primary) transparent;
    }
    .form-container::-webkit-scrollbar { width: 4px; }
    .form-container::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 10px; }

    .form-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .form-header h1 {
      font-size: 2.2rem;
      font-weight: 800;
      background: linear-gradient(135deg, #fff 40%, var(--primary) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 4px;
    }

    .form-header p {
      color: var(--text-muted);
      font-size: 1rem;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-label {
      display: block;
      font-size: 0.85rem;
      font-weight: 600;
      margin-bottom: 6px;
      color: var(--text-main);
      display: flex;
      align-items: center;
      gap: 8px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .form-label i {
      color: var(--primary);
    }

    .form-control {
      width: 100%;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid var(--border-light);
      border-radius: var(--border-radius);
      padding: 12px 16px;
      color: #fff;
      font-family: inherit;
      font-size: 0.95rem;
      transition: var(--transition);
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary);
      background: rgba(255, 255, 255, 0.08);
      box-shadow: 0 0 0 3px var(--primary-glow);
    }

    .row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 24px;
    }

    .btn-submit {
      width: 100%;
      background: var(--primary);
      color: #000;
      border: none;
      border-radius: var(--border-radius);
      padding: 16px;
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      margin-top: 10px;
    }

    .btn-submit:hover {
      background: var(--text-main);
      transform: translateY(-2px);
    }

    .btn-submit:disabled {
      opacity: 0.7;
      cursor: not-allowed;
    }

    /* Select2 Custom Styles */
    .select2-container--default .select2-selection--single {
      background-color: rgba(255, 255, 255, 0.05);
      border: 1px solid var(--border-light);
      border-radius: var(--border-radius);
      height: 48px;
      display: flex;
      align-items: center;
      width: 100% !important;
    }
    .select2-container {
      width: 100% !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #fff;
      padding-left: 16px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 46px;
    }
    .select2-dropdown {
      background-color: #1a1a1a;
      border: 1px solid var(--border-light);
      border-radius: var(--border-radius);
      color: #fff;
    }
    .select2-results__option--selectable {
      padding: 10px 16px;
    }
    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
      background-color: var(--primary);
      color: #000;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
      background-color: rgba(255, 255, 255, 0.05);
      border: 1px solid var(--border-light);
      border-radius: var(--border-radius);
      color: #fff;
    }

    .invalid-feedback {
      color: #ff4757;
      font-size: 0.8rem;
      margin-top: 4px;
      display: none;
    }

    .is-invalid {
      border-color: #ff4757 !important;
    }

    .is-invalid + .invalid-feedback {
      display: block;
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
      .row { grid-template-columns: 1fr; gap: 0; }
      .form-container { padding: 30px 20px; }
      .form-header h1 { font-size: 1.8rem; }
      body { overflow: auto; height: auto; }
      html { overflow: auto; }
    }

    .back-link {
      position: absolute;
      top: 20px;
      left: 20px;
      color: var(--text-muted);
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 600;
      transition: var(--transition);
      z-index: 10;
      font-size: 0.9rem;
    }

    .back-link:hover {
      color: var(--primary);
    }

    .form-footer-link:hover {
      color: var(--primary) !important;
      transform: translateX(-4px);
    }
  </style>
</head>
<body>
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>

  <div class="form-container">
    <div class="form-header">
      <h1>Buku Tamu Online</h1>
      <p>Silakan lengkapi data kunjungan Anda</p>
    </div>

    <form id="guestBookForm">
      <div class="row">
        <div class="form-group">
          <input type="text" name="nama_lengkap" class="form-control" placeholder="NAMA LENGKAP" required>
          <div class="invalid-feedback" data-field="nama_lengkap"></div>
        </div>
        <div class="form-group">
          <input type="text" name="no_whatsapp" class="form-control" placeholder="NOMOR WHATSAPP (AKTIF)" required>
          <div class="invalid-feedback" data-field="no_whatsapp"></div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <label class="form-label"><i class="bx bx-buildings"></i> Jenis Instansi</label>
          <select name="jenis_instansi" class="form-control select2" id="jenisInstansi" required>
            <option value="Personal">Personal</option>
            <option value="Lembaga">Lembaga</option>
            <option value="Instansi">Instansi</option>
          </select>
          <div class="invalid-feedback" data-field="jenis_instansi"></div>
        </div>
        <div class="form-group" id="namaInstansiGroup" style="display: none;">
          <label class="form-label"><i class="bx bx-building-house"></i> Nama Instansi / Lembaga</label>
          <input type="text" name="nama_instansi" class="form-control" placeholder="Nama instansi/lembaga" required>
          <div class="invalid-feedback" data-field="nama_instansi"></div>
        </div>
      </div>

      <div class="form-group">
        <input type="text" name="alamat" class="form-control" placeholder="ALAMAT LENGKAP" required>
        <div class="invalid-feedback" data-field="alamat"></div>
      </div>

      <div class="form-group">
        <select name="tujuan" class="form-control select2" required>
          <option value="" disabled selected>PILIH TUJUAN KUNJUNGAN</option>
          <option value="Kepala Madrasah">Kepala Madrasah</option>
          <option value="WAKAMAD Kesiswaan">WAKAMAD Kesiswaan</option>
          <option value="WAKAMAD Kurikulum">WAKAMAD Kurikulum</option>
          <option value="WAKAMAD Humas">WAKAMAD Humas</option>
          <option value="WAKAMAD Sarana Prasarana">WAKAMAD Sarana Prasarana</option>
          <option value="Tata Usaha">Tata Usaha</option>
          <option value="Guru">Guru</option>
          <option value="Lainnya">Lainnya</option>
        </select>
        <div class="invalid-feedback" data-field="tujuan"></div>
      </div>

      <div class="form-group">
        <input type="text" name="keperluan" class="form-control" placeholder="MAKSUD DAN KEPERLUAN" required>
        <div class="invalid-feedback" data-field="keperluan"></div>
      </div>

      <button type="submit" class="btn-submit" id="btnSubmit">
        <i class="bx bx-paper-plane"></i> Kirim Data Kunjungan
      </button>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize Select2
      $('.select2').select2({
        width: '100%'
      });

      const form = document.getElementById('guestBookForm');
      const jenisInstansi = $('#jenisInstansi');
      const namaInstansiGroup = document.getElementById('namaInstansiGroup');
      const btnSubmit = document.getElementById('btnSubmit');

      // Toggle Nama Instansi input
      jenisInstansi.on('change', function() {
        if (this.value === 'Personal') {
          $(namaInstansiGroup).fadeOut();
          namaInstansiGroup.querySelector('input').value = '';
        } else {
          $(namaInstansiGroup).fadeIn();
        }
      });

      // Handle form submission
      form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Reset validation
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Mengirim...';

        const formData = new FormData(form);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
          const response = await fetch('{{ route("buku-tamu.store") }}', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken,
              'Accept': 'application/json'
            },
            body: formData
          });

          const data = await response.json();

          if (response.ok) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: data.message,
              confirmButtonColor: '#2ecc71',
              borderRadius: '4px'
            }).then(() => {
              form.reset();
              $('.select2').val(null).trigger('change');
              window.location.href = '{{ route("home") }}';
            });
          } else if (response.status === 422) {
            for (const [field, messages] of Object.entries(data.errors)) {
              const input = form.querySelector(`[name="${field}"]`);
              const feedback = form.querySelector(`.invalid-feedback[data-field="${field}"]`);
              if (input) input.classList.add('is-invalid');
              if (feedback) feedback.textContent = messages[0];
            }
            
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Mohon periksa kembali isian Anda.',
              confirmButtonColor: '#2ecc71',
              borderRadius: '4px'
            });
          } else {
            throw new Error(data.message || 'Terjadi kesalahan sistem.');
          }
        } catch (error) {
          Swal.fire({
            icon: 'error',
            title: 'Kesalahan',
            text: error.message,
            confirmButtonColor: '#2ecc71',
            borderRadius: '4px'
          });
        } finally {
          btnSubmit.disabled = false;
          btnSubmit.innerHTML = '<i class="bx bx-paper-plane"></i> Kirim Data Kunjungan';
        }
      });
    });
  </script>
</body>
</html>
