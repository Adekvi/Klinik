<?php

namespace App\Http\Controllers\Perawat\Laporan\PoliGigi;

use App\Exports\RekapPasienGigiUmumExport;
use App\Http\Controllers\Controller;
use App\Models\Diagnosa;
use App\Models\Soap;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class GigiUmumController extends Controller
{
    public function poliGigiPasienUmum(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);
        $filterOption = $request->input('filter_option');
        $tanggal = $request->input('tanggal');
        $month = $request->input('month', ''); // Default ke string kosong jika tidak ada
        $tahun = $request->input('tahun', '');

        // Validasi $month sebagai angka 1-12
        $month = in_array($month, range(1, 12)) ? $month : '';

        $query = Soap::with('pasien', 'poli', 'rm', 'isian', 'obat')
            ->where('id_poli', 2)
            ->whereHas('pasien', function ($q) {
                $q->where('jenis_pasien', 'Umum');
            })
            ->orderBy('id', 'desc');

        // Tambahkan filter berdasarkan opsi yang dipilih
        if ($filterOption) {
            if ($filterOption === 'full_date' && $tanggal) {
                $date = Carbon::parse($tanggal)->startOfDay();
                $query->whereDate('created_at', $date);
            } elseif ($filterOption === 'month_year' && $month && $tahun) {
                $query->whereYear('created_at', $tahun)
                    ->whereMonth('created_at', $month);
            }
        }

        if ($search) {
            $query->whereHas('pasien', function ($q) use ($search) {
                $q->where('nama_pasien', 'LIKE', "%{$search}%")
                    ->orWhere('no_rm', 'LIKE', "%{$search}%");
            });
        }

        $gigiUmum = $query->paginate($entries, ['*'], 'page', $page);
        $gigiUmum->appends([
            'search' => $search,
            'entries' => $entries,
            'filter_option' => $filterOption,
            'tanggal' => $tanggal,
            'month' => $month,
            'tahun' => $tahun
        ]);

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        // Transformasi data untuk menambahkan diagnosa
        $gigiUmum->getCollection()->transform(function ($item) {
            $kdDiagnosa = [];
            $nmDiagnosa = [];

            // Proses diagnosa dari soap_a_primer
            try {
                $primer = json_decode($item->soap_a_primer, true);
                if (is_array($primer) && !empty($primer)) {
                    foreach ($primer as $value) {
                        $value = trim($value);
                        $diagnosa = Diagnosa::where('nm_diagno', 'LIKE', "%{$value}%")->first();
                        if ($diagnosa) {
                            $kdDiagnosa[] = $diagnosa->kd_diagno;
                            $nmDiagnosa[] = $diagnosa->nm_diagno;
                        } else {
                            Log::warning("Diagnosa primer tidak ditemukan: {$value}");
                            $kdDiagnosa[] = 'Tidak Ditemukan';
                            $nmDiagnosa[] = $value;
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error("Gagal parse soap_a_primer: {$item->soap_a_primer}", ['error' => $e->getMessage()]);
            }

            // Proses diagnosa dari soap_a_sekunder
            try {
                $sekunder = json_decode($item->soap_a_sekunder, true);
                if (is_array($sekunder) && !empty($sekunder)) {
                    foreach ($sekunder as $value) {
                        $value = trim($value);
                        $diagnosa = Diagnosa::where('nm_diagno', 'LIKE', "%{$value}%")->first();
                        if ($diagnosa) {
                            $kdDiagnosa[] = $diagnosa->kd_diagno;
                            $nmDiagnosa[] = $diagnosa->nm_diagno;
                        } else {
                            Log::warning("Diagnosa sekunder tidak ditemukan: {$value}");
                            $kdDiagnosa[] = 'Tidak Ditemukan';
                            $nmDiagnosa[] = $value;
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error("Gagal parse soap_a_sekunder: {$item->soap_a_sekunder}", ['error' => $e->getMessage()]);
            }

            $item->kd_diagno = !empty($kdDiagnosa) ? implode(', ', $kdDiagnosa) : 'Tidak ada diagnosa';
            $item->nm_diagno = !empty($nmDiagnosa) ? implode(', ', $nmDiagnosa) : 'Tidak ada diagnosa';

            return $item;
        });

        $gigiUmum->getCollection()->transform(function ($item) {
            $totalSemuaHarga = $item->obat->isNotEmpty()
                ? $item->obat->sum(function ($obat) {
                    $value = str_replace('.', '', $obat->totalSemuaHarga); // Hapus titik sebagai pemisah ribuan
                    return floatval($value); // Konversi ke angka (misalnya, "11400" dari "11.400")
                })
                : 0;
            $item->total_semua_harga = $totalSemuaHarga;
            return $item;
        });

        // dd($gigiUmum);

        // Log untuk debugging
        Log::info('Paginasi Data BPJS', [
            'total' => $gigiUmum->total(),
            'per_page' => $gigiUmum->perPage(),
            'current_page' => $gigiUmum->currentPage(),
            'search' => $search,
            'filter_option' => $filterOption,
            'tanggal' => $tanggal,
            'month' => $month,
            'tahun' => $tahun,
        ]);

        return view('perawat.laporan.poliGigi.umum.pasienUmum', compact('gigiUmum', 'search', 'entries', 'filterOption', 'tanggal', 'month', 'tahun', 'months'));
    }

    public function exportExcelPoliGigiUmum(Request $request)
    {
        $search = $request->input('search');
        $filterOption = $request->input('filter_option');
        $tanggal = $request->input('tanggal');
        $month = $request->input('month', ''); // Default ke string kosong jika tidak ada
        $tahun = $request->input('tahun', '');

        // Validasi $month sebagai angka 1-12
        $month = in_array($month, range(1, 12)) ? $month : '';

        return Excel::download(
            new RekapPasienGigiUmumExport($search, $filterOption, $tanggal, $month, $tahun),
            'pasien_umum_poli_gigi_' . now()->format('Ymd_His') . '.xlsx'
        );
    }
}
