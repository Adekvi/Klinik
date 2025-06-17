<?php

namespace App\Http\Controllers;

use App\Exports\RekapPasienBpjsExport;
use App\Exports\RekapPasienGigiBpjsExport;
use App\Exports\RekapPasienGigiUmumExport;
use App\Exports\RekapPasienUmumExport;
use App\Models\AntrianPerawat;
use App\Models\Soap;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPerawatController extends Controller
{
    public function rekap()
    {
        $pasien = AntrianPerawat::with(['booking.pasien', 'poli', 'rm', 'isian'])
            ->orderByRaw("CASE WHEN status = 'D' THEN 1 ELSE 2 END")
            ->orderBy('urutan', 'asc') // Menambahkan pengurutan berdasarkan urutan
            ->orderBy('created_at', 'asc')
            ->paginate(5);

        // dd($pasien);

        $log = AntrianPerawat::all();
        // Count untuk shift pagi berdasarkan id_poli = 1
        // Count untuk shift pagi berdasarkan id_poli = 1 dan id_pasien = 1
        // Count untuk shift pagi berdasarkan jenis_pasien == 'BPJS'

        // SHIFT PAGI POLI UMUM
        // PASIEN BPJS
        $countShiftPagiUmumBPJS = AntrianPerawat::where('id_poli', 1)
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'BPJS');
                });
            })
            ->whereTime('created_at', '>=', '07:00:00')
            ->whereTime('created_at', '<', '13:00:00')
            ->count();

        // PASIEN UMUM
        // Count untuk shift pagi berdasarkan jenis_pasien == 'Umum'
        $countShiftPagiUmumUmum = AntrianPerawat::where('id_poli', 1)
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
            ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'BPJS');
                });
            })
            ->whereTime('created_at', '>=', '07:00:00')
            ->whereTime('created_at', '<', '13:00:00')
            ->count();

        // PASIEN UMUM
        // Count untuk shift pagi berdasarkan jenis_pasien == 'Gigi'
        $countShiftPagiGigiUmum = AntrianPerawat::where('id_poli', 2)
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

        return view('perawat.rekap.index', compact(
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
            'pasien',
        ));
    }

    // Poli Umum
    // Pasien BPJS
    public function poliUmumPasienBpjs()
    {
        $umumBpjs = Soap::with('pasien', 'poli', 'rm', 'isian')->where('id_poli', 2)->orderBy('id', 'desc')->get();
        // dd($umumBpjs);
        return view('perawat.laporan.poliUmum.pasienBpjs', compact('umumBpjs'));
    }

    // Cari Pasien Bpjs
    public function cariBpjs(Request $request)
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

    // cetak Pasien Bpjs
    public function cetakUmumBpjs(Request $request)
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
        $html = View::make('perawat.laporan.PoliUmum.cetakPasienBpjs', compact('data', 'filterInfo'))->render();

        // Kembalikan respons berupa HTML
        return $html;
    }

    public function exportExcelUmumBpjs()
    {
        return Excel::download(new RekapPasienBpjsExport, 'Poli-Umum-Pasien-Bpjs.xlsx');
    }

    // Pasien UMUM
    public function poliUmumPasienUmum()
    {
        $umumUmum = Soap::with('pasien', 'poli', 'rm', 'isian')->where('id_poli', 2)->orderBy('id', 'desc')->get();
        // dd($umumUmum);
        return view('perawat.laporan.poliUmum.pasienUmum', compact('umumUmum'));
    }

    public function searchUmumUmum(Request $request)
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

    public function cetakUmumUmum(Request $request)
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
        $html = View::make('perawat.laporan.poliUmum.CetakPasienUmum', compact('data', 'filterInfo'))->render();

        // Kembalikan respons berupa HTML
        return $html;
    }

    public function exportExcelUmumUmum()
    {
        return Excel::download(new RekapPasienUmumExport, 'Poli-Umum-Pasien-Umum.xlsx');
    }

    // Poli Gigi
    // pasienBpjs
    public function poliGigiPasienBpjs()
    {
        $gigiBpjs = Soap::with('pasien', 'poli', 'rm', 'isian')->where('id_poli', 2)->orderBy('id', 'desc')->get();
        return view('perawat.laporan.poliGigi.pasienBpjs', compact('gigiBpjs'));
    }

    public function cariGigiBpjs(Request $request)
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

    public function printGigiBpjs(Request $request)
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
        $html = View::make('perawat.laporan.poliGigi.cetakPasienBpjs', compact('data', 'filterInfo'))->render();

        // Kembalikan respons berupa HTML
        return $html;
    }

    public function exportExcelPoliGigiBpjs()
    {
        return Excel::download(new RekapPasienGigiBpjsExport, 'Poli-Gigi-Pasien-Bpjs.xlsx');
    }

    // pasienUmum
    public function poliGigiPasienUmum()
    {
        $gigiUmum = Soap::with('pasien', 'poli', 'rm', 'isian')->where('id_poli', 2)->orderBy('id', 'desc')->get();
        return view('perawat.laporan.poliGigi.pasienUmum', compact('gigiUmum'));
    }

    public function cariGigiUmum(Request $request)
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

    public function printGigiUmum(Request $request)
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
        $html = View::make('perawat.laporan.poliGigi.cetakPasienUmum', compact('data', 'filterInfo'))->render();

        // Kembalikan respons berupa HTML
        return $html;
    }

    public function exportExcelPoliGigiUmum()
    {
        return Excel::download(new RekapPasienGigiUmumExport, 'Poli-Gigi-Pasien-Umum.xlsx');
    }
}
