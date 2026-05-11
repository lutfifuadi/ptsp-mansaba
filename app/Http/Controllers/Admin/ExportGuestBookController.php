<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuestBook;
use App\Exports\GuestBookExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportGuestBookController extends Controller
{
    public function rekap()
    {
        $guestBooks = GuestBook::orderBy('created_at', 'desc')->paginate(20);
        $total = GuestBook::count();

        $today = GuestBook::whereDate('created_at', today())->count();
        $thisMonth = GuestBook::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $instansiStats = GuestBook::selectRaw('jenis_instansi, COUNT(*) as total')
            ->groupBy('jenis_instansi')
            ->pluck('total', 'jenis_instansi');

        return view('content.pages.admin.guest-book.rekap', compact(
            'guestBooks', 'total', 'today', 'thisMonth', 'instansiStats'
        ));
    }

    public function export($format)
    {
        if (!in_array($format, ['xlsx', 'csv'])) {
            abort(404, 'Format tidak didukung.');
        }

        $filename = 'rekap-buku-tamu-' . now()->format('Y-m-d') . '.' . $format;

        return Excel::download(new GuestBookExport($format), $filename);
    }
}
