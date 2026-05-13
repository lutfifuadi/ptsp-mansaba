@if(isset($is_office_closed) && $is_office_closed)
<div id="closedServiceOverlay" style="position: fixed; inset: 0; z-index: 9999999; display: flex; align-items: center; justify-content: center; background: rgba(2, 6, 23, 0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); padding: 24px; font-family: 'Plus Jakarta Sans', sans-serif !important;">
    <div id="landscapeModal" style="background: #ffffff; width: 100%; max-width: 800px; border-radius: 5px; overflow: hidden; box-shadow: 0 40px 120px -20px rgba(0, 0, 0, 0.7); display: flex; animation: modalAppearing 0.7s cubic-bezier(0.22, 1, 0.36, 1);">
        
        <!-- Left Side: Visual Branding (Landscape) -->
        <div style="flex: 1; background: linear-gradient(135deg, #064e3b 0%, #059669 100%); padding: 50px 40px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; position: relative; overflow: hidden;">
            <div style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.15); border-radius: 5px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                <i class="ti tabler-clock-off" style="font-size: 32px; color: #ffffff;"></i>
            </div>
            
            <h2 style="color: #ffffff; margin: 0 0 12px; font-weight: 800; font-size: 1.5rem; letter-spacing: -0.02em; line-height: 1.2; font-family: inherit;">Layanan Tutup</h2>
            <div style="background: rgba(0, 0, 0, 0.2); color: #ffffff; padding: 6px 16px; border-radius: 5px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; border: 1px solid rgba(255, 255, 255, 0.1);">
                PTSP MAN 1 KOTA BANDUNG
            </div>
        </div>

        <!-- Right Side: Information & Action -->
        <div style="flex: 1.3; padding: 50px; background: #ffffff; display: flex; flex-direction: column; justify-content: center;">
            <p style="color: #475569; font-size: 0.95rem; line-height: 1.6; margin: 0 0 24px; font-weight: 500; font-family: inherit;">
                Mohon maaf, sistem pengajuan saat ini sedang <span style="color: #059669; font-weight: 700;">non-aktif</span> sementara karena di luar jam operasional kantor.
            </p>

            <!-- Horizontal Status Detail -->
            <div style="display: flex; gap: 15px; margin-bottom: 30px;">
                <div style="flex: 1; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 15px 18px;">
                    <small style="display: block; color: #94a3b8; font-size: 0.6rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px;">Status</small>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <span style="color: #0f172a; font-weight: 800; font-size: 0.9rem;">{{ $office_config->nama_hari ?? 'Rabu' }}</span>
                        <span style="background: #fee2e2; color: #ef4444; padding: 2px 6px; border-radius: 3px; font-size: 0.6rem; font-weight: 900; border: 1px solid #fecdd3;">OFF</span>
                    </div>
                </div>
                <div style="flex: 1.5; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 15px 18px;">
                    <small style="display: block; color: #94a3b8; font-size: 0.6rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px;">Jam Operasional</small>
                    <span style="color: #059669; font-weight: 800; font-size: 0.9rem; display: flex; align-items: center;">
                        <i class="ti tabler-calendar-time me-2" style="font-size: 16px;"></i>
                        @if($office_config && $office_config->is_aktif && $office_config->jam_buka)
                            {{ \Carbon\Carbon::parse($office_config->jam_buka)->format('H:i') }} — {{ \Carbon\Carbon::parse($office_config->jam_tutup)->format('H:i') }} WIB
                        @else
                            Tutup Hari Ini
                        @endif
                    </span>
                </div>
            </div>

            <!-- Expansive Button -->
            <a href="{{ route('home') }}" id="btnBack" style="display: flex; align-items: center; justify-content: center; background: #059669; color: #ffffff; text-decoration: none; padding: 16px; border-radius: 5px; font-weight: 800; font-size: 0.9rem; letter-spacing: 0.05em; transition: all 0.2s; box-shadow: 0 10px 20px -5px rgba(5, 150, 105, 0.4); font-family: inherit;">
                <i class="ti tabler-smart-home me-2" style="font-size: 20px;"></i> KEMBALI KE BERANDA
            </a>
            
            <p style="margin-top: 24px; color: #cbd5e1; font-size: 0.75rem; font-weight: 500; text-align: center;">ID Pelayanan: {{ strtoupper(\Illuminate\Support\Str::random(6)) }}</p>
        </div>
    </div>
</div>

<style>
    body { overflow: hidden !important; height: 100vh !important; }
    @keyframes modalAppearing {
        from { transform: scale(0.98); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    #btnBack:hover {
        background: #047857;
        box-shadow: 0 15px 30px -10px rgba(5, 150, 105, 0.5);
    }
    #btnBack:active { transform: translateY(1px); }

    @media (max-width: 800px) {
        #landscapeModal { flex-direction: column; max-width: 400px; }
        #landscapeModal > div { padding: 35px !important; }
    }
</style>
@endif
