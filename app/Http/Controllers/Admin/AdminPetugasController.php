<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Models\Layanan;
use Illuminate\Http\Request;

class AdminPetugasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $petugas = Petugas::with('layanan')
            ->when($search, function ($q, $search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('no_whatsapp', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('nama_lengkap')
            ->paginate(10);

        if ($request->ajax()) {
            return view('content.pages.admin.petugas._table', compact('petugas'))->render();
        }

        $layanan = Layanan::where('is_active', true)->orderBy('nama_layanan')->get();
        return view('content.pages.admin.petugas.index', compact('petugas', 'layanan'));
    }

    public function create()
    {
        $layanan = Layanan::where('is_active', true)->orderBy('nama_layanan')->get();
        return view('content.pages.admin.petugas.create', compact('layanan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'no_whatsapp'  => ['required', 'string', 'max:50'],
            'email'        => ['nullable', 'email', 'max:255'],
            'deskripsi'    => ['nullable', 'string', 'max:500'],
            'is_active'    => ['nullable', 'boolean'],
            'layanan_id'   => ['nullable', 'array'],
            'layanan_id.*' => ['exists:layanan,id'],
        ]);

        $petugas = Petugas::create($data);
        $petugas->layanan()->sync($request->layanan_id ?? []);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Data petugas berhasil ditambahkan.']);
        }

        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil ditambahkan.');
    }

    public function show(Petugas $petugas)
    {
        $petugas->load('layanan');
        return view('content.pages.admin.petugas.show', compact('petugas'));
    }

    public function edit(Petugas $petugas)
    {
        $layanan = Layanan::where('is_active', true)->orderBy('nama_layanan')->get();
        $petugas->load('layanan');
        return view('content.pages.admin.petugas.edit', compact('petugas', 'layanan'));
    }

    public function update(Request $request, Petugas $petugas)
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'no_whatsapp'  => ['required', 'string', 'max:50'],
            'email'        => ['nullable', 'email', 'max:255'],
            'deskripsi'    => ['nullable', 'string', 'max:500'],
            'is_active'    => ['nullable', 'boolean'],
            'layanan_id'   => ['nullable', 'array'],
            'layanan_id.*' => ['exists:layanan,id'],
        ]);

        $petugas->update($data);
        $petugas->layanan()->sync($request->layanan_id ?? []);

        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil diperbarui.');
    }

    public function destroy(Petugas $petugas)
    {
        $petugas->delete();
        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil dihapus.');
    }
}
