<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuestBook;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminGuestBookController extends Controller
{
    /**
     * Display a listing of the guest book entries.
     */
    public function index(Request $request)
    {
        $guestBooks = GuestBook::orderBy('created_at', 'desc')->paginate(10);
        
        $stats = [
            'total' => GuestBook::count(),
            'today' => GuestBook::whereDate('created_at', now()->today())->count(),
            'this_week' => GuestBook::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => GuestBook::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
        ];

        if ($request->ajax()) {
            return view('content.pages.admin.guest-book._table', compact('guestBooks', 'stats'));
        }
        
        return view('content.pages.admin.guest-book.index', compact('guestBooks', 'stats'));
    }

    /**
     * Display the specified guest book entry.
     */
    public function show(GuestBook $guestBook)
    {
        if (request()->wantsJson()) {
            $guestBook->load('guru');
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $guestBook->id,
                    'nama_lengkap' => $guestBook->nama_lengkap,
                    'no_whatsapp' => $guestBook->no_whatsapp,
                    'alamat' => $guestBook->alamat,
                    'jenis_instansi' => $guestBook->jenis_instansi,
                    'nama_instansi' => $guestBook->nama_instansi,
                    'guru_id' => $guestBook->guru_id,
                    'guru' => $guestBook->guru,
                    'tujuan' => $guestBook->tujuan,
                    'keperluan' => $guestBook->keperluan,
                    'waktu' => $guestBook->created_at->format('d F Y H:i') . ' WIB',
                ]
            ]);
        }

        return view('content.pages.admin.guest-book.show', compact('guestBook'));
    }

    /**
     * Reset all guest book data.
     */
    public function reset()
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            GuestBook::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            return response()->json([
                'success' => true,
                'message' => 'Semua data buku tamu berhasil direset.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mereset data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified guest book entry from storage.
     */
    public function destroy(GuestBook $guestBook)
    {
        try {
            $guestBook->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data buku tamu berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}
