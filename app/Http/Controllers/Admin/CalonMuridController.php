<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalonMurid;
use App\Imports\CalonMuridImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CalonMuridController extends Controller
{
    public function index(Request $request)
    {
        $query = CalonMurid::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jalur')) {
            $query->where('jalur_pendaftaran', $request->jalur);
        }

        if ($request->filled('status')) {
            $query->where('status_kelulusan', $request->status);
        }

        $calonMurid = $query->orderBy('nama_lengkap')->paginate(20)->withQueryString();
        $jalurList = CalonMurid::distinct()->orderBy('jalur_pendaftaran')->pluck('jalur_pendaftaran');

        if ($request->ajax()) {
            return view('content.pages.admin.pmbm._table', compact('calonMurid'))->render();
        }

        return view('content.pages.admin.pmbm.index', compact('calonMurid', 'jalurList'));
    }

    public function create()
    {
        return view('content.pages.admin.pmbm.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap'         => ['required', 'string', 'max:255'],
            'nisn'                 => ['nullable', 'digits:10', 'unique:calon_murids,nisn'],
            'no_pendaftaran'       => ['required', 'string', 'unique:calon_murids,no_pendaftaran'],
            'jalur_pendaftaran'    => ['required', 'string', 'max:100'],
            'asal_sekolah'         => ['required', 'string', 'max:255'],
            'tempat_tanggal_lahir' => ['required', 'string', 'max:255'],
            'no_hp_calon'          => ['nullable', 'string', 'max:20'],
            'no_hp_ortu'           => ['required', 'string', 'max:20'],
            'nama_ortu'            => ['required', 'string', 'max:255'],
            'nik'                  => ['required', 'digits:16', 'unique:calon_murids,nik'],
            'status_kelulusan'     => ['required', 'in:Lulus,Tidak Lulus,Proses'],
            'keterangan'           => ['nullable', 'string'],
        ]);

        CalonMurid::create($data);

        return redirect()->route('admin.pmbm.index')->with('success', 'Data calon murid berhasil ditambahkan.');
    }

    public function edit(CalonMurid $pmbm)
    {
        return view('content.pages.admin.pmbm.edit', ['calon' => $pmbm]);
    }

    public function update(Request $request, CalonMurid $pmbm)
    {
        $data = $request->validate([
            'nama_lengkap'         => ['required', 'string', 'max:255'],
            'nisn'                 => ['nullable', 'digits:10', 'unique:calon_murids,nisn,' . $pmbm->id],
            'no_pendaftaran'       => ['required', 'string', 'unique:calon_murids,no_pendaftaran,' . $pmbm->id],
            'jalur_pendaftaran'    => ['required', 'string', 'max:100'],
            'asal_sekolah'         => ['required', 'string', 'max:255'],
            'tempat_tanggal_lahir' => ['required', 'string', 'max:255'],
            'no_hp_calon'          => ['nullable', 'string', 'max:20'],
            'no_hp_ortu'           => ['required', 'string', 'max:20'],
            'nama_ortu'            => ['required', 'string', 'max:255'],
            'nik'                  => ['required', 'digits:16', 'unique:calon_murids,nik,' . $pmbm->id],
            'status_kelulusan'     => ['required', 'in:Lulus,Tidak Lulus,Proses'],
            'keterangan'           => ['nullable', 'string'],
        ]);

        $pmbm->update($data);

        return redirect()->route('admin.pmbm.index')->with('success', 'Data calon murid berhasil diperbarui.');
    }

    public function destroy(CalonMurid $pmbm)
    {
        $pmbm->delete();

        return redirect()->route('admin.pmbm.index')->with('success', 'Data calon murid berhasil dihapus.');
    }

    public function import(Request $request)
    {
        set_time_limit(0);

        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ], [
            'file.mimes' => 'File harus berformat xlsx, xls, atau csv.',
            'file.max'   => 'Ukuran file maksimal 5MB.',
        ]);

        try {
            Excel::import(new CalonMuridImport(), $request->file('file'));
            return redirect()->route('admin.pmbm.index')->with('success', 'Import data calon murid berhasil.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('[CalonMuridController] Import failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengimpor data. Pastikan format file benar. Detail: ' . $e->getMessage());
        }
    }
}

