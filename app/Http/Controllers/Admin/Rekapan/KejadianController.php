<?php

namespace App\Http\Controllers\Admin\Rekapan;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class KejadianController extends Controller
{
    // PENYAKIT TIDAK MENULAR
    public function indexPtm()
    {
        return view('admin.rekapan.kejadian.ptm.index');
    }
    public function searchPtm(Request $request)
    {
        // Ambil tipe pencarian dan kriteria pencarian dari permintaan
        $type = $request->input('type');
        $searchData = $request->all();
        // Proses pencarian berdasarkan tipe dan kriteria pencarian
        if ($type === 'full_date') {
            $data = Obat::whereDate('created_at', $searchData['date'])->get();
        } elseif ($type === 'month_year') {
            $data = Obat::whereMonth('created_at', $searchData['month'])
                         ->whereYear('created_at', $searchData['year'])
                         ->get();
        } else {
            // Tampilkan pesan kesalahan jika tipe pencarian tidak valid
            return response()->json(['error' => 'Tipe pencarian tidak valid'], 400);
        }

        // Ubah format tanggal jika diperlukan
        $formattedData = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'tanggal' => date_format(date_create($item->created_at), 'H:i:s / d-m-Y'),
                'no_rm' => $item->booking->pasien->no_rm,
                'nama_pasien' => $item->booking->pasien->nama_pasien,
                'jenis_pasien' => $item->booking->pasien->jenis_pasien,
                'nama_poli' => $item->soap->poli->namapoli,
                // Tambahkan kolom lain sesuai kebutuhan
            ];
        });

        // Kirim data yang ditemukan sebagai respons
        return response()->json($formattedData);
    }
    public function cetakPtm(Request $request)
    {
        $type = $request->input('type');
        $searchData = $request->all();
        // dd($type);
        // Proses pencarian berdasarkan tipe dan kriteria pencarian
        if ($type === 'full_date') {
            $data = Obat::whereDate('created_at', $searchData['date'])->get();
            $hari = Carbon::createFromDate($searchData['date'])->translatedFormat('l, d/m/Y');
            $filterInfo = "Tanggal: " . $hari;
        } elseif ($type === 'month_year') {
            $data = Obat::whereMonth('created_at', $searchData['month'])
                         ->whereYear('created_at', $searchData['year'])
                         ->get();
            // Konversi nomor bulan menjadi nama bulan dalam bahasa Indonesia
            $monthName = Carbon::createFromFormat('m', $searchData['month'])->monthName;
            $filterInfo = "Bulan: " . $monthName . " " . $searchData['year'];
        } else {
            $data = Obat::all();
            $filterInfo = "Semua Data";
        }
        // Render view pencetakan ke dalam HTML
        $html = View::make('admin.rekapan.kejadian.ptm.cetak', compact('data', 'filterInfo'))->render();

        // Kembalikan respons berupa HTML
        return $html;
    }
}
