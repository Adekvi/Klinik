<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AntrianPerawat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaApotekerController extends Controller
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

        $auth = Auth::user()->id_dokter;
        
        $totalPasien = AntrianPerawat::where('status', 'P')
            ->where('id_dokter', $auth)
            ->count();

        $today = Carbon::today();
        $BelumDilayani = AntrianPerawat::where('status', 'M')
            ->where('id_dokter', $auth)
            ->whereDate('created_at', $today)
            ->count();

        $pasienBpjs = AntrianPerawat::where('status', 'P')
            ->where('id_dokter', $auth)
             ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'BPJS');
                });
            })
            ->count();

        $pasienUmum = AntrianPerawat::where('status', 'P')
            ->where('id_dokter', $auth)
             ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'Umum');
                });
            })
            ->count();

        // dd($pasienUmum);

        return view('dashboard', compact(
            'totalPasien',
            'BelumDilayani',
            'pasienBpjs',
            'pasienUmum',
        ));
    }
}
