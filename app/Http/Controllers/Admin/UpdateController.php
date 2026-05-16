<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UpdateController extends Controller
{
    public function index()
    {
        $info = $this->getGitInfo();
        $appVersion = Pengaturan::get('app_version', '1.0.0');

        return view('content.pages.admin.update.index', compact('info', 'appVersion'));
    }

    public function check(): JsonResponse
    {
        try {
            $redirection = DIRECTORY_SEPARATOR === '\\' ? '2>nul' : '2>/dev/null';

            exec("git fetch origin {$redirection}", $fetchOutput, $fetchCode);

            $branch = trim(shell_exec('git rev-parse --abbrev-ref HEAD 2>nul') ?? 'main');
            exec("git rev-parse HEAD {$redirection}", $localOutput);
            exec("git rev-parse origin/{$branch} {$redirection}", $remoteOutput);

            $localHash = $localOutput[0] ?? '';
            $remoteHash = $remoteOutput[0] ?? '';

            $hasUpdate = !empty($localHash) && !empty($remoteHash) && $localHash !== $remoteHash;

            exec("git log HEAD..origin/{$branch} --oneline {$redirection}", $commitOutput);

            return response()->json([
                'success' => true,
                'has_update' => $hasUpdate,
                'branch' => $branch,
                'local_commit' => $localHash ? substr($localHash, 0, 7) : '-',
                'remote_commit' => $remoteHash ? substr($remoteHash, 0, 7) : '-',
                'pending_commits' => $commitOutput,
                'message' => $hasUpdate
                    ? 'Pembaruan tersedia!'
                    : 'Aplikasi sudah yang terbaru.',
            ]);
        } catch (\Throwable $e) {
            Log::error('Update check gagal: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memeriksa pembaruan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function run()
    {
        Log::info('Memulai proses update aplikasi oleh admin.');

        return response()->stream(function () {
            $this->streamOutput("[INFO] Memulai proses update...\n");

            try {
                $exitCode = Artisan::call('update:app');
                $commandOutput = Artisan::output();

                $this->streamOutput($commandOutput);

                if ($exitCode === 0) {
                    $this->streamOutput("\n[SUKSES] Update aplikasi berhasil!\n");
                    Log::info('Update aplikasi berhasil.');
                } else {
                    $this->streamOutput("\n[ERROR] Update gagal. Periksa log untuk detail.\n");
                    Log::error('Update aplikasi gagal.', ['output' => $commandOutput]);
                }
            } catch (\Throwable $e) {
                $this->streamOutput("\n[ERROR] " . $e->getMessage() . "\n");
                Log::error('Update aplikasi error: ' . $e->getMessage());
            }

            $this->streamOutput("[INFO] Selesai.\n");
        }, 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    private function streamOutput(string $text): void
    {
        echo $text;
        ob_flush();
        flush();
    }

    private function getGitInfo(): array
    {
        $redirection = DIRECTORY_SEPARATOR === '\\' ? '2>nul' : '2>/dev/null';
        $branch = trim(shell_exec('git rev-parse --abbrev-ref HEAD 2>nul') ?? 'main');
        $commit = trim(shell_exec('git log -1 --format="%h - %s" 2>nul') ?? '-');
        $commitDate = trim(shell_exec('git log -1 --format="%ci" 2>nul') ?? '-');
        exec("git describe --tags --abbrev=0 {$redirection}", $tagOutput, $tagCode);
        $tag = ($tagCode === 0 && !empty($tagOutput[0])) ? trim($tagOutput[0]) : '-';

        return [
            'branch' => $branch,
            'commit' => $commit,
            'commit_date' => $commitDate,
            'tag' => $tag,
        ];
    }
}
