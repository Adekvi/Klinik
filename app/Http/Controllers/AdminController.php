<?php

namespace App\Http\Controllers;

use App\Models\DataDokter;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\PasienSehat;
use App\Models\Resep;
use App\Models\RmDa1;
use App\Models\User;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // Mengecek apakah pengguna sudah login
        if (Auth::check()) {
            // Menyimpan status aktif di session jika login
            session(['admin_active' => true]);
        } else {
            // Menyimpan status tidak aktif di session jika tidak login
            session(['admin_active' => false]);
        }

        $totalpasien = Pasien::count();
        $totalpasienUmum = Pasien::where('jenis_pasien', 'Umum')->count();
        $totalpasienBpjs = Pasien::where('jenis_pasien', 'BPJS')->count();
        $totalpasienSehat = PasienSehat::count();
        $totalDokter = DataDokter::where('profesi', 'Dokter Umum')
            ->orWhere('profesi', 'Dokter Gigi')
            ->count();

        // dd($totalDokter);
        $totalTenagamedis = DataDokter::count();

        // Menyimpan data jumlah pasien berdasarkan bulan
        $pasienUmumPerBulan = [];
        $pasienBpjsPerBulan = [];
        $pasienSehatPerBulan = [];

        // Loop untuk menghitung jumlah pasien per bulan (Januari sampai Desember)
        for ($i = 1; $i <= 12; $i++) {
            $pasienUmumPerBulan[] = Pasien::where('jenis_pasien', 'Umum')->whereMonth('created_at', $i)->count();
            $pasienBpjsPerBulan[] = Pasien::where('jenis_pasien', 'BPJS')->whereMonth('created_at', $i)->count();
            $pasienSehatPerBulan[] = PasienSehat::whereMonth('created_at', $i)->count();
        }

        // Menyusun data untuk bulan dalam format string
        $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        return view('admin.dashboard', compact('pasienUmumPerBulan', 'pasienBpjsPerBulan', 'pasienSehatPerBulan', 'bulan', 'totalpasien', 'totalpasienUmum', 'totalpasienBpjs', 'totalpasienSehat', 'totalDokter', 'totalTenagamedis'));
    }
}
