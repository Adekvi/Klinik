<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Exports\KasirExport;
use App\Exports\RekapKasirExport;
use App\Http\Controllers\Controller;
use App\Models\Kasir;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class BerandaKasirController extends Controller
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

    public function check(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10); // Default 10
        $page = $request->input('page', 1);
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = Kasir::with(['booking.pasien', 'resep', 'poli', 'soap'])
            ->where('status', 'T')
            ->orderBy('id', 'asc');

        // Filter berdasarkan rentang tanggal
        if ($start_date && $end_date) {
            try {
                $start = Carbon::parse($start_date)->startOfDay();
                $end = Carbon::parse($end_date)->endOfDay();
                if ($start->gt($end)) {
                    // Jika start_date lebih besar dari end_date, tukar nilai
                    [$start, $end] = [$end, $start];
                }
                $query->whereBetween('created_at', [$start, $end]);
            } catch (\Exception $e) {
                // Jika format tanggal salah, fallback ke hari ini
                Log::warning('Invalid date format in Kasir check: ' . $e->getMessage());
                $query->whereDate('created_at', Carbon::today());
            }
        }
        // else {
        //     // Fallback ke hari ini jika tidak ada rentang tanggal
        //     $query->whereDate('created_at', Carbon::today());
        // }

        // Filter pencarian berdasarkan nama atau no_rm
        if ($search) {
            $query->whereHas('booking.pasien', function ($q) use ($search) {
                $q->where('nama_pasien', 'LIKE', "%{$search}%")
                    ->orWhere('no_rm', 'LIKE', "%{$search}%")
                    ->orWhere('no_transaksi', 'LIKE', "%{$search}%");
            });
        }

        // Paginasi dengan jumlah entri yang dipilih
        $antrianKasir = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);

        // Menjaga parameter pencarian dan filter tetap ada saat navigasi halaman
        $antrianKasir->appends([
            'search' => $search,
            'entries' => $entries,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        // dd($antrianKasir);

        Log::info('Kasir check data retrieved', [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'search' => $search,
            'total_records' => $antrianKasir->total(),
        ]);

        return view('kasir.check.index', compact(
            'antrianKasir',
            'search',
            'entries',
            'start_date',
            'end_date'
        ));
    }

    public function exportExcel(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $search = $request->input('search');

        $query = Kasir::with(['booking.pasien', 'resep', 'poli', 'soap'])
            ->where('status', 'T')
            ->orderBy('id', 'asc');

        // Filter berdasarkan rentang tanggal
        if ($start_date && $end_date) {
            try {
                $start = Carbon::parse($start_date)->startOfDay();
                $end = Carbon::parse($end_date)->endOfDay();
                if ($start->gt($end)) {
                    [$start, $end] = [$end, $start];
                }
                $query->whereBetween('created_at', [$start, $end]);
            } catch (\Exception $e) {
                Log::warning('Invalid date format in Kasir export: ' . $e->getMessage(), [
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ]);
                $query->whereDate('created_at', Carbon::today());
            }
        }
        //  else {
        //     $query->whereDate('created_at', Carbon::today());
        // }

        // Filter pencarian
        if ($search) {
            $query->whereHas('booking.pasien', function ($q) use ($search) {
                $q->where('nama_pasien', 'LIKE', "%{$search}%")
                    ->orWhere('no_rm', 'LIKE', "%{$search}%");
            });
        }

        $data = $query->get();

        // Log data untuk debugging
        Log::info('Kasir export data retrieved', [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'search' => $search,
            'total_records' => $data->count(),
            'sample_data' => $data->take(2)->toArray(), // Ambil 2 data untuk contoh
        ]);

        if ($data->isEmpty()) {
            Log::warning('No data found for Kasir export with given filters');
            return redirect()->back()->with('error', 'Tidak ada data yang ditemukan untuk rentang tanggal tersebut.');
        }

        return Excel::download(new KasirExport($data), 'kasir_report_' . Carbon::now()->format('Ymd_His') . '.xlsx');
    }
}
