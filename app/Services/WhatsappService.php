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

    protected array $defaultTemplates;

    public function __construct()
    {
        $this->baseUrl = 'https://wa.lutfifuadi.my.id';
        // Pengaturan::get bisa mengembalikan null jika baris ada tetapi nilainya null.
        // Cast eksplisit ke string untuk properti bertipe string agar tidak terjadi
        // TypeError ketika nilai null tersimpan di DB pada live site.
        $this->apiKey = (string) Pengaturan::get('wa_api_key', '');
        $this->sender = (string) Pengaturan::get('wa_sender', '');
        $this->waGroupId = Pengaturan::get('wa_group_id') ?: null;

        $this->defaultTemplates = [
            'baru_petugas' => "\u{1F4CC} *Permohonan Baru!*\n\nLayanan: {layanan}\nNo. Tiket: {no_tiket}\nNama: {nama}\nStatus: {status_label}\nWaktu: {waktu}\n\nSilakan proses permohonan ini di sistem PTSP.",
            'baru_pemohon' => "\u{2611} *Permohonan Diterima*\n\nHalo {nama},\n\nPermohonan Anda telah kami terima dengan detail:\nLayanan: {layanan}\nNo. Tiket: {no_tiket}\nStatus: {status_label}\nWaktu: {waktu}\n\nSimpan nomor tiket di atas untuk melacak status permohonan Anda.\nKami akan mengabari jika ada perubahan status.",
            'baru_group' => "{no_tiket}\n\n\u{1F4CC} *Permohonan Baru!*\n\nLayanan: {layanan}\nNo. Tiket: {no_tiket}\nNama: {nama}\nStatus: {status_label}\nWaktu: {waktu}",
            'status_petugas' => "\u{1F504} *Status Permohonan Diperbarui*\n\nLayanan: {layanan}\nNo. Tiket: {no_tiket}\nNama: {nama}\nStatus: {status_label}\n{catatan}",
            'status_pemohon' => "\u{1F514} *Status Permohonan Anda*\n\nHalo {nama},\n\nStatus permohonan Anda telah diperbarui:\nLayanan: {layanan}\nNo. Tiket: {no_tiket}\nStatus: {status_label}\n{catatan}\n\nTerima kasih.",
            'status_group' => "\u{1F504} *Status Permohonan*\n\nLayanan: {layanan}\nNo. Tiket: {no_tiket}\nNama: {nama}\nStatus: {status_label}\n{catatan}",
        ];
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

    public function getTemplate(string $key): string
    {
        return Pengaturan::get('wa_template_' . $key, $this->defaultTemplates[$key] ?? '');
    }

    public function getAllTemplates(): array
    {
        $templates = [];
        foreach ($this->defaultTemplates as $key => $default) {
            $templates[$key] = Pengaturan::get('wa_template_' . $key, $default);
        }
        return $templates;
    }

    protected function sendKeGroup(object $permohonan, string $type): void
    {
        if (empty($this->waGroupId)) return;

        $data = $this->buildPlaceholders($permohonan);
        $template = $this->getTemplate($type . '_group');
        $message = $this->replacePlaceholders($template, $data);

        $this->send($this->waGroupId, $message);
    }

    protected function sendKePetugas(object $permohonan, string $type): void
    {
        $petugasList = $permohonan->layanan->petugas;
        if ($petugasList->isEmpty()) return;

        $data = $this->buildPlaceholders($permohonan);
        $template = $this->getTemplate($type . '_petugas');
        $message = $this->replacePlaceholders($template, $data);

        foreach ($petugasList as $petugas) {
            if (empty($petugas->no_whatsapp)) continue;
            $this->send($petugas->no_whatsapp, $message);
        }
    }

    protected function sendKePemohon(object $permohonan, string $type): void
    {
        $noWa = $this->extractNoWa($permohonan);
        if (empty($noWa)) return;

        $data = $this->buildPlaceholders($permohonan);
        $template = $this->getTemplate($type . '_pemohon');
        $message = $this->replacePlaceholders($template, $data);

        $this->send($noWa, $message);
    }

    protected function buildPlaceholders(object $permohonan): array
    {
        $statusLabels = [
            'pending' => "\u{23F3} Pending",
            'proses'  => "\u{2699}\u{FE0F} Diproses",
            'selesai' => "\u{2705} Selesai",
            'ditolak' => "\u{274C} Ditolak",
        ];

        $nama = $permohonan->data_form['nama_lengkap']
            ?? $permohonan->data_form['nama']
            ?? $permohonan->siswa->nama_lengkap
            ?? '-';

        $catatan = $permohonan->catatan_admin
            ? "Catatan: {$permohonan->catatan_admin}"
            : '';

        return [
            '{no_tiket}'     => $permohonan->no_tiket,
            '{layanan}'      => $permohonan->layanan->nama_layanan,
            '{nama}'         => $nama,
            '{status}'       => $permohonan->status,
            '{status_label}' => $statusLabels[$permohonan->status] ?? $permohonan->status,
            '{waktu}'        => $permohonan->created_at->format('d/m/Y H:i'),
            '{catatan}'      => $catatan,
        ];
    }

    protected function replacePlaceholders(string $template, array $data): string
    {
        return str_replace(array_keys($data), array_values($data), $template);
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
}
