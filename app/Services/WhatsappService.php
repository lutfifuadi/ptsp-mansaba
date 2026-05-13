<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Pengaturan;

class WhatsappService
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $sender;
    protected ?string $waGroupId;

    public function __construct()
    {
        $this->baseUrl = 'https://wa.lutfifuadi.my.id';
        $this->apiKey = Pengaturan::get('wa_api_key', '');
        $this->sender = Pengaturan::get('wa_sender', '');
        $this->waGroupId = Pengaturan::get('wa_group_id');
    }

    public function send(string $to, string $message): bool
    {
        if (empty($this->apiKey) || empty($this->sender)) {
            Log::warning('WhatsappService: wa_api_key atau wa_sender belum dikonfigurasi.');
            return false;
        }

        try {
            $response = Http::timeout(15)->withoutVerifying()->post($this->baseUrl . '/send-message', [
                'api_key' => $this->apiKey,
                'sender'  => $this->sender,
                'number'  => $to,
                'message' => $message,
            ]);

            if ($response->successful()) {
                Log::info("WhatsappService: Pesan terkirim ke {$to}");
                return true;
            }

            Log::warning("WhatsappService: Gagal kirim ke {$to}. Response: " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("WhatsappService: Error kirim ke {$to}: " . $e->getMessage());
            return false;
        }
    }

    public function sendPermohonanBaru(object $permohonan): void
    {
        $this->sendKePetugas($permohonan, 'baru');
        $this->sendKePemohon($permohonan, 'baru');
        $this->sendKeGroup($permohonan, 'baru');
    }

    public function sendStatusBerubah(object $permohonan): void
    {
        $this->sendKePetugas($permohonan, 'status');
        $this->sendKePemohon($permohonan, 'status');
        $this->sendKeGroup($permohonan, 'status');
    }

    protected function sendKeGroup(object $permohonan, string $type): void
    {
        if (empty($this->waGroupId)) return;

        $message = $type === 'baru'
            ? $this->buildPermohonanBaruMessage($permohonan)
            : $this->buildStatusBerubahMessage($permohonan);

        $message = "*[NOTIFIKASI PTSP]*\n" . $message;

        $this->send($this->waGroupId, $message);
    }

    protected function sendKePetugas(object $permohonan, string $type): void
    {
        $petugasList = $permohonan->layanan->petugas;
        if ($petugasList->isEmpty()) return;

        $message = $type === 'baru'
            ? $this->buildPermohonanBaruMessage($permohonan)
            : $this->buildStatusBerubahMessage($permohonan);

        foreach ($petugasList as $petugas) {
            if (empty($petugas->no_whatsapp)) continue;
            $this->send($petugas->no_whatsapp, $message);
        }
    }

    protected function sendKePemohon(object $permohonan, string $type): void
    {
        $noWa = $this->extractNoWa($permohonan);
        if (empty($noWa)) return;

        $message = $type === 'baru'
            ? $this->buildPemohonBaruMessage($permohonan)
            : $this->buildPemohonStatusMessage($permohonan);

        $this->send($noWa, $message);
    }

    protected function extractNoWa(object $permohonan): ?string
    {
        if (isset($permohonan->data_form['no_wa'])) {
            return $permohonan->data_form['no_wa'];
        }

        if (isset($permohonan->data_form['no_whatsapp'])) {
            return $permohonan->data_form['no_whatsapp'];
        }

        return null;
    }

    protected function getNamaPemohon(object $permohonan): string
    {
        return $permohonan->data_form['nama_lengkap']
            ?? $permohonan->data_form['nama']
            ?? $permohonan->siswa->nama_lengkap
            ?? '-';
    }

    protected function buildPermohonanBaruMessage(object $permohonan): string
    {
        $nama = $this->getNamaPemohon($permohonan);

        return "📌 *Permohonan Baru!*\n\n" .
            "Layanan: {$permohonan->layanan->nama_layanan}\n" .
            "No. Tiket: {$permohonan->no_tiket}\n" .
            "Nama: {$nama}\n" .
            "Status: " . strtoupper($permohonan->status) . "\n" .
            "Waktu: {$permohonan->created_at->format('d/m/Y H:i')}\n\n" .
            "Silakan proses permohonan ini di sistem PTSP.";
    }

    protected function buildPemohonBaruMessage(object $permohonan): string
    {
        $nama = $this->getNamaPemohon($permohonan);

        return "☑️ *Permohonan Diterima*\n\n" .
            "Halo {$nama},\n\n" .
            "Permohonan Anda telah kami terima dengan detail:\n" .
            "Layanan: {$permohonan->layanan->nama_layanan}\n" .
            "No. Tiket: {$permohonan->no_tiket}\n" .
            "Status: ⏳ Pending\n" .
            "Waktu: {$permohonan->created_at->format('d/m/Y H:i')}\n\n" .
            "Simpan nomor tiket di atas untuk melacak status permohonan Anda.\n" .
            "Kami akan mengabari jika ada perubahan status.";
    }

    protected function buildPemohonStatusMessage(object $permohonan): string
    {
        $nama = $this->getNamaPemohon($permohonan);

        $statusLabels = [
            'pending' => '⏳ Pending',
            'proses'  => '⚙️ Diproses',
            'selesai' => '✅ Selesai',
            'ditolak' => '❌ Ditolak',
        ];

        $text = "🔔 *Status Permohonan Anda*\n\n" .
            "Halo {$nama},\n\n" .
            "Status permohonan Anda telah diperbarui:\n" .
            "Layanan: {$permohonan->layanan->nama_layanan}\n" .
            "No. Tiket: {$permohonan->no_tiket}\n" .
            "Status: {$statusLabels[$permohonan->status]}\n";

        if ($permohonan->catatan_admin) {
            $text .= "Catatan: {$permohonan->catatan_admin}\n";
        }

        $text .= "\nTerima kasih.";
        return $text;
    }

    protected function buildStatusBerubahMessage(object $permohonan): string
    {
        $nama = $this->getNamaPemohon($permohonan);

        $statusLabels = [
            'pending' => '⏳ Pending',
            'proses'  => '⚙️ Diproses',
            'selesai' => '✅ Selesai',
            'ditolak' => '❌ Ditolak',
        ];

        $text = "🔄 *Status Permohonan Diperbarui*\n\n" .
            "Layanan: {$permohonan->layanan->nama_layanan}\n" .
            "No. Tiket: {$permohonan->no_tiket}\n" .
            "Nama: {$nama}\n" .
            "Status: {$statusLabels[$permohonan->status]}\n";

        if ($permohonan->catatan_admin) {
            $text .= "Catatan: {$permohonan->catatan_admin}\n";
        }

        $text .= "\nTerima kasih.";
        return $text;
    }
}
