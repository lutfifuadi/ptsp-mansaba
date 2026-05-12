<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\PermohonanExport;
use App\Models\Layanan;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportPermohonanController extends Controller
{
    public function export(Request $request, $format)
    {
        if (!in_array($format, ['xlsx', 'csv'])) {
            abort(404, 'Format tidak didukung.');
        }

        $prefix = 'rekap-ptsp';
        if ($request->filled('layanan_id')) {
            $layanan = Layanan::find($request->layanan_id);
            if ($layanan) {
                $prefix = 'rekap-' . str_replace(' ', '-', strtolower($layanan->nama_layanan));
            }
        }

        $filename = $prefix . '-' . now()->format('Y-m-d') . '.' . $format;

        return Excel::download(new PermohonanExport($request), $filename);
    }
}
