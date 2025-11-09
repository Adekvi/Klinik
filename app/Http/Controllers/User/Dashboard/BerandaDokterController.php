<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AntrianPerawat;
use App\Models\TtdMedis;
use Carbon\Carbon;
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

    public function periksa(Request $request)
    {
        $auth = Auth::user()->id_dokter;

        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli'])
            ->where('status', 'P')
            ->where('id_dokter', $auth)
            ->orderBy('urutan', 'asc')
            ->orderBy('updated_at', 'asc');

        // 🔍 Filter berdasarkan nama atau nomor RM pasien
        if ($search) {
            $query->whereHas('booking.pasien', function ($q) use ($search) {
                $q->where('nama_pasien', 'LIKE', "%{$search}%")
                ->orWhere('no_rm', 'LIKE', "%{$search}%");
            });
        }

        // 📅 Filter berdasarkan rentang tanggal (gunakan created_at)
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Pagination
        $antrianDokter = $query->paginate($entries, ['*'], 'page', $page);
        $antrianDokter->appends([
            'search' => $search,
            'entries' => $entries,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        $ttd = TtdMedis::all();

        // Group berdasarkan nama poli
        // $groupedAntrian = $antrianDokter->groupBy('poli.namapoli');

        return view('dokter.periksa', compact(
            'antrianDokter',
            'ttd',
            // 'groupedAntrian',
            'entries',
            'search',
            'startDate',
            'endDate'
        ));
    }

}
