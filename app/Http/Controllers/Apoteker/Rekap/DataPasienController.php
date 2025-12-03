<?php

namespace App\Http\Controllers\Apoteker\Rekap;

use App\Http\Controllers\Controller;
use App\Models\AntrianPerawat;
use App\Models\TtdMedis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataPasienController extends Controller
{
    public function periksa(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'poli'])
            ->where('status', 'S')
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
        $pasienObat = $query->paginate($entries, ['*'], 'page', $page);
        $pasienObat->appends([
            'search' => $search,
            'entries' => $entries,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        $ttd = TtdMedis::all();

        // dd($pasienObat);

        // Group berdasarkan nama poli

        return view('obat.rekap-pasien', compact(
            'pasienObat',
            'ttd',
            // 'groupedAntrian',
            'entries',
            'search',
            'startDate',
            'endDate'
        ));
    }
}
