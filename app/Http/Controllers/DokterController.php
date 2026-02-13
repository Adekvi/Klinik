<?php

namespace App\Http\Controllers;

use App\Models\Anjuran;
use App\Models\AntrianDokter;
use App\Models\AntrianPerawat;
use App\Models\Aturan;
use App\Models\Booking;
use App\Models\DataDokter;
use App\Models\Diagnosa;
use App\Models\Fisik;
use App\Models\IsianPerawat;
use App\Models\Jenisobat;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Resep;
use App\Models\RmDa1;
use App\Models\Soap;
use App\Models\TtdMedis;
use App\Models\Video;
use Carbon\Carbon;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        // $anamnesis = RmDa1::with(['pasien', 'booking', 'poli', 'isian'])->get()->toArray();
        $auth = Auth::user()->id_dokter;

        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = AntrianPerawat::with(['booking.pasien', 'isian', 'rm.ttd', 'poli'])
            ->where('status', 'M')
            ->where('id_dokter', $auth)
            ->orderBy('urutan', 'asc')
            ->orderBy('updated_at', 'asc');

        if ($search) {
            $query->whereHas('booking.pasien', function ($q) use ($search) {
                $q->where('nama_pasien', 'LIKE', "%{$search}%")
                    ->orWhere('no_rm', 'LIKE', "%{$search}%");
            });
        }

        /** @var \Illuminate\Pagination\LengthAwarePaginator $antrianDokter */
        $antrianDokter = $query->paginate($entries, ['*'], 'page', $page);
        $antrianDokter->appends(['search' => $search, 'entries' => $entries]);

        $ttd = TtdMedis::where('status', true)->get();

        // dd($antrianDokter);

        // Jumlah pasien
        $today = Carbon::today();

        // PASIEN DILAYANI & BELUM
        $umumDilayani = AntrianPerawat::where('status', 'P')
            ->where('id_poli', 1)
            ->whereDate('created_at', $today)
            ->count();

        $umumBelumDilayani = AntrianPerawat::where('status', 'M')
            ->where('id_poli', 1)
            ->whereDate('created_at', $today)
            ->count();

        // Poli Gigi
        $gigiDilayani = AntrianPerawat::where('status', 'P')
            ->where('id_poli', 2)
            ->whereDate('created_at', $today)
            ->count();

        $gigiBelumDilayani = AntrianPerawat::where('status', 'M')
            ->where('id_poli', 2)
            ->whereDate('created_at', $today)
            ->count();

        // SHIFT PAGI POLI UMUM
        // PASIEN BPJS
        $countShiftPagiUmumBPJS = AntrianPerawat::where('id_poli', 1)
            ->where('status', 'P')
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
            ->where('status', 'P')
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
            ->where('status', 'P')
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
            ->where('status', 'P')
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
            ->where('status', 'P')
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
            ->where('status', 'P')
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
            ->where('status', 'P')
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
            ->where('status', 'P')
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

        $groupedAntrian = $antrianDokter->groupBy('poli.namapoli');

        // dd(vars: $antrianDokter);

        return view('dokter.index', compact(
            'antrianDokter',
            'ttd',
            'groupedAntrian',
            'entries',
            'search',
            'umumDilayani',
            'umumBelumDilayani',
            'gigiDilayani',
            'gigiBelumDilayani',
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
        ));
    }

    public function lewatiAntrianDokter($id)
    {
        $antrian = AntrianPerawat::find($id);
        if ($antrian) {
            $urutan = $antrian->urutan;
            $urutanBaru = $urutan + 5;

            // Perbarui nomor antrian yang dilewati dan nomor antrian lainnya
            AntrianPerawat::where('urutan', '>=', $urutanBaru)
                ->where('status', 'M')
                ->orderBy('urutan', 'asc')
                ->update(['urutan' => DB::raw('urutan + 1')]);

            // Perbarui nomor antrian yang dilewati dengan urutan baru
            $antrian->urutan = $urutanBaru;
            $antrian->save();
        }

        return redirect()->route('dokter.index');
    }

    // Fungsi pencarian Diagnosa
    public function searchDiagnosa(Request $request)
    {
        $term = $request->input('term');

        $results = Diagnosa::where('kd_diagno', 'LIKE', '%' . $term . '%')
            ->orWhere('nm_diagno', 'LIKE', '%' . $term . '%')
            ->select('id', 'nm_diagno', 'kd_diagno')
            ->take(5) // Batasi hasil pencarian
            ->get();

        $formattedResults = [];

        foreach ($results as $result) {
            $formattedResults[] = [
                'id' => $result->id,
                'text' => $result->kd_diagno . ' - ' . $result->nm_diagno // Gabungkan kode dan nama diagnosa
            ];
        }

        return response()->json($formattedResults);
    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('term');

        $results = Resep::where('nama_obat', 'LIKE', '%' . $term . '%')
            ->select('id', 'nama_obat as text') // Sesuaikan dengan kolom yang diinginkan
            ->take(10)
            ->get();

        return response()->json($results);
    }

    public function jenisobat(Request $request)
    {
        $term = $request->input('term');

        $results = Jenisobat::where('jenis', 'LIKE', '%' . $term . '%')
            ->where('status', 'Aktif')
            ->select('id', 'jenis as text') // Sesuaikan dengan kolom yang diinginkan
            ->take(10)
            ->get();

        return response()->json($results);
    }

    public function aturan(Request $request)
    {
        $term = $request->input('term');

        $results = Aturan::where('aturan_minum', 'LIKE', '%' . $term . '%')
            ->orWhere('takaran', 'LIKE', '%' . $term . '%')
            ->select('id', 'aturan_minum', 'takaran')
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => strtoupper($item->takaran) . ' - ' . $item->aturan_minum,
                ];
            });

        return response()->json($results);
    }

    public function anjuran(Request $request)
    {
        $term = $request->input('term');

        $results = Anjuran::where('kode_anjuran', 'LIKE', '%' . $term . '%')
            ->orWhere('golongan', 'LIKE', '%' . $term . '%')
            ->select('id', 'kode_anjuran', 'golongan')
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->kode_anjuran . ' - ' . $item->golongan,
                ];
            });

        return response()->json($results);
    }

    public function daftarAntrian()
    {
        $today = Carbon::today();
        // Mengambil data antrian dengan relasi yang diperlukan
        $pasien = AntrianPerawat::with(['booking.pasien', 'poli'])->whereDate('created_at', $today)->get();

        // Inisialisasi array untuk menampung tanggal dan waktu
        $date = [];
        $time = [];

        // Loop melalui setiap antrian untuk mengumpulkan tanggal dan waktu
        foreach ($pasien as $item) {
            // Tambahkan tanggal dan waktu ke dalam array
            $date[] = Carbon::parse($item->created_at)->translatedFormat('l, j F Y');
            $time[] = Carbon::parse($item->created_at)->translatedFormat('H:i:s');
        }

        // Kembalikan view dengan data yang diperlukan
        return view('antrian.daftar', compact('pasien', 'date', 'time'));
    }

    public function panggilAntrian(Request $request)
    {
        $poli = $request->poli; // contoh: 'umum' atau 'gigi'
        $today = Carbon::today();

        // Ambil antrian pertama berdasarkan status terendah ('D' atau 'M')
        $next = AntrianPerawat::whereHas('poli', function ($q) use ($poli) {
                $q->whereRaw('LOWER(namapoli) = ?', [strtolower($poli)]);
            })
            ->whereDate('created_at', $today)
            ->whereIn('status', ['D', 'M', 'P', 'B', 'K'])
            ->orderByRaw("
                FIELD(status, 'D', 'M', 'P', 'B', 'K', 'WS'),
                kode_antrian ASC
            ")
            ->first();

        if (!$next) {
            return response()->json(['success' => false, 'message' => 'Tidak ada antrian berikutnya']);
        }

        // Tentukan status berikutnya
        $statusLama = $next->status;
        $statusBaru = match ($statusLama) {
            'D' => 'M',
            'M' => 'P',
            'P' => 'B',
            'B' => 'K',
            'K' => 'WS',
            default => $statusLama
        };

        // Update status di database
        // $next->update(['status' => $statusBaru]);

        return response()->json([
            'success' => true,
            'nomor' => $next->kode_antrian,
            'poli' => $poli,
            'status_sebelumnya' => $statusLama,
            'status_baru' => $statusBaru,
            'pasien' => $next->booking->pasien->nama_pasien,
        ]);
    }

    // public function panggilAntrian(Request $request)
    // {
    //     $poli = $request->poli; // contoh: 'umum' atau 'gigi'
    //     $today = Carbon::today();

    //     // Ambil antrian pertama dengan status 'M' (Menunggu)
    //     $next = AntrianPerawat::whereHas('poli', function ($q) use ($poli) {
    //             $q->whereRaw('LOWER(namapoli) = ?', [strtolower($poli)]);
    //         })
    //         // ->whereDate('created_at', $today)
    //         ->where('status', 'M') // ✅ gunakan where, bukan whereIn
    //         ->orderBy('kode_antrian', 'asc')
    //         ->first();

    //     if (!$next) {
    //         return response()->json(['success' => false, 'message' => 'Tidak ada antrian berikutnya']);
    //     }

    //     // Update status menjadi 'P' (sedang diperiksa)
    //     // $next->update(['status' => 'P']);

    //     return response()->json([
    //         'success' => true,
    //         'nomor' => $next->kode_antrian,
    //         'poli' => $poli
    //     ]);
    // }

    // Controller Antrian Dokter
    // public function panggilAntrian(Request $request)
    // {
    //     // Dapatkan nomor antrian dari $request->nomor_antrian
    //     $nomorAntrian = $request->nomor_antrian;

    //     // Simpan nomor antrian ke dalam sesi atau database sesuai kebutuhan
    //     session(['nomor_antrian_dokter' => $nomorAntrian]);

    //     // Render tampilan antrian.blade.php dan kirimkan sebagai respon Ajax

    //     // $view = View::make('antrian.antrian', compact('nomorAntrian'))->render();

    //     return response()->json(['nomorAntrian' => $nomorAntrian]);
    // }
}
