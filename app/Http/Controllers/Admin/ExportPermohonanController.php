<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\PermohonanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportPermohonanController extends Controller
{
    public function export(Request $request, $format)
    {
        if (!in_array($format, ['xlsx', 'csv'])) {
            abort(404, 'Format tidak didukung.');
        }

        $filename = 'rekap-layanan-ptsp-' . now()->format('Y-m-d') . '.' . $format;

        return Excel::download(new PermohonanExport($request), $filename);
    }
}
