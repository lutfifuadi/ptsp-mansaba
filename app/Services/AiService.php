<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Layanan;

class AiService
{
    protected $apiKeys = [];
    protected $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash-preview:generateContent';

    public function __construct()
    {
        $this->loadApiKeys();
    }

    protected function loadApiKeys()
    {
        $keysValue = \App\Models\Pengaturan::get('gemini_api_keys');
        
        if (!empty($keysValue)) {
            // Mendukung pemisah koma atau baris baru
            $keys = preg_split('/[\n,]+/', $keysValue);
            $this->apiKeys = array_values(array_filter(array_map('trim', $keys)));
        } else {
            $envKey = config('services.gemini.key');
            if ($envKey) {
                $this->apiKeys = [$envKey];
            }
        }
    }

    protected function getApiKey($attempt = 0)
    {
        if (empty($this->apiKeys)) return null;
        
        $count = count($this->apiKeys);
        $index = (\Illuminate\Support\Facades\Cache::get('gemini_api_key_index', 0) + $attempt) % $count;
        
        // Simpan index terakhir jika attempt 0
        if ($attempt === 0) {
            \Illuminate\Support\Facades\Cache::forever('gemini_api_key_index', $index);
        }
        
        return $this->apiKeys[$index];
    }

    public function generateResponse($message, $history = [])
    {
        if (empty($this->apiKeys)) {
            return "Maaf, API Key belum dikonfigurasi. Silakan hubungi admin.";
        }

        $maxAttempts = count($this->apiKeys);
        $lastError = "";

        for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
            $apiKey = $this->getApiKey($attempt);
            
            try {
                $response = $this->callGeminiApi($apiKey, $message, $history);
                
                if ($response->successful()) {
                    $result = $response->json();
                    return $result['candidates'][0]['content']['parts'][0]['text'] ?? "Maaf, saya tidak bisa merespon saat ini.";
                }

                $errorBody = $response->json();
                $lastError = $errorBody['error']['message'] ?? 'Unknown Error';
                
                Log::error("Gemini API Error (Attempt ".($attempt+1)."): " . $response->body());

                // Jika error adalah kuota habis (429), coba key berikutnya
                if ($response->status() === 429) {
                    continue;
                }

                return "Maaf, terjadi kesalahan pada koneksi AI: " . $lastError;
            } catch (\Exception $e) {
                Log::error("AiService Exception (Attempt ".($attempt+1)."): " . $e->getMessage());
                $lastError = $e->getMessage();
                continue;
            }
        }

        return "Maaf, seluruh API Key telah mencapai batas kuota atau mengalami kendala teknis.";
    }

    protected function callGeminiApi($apiKey, $message, $history)
    {
        $layanan = Layanan::where('is_active', true)->get(['nama_layanan', 'deskripsi', 'persyaratan']);
        $gurus = \App\Models\Guru::where('is_active', true)->get(['id', 'nama_lengkap', 'bidang_studi']);
        
        $isOfficeOpen = \App\Helpers\Helpers::isOfficeHour();
        $officeHour = \App\Helpers\Helpers::currentOfficeHour();
        $officeStatus = $isOfficeOpen ? "BUKA (Hingga " . date('H:i', strtotime($officeHour->jam_tutup)) . ")" : "TUTUP";

        $context = "Anda adalah Asisten Pintar PTSP (Pelayanan Terpadu Satu Pintu) MAN 1 Kota Bandung. 
        Tugas Anda adalah membantu menjawab pertanyaan pengguna mengenai layanan di PTSP MAN 1 Kota Bandung dan membantu mereka mengisi Buku Tamu.
        Gunakan bahasa yang sopan, ramah, dan profesional (Gaya bahasa Islami yang sejuk sangat dianjurkan).
        
        STATUS OPERASIONAL SAAT INI: {$officeStatus}
        (Penting: Jika status adalah TUTUP, ingatkan pengguna bahwa mereka masih bisa bertanya namun pengajuan layanan mungkin baru diproses pada jam kerja berikutnya).

        ATURAN FORMATTING (Gaya WhatsApp):
        1. Gunakan *teks tebal* untuk poin penting atau judul.
        2. Gunakan emoji yang relevan.
        3. Gunakan spasi baris agar teks mudah dibaca.
        
        FITUR SPESIAL - PENGISIAN FORM:
        Jika pengguna ingin mengisi Buku Tamu, Anda harus menanyakan data berikut secara bertahap atau sekaligus:
        - Nama Lengkap
        - No WhatsApp
        - Jenis Instansi (Personal / Lembaga / Instansi)
        - Nama Instansi (jika bukan Personal)
        - Alamat
        - Tujuan Kunjungan (Pilih: Kepala Madrasah, WAKAMAD Kesiswaan, WAKAMAD Kurikulum, WAKAMAD Humas, WAKAMAD Sarana Prasarana, Tata Usaha, Guru, atau Lainnya)
        - Nama Guru (Jika tujuan adalah Guru)
        - Keperluan
        
        DAFTAR GURU TERSEDIA:\n";

        foreach ($gurus as $g) {
            $context .= "- ID: {$g->id}, Nama: {$g->nama_lengkap} ({$g->bidang_studi})\n";
        }

        $context .= "\nDAFTAR LAYANAN PTSP:\n";

        foreach ($layanan as $l) {
            $context .= "- {$l->nama_layanan}: {$l->deskripsi}. Persyaratan: {$l->persyaratan}\n";
        }

        $context .= "\nINSTRUKSI PENGISIAN FORM:
        Jika semua informasi untuk Buku Tamu SUDAH LENGKAP, Anda WAJIB menyertakan blok JSON berikut di AKHIR jawaban Anda untuk membantu pengisian otomatis:
        [[FILL_FORM: {\"nama_lengkap\": \"...\", \"no_whatsapp\": \"...\", \"jenis_instansi\": \"...\", \"nama_instansi\": \"...\", \"alamat\": \"...\", \"tujuan\": \"...\", \"guru_id\": \"...\", \"keperluan\": \"...\"} ]]
        
        Pastikan guru_id diisi dengan ID numerik dari daftar guru di atas jika tujuannya adalah Guru.";

        $contents = [];
        $contents[] = ['role' => 'user', 'parts' => [['text' => $context]]];
        $contents[] = ['role' => 'model', 'parts' => [['text' => 'Baik, saya mengerti. Saya siap membantu sebagai Asisten Pintar PTSP MAN 1 Kota Bandung. Ada yang bisa saya bantu?']]];

        foreach ($history as $chat) {
            $contents[] = [
                'role' => $chat['role'] === 'user' ? 'user' : 'model',
                'parts' => [['text' => $chat['content']]]
            ];
        }

        $contents[] = ['role' => 'user', 'parts' => [['text' => $message]]];

        return Http::withoutVerifying()->post($this->apiUrl . '?key=' . $apiKey, [
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => 0.7,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 1024,
            ],
        ]);
    }
}
