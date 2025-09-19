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

        $antrianDokter = $query->paginate($entries, ['*'], 'page', $page);
        $antrianDokter->appends(['search' => $search, 'entries' => $entries]);

        $ttd = TtdMedis::where('status', true)->get();
        // dd($ttd);

        // dd($antrianDokter);

        // Group by Poli
        $groupedAntrian = $antrianDokter->groupBy('poli.namapoli');

        // dd($groupedAntrian);

        return view('dokter.index', compact('antrianDokter', 'ttd', 'groupedAntrian', 'entries', 'search'));
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
            ->select('id', 'aturan_minum as text') // Sesuaikan dengan kolom yang diinginkan
            ->take(10)
            ->get();

        return response()->json($results);
    }

    public function anjuran(Request $request)
    {
        $term = $request->input('term');

        $results = Anjuran::where('kode_anjuran', 'LIKE', '%' . $term . '%')
            ->orWhere('golongan', 'LIKE', '%' . $term . '%')
            ->select('id', 'kode_anjuran as text') // Sesuaikan dengan kolom yang diinginkan
            ->take(10)
            ->get();

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

    // Controller Antrian Dokter
    public function panggilAntrian(Request $request)
    {
        // Dapatkan nomor antrian dari $request->nomor_antrian
        $nomorAntrian = $request->nomor_antrian;

        // Simpan nomor antrian ke dalam sesi atau database sesuai kebutuhan
        session(['nomor_antrian_dokter' => $nomorAntrian]);

        // Render tampilan antrian.blade.php dan kirimkan sebagai respon Ajax

        // $view = View::make('antrian.antrian', compact('nomorAntrian'))->render();

        return response()->json(['nomorAntrian' => $nomorAntrian]);
    }
}
