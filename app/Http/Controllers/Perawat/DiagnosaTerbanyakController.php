<?php

namespace App\Http\Controllers\Perawat;

use App\Exports\DiagnosaPerawatExport;
use App\Http\Controllers\Controller;
use App\Models\DiagnosaTerbanyak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class DiagnosaTerbanyakController extends Controller
{
    public function indexdiagnosa(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $search = $request->query('search');
        $entries = $request->query('entries', 10); // Default 10, opsi: 10, 25, 50, 100

        // Validasi entries
        $validEntries = [10, 25, 50, 100];
        $entries = in_array($entries, $validEntries) ? $entries : 10;

        // Inisialisasi query
        $query = DiagnosaTerbanyak::with('diagno')->orderBy('id', 'asc');

        // Filter berdasarkan rentang tanggal
        if ($startDate && $endDate) {
            try {
                $start = Carbon::parse($startDate)->startOfDay();
                $end = Carbon::parse($endDate)->endOfDay();
                if ($start->gt($end)) {
                    [$start, $end] = [$end, $start];
                }
                $query->whereBetween('created_at', [$start, $end]);
            } catch (\Exception $e) {
                Log::warning('Format tanggal tidak valid: ' . $e->getMessage(), [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);
                return redirect()->back()->with('error', 'Format tanggal tidak valid.');
            }
        }

        // Filter pencarian
        if ($search) {
            $query->whereHas('diagno', function ($q) use ($search) {
                $q->where('nm_diagno', 'LIKE', "%{$search}%")
                    ->orWhere('kd_diagno', 'LIKE', "%{$search}%");
            });
        }

        // Ambil data dan kelompokkan
        $allDiagnoses = $query->get();
        $groupedDiagnoses = [];

        foreach ($allDiagnoses as $diagnosis) {
            $id = $diagnosis->id_diagnosa;
            $nm_diagno = $diagnosis->diagno ? $diagnosis->diagno->nm_diagno : 'Tidak Ditemukan';
            $gender = $diagnosis->gender;
            $created_at = $diagnosis->created_at;

            if (!isset($groupedDiagnoses[$id])) {
                $groupedDiagnoses[$id] = [
                    'diagnosa' => $nm_diagno,
                    'laki_laki' => 0,
                    'perempuan' => 0,
                    'jumlah' => 0,
                    'created_at' => $created_at, // Simpan created_at terbaru
                ];
            } else {
                // Update created_at jika lebih baru
                if (Carbon::parse($created_at)->gt(Carbon::parse($groupedDiagnoses[$id]['created_at']))) {
                    $groupedDiagnoses[$id]['created_at'] = $created_at;
                }
            }

            if ($gender == 'L') {
                $groupedDiagnoses[$id]['laki_laki'] += 1;
            } else {
                $groupedDiagnoses[$id]['perempuan'] += 1;
            }

            $groupedDiagnoses[$id]['jumlah'] += 1;
        }

        // Urutkan berdasarkan jumlah kasus
        usort($groupedDiagnoses, function ($a, $b) {
            return $b['jumlah'] <=> $a['jumlah'];
        });

        // Terapkan paginasi pada array yang sudah dikelompokkan
        $perPage = $entries;
        $page = $request->query('page', 1);
        $total = count($groupedDiagnoses);
        $groupedDiagnoses = array_slice($groupedDiagnoses, ($page - 1) * $perPage, $perPage);
        $groupedDiagnoses = new \Illuminate\Pagination\LengthAwarePaginator(
            $groupedDiagnoses,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Log data untuk debugging
        Log::info('Data Diagnosa untuk tampilan', [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'search' => $search,
            'entries' => $entries,
            'total_diagnoses' => $total,
        ]);

        return view('perawat.rekap.diagnosa', compact('groupedDiagnoses', 'startDate', 'endDate', 'search', 'entries'));
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $search = $request->query('search');

        $query = DiagnosaTerbanyak::with('diagno')->orderBy('id', 'asc');

        if ($startDate && $endDate) {
            try {
                $start = Carbon::parse($startDate)->startOfDay();
                $end = Carbon::parse($endDate)->endOfDay();
                if ($start->gt($end)) {
                    [$start, $end] = [$end, $start];
                }
                $query->whereBetween('created_at', [$start, $end]);
            } catch (\Exception $e) {
                Log::warning('Format tanggal tidak valid: ' . $e->getMessage(), [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);
                return redirect()->back()->with('error', 'Format tanggal tidak valid.');
            }
        }

        if ($search) {
            $query->whereHas('diagno', function ($q) use ($search) {
                $q->where('nm_diagno', 'LIKE', "%{$search}%")
                    ->orWhere('kd_diagno', 'LIKE', "%{$search}%");
            });
        }

        $allDiagnoses = $query->get();
        $groupedDiagnoses = [];
        foreach ($allDiagnoses as $diagnosis) {
            $id = $diagnosis->id_diagnosa;
            $nm_diagno = $diagnosis->diagno ? $diagnosis->diagno->nm_diagno : 'Tidak Ditemukan';
            $gender = $diagnosis->gender;
            $createdAt = $diagnosis->created_at; // Ambil created_at dari data asli

            if (!isset($groupedDiagnoses[$id])) {
                $groupedDiagnoses[$id] = [
                    'diagnosa' => $nm_diagno,
                    'laki_laki' => 0,
                    'perempuan' => 0,
                    'jumlah' => 0,
                    'created_at' => $createdAt, // Simpan created_at pertama
                ];
            }

            if ($gender == 'L') {
                $groupedDiagnoses[$id]['laki_laki'] += 1;
            } else {
                $groupedDiagnoses[$id]['perempuan'] += 1;
            }

            $groupedDiagnoses[$id]['jumlah'] += 1;
        }

        usort($groupedDiagnoses, function ($a, $b) {
            return $b['jumlah'] <=> $a['jumlah'];
        });

        Log::info('Mengekspor data Diagnosa', [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'search' => $search,
            'total_diagnoses' => count($groupedDiagnoses),
        ]);

        if (empty($groupedDiagnoses)) {
            Log::warning('Tidak ada data untuk diekspor');
            return redirect()->back()->with('error', 'Tidak ada data yang ditemukan untuk rentang tanggal tersebut.');
        }

        return Excel::download(
            new DiagnosaPerawatExport($groupedDiagnoses),
            'diagnosaterbanyak_' . ($startDate ? Carbon::parse($startDate)->format('Ymd') : Carbon::now()->format('Ymd')) . '_' . ($endDate ? Carbon::parse($endDate)->format('Ymd') : Carbon::now()->format('Ymd')) . '.xlsx'
        );
    }
}
