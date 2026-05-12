<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Permohonan;
use Illuminate\Http\Request;

class AdminPermohonanController extends Controller
{
    /**
     * Tampilkan semua data permohonan.
     */
    public function semuaData(Request $request)
    {
        $query = Permohonan::with(['user', 'layanan', 'siswa'])->latest();
        $this->applyFilters($request, $query);

        $permohonan = $query->paginate(15);
        $title = 'Semua Data Permohonan';
        $icon = 'tabler-database';

        return view('admin.ptsp.index', compact('permohonan', 'title', 'icon'));
    }

    /**
     * Halaman khusus Legalisir Ijazah.
     */
    public function legalisirIjazah(Request $request)
    {
        $layanan = Layanan::where('nama_layanan', 'Legalisir Ijazah')->first();
        $query = Permohonan::where('layanan_id', $layanan?->id)->with(['user', 'siswa'])->latest();
        $this->applyFilters($request, $query);

        $permohonan = $query->paginate(15);
        $title = 'Data Legalisir Ijazah';
        $icon = 'tabler-file-certificate';

        return view('admin.ptsp.index', compact('permohonan', 'title', 'icon', 'layanan'));
    }

    /**
     * Halaman khusus Pengambilan Ijazah.
     */
    public function pengambilanIjazah(Request $request)
    {
        $layanan = Layanan::where('nama_layanan', 'Pengambilan Ijazah')->first();
        $query = Permohonan::where('layanan_id', $layanan?->id)->with(['user', 'siswa'])->latest();
        $this->applyFilters($request, $query);

        $permohonan = $query->paginate(15);
        $title = 'Data Pengambilan Ijazah';
        $icon = 'tabler-certificate';

        return view('admin.ptsp.index', compact('permohonan', 'title', 'icon', 'layanan'));
    }

    /**
     * Halaman khusus Pembuatan Surat.
     */
    public function pembuatanSurat(Request $request)
    {
        $layanan = Layanan::where('nama_layanan', 'Pembuatan Surat-Surat')->first();
        $query = Permohonan::where('layanan_id', $layanan?->id)->with(['user', 'siswa'])->latest();
        $this->applyFilters($request, $query);

        $permohonan = $query->paginate(15);
        $title = 'Data Pembuatan Surat';
        $icon = 'tabler-mail';

        return view('admin.ptsp.index', compact('permohonan', 'title', 'icon', 'layanan'));
    }

    /**
     * Halaman khusus Legalisir.
     */
    public function legalisir(Request $request)
    {
        $layanan = Layanan::where('nama_layanan', 'Legalisir')->first();
        $query = Permohonan::where('layanan_id', $layanan?->id)->with(['user', 'siswa'])->latest();
        $this->applyFilters($request, $query);

        $permohonan = $query->paginate(15);
        $title = 'Data Legalisir';
        $icon = 'tabler-file-certificate';

        return view('admin.ptsp.index', compact('permohonan', 'title', 'icon', 'layanan'));
    }

    /**
     * Helper untuk apply filter pencarian dan status.
     */
    private function applyFilters(Request $request, $query)
    {
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_tiket', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhereHas('siswa', function($sq) use ($search) {
                      $sq->where('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }
    }
}
