<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Pengaturan;

class HomePage extends Controller
{
  public function index()
  {
    $totalSiswa = Siswa::count();
    $lulus = Siswa::where('status_kelulusan', 'lulus')->count();
    $tidakLulus = Siswa::where('status_kelulusan', 'tidak_lulus')->count();
    $belumDitentukan = Siswa::whereNull('status_kelulusan')->orWhere('status_kelulusan', '')->count();
    
    $tglPengumuman = Pengaturan::get('tanggal_pengumuman', '-');
    $statusPengumuman = Pengaturan::get('pengumuman_aktif', '0');
    
    $siswaTerbaru = Siswa::latest()->take(5)->get();

    return view('content.pages.pages-home', compact(
      'totalSiswa',
      'lulus',
      'tidakLulus',
      'belumDitentukan',
      'tglPengumuman',
      'statusPengumuman',
      'siswaTerbaru'
    ));
  }
}
