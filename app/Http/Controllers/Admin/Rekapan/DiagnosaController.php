<?php

namespace App\Http\Controllers\Admin\Rekapan;

use App\Exports\DiagnosaTerbanyakExport;
use App\Http\Controllers\Controller;
use App\Models\Diagnosa;
use App\Models\DiagnosaTerbanyak;
use App\Models\Obat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class DiagnosaController extends Controller
{
    public function indexdiagnosa()
    {
        $allDiagnoses = DiagnosaTerbanyak::with('diagno')->get();

        // Mengelompokkan diagnosa berdasarkan id_diagnosa dan menghitung jumlah kasus baru berdasarkan jenis kelamin
        $groupedDiagnoses = [];

        foreach ($allDiagnoses as $diagnosis) {
            $id = $diagnosis->id_diagnosa;
            $nm_diagno = $diagnosis->diagno->nm_diagno;
            $gender = $diagnosis->gender;

            if (!isset($groupedDiagnoses[$id])) {
                $groupedDiagnoses[$id] = [
                    'diagnosa' => $nm_diagno,
                    'laki_laki' => 0,
                    'perempuan' => 0,
                    'jumlah' => 0,
                ];
            }
            // dd($groupedDiagnoses);

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

        return view('admin.rekapan.diagnosa.index', compact('groupedDiagnoses'));
    }

    public function searchDiag(Request $request)
    {
        // Ambil tipe pencarian dan kriteria pencarian dari permintaan
        $type = $request->input('type');
        $searchData = $request->all();
        // Proses pencarian berdasarkan tipe dan kriteria pencarian
        if ($type === 'full_date') {
            $data = DiagnosaTerbanyak::whereDate('created_at', $searchData['date'])->get();
        } elseif ($type === 'month_year') {
            $data = DiagnosaTerbanyak::whereMonth('created_at', $searchData['month'])
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

    public function cetakdiag(Request $request)
    {
        $type = $request->input('type');
        $searchData = $request->all();

        if ($type === 'full_date') {
            $data = DiagnosaTerbanyak::with('diagno')->whereDate('created_at', $searchData['date'])->get();
            $hari = Carbon::createFromDate($searchData['date'])->translatedFormat('l, d/m/Y');
            $filterInfo = "Tanggal: " . $hari;
        } elseif ($type === 'month_year') {
            $data = DiagnosaTerbanyak::with('diagno')->whereMonth('created_at', $searchData['month'])
                ->whereYear('created_at', $searchData['year'])
                ->get();
            $monthName = Carbon::createFromFormat('m', $searchData['month'])->monthName;
            $filterInfo = "BULAN : " . $monthName . " " . $searchData['year'];
        } else {
            $data = DiagnosaTerbanyak::with('diagno')->get();
            $filterInfo = "Semua Data";
        }

        $groupedDiagnoses = [];

        foreach ($data as $diagnosis) {
            $id = $diagnosis->id_diagnosa;
            $nm_diagno = $diagnosis->diagno->nm_diagno;
            $gender = $diagnosis->gender;

            if (!isset($groupedDiagnoses[$id])) {
                $groupedDiagnoses[$id] = [
                    'diagnosa' => $nm_diagno,
                    'laki_laki' => 0,
                    'perempuan' => 0,
                    'jumlah' => 0,
                ];
            }

            if ($gender == 'L') {
                $groupedDiagnoses[$id]['laki_laki'] += 1;
            } else {
                $groupedDiagnoses[$id]['perempuan'] += 1;
            }

            $groupedDiagnoses[$id]['jumlah'] += 1;
        }

        // Pastikan groupedDiagnoses tidak null
        if (empty($groupedDiagnoses)) {
            $groupedDiagnoses = [];
        }

        // Render view pencetakan ke dalam HTML
        $html = View::make('admin.rekapan.diagnosa.cetak', compact('groupedDiagnoses', 'filterInfo'))->render();

        // Kembalikan respons berupa HTML
        return $html;
    }

    public function exportDiagnosa()
    {
        return Excel::download(new DiagnosaTerbanyakExport, 'Diagnosa Terbanyak.xlsx');
    }

    public function exportToPDF()
    {
        $export = new DiagnosaTerbanyakExport();
        $export->exportToPDF();
    }
}
