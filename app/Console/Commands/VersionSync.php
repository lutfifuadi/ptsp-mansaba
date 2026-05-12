<?php

namespace App\Console\Commands;

use App\Models\Pengaturan;
use Illuminate\Console\Command;

class VersionSync extends Command
{
    protected $signature = 'version:sync {--force : Paksa update tanpa konfirmasi}';
    protected $description = 'Sinkronisasi versi aplikasi dengan tag release GitHub terbaru';

    public function handle(): int
    {
        $version = null;

        exec('git describe --tags --abbrev=0 2>nul', $output, $exitCode);

        if ($exitCode === 0 && !empty($output[0])) {
            $tag = trim($output[0]);
            if (preg_match('/^v?(\d+\.\d+\.\d+)/', $tag, $matches)) {
                $version = $matches[1];
            }
        }

        $currentVersion = Pengaturan::get('app_version', '1.0.0');

        if (!$version) {
            if ($this->option('force')) {
                $this->warn("Git tag tidak ditemukan. Versi tetap: {$currentVersion}.");
                return Command::SUCCESS;
            }

            if ($this->confirm("Git tag tidak terdeteksi. Gunakan versi saat ini ({$currentVersion})?", true)) {
                $version = $currentVersion;
            } else {
                $version = $this->ask('Masukkan versi manual (contoh: 1.1.1)');
                if (!$version || !preg_match('/^\d+\.\d+\.\d+$/', $version)) {
                    $this->error('Format versi tidak valid. Gunakan format semver (contoh: 1.1.1).');
                    return Command::FAILURE;
                }
            }
        }

        if ($version === $currentVersion) {
            $this->info("Versi sudah sinkron: {$version}. Tidak ada perubahan.");
            return Command::SUCCESS;
        }

        Pengaturan::set('app_version', $version);
        $this->info("Versi berhasil disinkronkan dari {$currentVersion} ke {$version}.");

        if ($this->laravel->runningInConsole()) {
            $this->line("Cek di /admin/pengaturan/umum untuk melihat perubahan.");
        }

        return Command::SUCCESS;
    }
}
