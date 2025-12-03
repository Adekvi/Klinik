<?php

namespace App\Http\Controllers\Admin\Rekapan;

use App\Exports\RekapPasienBpjsExport;
use App\Exports\RekapPasienGigiBpjsExport;
use App\Exports\RekapPasienGigiUmumExport;
use App\Exports\RekapPasienUmumExport;
use App\Http\Controllers\Controller;
use App\Models\Soap;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class RekapPasienController extends Controller
{
    // POLI UMUM PASIEN BPJS
    public function indexBpjs()
    {
        $umumBpjs = Soap::with('pasien', 'poli', 'rm', 'isian')->where('id_poli', 2)->orderBy('id', 'desc')->get();
        // dd($umumBpjs);
        return view('admin.rekapan.pasien-bpjs.index', compact('umumBpjs'));
    }

    public function searchBpjs(Request $request)
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

    public function cetakBpjs(Request $request)
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

        // Mendapatkan nama diagnosa primer tanpa tanda []
        foreach ($data as $item) {
            $item->soap_a_primer = json_decode($item->soap_a_primer, true)[0];
            $item->soap_a_sekunder = json_decode($item->soap_a_sekunder, true)[0];
        }

        // dd($data. $filterInfo);
        // Render view pencetakan ke dalam HTML
        $html = View::make('admin.rekapan.pasien-bpjs.cetak', compact('data', 'filterInfo'))->render();

        // Kembalikan respons berupa HTML
        return $html;
    }

    public function exportExcelBpjs()
    {
        return Excel::download(new RekapPasienBpjsExport(), 'umum-pasien-bpjs.xlsx');
    }

    // POLI UMUM PASIEN UMUM
    public function indexUmum()
    {
        $umumUmum = Soap::with('pasien', 'poli', 'rm', 'isian')->where('id_poli', 1)->orderBy('id', 'desc')->get();
        return view('admin.rekapan.pasien-umum.index', compact('umumUmum'));
    }

    public function searchUmum(Request $request)
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
            if ($item->pasien->jenis_pasien == 'Umum') {
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

    public function cetakUmum(Request $request)
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

        // // Mendapatkan nama diagnosa primer tanpa tanda []
        // foreach ($data as $item) {
        //     $item->soap_a_primer = json_decode($item->soap_a_primer, true)[0];
        //     $item->soap_a_sekunder = json_decode($item->soap_a_sekunder, true)[0];
        // }

        // dd($data. $filterInfo);
        // Render view pencetakan ke dalam HTML
        $html = View::make('admin.rekapan.pasien-bpjs.cetak', compact('data', 'filterInfo'))->render();

        // Kembalikan respons berupa HTML
        return $html;
    }

    public function exportExcelUmum()
    {
        return Excel::download(new RekapPasienUmumExport(), 'umum-pasien-umum.xlsx');
    }

    // POLI GIGI PASIEN BPJS
    public function indexGigiBpjs()
    {
        $gigiBpjs = Soap::with('pasien', 'poli', 'rm', 'isian')->where('id_poli', 2)->orderBy('id', 'asc')->get();
        // dd($gigiBpjs);
        return view('admin.rekapan.pasien-gigi.gigi-bpjs.index', compact('gigiBpjs'));
    }
    public function searchGigiBpjs(Request $request)
    {
        // Ambil tipe pencarian dan kriteria pencarian dari permintaan
        $type = $request->input('type');
        $searchData = $request->all();
        // Proses pencarian berdasarkan tipe dan kriteria pencarian
        if ($type === 'full_date') {
            $data = Soap::with('pasien', 'poli', 'rm', 'isian')->where('id_poli', 2)->whereDate('created_at', $searchData['date'])->get();
            // dd($data);
        } elseif ($type === 'month_year') {
            $data = Soap::with('pasien', 'poli', 'rm', 'isian')->where('id_poli', 2)->whereMonth('created_at', $searchData['month'])
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
    public function cetakGigiBpjs(Request $request)
    {
        $type = $request->input('type');
        $searchData = $request->all();
        // dd($type);
        // Proses pencarian berdasarkan tipe dan kriteria pencarian
        if ($type === 'full_date') {
            $data = Soap::with(['pasien', 'poli', 'rm', 'isian'])->where('id_poli', 2)->whereDate('created_at', $searchData['date'])->get();
            $hari = Carbon::createFromDate($searchData['date'])->translatedFormat('l, d/m/Y');
            $filterInfo = "Tanggal: " . $hari;
        } elseif ($type === 'month_year') {
            $data = Soap::with(['pasien', 'poli', 'rm', 'isian'])->where('id_poli', 2)->whereMonth('created_at', $searchData['month'])
                ->whereYear('created_at', $searchData['year'])
                ->get();
            // Konversi nomor bulan menjadi nama bulan dalam bahasa Indonesia
            $monthName = Carbon::createFromFormat('m', $searchData['month'])->monthName;
            $filterInfo = "Bulan: " . $monthName . " " . $searchData['year'];
        } else {
            $data = Soap::with(['pasien', 'poli', 'rm', 'isian'])->where('id_poli', 2)->get();
            $filterInfo = "Semua Data";
        }

        // Mendapatkan nama diagnosa primer tanpa tanda []
        foreach ($data as $item) {
            $item->soap_a_primer = json_decode($item->soap_a_primer, true)[0];
            $item->soap_a_sekunder = json_decode($item->soap_a_sekunder, true)[0];
        }

        // dd($data. $filterInfo);
        // Render view pencetakan ke dalam HTML
        $html = View::make('admin.rekapan.pasien-bpjs.cetak', compact('data', 'filterInfo'))->render();

        // Kembalikan respons berupa HTML
        return $html;
    }

    public function exportExcelGigiBpjs()
    {
        return Excel::download(new RekapPasienGigiBpjsExport(), 'gigi-pasien-bpjs.xlsx');
    }

    // POLI GIGI PASIEN UMUM
    public function indexGigiUmum()
    {
        $gigiUmum = Soap::with('pasien', 'poli', 'rm', 'isian')->where('id_poli', 2)->orderBy('id', 'asc')->get();
        return view('admin.rekapan.pasien-gigi.gigi-umum.index', compact('gigiUmum'));
    }
    public function searchGigiUmum(Request $request)
    {
        // Ambil tipe pencarian dan kriteria pencarian dari permintaan
        $type = $request->input('type');
        $searchData = $request->all();
        // Proses pencarian berdasarkan tipe dan kriteria pencarian
        if ($type === 'full_date') {
            $data = Soap::with('pasien', 'poli', 'rm', 'isian')->where('id_poli', 2)->whereDate('created_at', $searchData['date'])->get();
            // dd($data);
        } elseif ($type === 'month_year') {
            $data = Soap::with('pasien', 'poli', 'rm', 'isian')->where('id_poli', 2)->whereMonth('created_at', $searchData['month'])
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
    public function cetakGigiUmum(Request $request)
    {
        $type = $request->input('type');
        $searchData = $request->all();
        // dd($type);
        // Proses pencarian berdasarkan tipe dan kriteria pencarian
        if ($type === 'full_date') {
            $data = Soap::with(['pasien', 'poli', 'rm', 'isian'])->where('id_poli', 2)->whereDate('created_at', $searchData['date'])->get();
            $hari = Carbon::createFromDate($searchData['date'])->translatedFormat('l, d/m/Y');
            $filterInfo = "Tanggal: " . $hari;
        } elseif ($type === 'month_year') {
            $data = Soap::with(['pasien', 'poli', 'rm', 'isian'])->where('id_poli', 2)->whereMonth('created_at', $searchData['month'])
                ->whereYear('created_at', $searchData['year'])
                ->get();
            // Konversi nomor bulan menjadi nama bulan dalam bahasa Indonesia
            $monthName = Carbon::createFromFormat('m', $searchData['month'])->monthName;
            $filterInfo = "Bulan: " . $monthName . " " . $searchData['year'];
        } else {
            $data = Soap::with(['pasien', 'poli', 'rm', 'isian'])->where('id_poli', 2)->get();
            $filterInfo = "Semua Data";
        }

        // Mendapatkan nama diagnosa primer tanpa tanda []
        foreach ($data as $item) {
            $item->soap_a_primer = json_decode($item->soap_a_primer, true)[0];
            $item->soap_a_sekunder = json_decode($item->soap_a_sekunder, true)[0];
        }

        // dd($data. $filterInfo);
        // Render view pencetakan ke dalam HTML
        $html = View::make('admin.rekapan.pasien-bpjs.cetak', compact('data', 'filterInfo'))->render();

        // Kembalikan respons berupa HTML
        return $html;
    }

    public function exportExcelGigiUmum()
    {
        return Excel::download(new RekapPasienGigiUmumExport(), 'gigi-pasien-umum.xlsx');
    }
}
