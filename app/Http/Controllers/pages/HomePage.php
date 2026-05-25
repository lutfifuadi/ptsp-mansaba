<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\GuestBook;
use App\Models\Layanan;
use App\Models\Permohonan;

class HomePage extends Controller
{
  public function index()
  {
    $totalPermohonan = Permohonan::count();
    $pending   = Permohonan::where('status', 'pending')->count();
    $proses    = Permohonan::where('status', 'proses')->count();
    $selesai   = Permohonan::where('status', 'selesai')->count();
    $publik    = Permohonan::whereNull('user_id')->count();
    $totalLayanan = Layanan::where('is_active', true)->count();
    $permohonanTerbaru = Permohonan::with(['layanan', 'siswa', 'user'])->latest()->take(5)->get();

    $totalTamu    = GuestBook::count();
    $tamuHariIni  = GuestBook::whereDate('created_at', now()->today())->count();
    $tamuMingguIni = GuestBook::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
    $tamuBulanIni = GuestBook::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
    $tamuTerbaru  = GuestBook::latest()->take(5)->get();

    $recentStart = now()->subDays(6)->startOfDay();
    $recentEnd   = now()->endOfDay();

    $dailyLabels = collect(range(6, 0))->map(fn($i) => now()->subDays($i)->format('Y-m-d'));
    $dailyRaw = Permohonan::selectRaw('DATE(created_at) as date, COUNT(*) as count')
      ->whereBetween('created_at', [$recentStart, $recentEnd])
      ->groupBy('date')
      ->orderBy('date')
      ->pluck('count', 'date');
    $chartDailyData = $dailyLabels->map(fn($date) => (int) ($dailyRaw[$date] ?? 0));

    $weeklyRaw = Permohonan::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
      ->selectRaw('DAYOFWEEK(created_at) as dow, COUNT(*) as count')
      ->groupBy('dow')
      ->orderBy('dow')
      ->pluck('count', 'dow');
    $chartWeeklyData = collect([2, 3, 4, 5, 6, 7, 1])->map(fn($dow) => (int) ($weeklyRaw[$dow] ?? 0));

    $total7Hari    = Permohonan::whereBetween('created_at', [$recentStart, $recentEnd])->count();
    $selesai7Hari  = Permohonan::where('status', 'selesai')->whereBetween('created_at', [$recentStart, $recentEnd])->count();
    $proses7Hari   = Permohonan::where('status', 'proses')->whereBetween('created_at', [$recentStart, $recentEnd])->count();
    $pending7Hari  = Permohonan::where('status', 'pending')->whereBetween('created_at', [$recentStart, $recentEnd])->count();
    $chartCompletionRate = $total7Hari > 0 ? round(($selesai7Hari / $total7Hari) * 100) : 0;

    return view('content.pages.pages-home', compact(
      'totalPermohonan',
      'pending',
      'proses',
      'selesai',
      'publik',
      'totalLayanan',
      'permohonanTerbaru',
      'totalTamu',
      'tamuHariIni',
      'tamuMingguIni',
      'tamuBulanIni',
      'tamuTerbaru',
      'chartDailyData',
      'chartWeeklyData',
      'chartCompletionRate',
      'total7Hari',
      'selesai7Hari',
      'proses7Hari',
      'pending7Hari'
    ));
  }
}
