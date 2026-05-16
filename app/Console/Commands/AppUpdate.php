<?php

namespace App\Console\Commands;

use App\Models\Pengaturan;
use App\Services\GitService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class AppUpdate extends Command
{
    protected $signature = 'update:app {--step=all : Langkah spesifik (pull/migrate/cache)}';
    protected $description = 'Update aplikasi dari repository Git dan jalankan migrasi';

    private array $outputBuffer = [];
    private bool $hasError = false;

    public function handle(): int
    {
        $this->outputBuffer = [];
        $this->hasError = false;

        $step = $this->option('step');

        if ($step === 'all' || $step === 'pull') {
            $this->runStep('Git Pull', fn() => $this->gitPull());
        }
        if ($step === 'all' || $step === 'migrate') {
            $this->runStep('Migrasi Database', fn() => $this->runMigrate());
        }
        if ($step === 'all' || $step === 'cache') {
            $this->runStep('Optimize', fn() => $this->optimizeApp());
        }

        if ($this->hasError) {
            $this->error('Update gagal. Periksa log untuk detail.');
            return Command::FAILURE;
        }

        $this->syncVersion();
        $this->info('Update selesai!');
        return Command::SUCCESS;
    }

    private function runStep(string $label, callable $fn): void
    {
        $this->line("[MULAI] {$label}...");
        $this->logOutput("[MULAI] {$label}...");
        try {
            $fn();
            $this->line("[SELESAI] {$label} ✓");
            $this->logOutput("[SELESAI] {$label} ✓");
        } catch (\Throwable $e) {
            $this->hasError = true;
            $this->error("[GAGAL] {$label}: {$e->getMessage()}");
            $this->logOutput("[GAGAL] {$label}: {$e->getMessage()}");
            Log::error("AppUpdate: {$label} gagal", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    private function runProcess(array $cmd, ?string $cwd = null): void
    {
        $process = new Process($cmd, $cwd ?? base_path());
        $process->setTimeout(300);
        $process->run(function ($type, $buffer) {
            $this->outputWrite($buffer);
            $this->logOutput($buffer);
        });

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }

    private function gitPull(): void
    {
        if (!is_dir(base_path('.git'))) {
            $this->warn('Bukan repository Git. Lewati langkah pull.');
            $this->logOutput('[SKIP] Bukan repository Git');
            return;
        }

        $git = new GitService();
        $branch = $git->getBranch();
        $this->line("Branch aktif: {$branch}");
        $this->logOutput("Branch aktif: {$branch}");

        $this->runProcess(['git', 'fetch', 'origin']);
        $this->runProcess(['git', 'pull', 'origin', $branch]);
    }

    private function runMigrate(): void
    {
        $this->runProcess([PHP_BINARY, 'artisan', 'migrate', '--force']);
    }

    private function optimizeApp(): void
    {
        $this->runProcess([PHP_BINARY, 'artisan', 'cache:clear']);
        $this->runProcess([PHP_BINARY, 'artisan', 'config:clear']);
        $this->runProcess([PHP_BINARY, 'artisan', 'view:clear']);
        $this->runProcess([PHP_BINARY, 'artisan', 'route:clear']);

        if (app()->isProduction()) {
            $this->runProcess([PHP_BINARY, 'artisan', 'config:cache']);
            $this->runProcess([PHP_BINARY, 'artisan', 'route:cache']);
            $this->runProcess([PHP_BINARY, 'artisan', 'view:cache']);
        }
    }

    private function syncVersion(): void
    {
        $git = new GitService();
        $version = $git->getVersionTag();

        if (!empty($version)) {
            Pengaturan::set('app_version', $version);
            $this->line("Versi: {$version}");
            $this->logOutput("Versi: {$version}");
        }
    }

    public function getOutputBuffer(): array
    {
        return $this->outputBuffer;
    }

    public function hasErrors(): bool
    {
        return $this->hasError;
    }

    private function outputWrite(string $text): void
    {
        if ($this->laravel->runningInConsole()) {
            $this->output->write($text);
        }
    }

    private function logOutput(string $text): void
    {
        $this->outputBuffer[] = $text;
    }
}
