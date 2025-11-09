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

        // Total pasien hari ini
        $totalHariIni = Pasien::whereDate('created_at', $today)->count();

        // Ambil video aktif
        $video = Video::where('status', 'Aktif')->get();

        // Data antrian untuk tabel (semua pasien hari ini)
        $data = AntrianPerawat::with(['booking.pasien', 'poli'])
            ->whereDate('created_at', $today)
            ->get();

        // === NOMOR ANTRIAN AKTIF (yang sedang dipanggil) ===

        // Poli Umum: ambil antrian pertama yang status 'P' (Periksa) atau 'B' (Apotek) atau 'M' (Menunggu)
        $antrianUmum = AntrianPerawat::with(['booking.pasien'])
            ->whereHas('poli', fn($q) => $q->where('namapoli', 'Umum'))
            ->whereDate('created_at', $today)
            ->whereIn('status', ['D', 'M', 'P', 'B'])
            ->orderBy('kode_antrian')
            ->first();

        $nomorAntrianUmum = $antrianUmum?->kode_antrian ?? 0;

        // Poli Gigi
        $antrianGigi = AntrianPerawat::with(['booking.pasien'])
            ->whereHas('poli', fn($q) => $q->where('namapoli', 'Gigi'))
            ->whereDate('created_at', $today)
            ->whereIn('status', ['D', 'M', 'P', 'B'])
            ->orderBy('kode_antrian')
            ->first();

        // dd($antrianGigi);

        $nomorAntrianGigi = $antrianGigi?->kode_antrian ?? 0;

        // Ruang Farmasi: antrian yang status 'B' (Apotek)
        $antrianObat = AntrianPerawat::with(['booking.pasien'])
            ->whereDate('created_at', $today)
            ->where('status', 'B')
            ->orderBy('kode_antrian')
            ->first();

        $nomorAntrianObat = $antrianObat?->kode_antrian ?? 0;

        return view('antrian.antrian', compact(
            'totalHariIni',
            'video',
            'data',
            'nomorAntrianUmum',
            'nomorAntrianGigi',
            'nomorAntrianObat'
        ));
    }
    
    // public function antrianView()
    // {
    //     $today = Carbon::today();
    
    //     // Menghitung total pasien yang datang hari ini
    //     $totalHariIni = Pasien::whereDate('created_at', $today)->count();

    //     $nomorAntrian = session('nomor_antrian_dokter', 0);
    //     $nomorAntrianPerawat = session('nomor_antrian_perawat', 0);
    //     $nomorAntrianObat = session('nomor_antrian_obat', 0);

    //     $video = Video::where('status', 'Aktif')->get();
        
    //     $data = AntrianPerawat::with(['booking.pasien', 'poli'])->whereDate('created_at', $today)->get();
    //     // dd($data);

    //     // Simpan nomor antrian dalam session
    //     $nomorAntrianUmum = session('nomor_antrian_umum', 0);
    //     $nomorAntrianGigi = session('nomor_antrian_gigi', 0);

    //     // Cari nomor antrian berikutnya dan simpan dalam sesi
    //     $dataUmum = AntrianPerawat::with(['booking.pasien'])
    //         ->whereHas('poli', function ($query) {
    //             $query->where('namapoli', 'Umum');
    //         })
    //         ->whereDate('created_at', $today)
    //         ->first();

    //     if ($dataUmum) {
    //     $nomorAntrianUmum = $dataUmum->kode_antrian;
    //         // Simpan nomor antrian umum dalam session
    //         session(['nomor_antrian_umum' => $nomorAntrianUmum]);
    //         } else {
    //         // Jika tidak ada nomor antrian, atur session ke null
    //         session(['nomor_antrian_umum' => 0]);
    //     }

    //     $dataGigi = AntrianPerawat::with(['booking.pasien'])
    //         ->whereHas('poli', function ($query) {
    //             $query->where('namapoli', 'Gigi');
    //         })
    //         ->whereDate('created_at', $today)
    //         ->first();

    //     if ($dataGigi) {
    //     $nomorAntrianGigi = $dataGigi->kode_antrian;
    //         // Simpan nomor antrian gigi dalam session
    //         session(['nomor_antrian_gigi' => $nomorAntrianGigi]);
    //         } else {
    //         // Jika tidak ada nomor antrian, atur session ke null
    //         session(['nomor_antrian_gigi' => 0]);
    //     }

    //     // dd($data);
    //     return view('antrian.antrian', compact('nomorAntrian', 'nomorAntrianPerawat', 'nomorAntrianObat', 'totalHariIni', 'video', 'data', 'dataUmum', 'dataGigi', 'nomorAntrianUmum', 'nomorAntrianGigi'));
    // }
}
