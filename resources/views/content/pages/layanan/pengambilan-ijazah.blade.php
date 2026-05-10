<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pengambilan Ijazah - MAN 1 Kota Bandung</title>
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
      --border-radius: 4px;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    html, body {
      height: 100%;
      overflow-x: hidden;
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
      max-width: 900px;
      background: var(--bg-card);
      backdrop-filter: blur(20px);
      border: 1px solid var(--border-light);
      border-radius: var(--border-radius);
      padding: 40px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
      animation: fadeInUp 0.8s ease-out;
      max-height: 95vh;
      overflow-y: auto;
      overflow-x: hidden;
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

    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-wrapper .prefix {
      position: absolute;
      left: 16px;
      color: var(--text-muted);
      font-weight: 700;
      font-size: 0.95rem;
      pointer-events: none;
      z-index: 2;
    }

    .input-wrapper .wa-flag {
      position: absolute;
      left: 16px;
      display: flex;
      align-items: center;
      gap: 6px;
      color: var(--text-muted);
      font-size: 0.9rem;
      pointer-events: none;
      z-index: 2;
    }

    .input-wrapper .wa-flag img {
      width: 22px;
      height: auto;
      border-radius: 2px;
    }

    .input-wrapper .form-control {
      flex: 1;
    }

    .input-wrapper .form-control.with-prefix {
      padding-left: 48px;
    }

    .input-wrapper .form-control.with-wa-flag {
      padding-left: 80px;
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

    .form-control::placeholder {
      color: var(--text-muted);
      text-transform: uppercase;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary);
      background: rgba(255, 255, 255, 0.08);
      box-shadow: 0 0 0 3px var(--primary-glow);
    }

    select.form-control {
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='rgba(255,255,255,0.6)' d='M1.41.59L6 5.17 10.59.59 12 2l-6 6-6-6z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 16px center;
      padding-right: 40px;
      cursor: pointer;
    }

    select.form-control option {
      background: #1a1a1a;
      color: #fff;
    }

    .select2-container--default .select2-selection--single {
      background-color: rgba(255, 255, 255, 0.05);
      border: 1px solid var(--border-light);
      border-radius: var(--border-radius);
      height: 48px;
      display: flex;
      align-items: center;
      width: 100% !important;
    }
    .select2-container { width: 100% !important; }
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

    .invalid-feedback {
      color: #ff4757;
      font-size: 0.8rem;
      margin-top: 4px;
      display: none;
    }

    .is-invalid {
      border-color: #ff4757 !important;
    }

    .is-invalid + .invalid-feedback,
    .invalid-feedback.show {
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
  </style>
</head>
<body>
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>

  <div class="form-container">
    <div class="form-header">
      <h1>Pengambilan Ijazah</h1>
      <p>Lengkapi data diri Anda untuk pengambilan ijazah</p>
    </div>

    <form id="ijazahForm">
      <div class="row">
        <div class="form-group">
          <input type="text" name="nama_lengkap" class="form-control" placeholder="TULIS NAMA LENGKAP" required>
          <div class="invalid-feedback" data-field="nama_lengkap"></div>
        </div>
        <div class="form-group">
          <select name="jenis_kelamin" class="form-control select2" required>
            <option value="" disabled selected>JENIS KELAMIN</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
          <div class="invalid-feedback" data-field="jenis_kelamin"></div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <div class="input-wrapper">
            <span class="prefix">XII</span>
            <input type="text" name="kelas_asal" class="form-control with-prefix" placeholder="KELAS ASAL CONTOH : MIPA 1" required>
          </div>
          <div class="invalid-feedback" data-field="kelas_asal"></div>
        </div>
        <div class="form-group">
          <input type="number" name="tahun_lulus" class="form-control" placeholder="TAHUN LULUS CONTOH : 1990" min="1980" max="2030" required>
          <div class="invalid-feedback" data-field="tahun_lulus"></div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <input type="date" name="tgl_pengajuan" class="form-control" placeholder="TANGGAL PENGAJUAN AMBIL IJAZAH" readonly required>
          <div class="invalid-feedback" data-field="tgl_pengajuan"></div>
        </div>
        <div class="form-group">
          <div class="input-wrapper">
            <span class="wa-flag">
              <svg width="22" height="15" viewBox="0 0 22 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="22" height="15" fill="#fff"/>
                <rect y="0" width="22" height="5" fill="#e30a17"/>
                <rect y="10" width="22" height="5" fill="#e30a17"/>
              </svg>
              +62
            </span>
            <input type="text" name="no_wa" class="form-control with-wa-flag" placeholder="NOMOR WHATSAPP" required>
          </div>
          <div class="invalid-feedback" data-field="no_wa"></div>
        </div>
      </div>

      <button type="submit" class="btn-submit" id="btnSubmit">
        <i class="bx bx-paper-plane"></i> Ajukan Pengambilan Ijazah
      </button>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize Select2
      $('.select2').select2({ width: '100%' });

      // Auto-fill tanggal pengajuan with today
      const tglInput = document.querySelector('[name="tgl_pengajuan"]');
      if (tglInput) {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        tglInput.value = yyyy + '-' + mm + '-' + dd;
      }

      const form = document.getElementById('ijazahForm');
      const btnSubmit = document.getElementById('btnSubmit');

      form.addEventListener('submit', async function(e) {
        e.preventDefault();

        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => {
          el.textContent = '';
          el.classList.remove('show');
        });

        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Mengirim...';

        const formData = new FormData(form);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
          const response = await fetch('{{ route("ptsp.pengambilan-ijazah.store") }}', {
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
              html: 'Permohonan pengambilan ijazah berhasil dikirim.<br><br><strong>Nomor Tiket:</strong><br><span style="font-size:1.5rem;font-weight:800;color:#2ecc71;letter-spacing:2px">' + data.no_tiket + '</span>',
              confirmButtonColor: '#2ecc71',
              borderRadius: '4px'
            }).then(() => {
              form.reset();
              $('.select2').val(null).trigger('change');
              if (tglInput) {
                const today = new Date();
                const yyyy = today.getFullYear();
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const dd = String(today.getDate()).padStart(2, '0');
                tglInput.value = yyyy + '-' + mm + '-' + dd;
              }
            });
          } else if (response.status === 422) {
            for (const [field, messages] of Object.entries(data.errors)) {
              const input = form.querySelector(`[name="${field}"]`);
              const feedback = form.querySelector(`.invalid-feedback[data-field="${field}"]`);
              if (input) input.classList.add('is-invalid');
              if (feedback) {
                feedback.textContent = messages[0];
                feedback.classList.add('show');
              }
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
          btnSubmit.innerHTML = '<i class="bx bx-paper-plane"></i> Ajukan Pengambilan Ijazah';
        }
      });
    });
  </script>
</body>
</html>
