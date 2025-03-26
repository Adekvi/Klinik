<?php

namespace App\Http\Controllers\Admin\Rekapan;

use App\Http\Controllers\Controller;
use App\Models\DiagnosaTerbanyak;
use App\Models\Pasien;
use App\Models\PasienSehat;
use App\Models\Poli;
use App\Models\Soap;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HarianController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Menghitung total pasien
        $totalpasien = Pasien::count();

        // Menghitung total pasien berdasarkan jenis
        $totalpasienUmum = Pasien::where('jenis_pasien', 'Umum')->count();
        $totalpasienBpjs = Pasien::where('jenis_pasien', 'BPJS')->count();

        // Menghitung pasien yang diperiksa hari ini berdasarkan jenisnya
        $pasienHariIniUmum = Pasien::where('jenis_pasien', 'Umum')
                                    ->whereDate('created_at', $today)
                                    ->count();
        $pasienHariIniBpjs = Pasien::where('jenis_pasien', 'BPJS')
                                    ->whereDate('created_at', $today)
                                    ->count();

        // Menghitung total pasien sehat
        $totalpasienSehat = PasienSehat::count();

        // Menghitung total diagnosa
        $totaldiagnosa = DiagnosaTerbanyak::count();

        // // Menghitung total poli
        // $totalpoliUmum = Poli::where('namapoli', 'Umum')->count();
        // $totalpoliGigi = Poli::where('namapoli', 'Gigi')->count();

        // dd($today);

        return view('admin.rekaphari.index', compact(
            'totalpasien', 
            'totalpasienUmum', 
            'totalpasienBpjs', 
            'pasienHariIniUmum', 
            'pasienHariIniBpjs', 
            'totalpasienSehat', 
            'totaldiagnosa', 
            // 'totalpoliUmum',
            // 'totalpoliGigi',
        ));
    }
}
