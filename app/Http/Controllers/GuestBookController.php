<?php

namespace App\Http\Controllers;

use App\Models\GuestBook;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuestBookController extends Controller
{
    /**
     * Display the guest book form.
     */
    public function index()
    {
        return view('content.pages.guest-book');
    }

    /**
     * Store a newly created guest book entry in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'jenis_instansi' => 'required|in:Instansi,Lembaga,Personal',
            'nama_instansi' => 'nullable|string|max:255',
            'guru_id' => 'nullable|exists:guru,id',
            'tujuan' => 'required|string|max:255',
            'keperluan' => 'required|string',
        ];

        if ($request->tujuan === 'Guru') {
            $rules['guru_id'] = 'required|exists:guru,id';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            GuestBook::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data buku tamu berhasil dikirim. Terima kasih atas kunjungan Anda!'
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('GuestBook Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'
            ], 500);
        }
    }
}
