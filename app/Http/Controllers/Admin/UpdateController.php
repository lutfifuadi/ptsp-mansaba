<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Services\GitService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class UpdateController extends Controller
{
    private GitService $git;

    public function __construct(GitService $git)
    {
        $this->git = $git;
    }

    public function index()
    {
        $info = $this->git->getGitInfo();
        $appVersion = Pengaturan::get('app_version', '1.0.0');

        return view('content.pages.admin.update.index', compact('info', 'appVersion'));
    }

    public function check(): JsonResponse
    {
        try {
            if (!$this->git->isGitAvailable()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fitur git tidak tersedia di server ini. Update tidak dapat dilakukan.',
                    'git_available' => false,
                ], 503);
            }

            if (!$this->git->isRepo()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aplikasi bukan merupakan repository Git.',
                    'git_available' => false,
                ], 503);
            }

            $this->git->fetchOrigin();

            $branch = $this->git->getBranch();
            $localHash = $this->git->getLocalHash();
            $remoteHash = $this->git->getRemoteHash($branch);

            $hasUpdate = !empty($localHash) && !empty($remoteHash) && $localHash !== $remoteHash;
            $pendingCommits = $this->git->getPendingCommits($branch);

            return response()->json([
                'success' => true,
                'has_update' => $hasUpdate,
                'branch' => $branch,
                'local_commit' => $localHash ? substr($localHash, 0, 7) : '-',
                'remote_commit' => $remoteHash ? substr($remoteHash, 0, 7) : '-',
                'pending_commits' => $pendingCommits,
                'git_available' => true,
                'message' => $hasUpdate
                    ? 'Pembaruan tersedia!'
                    : 'Aplikasi sudah yang terbaru.',
            ]);
        } catch (\Throwable $e) {
            Log::error('Update check gagal: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memeriksa pembaruan. Silakan coba lagi atau hubungi administrator.',
                'git_available' => $this->git->isGitAvailable(),
            ], 500);
        }
    }

    public function run()
    {
        Log::info('Memulai proses update aplikasi oleh admin.');

        if (!$this->git->isGitAvailable()) {
            return response()->json([
                'success' => false,
                'message' => 'Fitur git tidak tersedia di server ini.',
            ], 503);
        }

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
}
