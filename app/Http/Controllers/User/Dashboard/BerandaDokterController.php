<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AntrianPerawat;
use App\Models\TtdMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaDokterController extends Controller
{
    public function index()
    {
        // Mengecek apakah pengguna sudah login
        if (Auth::check()) {
            // Menyimpan status aktif di session jika login
            session(['perawat_active' => true]);
        } else {
            // Menyimpan status tidak aktif di session jika tidak login
            session(['perawat_active' => false]);
        }

        return view('dashboard');
    }

    public function periksa()
    {
        $auth = Auth::user()->id_dokter;
        $antrianDokter = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli'])
            ->where('status', 'M')
            ->where('id_dokter', $auth)
            ->orderBy('urutan', 'asc')
            ->orderBy('updated_at', 'asc')
            ->paginate(10);

        $ttd = TtdMedis::all();

        // Group by Poli
        $groupedAntrian = $antrianDokter->groupBy('poli.namapoli');

        return view('dokter.periksa', compact('antrianDokter', 'ttd', 'groupedAntrian'));
    }
}
