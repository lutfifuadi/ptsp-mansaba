<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Buku Tamu Online - MAN 1 Kota Bandung</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png"
    href="{{ \App\Models\Pengaturan::get('logo_kanan') ?: asset('assets/img/favicon/favicon.ico') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <style>
    :root {
      --primary: #059669;
      --primary-glow: rgba(5, 150, 105, 0.5);
      --primary-light: #34d399;
      --gold: #d4af37;
      --gold-glow: rgba(212, 175, 55, 0.4);
      --bg-dark: #0f172a;
      --bg-darker: #020617;
      --glass-bg: rgba(15, 23, 42, 0.6);
      --glass-border: rgba(52, 211, 153, 0.2);
      --text-main: #f8fafc;
      --text-muted: #94a3b8;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html,
    body {
      height: 100%;
      overflow-x: hidden;
      overflow-y: hidden;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg-darker);
      color: var(--text-main);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
    }

    /* Animated Grid Background */
    .grid-bg {
      position: fixed;
      inset: 0;
      background-size: 50px 50px;
      background-image:
        linear-gradient(to right, rgba(255, 255, 255, 0.02) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
      z-index: -2;
      transform: perspective(500px) rotateX(60deg) translateY(-100px) translateZ(-200px);
      animation: gridMove 20s linear infinite;
    }

    @keyframes gridMove {
      0% {
        background-position: 0 0;
      }

      100% {
        background-position: 0 50px;
      }
    }

    /* Ambient Glows */
    .glow-orb {
      position: fixed;
      border-radius: 50%;
      filter: blur(100px);
      z-index: -1;
      opacity: 0.4;
      animation: float 10s ease-in-out infinite alternate;
    }

    .glow-emerald {
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, var(--primary) 0%, transparent 70%);
      top: -100px;
      left: -100px;
    }

    .glow-gold {
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, var(--gold) 0%, transparent 70%);
      bottom: -150px;
      right: -100px;
      animation-delay: -5s;
    }

    @keyframes float {
      0% {
        transform: translate(0, 0) scale(1);
      }

      100% {
        transform: translate(30px, 50px) scale(1.1);
      }
    }

    /* Islamic Geometric Pattern Overlay */
    .islamic-pattern {
      position: fixed;
      inset: 0;
      opacity: 0.03;
      z-index: -1;
      background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M30 30L15 15H0v15l15 15-15 15v15h15L30 45l15 15h15V45L45 30l15-15V0H45L30 15zM15 45L0 60v-15l15-15v15zM45 45l15 15V45L45 30v15zM15 15L0 0v15l15 15V15zM45 15l15-15v15L45 30V15z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .form-container {
      width: 100%;
      max-width: 900px;
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-radius: 4px;
      padding: 40px 36px;
      position: relative;
      overflow-y: auto;
      overflow-x: hidden;
      animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
      max-height: 95vh;
      scrollbar-width: thin;
      scrollbar-color: var(--primary-light) transparent;
    }

    .form-container::-webkit-scrollbar {
      width: 4px;
    }

    .form-container::-webkit-scrollbar-thumb {
      background: var(--primary-light);
      border-radius: 10px;
    }

    .form-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--primary-light), var(--gold), transparent);
      opacity: 0.7;
    }

    .form-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .card-icon {
      width: 72px;
      height: 72px;
      border-radius: 4px;
      background: rgba(52, 211, 153, 0.1);
      border: 1px solid rgba(52, 211, 153, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary-light);
      font-size: 36px;
      margin: 0 auto 24px;
      animation: pulseGlow 3s infinite;
    }

    @keyframes pulseGlow {

      0%,
      100% {
        transform: scale(1);
        opacity: 0.5;
      }

      50% {
        transform: scale(1.2);
        opacity: 0.8;
      }
    }

    .form-header h1 {
      font-size: 1.8rem;
      font-weight: 700;
      text-align: center;
      margin-bottom: 8px;
      color: var(--text-main);
    }

    .form-header p {
      font-size: 0.9rem;
      color: var(--text-muted);
      text-align: center;
      margin-bottom: 28px;
      line-height: 1.5;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-label {
      display: block;
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--text-muted);
      margin-bottom: 8px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--primary-light);
      font-size: 20px;
      pointer-events: none;
      z-index: 2;
      /* important for select2 */
    }

    .form-control {
      width: 100%;
      background: rgba(15, 23, 42, 0.8);
      border: 1px solid var(--glass-border);
      border-radius: 4px;
      padding: 14px 16px 14px 46px;
      /* padding-left for icon */
      color: var(--text-main);
      font-size: 1rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      transition: var(--transition);
      outline: none;
    }

    .form-control::placeholder {
      color: rgba(148, 163, 184, 0.5);
    }

    .form-control:focus {
      border-color: var(--primary-light);
      box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.15);
      background: rgba(15, 23, 42, 0.95);
    }

    /* No icon variant */
    .form-control.no-icon {
      padding-left: 16px;
    }

    .row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 24px;
    }

    .btn-submit {
      width: 100%;
      background: linear-gradient(135deg, var(--primary), #047857);
      border: 1px solid var(--primary-light);
      color: #fff;
      padding: 14px 28px;
      border-radius: 4px;
      font-weight: 700;
      font-size: 1rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      transition: var(--transition);
      box-shadow: 0 0 20px rgba(5, 150, 105, 0.2);
      letter-spacing: 0.5px;
      margin-top: 20px;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 30px rgba(5, 150, 105, 0.5);
      background: linear-gradient(135deg, #10b981, var(--primary));
    }

    .btn-submit:active {
      transform: translateY(0);
    }

    .btn-submit:disabled {
      opacity: 0.7;
      cursor: not-allowed;
      transform: none;
    }

    /* Back Link / Divider */
    .divider {
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--glass-border), transparent);
      margin: 24px 0;
    }

    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: var(--gold);
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 500;
      margin-top: 10px;
      transition: var(--transition);
      justify-content: center;
      width: 100%;
      border: 1px solid rgba(212, 175, 55, 0.2);
      padding: 10px 20px;
      border-radius: 4px;
      background: rgba(212, 175, 55, 0.05);
      backdrop-filter: blur(10px);
    }

    .back-link:hover {
      color: var(--bg-darker);
      background: var(--gold);
      border-color: var(--gold);
      box-shadow: 0 0 20px var(--gold-glow);
      transform: translateY(-1px);
    }

    /* Select2 Custom Styles */
    .select2-container--default .select2-selection--single {
      background-color: rgba(15, 23, 42, 0.8);
      border: 1px solid var(--glass-border);
      border-radius: 4px;
      height: auto;
      min-height: 50px;
      /* match input height */
      display: flex;
      align-items: center;
      width: 100% !important;
      transition: var(--transition);
    }

    .select2-container {
      width: 100% !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: var(--text-main);
      padding-left: 46px;
      /* Space for icon */
      font-family: 'Plus Jakarta Sans', sans-serif;
      line-height: normal;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 48px;
    }

    .select2-dropdown {
      background-color: var(--bg-darker);
      border: 1px solid var(--primary-light);
      border-radius: 4px;
      color: var(--text-main);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
    }

    .select2-results__option--selectable {
      padding: 10px 16px;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
      background-color: var(--primary);
      color: #fff;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
      background-color: rgba(15, 23, 42, 0.8);
      border: 1px solid var(--glass-border);
      border-radius: 4px;
      color: var(--text-main);
      padding: 8px 12px;
      outline: none;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
      border-color: var(--primary-light);
    }

    .invalid-feedback {
      color: #ef4444;
      font-size: 0.8rem;
      margin-top: 6px;
      display: none;
    }

    .is-invalid {
      border-color: #ef4444 !important;
    }

    .is-invalid+.invalid-feedback {
      display: block;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 768px) {
      .row {
        grid-template-columns: 1fr;
        gap: 0;
      }

      .form-container {
        padding: 30px 20px;
      }

      .form-header h1 {
        font-size: 1.6rem;
      }

      body {
        overflow: auto;
        height: auto;
      }

      html {
        overflow: auto;
      }
    }
  </style>
