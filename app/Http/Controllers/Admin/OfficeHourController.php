<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JamOperasional;
use Illuminate\Http\Request;

class OfficeHourController extends Controller
{
    public function index()
    {
        $jamOperasional = JamOperasional::orderBy('hari', 'asc')->get();
        return view('content.pages.admin.pengaturan.jam-operasional', compact('jamOperasional'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'jam' => 'required|array',
            'jam.*.hari' => 'required|integer',
            'jam.*.is_aktif' => 'nullable|boolean',
            'jam.*.jam_buka' => 'nullable|date_format:H:i',
            'jam.*.jam_tutup' => 'nullable|date_format:H:i',
        ]);

        foreach ($request->jam as $hari => $config) {
            JamOperasional::where('hari', $hari)->update([
                'is_aktif' => isset($config['is_aktif']),
                'jam_buka' => $config['jam_buka'] ?? null,
                'jam_tutup' => $config['jam_tutup'] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Jam operasional berhasil diperbarui.');
    }
}
