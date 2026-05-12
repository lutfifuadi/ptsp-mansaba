<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::where('is_active', true)->get(['id', 'nama_lengkap', 'bidang_studi']);

        return response()->json($gurus);
    }
}
