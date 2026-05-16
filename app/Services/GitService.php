<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class GitService
{
    private string $repoPath;
    private bool $gitAvailable = true;

    public function __construct(?string $repoPath = null)
    {
        $this->repoPath = $repoPath ?? base_path();
        $this->checkGitAvailability();
    }

    public function isGitAvailable(): bool
    {
        return $this->gitAvailable;
    }

    public function getBranch(): string
    {
        try {
            return trim($this->runProcess(['git', 'rev-parse', '--abbrev-ref', 'HEAD']));
        } catch (\Throwable $e) {
            Log::warning('GitService: Gagal mengambil branch', ['error' => $e->getMessage()]);
            return 'main';
        }
    }

    public function getCurrentCommit(): string
    {
        try {
            return trim($this->runProcess(['git', 'log', '-1', '--format=%h - %s']));
        } catch (\Throwable $e) {
            Log::warning('GitService: Gagal mengambil commit', ['error' => $e->getMessage()]);
            return '-';
        }
    }

    public function getCommitDate(): string
    {
        try {
            return trim($this->runProcess(['git', 'log', '-1', '--format=%ci']));
        } catch (\Throwable $e) {
            Log::warning('GitService: Gagal mengambil commit date', ['error' => $e->getMessage()]);
            return '-';
        }
    }

    public function getCurrentTag(): string
    {
        try {
            $process = new Process(['git', 'describe', '--tags', '--abbrev=0'], $this->repoPath);
            $process->setTimeout(30);
            $process->run();

            if ($process->isSuccessful()) {
                return trim($process->getOutput());
            }
            return '-';
        } catch (\Throwable $e) {
            Log::warning('GitService: Gagal mengambil tag', ['error' => $e->getMessage()]);
            return '-';
        }
    }

    public function getGitInfo(): array
    {
        try {
            return [
                'branch' => $this->getBranch(),
                'commit' => $this->getCurrentCommit(),
                'commit_date' => $this->getCommitDate(),
                'tag' => $this->getCurrentTag(),
                'git_available' => true,
            ];
        } catch (\Throwable $e) {
            Log::error('GitService: Gagal mengambil git info', ['error' => $e->getMessage()]);
            return [
                'branch' => 'N/A',
                'commit' => 'N/A',
                'commit_date' => 'N/A',
                'tag' => 'N/A',
                'git_available' => false,
                'error' => 'Git tidak tersedia. Periksa koneksi server atau hubungi administrator.',
            ];
        }
    }

    public function fetchOrigin(): bool
    {
        try {
            $this->runProcess(['git', 'fetch', 'origin']);
            return true;
        } catch (\Throwable $e) {
            Log::error('GitService: Gagal fetch origin', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getLocalHash(): string
    {
        try {
            return trim($this->runProcess(['git', 'rev-parse', 'HEAD']));
        } catch (\Throwable $e) {
            Log::warning('GitService: Gagal mengambil local hash', ['error' => $e->getMessage()]);
            return '';
        }
    }

    public function getRemoteHash(string $branch): string
    {
        try {
            return trim($this->runProcess(['git', 'rev-parse', "origin/{$branch}"]));
        } catch (\Throwable $e) {
            Log::warning('GitService: Gagal mengambil remote hash', ['error' => $e->getMessage()]);
            return '';
        }
    }

    public function getPendingCommits(string $branch): array
    {
        try {
            $output = $this->runProcess(['git', 'log', "HEAD..origin/{$branch}", '--oneline']);
            return array_filter(explode("\n", trim($output)));
        } catch (\Throwable $e) {
            Log::warning('GitService: Gagal mengambil pending commits', ['error' => $e->getMessage()]);
            return [];
        }
    }

    public function getVersionTag(): string
    {
        try {
            $process = new Process(['git', 'describe', '--tags', '--abbrev=0'], $this->repoPath);
            $process->setTimeout(30);
            $process->run();

            if ($process->isSuccessful() && !empty(trim($process->getOutput()))) {
                $tag = trim($process->getOutput());
                if (preg_match('/^v?(\d+\.\d+\.\d+)/', $tag, $matches)) {
                    return $matches[1];
                }
            }
        } catch (\Throwable $e) {
            Log::warning('GitService: Gagal mengambil version tag', ['error' => $e->getMessage()]);
        }

        return '';
    }

    public function isRepo(): bool
    {
        if (!$this->gitAvailable) {
            return false;
        }
        return is_dir($this->repoPath . DIRECTORY_SEPARATOR . '.git');
    }

    public function getLastError(): ?string
    {
        return $this->gitAvailable ? null : 'Fungsi eksekusi perintah (proc_open) tidak tersedia di server ini.';
    }

    private function checkGitAvailability(): void
    {
        $disabled = explode(',', ini_get('disable_functions') ?? '');
        $required = ['proc_open', 'proc_close', 'proc_get_status', 'proc_terminate'];

        foreach ($required as $fn) {
            if (in_array(trim($fn), $disabled, true)) {
                $this->gitAvailable = false;
                Log::warning("GitService: Fungsi {$fn} di-disable oleh server.");
                return;
            }
        }

        try {
            $test = new Process(['git', '--version'], $this->repoPath);
            $test->setTimeout(10);
            $test->run();
            if (!$test->isSuccessful()) {
                $this->gitAvailable = false;
                Log::warning('GitService: Git CLI tidak tersedia');
            }
        } catch (\Throwable $e) {
            $this->gitAvailable = false;
            Log::warning('GitService: Git CLI tidak tersedia', ['error' => $e->getMessage()]);
        }
    }

    private function runProcess(array $cmd): string
    {
        if (!$this->gitAvailable) {
            throw new \RuntimeException('Git tidak tersedia di server ini.');
        }

        $process = new Process($cmd, $this->repoPath);
        $process->setTimeout(60);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
