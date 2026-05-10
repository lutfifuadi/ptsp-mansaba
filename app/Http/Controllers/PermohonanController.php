<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Layanan;
use App\Models\Permohonan;
use Illuminate\Support\Str;

class PermohonanController extends Controller
{
    public function index()
    {
        $layananUmum = Layanan::where('is_active', true)->where('kategori', 'umum')->get();
        $layananSiswa = Layanan::where('is_active', true)->where('kategori', 'siswa')->get();
        return view('ptsp.index', compact('layananUmum', 'layananSiswa'));
    }

    public function tracking()
    {
        return view('ptsp.tracking');
    }

    public function track(Request $request)
    {
        $request->validate([
            'no_tiket' => 'required|string',
        ]);

        $permohonan = Permohonan::where('no_tiket', $request->no_tiket)->first();

        if (!$permohonan) {
            return back()->with('error', 'Nomor tiket tidak ditemukan.');
        }

        return view('ptsp.tracking-result', compact('permohonan'));
    }

    public function create(Request $request)
    {
        $layanan_id = $request->query('layanan_id');
        $layanan = Layanan::findOrFail($layanan_id);
        return view('ptsp.create', compact('layanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'data_form' => 'nullable|array',
        ]);

        $permohonan = Permohonan::create([
            'user_id' => auth()->id(),
            'layanan_id' => $request->layanan_id,
            'no_tiket' => 'PTSP-' . strtoupper(Str::random(8)),
            'status' => 'pending',
            'data_form' => $request->data_form,
        ]);

        return redirect()->route('ptsp.show', $permohonan->id)->with('success', 'Permohonan berhasil dikirim.');
    }

    public function pengambilanIjazah()
    {
        return view('content.pages.layanan.pengambilan-ijazah');
    }

    public function storeIjazah(Request $request)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kelas_asal'    => 'required|string|max:50',
            'tahun_lulus'   => 'required|string|max:10',
            'tgl_pengajuan' => 'required|date',
            'no_wa'         => 'required|string|max:20',
        ]);

        $layanan = Layanan::firstOrCreate(
            ['nama_layanan' => 'Pengambilan Ijazah'],
            [
                'deskripsi' => 'Layanan pengambilan ijazah bagi alumni',
                'kategori'  => 'umum',
                'is_active' => true,
            ]
        );

        $permohonan = Permohonan::create([
            'user_id'    => auth()->check() ? auth()->id() : null,
            'layanan_id' => $layanan->id,
            'no_tiket'   => 'PTSP-IJZ-' . strtoupper(Str::random(5)),
            'status'     => 'pending',
            'data_form'  => [
                'nama_lengkap'  => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'kelas_asal'    => $request->kelas_asal,
                'tahun_lulus'   => $request->tahun_lulus,
                'tgl_pengajuan' => $request->tgl_pengajuan,
                'no_wa'         => $request->no_wa,
            ],
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Permohonan pengambilan ijazah berhasil dikirim.',
            'no_tiket' => $permohonan->no_tiket,
        ]);
    }

    public function show(Permohonan $permohonan)
    {
        // Ensure user can only see their own permohonan
        if (auth()->id() !== $permohonan->user_id) {
            abort(403);
        }

        return view('ptsp.show', compact('permohonan'));
    }

    // Admin Methods
    public function adminIndex(Request $request)
    {
        $query = Permohonan::with(['user', 'layanan', 'siswa'])->latest();

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter sumber (login / publik)
        if ($request->filled('sumber')) {
            if ($request->sumber === 'publik') {
                $query->whereNull('user_id');
            } elseif ($request->sumber === 'login') {
                $query->whereNotNull('user_id');
            }
        }

        // Filter layanan
        if ($request->filled('layanan_id')) {
            $query->where('layanan_id', $request->layanan_id);
        }

        // Search tiket / nama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_tiket', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $permohonan = $query->paginate(15);
        return view('admin.ptsp.index', compact('permohonan'));
    }

    public function adminShow(Permohonan $permohonan)
    {
        $permohonan->load(['user', 'layanan', 'siswa']);
        return view('admin.ptsp.show', compact('permohonan'));
    }

    public function updateStatus(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $permohonan->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Status permohonan berhasil diperbarui.');
    }
}
