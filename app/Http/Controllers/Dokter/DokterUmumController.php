<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\AntrianPerawat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterUmumController extends Controller
{
    public function dokterUmum($id)
    {
        $auth = Auth::user()->id_dokter;
        $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli'])
            ->where('status', 'M')
            ->where('id_dokter', $auth)
            ->where('id', $id)
            ->orderBy('urutan', 'asc')
            ->orderBy('updated_at', 'asc')
            ->first();
        // dd($antrianDokter);
        return view('dokter.umum.index', compact('antrianDokter', 'auth'));
    }
}
