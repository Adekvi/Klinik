<?php

namespace App\Http\Controllers\Admin\Rekapan;

use App\Http\Controllers\Controller;
use App\Models\Soap;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class KBController extends Controller
{
    
    public function indexKB()
    {
        $kb = Soap::with('pasien', 'poli', 'rm', 'isian')->where('id_poli', 1)->orderBy('id', 'desc')->get();
        // dd($umumBpjs);
        return view('admin.rekapan.kb.index', compact('kb'));

        dd($kb);
    }
    public function searchKB(Request $request)
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
                    'no_rm' => $item->pasien->no_rm,
                    'nama_pasien' => $item->pasien->nama_pasien,
                    'jenis_pasien' => $item->pasien->jenis_pasien,
                    'tgllahir' => $item->pasien->tgllahir,
                    'nomor_bpjs' => $item->pasien->bpjs,
                    'nik' => $item->pasien->nik,
                    'noHP' => $item->pasien->noHP,
                    'pekerjaan' => $item->pasien->pekerjaan,
                    'nama_kk' => $item->pasien->nama_kk,
                    'alamat_asal' => $item->pasien->alamat_asal,
                    'keluhan_utama' => $item->keluhan_utama,
                    'p_tensi' => $item->p_tensi,
                    'p_nadi' => $item->p_nadi,
                    'p_rr' => $item->p_rr,
                    'p_suhu' => $item->p_suhu,
                    'spo2' => $item->spo2,
                    'p_bb' => $item->p_bb,
                    'p_tb' => $item->p_tb,
                    'soap_a_primer' => $item->soap_a_primer,
                    'soap_p' => $item->soap_p,
                    'rujuk' => $item->rujuk,
                    // Tambahkan kolom lain sesuai kebutuhan
                ];
            }
        });
        // dd($formattedData);
        // Kirim data yang ditemukan sebagai respons
        return response()->json($formattedData);
    }
    public function cetakKB(Request $request)
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
            $filterInfo = "Bulan: " . $monthName . " " . $searchData['year'];
        } else {
            $data = Soap::with(['pasien', 'poli', 'rm', 'isian'])->where('id_poli', 1)->get();
            $filterInfo = "Semua Data";
        }
        // dd($data. $filterInfo);
        // Render view pencetakan ke dalam HTML
        $html = View::make('admin.rekapan.kb.cetak', compact('data', 'filterInfo'))->render();

        // Kembalikan respons berupa HTML
        return $html;
    }
}
