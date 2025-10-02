<?php

namespace App\Http\Controllers;

use App\Exports\RekapPasienBpjsExport;
use App\Exports\RekapPasienGigiBpjsExport;
use App\Exports\RekapPasienGigiUmumExport;
use App\Exports\RekapPasienUmumExport;
use App\Models\AntrianObat;
use App\Models\AntrianPerawat;
use App\Models\Diagnosa;
use App\Models\Soap;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPerawatController extends Controller
{
    public function rekap(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10); // Default 10
        $page = $request->input('page', 1);

        // Query semua pasien
        $query = AntrianPerawat::with(['booking.pasien', 'poli', 'rm', 'isian'])
            ->where('status', 'M')
            // ->orderByRaw("CASE WHEN status = 'D' THEN 1 ELSE 2 END")
            ->orderBy('urutan', 'asc') // Menambahkan pengurutan berdasarkan urutan
            ->orderBy('created_at', 'asc');

        if ($search) {
            $query->whereHas('booking.pasien', function ($q) use ($search) {
                $q->where('nama_pasien', 'LIKE', "%{$search}%")
                    ->orWhere('nik', 'LIKE', "%{$search}%")
                    ->orWhere('no_rm', 'LIKE', "%{$search}%");
            });
        }

        // Paginasi dengan jumlah entri yang dipilih
        $pasien = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);

        // Menjaga parameter pencarian tetap ada saat navigasi halaman
        $pasien->appends(['search' => $search, 'entries' => $entries]);

        // $pasien = AntrianPerawat::with(['booking.pasien', 'poli', 'rm', 'isian'])
        //     ->orderByRaw("CASE WHEN status = 'D' THEN 1 ELSE 2 END")
        //     ->orderBy('urutan', 'asc') // Menambahkan pengurutan berdasarkan urutan
        //     ->orderBy('created_at', 'asc')
        //     ->paginate(10);

        // dd($pasien);

        $log = AntrianPerawat::all();
        // Count untuk shift pagi berdasarkan id_poli = 1
        // Count untuk shift pagi berdasarkan id_poli = 1 dan id_pasien = 1
        // Count untuk shift pagi berdasarkan jenis_pasien == 'BPJS'

        // SHIFT PAGI POLI UMUM
        // PASIEN BPJS
        $countShiftPagiUmumBPJS = AntrianPerawat::where('id_poli', 1)
            ->whereDate('created_at', Carbon::today()) // <-- tambah filter hari ini
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'BPJS');
                });
            })
            ->whereTime('created_at', '>=', '07:00:00')
            ->whereTime('created_at', '<', '13:00:00')
            ->count();

        // PASIEN UMUM
        $countShiftPagiUmumUmum = AntrianPerawat::where('id_poli', 1)
            ->whereDate('created_at', Carbon::today())
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'Umum');
                });
            })
            ->whereTime('created_at', '>=', '07:00:00')
            ->whereTime('created_at', '<', '13:00:00')
            ->count();

        // SHIFT PAGI POLI GIGI
        // PASIEN BPJS
        $countShiftPagiGigiBPJS = AntrianPerawat::where('id_poli', 2)
            ->whereDate('created_at', Carbon::today())
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'BPJS');
                });
            })
            ->whereTime('created_at', '>=', '07:00:00')
            ->whereTime('created_at', '<', '13:00:00')
            ->count();

        // PASIEN UMUM
        $countShiftPagiGigiUmum = AntrianPerawat::where('id_poli', 2)
            ->whereDate('created_at', Carbon::today())
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'Umum');
                });
            })
            ->whereTime('created_at', '>=', '07:00:00')
            ->whereTime('created_at', '<', '13:00:00')
            ->count();

        // SHIFT SIANG POLI UMUM
        // PASIEN BPJS
        $countShiftSiangUmumBPJS = AntrianPerawat::where('id_poli', 1)
            ->whereDate('created_at', Carbon::today())
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'BPJS');
                });
            })
            ->whereTime('created_at', '>=', '13:00:00')
            ->whereTime('created_at', '<', '18:00:00')
            ->count();

        // PASIEN UMUM
        $countShiftSiangUmumUmum = AntrianPerawat::where('id_poli', 1)
            ->whereDate('created_at', Carbon::today())
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'Umum');
                });
            })
            ->whereTime('created_at', '>=', '13:00:00')
            ->whereTime('created_at', '<', '18:00:00')
            ->count();

        // SHIFT SIANG POLI GIGI
        // PASIEN UMUM
        $countShiftSiangGigiUmum = AntrianPerawat::where('id_poli', 2)
            ->whereDate('created_at', Carbon::today())
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'Umum');
                });
            })
            ->whereTime('created_at', '>=', '13:00:00')
            ->whereTime('created_at', '<', '18:00:00')
            ->count();

        // PASIEN BPJS
        $countShiftSiangGigiBpjs = AntrianPerawat::where('id_poli', 2)
            ->whereDate('created_at', Carbon::today())
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'BPJS');
                });
            })
            ->whereTime('created_at', '>=', '13:00:00')
            ->whereTime('created_at', '<', '18:00:00')
            ->count();

        // dd($countShiftSiangUmumUmum, $countShiftSiangGigiBpjs, $countShiftSiangGigiUmum);

        // TOTAL PASIEN SHIFT PAGI DAN SIANG
        // POLI UMUM PASIEN UMUM
        $totalPoliUmumPasienUmum = $countShiftPagiUmumUmum + $countShiftSiangUmumUmum;

        // POLI UMUM PASIEN BPJS
        $totalPoliUmumPasienBPJS = $countShiftPagiUmumBPJS + $countShiftSiangUmumBPJS;

        // POLI GIGI PASIEN UMUM
        $totalPoliGigiPasienUmum = $countShiftPagiGigiUmum + $countShiftSiangGigiUmum;

        // POLI GIGI PASIEN BPJS
        $totalPoliGigiPasienBPJS = $countShiftPagiGigiBPJS + $countShiftSiangGigiBpjs;

        return view('perawat.rekap.index', compact(
            'countShiftPagiUmumBPJS',
            'countShiftPagiUmumUmum',
            'countShiftPagiGigiBPJS',
            'countShiftPagiGigiUmum',
            'countShiftSiangUmumBPJS',
            'countShiftSiangUmumUmum',
            'countShiftSiangGigiBpjs',
            'countShiftSiangGigiUmum',
            'totalPoliUmumPasienUmum',
            'totalPoliUmumPasienBPJS',
            'totalPoliGigiPasienUmum',
            'totalPoliGigiPasienBPJS',
            'pasien',
            'entries',
            'search'
        ));
    }
}
