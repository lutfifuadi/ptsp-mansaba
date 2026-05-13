<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\GuruTemplateExport;
use App\Imports\GuruImport;
use App\Models\Guru;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminGuruController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $gurus = Guru::when($search, function ($q, $search) {
            $q->where('nama_lengkap', 'like', "%{$search}%")
              ->orWhere('nip', 'like', "%{$search}%")
              ->orWhere('nuptk', 'like', "%{$search}%")
              ->orWhere('bidang_studi', 'like', "%{$search}%");
        })->orderBy('nama_lengkap')->paginate(10);

        if ($request->ajax()) {
            return view('content.pages.admin.guru._table', compact('gurus'))->render();
        }

        return view('content.pages.admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('content.pages.admin.guru.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nip'          => ['nullable', 'string', 'max:50'],
            'nuptk'        => ['nullable', 'string', 'max:50'],
            'bidang_studi' => ['required', 'string', 'max:255'],
            'no_whatsapp'  => ['nullable', 'string', 'max:20'],
            'alamat'       => ['nullable', 'string'],
            'is_active'    => ['nullable', 'boolean'],
        ]);

        Guru::create($data);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        return view('content.pages.admin.guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('content.pages.admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nip'          => ['nullable', 'string', 'max:50'],
            'nuptk'        => ['nullable', 'string', 'max:50'],
            'bidang_studi' => ['required', 'string', 'max:255'],
            'no_whatsapp'  => ['nullable', 'string', 'max:20'],
            'alamat'       => ['nullable', 'string'],
            'is_active'    => ['nullable', 'boolean'],
        ]);

        $guru->update($data);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus.');
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
            Excel::import(new GuruImport(), $request->file('file'));
            return redirect()->route('admin.guru.index')->with('success', 'Import data guru berhasil.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('[AdminGuruController] Import failed: ' . $e->getMessage());
            return redirect()->back()->with('error_import', 'Gagal mengimpor data. Pastikan format file benar. Detail: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new GuruTemplateExport(), 'template-import-guru.xlsx');
    }
}
