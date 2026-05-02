<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
    <title>Verifikasi Keaslian Dokumen - {{ $pengaturan['nama_lembaga'] }}</title>
    <link rel="icon" type="image/png" href="{{ $pengaturan['logo_kanan'] ? asset('storage/'.$pengaturan['logo_kanan']) : asset('assets/img/favicon/favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1e8449;
            --primary-dark: #145a32;
            --secondary: #f39c12;
            --text-dark: #1a1a1a;
            --text-muted: #666;
            --bg-light: #f8fafc;
            --white: #ffffff;
            --border-color: #e2e8f0;
            --success-bg: #ecfdf5;
            --success-text: #065f46;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: var(--text-dark);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            width: 100%;
            max-width: 850px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .main-card {
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid var(--border-color);
            position: relative;
        }

        /* Certificate-like border accent */
        .main-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        /* Header Section */
        .header {
            padding: 40px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(to bottom, #ffffff, #fdfdfd);
        }

        .institution-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .logo {
            width: 80px;
            height: auto;
            object-fit: contain;
        }

        .institution-info h1 {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            text-transform: uppercase;
            color: var(--primary-dark);
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .institution-info p {
            font-size: 13px;
            color: var(--text-muted);
            max-width: 500px;
        }

        /* Verification Status Badge */
        .verification-status {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background-color: var(--success-bg);
            color: var(--success-text);
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            border: 1px solid rgba(6, 95, 70, 0.1);
        }

        .verification-status svg {
            width: 20px;
            height: 20px;
        }

        .doc-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin-top: 10px;
        }

        /* Content Area */
        .content {
            padding: 40px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }

        /* Data Grid */
        .data-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            margin-bottom: 40px;
        }

        .data-item {
            display: flex;
            flex-direction: column;
        }

        .data-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .data-value {
            font-size: 15px;
            font-weight: 500;
            color: var(--text-dark);
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .data-value.important {
            font-weight: 700;
            color: var(--primary-dark);
        }

        .full-width {
            grid-column: span 2;
        }

        /* Footer Info */
        .official-note {
            background: #f8fafc;
            border-left: 4px solid var(--primary);
            padding: 20px;
            border-radius: 0 8px 8px 0;
            font-size: 14px;
            color: #475569;
            margin-top: 20px;
        }

        .official-note strong {
            color: var(--text-dark);
        }

        .footer {
            padding: 30px 40px;
            background: #fafafa;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .footer-text {
            font-size: 12px;
            color: var(--text-muted);
        }

        .btn-print {
            padding: 10px 20px;
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-print:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .data-grid {
                grid-template-columns: 1fr;
            }
            .full-width {
                grid-column: span 1;
            }
            .header {
                padding: 30px 20px;
            }
            .content {
                padding: 30px 20px;
            }
            .institution-header {
                flex-direction: column;
                gap: 15px;
            }
            .footer {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            .doc-title {
                font-size: 20px;
            }
        }

        @media print {
            body {
                background: white;
            }
            .main-card {
                box-shadow: none;
                border: 1px solid #eee;
            }
            .btn-print {
                display: none;
            }
            .container {
                margin: 0;
                padding: 0;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="main-card">
            
            <!-- Header Section -->
            <div class="header">
                <div class="verification-status">
                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.333 16.676 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Dokumen Terverifikasi
                </div>
                
                <div class="institution-header">
                    @if($pengaturan['logo_kiri'])
                        <img src="{{ asset('storage/'.$pengaturan['logo_kiri']) }}" alt="Logo" class="logo">
                    @elseif($pengaturan['logo_kanan'])
                        <img src="{{ asset('storage/'.$pengaturan['logo_kanan']) }}" alt="Logo" class="logo">
                    @else
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="logo">
                    @endif
                    
                    <div class="institution-info">
                        <h1>{{ $pengaturan['nama_lembaga'] }}</h1>
                        <p>{{ $pengaturan['alamat_lembaga'] }}, {{ $pengaturan['kabupaten_kota'] }}, {{ $pengaturan['provinsi'] }}</p>
                    </div>
                </div>
                
                <h2 class="doc-title">Validasi Surat Keterangan Lulus</h2>
                <p style="color: var(--text-muted); font-size: 14px; margin-top: 5px;">Tahun Pelajaran {{ $pengaturan['tahun_ajaran'] }}</p>
            </div>

            <!-- Content Area -->
            <div class="content">
                
                <div class="section-title">Informasi Peserta Didik</div>
                
                <div class="data-grid">
                    <div class="data-item full-width">
                        <div class="data-label">Nama Lengkap</div>
                        <div class="data-value important" style="font-size: 18px;">{{ strtoupper($siswa->nama_lengkap) }}</div>
                    </div>
                    
                    <div class="data-item">
                        <div class="data-label">NISN</div>
                        <div class="data-value">{{ $siswa->nisn }}</div>
                    </div>
                    
                    <div class="data-item">
                        <div class="data-label">NIS</div>
                        <div class="data-value">{{ $siswa->nis ?: '-' }}</div>
                    </div>
                    
                    <div class="data-item">
                        <div class="data-label">No. Peserta Ujian</div>
                        <div class="data-value">{{ $siswa->no_peserta_ujian ?: ($siswa->no_peserta ?: '-') }}</div>
                    </div>
                    
                    <div class="data-item">
                        <div class="data-label">Kelas / Jurusan</div>
                        <div class="data-value">{{ $siswa->kelas }} / {{ $siswa->jurusan }}</div>
                    </div>
                    
                    <div class="data-item">
                        <div class="data-label">Tempat, Tanggal Lahir</div>
                        <div class="data-value">
                            @if($siswa->tempat_lahir && $siswa->tanggal_lahir)
                                {{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    
                    <div class="data-item">
                        <div class="data-label">Nama Orang Tua</div>
                        <div class="data-value">{{ $siswa->nama_orang_tua ?: '-' }}</div>
                    </div>
                    
                    <div class="data-item full-width">
                        <div class="data-label">Sekolah / Madrasah Asal</div>
                        <div class="data-value">{{ $siswa->madrasah_asal ?: $pengaturan['nama_lembaga'] }}</div>
                    </div>
                </div>

                <div class="section-title">Status Kelulusan</div>
                
                <div style="text-align: center; padding: 20px 0;">
                    <div style="font-size: 32px; font-weight: 800; color: var(--primary); letter-spacing: 2px;">LULUS</div>
                    <p style="font-size: 14px; color: var(--text-muted); margin-top: 10px;">Dinyatakan Lulus berdasarkan kriteria kelulusan satuan pendidikan.</p>
                </div>

                <div class="official-note">
                    <strong>Catatan Resmi:</strong> Dokumen ini merupakan bukti elektronik yang sah untuk verifikasi data kelulusan siswa. Data ini sinkron dengan database sistem informasi kelulusan <strong>{{ $pengaturan['nama_lembaga'] }}</strong>.
                </div>
            </div>

            <!-- Footer Area -->
            <div class="footer">
                <div class="footer-text">
                    &copy; {{ date('Y') }} {{ $pengaturan['nama_lembaga'] }}<br>
                    Sistem Informasi Kelulusan Terintegrasi
                </div>
                
                <button class="btn-print" onclick="window.print()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 012-2H5a2 2 0 01-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v7h10z"></path></svg>
                    Cetak Halaman
                </button>
            </div>
        </div>
        
        <p style="text-align: center; font-size: 11px; color: #94a3b8; margin-top: 20px;">
            ID Verifikasi: {{ substr($siswa->validation_token, 0, 8) }}...{{ substr($siswa->validation_token, -8) }}
        </p>
    </div>

</body>
</html>