</head>

<body>
  <div class="grid-bg"></div>
  <div class="islamic-pattern"></div>
  <div class="glow-orb glow-emerald"></div>
  <div class="glow-orb glow-gold"></div>

  <div class="form-container">
    <div class="form-header">

      <h1>Buku Tamu Online</h1>
      <p>Silakan lengkapi data kunjungan Anda</p>
    </div>

    <form id="guestBookForm">
      <div class="row">
        <div class="form-group">
          <div class="input-wrapper">
            <i class="ti ti-user input-icon"></i>
            <input type="text" name="nama_lengkap" class="form-control" placeholder="Contoh: Budi Santoso" required>
            <div class="invalid-feedback" data-field="nama_lengkap"></div>
          </div>
        </div>
        <div class="form-group">
          <div class="input-wrapper">
            <i class="ti ti-brand-whatsapp input-icon"></i>
            <input type="text" name="no_whatsapp" class="form-control" placeholder="Contoh: 08123456789" required>
            <div class="invalid-feedback" data-field="no_whatsapp"></div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <div class="input-wrapper">
            <i class="ti ti-building input-icon"></i>
            <select name="jenis_instansi" class="form-control select2" id="jenisInstansi" required>
              <option value="Personal">Personal</option>
              <option value="Lembaga">Lembaga</option>
              <option value="Instansi">Instansi</option>
            </select>
            <div class="invalid-feedback" data-field="jenis_instansi"></div>
          </div>
        </div>
        <div class="form-group" id="namaInstansiGroup" style="display: none;">
          <div class="input-wrapper">
            <i class="ti ti-building-community input-icon"></i>
            <input type="text" name="nama_instansi" class="form-control" placeholder="Nama instansi/lembaga"
              required>
            <div class="invalid-feedback" data-field="nama_instansi"></div>
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="input-wrapper">
          <i class="ti ti-map-pin input-icon"></i>
          <input type="text" name="alamat" class="form-control" placeholder="Masukkan alamat lengkap Anda" required>
          <div class="invalid-feedback" data-field="alamat"></div>
        </div>
      </div>

      <div class="form-group">
        <div class="input-wrapper">
          <i class="ti ti-target input-icon"></i>
          <select name="tujuan" class="form-control select2" required>
            <option value="" disabled selected>Kunjungan ditujukan ke:</option>
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
      </div>

      <div class="form-group">
        <div class="input-wrapper">
          <i class="ti ti-note input-icon"></i>
          <input type="text" name="keperluan" class="form-control"
            placeholder="Jelaskan maksud dan keperluan Anda" required>
          <div class="invalid-feedback" data-field="keperluan"></div>
        </div>
      </div>

      <button type="submit" class="btn-submit" id="btnSubmit">
        <i class="ti ti-paper-plane"></i> Kirim Data Kunjungan
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
        width: '100%',
        minimumResultsForSearch: -1
      });

      const form = document.getElementById('guestBookForm');
      const jenisInstansi = $('#jenisInstansi');
      const namaInstansiGroup = document.getElementById('namaInstansiGroup');
      const btnSubmit = document.getElementById('btnSubmit');

      // Toggle Nama Instansi input
      function toggleNamaInstansi() {
        const input = namaInstansiGroup.querySelector('input');
        if (jenisInstansi.val() === 'Personal') {
          $(namaInstansiGroup).hide();
          input.value = '';
          input.removeAttribute('required');
        } else {
          $(namaInstansiGroup).show();
          input.setAttribute('required', 'required');
        }
      }

      jenisInstansi.on('change', toggleNamaInstansi);
      toggleNamaInstansi(); // Run on load

      // Select2 focus outline fix (optional)
      $('.select2').on('select2:open', function(e) {
        $('.select2-search__field').get(0).focus();
      });

      // Handle form submission
      form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Reset validation
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');

        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="ti ti-loader ti-spin"></i> Mengirim...';

        const formData = new FormData(form);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
          console.log('Sending guest book data...');
          const response = await fetch('{{ route('buku-tamu.store') }}', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken,
              'Accept': 'application/json'
            },
            body: formData
          });

          console.log('Response status:', response.status);
          const data = await response.json();
          console.log('Response data:', data);

          if (response.ok) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: data.message,
              confirmButtonColor: '#059669',
              background: '#0f172a',
              color: '#f8fafc',
              borderRadius: '4px'
            }).then(() => {
              form.reset();
              $('.select2').val(null).trigger('change');
              window.location.href = '{{ route('home') }}';
            });
          } else if (response.status === 422) {
            for (const [field, messages] of Object.entries(data.errors)) {
              const input = form.querySelector(`[name="${field}"]`);
              const feedback = form.querySelector(`.invalid-feedback[data-field="${field}"]`);
              if (input) input.classList.add('is-invalid');
              if (feedback) {
                feedback.textContent = messages[0];
                feedback.style.display = 'block';
              }
            }

            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Mohon periksa kembali isian Anda.',
              confirmButtonColor: '#059669',
              background: '#0f172a',
              color: '#f8fafc',
              borderRadius: '4px'
            });
          } else {
            throw new Error(data.message || 'Terjadi kesalahan sistem.');
          }
          console.error('Submission error:', error);
          Swal.fire({
            icon: 'error',
            title: 'Kesalahan',
            text: error.message,
            confirmButtonColor: '#059669',
            background: '#0f172a',
            color: '#f8fafc',
            borderRadius: '4px'
          });
        } finally {
          btnSubmit.disabled = false;
          btnSubmit.innerHTML = '<i class="ti ti-paper-plane"></i> Kirim Data Kunjungan';
        }
      });
    });
  </script>
</body>

</html>
