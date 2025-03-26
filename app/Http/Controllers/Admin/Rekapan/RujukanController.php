<?php

namespace App\Http\Controllers\Admin\Rekapan;

use App\Http\Controllers\Controller;
use App\Models\Soap;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class RujukanController extends Controller
{
    public function indexRujukan()
    {
        $rujukan = Soap::with('pasien', 'poli', 'rm', 'isian')->where('id_poli', 1)->orderBy('id', 'desc')->get();
        // dd($rujukan);
        return view('admin.rekapan.rujukan.index', compact('rujukan'));
    }
    public function searchRujukan(Request $request)
    {
        // Ambil tipe pencarian dan kriteria pencarian dari permintaan
        $type = $request->input('type');
        $searchData = $request->all();
        // Proses pencarian berdasarkan tipe dan kriteria pencarian
        if ($type === 'full_date') {
            $data = Soap::with('pasien', 'poli', 'rm', 'isian')->where('id_poli', 1)->whereDate('created_at', $searchData['date'])->get();
            // dd($data);
        } elseif ($type === 'month_year') {
            $data = Soap::with('pasien', 'poli', 'rm', 'isian')->where('id_poli', 1)->whereMonth('created_at', $searchData['month'])
                         ->whereYear('created_at', $searchData['year'])
                         ->get();
        } else {
            // Tampilkan pesan kesalahan jika tipe pencarian tidak valid
            return response()->json(['error' => 'Tipe pencarian tidak valid'], 400);
        }

        // Ubah format tanggal jika diperlukan
        $formattedData = $data->map(function ($item) {
            if ($item->pasien->jenis_pasien == 'Bpjs') {
                return [
                    'id' => $item->id,
                    'tanggal' => date_format(date_create($item->created_at), 'd/m/Y'),
                    'jam' => date_format(date_create($item->created_at), 'H:i:s'),
                    'nama_pasien' => $item->pasien->nama_pasien,
                    'nomor_bpjs' => $item->pasien->bpjs,
                    'jenis_kelamin' => $item->pasien->jenis_kelamin,
                    'nik' => $item->pasien->nik,
                    'nama_kk' => $item->pasien->nama_kk,
                    'keluhan_utama' => $item->keluhan_utama,
                    'rujuk' => $item->rujuk,
                    // Tambahkan kolom lain sesuai kebutuhan
                ];
            }
        });
        // dd($formattedData);
        // Kirim data yang ditemukan sebagai respons
        return response()->json($formattedData);
    }
    public function cetakRujukan(Request $request)
    {
        $type = $request->input('type');
        $searchData = $request->all();
        // dd($type);
        // Proses pencarian berdasarkan tipe dan kriteria pencarian
        if ($type === 'full_date') {
            $data = Soap::with(['pasien', 'poli', 'rm', 'isian'])->where('id_poli', 1)->whereDate('created_at', $searchData['date'])->get();
            $hari = Carbon::createFromDate($searchData['date'])->translatedFormat('l, d/m/Y');
            $filterInfo = "Tanggal: " . $hari;
        } elseif ($type === 'month_year') {
            $data = Soap::with(['pasien', 'poli', 'rm', 'isian'])->where('id_poli', 1)->whereMonth('created_at', $searchData['month'])
                         ->whereYear('created_at', $searchData['year'])
                         ->get();
            // Konversi nomor bulan menjadi nama bulan dalam bahasa Indonesia
            $monthName = Carbon::createFromFormat('m', $searchData['month'])->monthName;
            $filterInfo = "BULAN: " . $monthName . " " . $searchData['year'];
        } else {
            $data = Soap::with(['pasien', 'poli', 'rm', 'isian'])->where('id_poli', 1)->get();
            $filterInfo = "SEMUA DATA";
        }

        foreach ($data as $item) {
            $item->soap_a_primer = json_decode($item->soap_a_primer, true)[0];
            $item->soap_a_sekunder = json_decode($item->soap_a_sekunder, true)[0];
        }
        // dd($data);
        // Render view pencetakan ke dalam HTML
        $html = View::make('admin.rekapan.rujukan.cetak', compact('data', 'filterInfo'))->render();

        // Kembalikan respons berupa HTML
        return $html;
    }
}
