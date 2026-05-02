<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nisn', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('no_peserta', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }

        if ($request->filled('status')) {
            $query->where('status_kelulusan', $request->status);
        }

        $siswa  = $query->orderBy('nama_lengkap')->paginate(20)->withQueryString();
        $kelasList  = Siswa::distinct()->orderBy('kelas')->pluck('kelas');
        $jurusanList = Siswa::distinct()->orderBy('jurusan')->pluck('jurusan');

        if ($request->ajax()) {
            return view('content.pages.admin.siswa._table', compact('siswa'))->render();
        }

        return view('content.pages.admin.siswa.index', compact('siswa', 'kelasList', 'jurusanList'));
    }

    public function create()
    {
        return view('content.pages.admin.siswa.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nisn'             => ['required', 'digits:10', 'unique:siswa,nisn'],
            'nis'              => ['nullable', 'string', 'max:20'],
            'no_peserta'       => ['nullable', 'string', 'max:50'],
            'nama_lengkap'     => ['required', 'string', 'max:255'],
            'tempat_lahir'     => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'    => ['nullable', 'date'],
            'jenis_kelamin'    => ['nullable', 'in:laki-laki,perempuan'],
            'nama_orang_tua'   => ['nullable', 'string', 'max:255'],
            'no_peserta_ujian' => ['nullable', 'string', 'max:50'],
            'kelas'            => ['required', 'string', 'max:50'],
            'jurusan'          => ['required', 'string', 'max:100'],
            'madrasah_asal'    => ['nullable', 'string', 'max:255'],
            'status_kelulusan' => ['required', 'in:lulus,tidak_lulus,pending'],
        ], [
            'nisn.unique' => 'NISN sudah terdaftar.',
            'nisn.digits' => 'NISN harus 10 digit angka.',
        ]);

        Siswa::create($data);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        return view('content.pages.admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $data = $request->validate([
            'nisn'             => ['required', 'digits:10', 'unique:siswa,nisn,' . $siswa->id],
            'nis'              => ['nullable', 'string', 'max:20'],
            'no_peserta'       => ['nullable', 'string', 'max:50'],
            'nama_lengkap'     => ['required', 'string', 'max:255'],
            'tempat_lahir'     => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'    => ['nullable', 'date'],
            'jenis_kelamin'    => ['nullable', 'in:laki-laki,perempuan'],
            'nama_orang_tua'   => ['nullable', 'string', 'max:255'],
            'no_peserta_ujian' => ['nullable', 'string', 'max:50'],
            'kelas'            => ['required', 'string', 'max:50'],
            'jurusan'          => ['required', 'string', 'max:100'],
            'madrasah_asal'    => ['nullable', 'string', 'max:255'],
            'status_kelulusan' => ['required', 'in:lulus,tidak_lulus,pending'],
        ]);

        $siswa->update($data);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ], [
            'file.mimes' => 'File harus berformat xlsx, xls, atau csv.',
            'file.max'   => 'Ukuran file maksimal 5MB.',
        ]);

        Excel::import(new SiswaImport(), $request->file('file'));

        return redirect()->route('admin.siswa.index')->with('success', 'Import data siswa berhasil.');
    }

    public function bulkStatus(Request $request)
    {
        $request->validate([
            'ids'    => ['required', 'array'],
            'ids.*'  => ['integer', 'exists:siswa,id'],
            'status' => ['required', 'in:lulus,tidak_lulus,pending'],
        ]);

        Siswa::whereIn('id', $request->ids)->update(['status_kelulusan' => $request->status]);

        return response()->json(['message' => 'Status berhasil diperbarui.']);
    }
}
