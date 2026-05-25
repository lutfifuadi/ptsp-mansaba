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
      'tamuTerbaru'
    ));
  }
}
