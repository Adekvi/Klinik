<?php

namespace App\Http\Controllers;

use App\Models\AntrianPerawat;
use App\Models\Pasien;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function antrianView()
    {
        $today = Carbon::today();
    
        // Menghitung total pasien yang datang hari ini
        $totalHariIni = Pasien::whereDate('created_at', $today)->count();

        $nomorAntrian = session('nomor_antrian_dokter', 0);
        $nomorAntrianPerawat = session('nomor_antrian_perawat', 0);
        $nomorAntrianObat = session('nomor_antrian_obat', 0);

        $video = Video::all();
        
        $data = AntrianPerawat::with(['booking.pasien', 'poli'])->whereDate('created_at', $today)->get();
        // dd($data);

        // Simpan nomor antrian dalam session
        $nomorAntrianUmum = session('nomor_antrian_umum', 0);
        $nomorAntrianGigi = session('nomor_antrian_gigi', 0);

        // Cari nomor antrian berikutnya dan simpan dalam sesi
        $dataUmum = AntrianPerawat::with(['booking.pasien'])
            ->whereHas('poli', function ($query) {
                $query->where('namapoli', 'Umum');
            })
            ->whereDate('created_at', $today)
            ->first();

        if ($dataUmum) {
        $nomorAntrianUmum = $dataUmum->kode_antrian;
            // Simpan nomor antrian umum dalam session
            session(['nomor_antrian_umum' => $nomorAntrianUmum]);
            } else {
            // Jika tidak ada nomor antrian, atur session ke null
            session(['nomor_antrian_umum' => 0]);
        }

        $dataGigi = AntrianPerawat::with(['booking.pasien'])
            ->whereHas('poli', function ($query) {
                $query->where('namapoli', 'Gigi');
            })
            ->whereDate('created_at', $today)
            ->first();

        if ($dataGigi) {
        $nomorAntrianGigi = $dataGigi->kode_antrian;
            // Simpan nomor antrian gigi dalam session
            session(['nomor_antrian_gigi' => $nomorAntrianGigi]);
            } else {
            // Jika tidak ada nomor antrian, atur session ke null
            session(['nomor_antrian_gigi' => 0]);
        }

        // dd($data);
        return view('antrian.antrian', compact('nomorAntrian', 'nomorAntrianPerawat', 'nomorAntrianObat', 'totalHariIni', 'video', 'data', 'dataUmum', 'dataGigi', 'nomorAntrianUmum', 'nomorAntrianGigi'));
    }
}
