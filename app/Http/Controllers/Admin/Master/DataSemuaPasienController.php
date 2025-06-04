<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Imports\PasienImport;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;

class DataSemuaPasienController extends Controller
{
    public function index(Request $request)
    {
        // Pencarian & jumlah entri untuk data semua pasien
        $search = $request->input('search');
        $entries = $request->input('entries', 10); // Default 10
        $page = $request->input('page', 1);

        // Pencarian & jumlah entri untuk data terbaru
        $recentSearch = $request->input('recent_search');
        $recentEntries = $request->input('recent_entries', 10); // Default 10
        $recentPage = $request->input('recent_page', 1);

        // Query semua pasien
        $query = Pasien::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_pasien', 'LIKE', "%{$search}%")
                    ->orWhere('nik', 'LIKE', "%{$search}%")
                    ->orWhere('no_rm', 'LIKE', "%{$search}%");
            });
        }

        $pasien = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $pasien->appends(['search' => $search, 'entries' => $entries]);

        $recentQuery = Pasien::where('created_at', '>=', now()->subDay()); // Data dalam 24 jam terakhir

        if ($recentSearch) {
            $recentQuery->where(function ($q) use ($recentSearch) {
                $q->where('nama_pasien', 'LIKE', "%{$recentSearch}%")
                    ->orWhere('nik', 'LIKE', "%{$recentSearch}%")
                    ->orWhere('no_rm', 'LIKE', "%{$recentSearch}%");
            });
        }

        $recentPatients = $recentQuery->orderBy('id', 'desc')->paginate($recentEntries, ['*'], 'recent_page', $recentPage);
        $recentPatients->appends(['recent_search' => $recentSearch, 'recent_entries' => $recentEntries]);

        $lastUploadTime = $recentPatients->max('created_at');

        $uploadStatus = $lastUploadTime
            ? Carbon::parse($lastUploadTime)->diffForHumans()
            : 'Belum ada data yang diunggah';

        return view('admin.master.semuapasien.index', compact('pasien', 'recentPatients', 'search', 'entries', 'recentSearch', 'recentEntries', 'uploadStatus'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Log::info('File berhasil diupload:', [$request->file('file')->getClientOriginalName()]);

            $import = new PasienImport();
            Excel::import($import, $request->file('file'));

            // Ambil jumlah data yang berhasil diunggah
            $uploadedCount = count($import->getUploadedRecords());

            Log::info("Jumlah data yang berhasil diunggah: $uploadedCount");

            return redirect()->route('master.semuadata')->with('success', "Data pasien berhasil diunggah! ($uploadedCount data baru ditambahkan)");
        } catch (\Exception $e) {
            Log::error('Import Error: ' . $e->getMessage());
            return redirect()->back()->with('import_error', $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menentukan header kolom
        $headers = ['no_rm', 'nama_pasien', 'nik', 'nama_kk', 'tgllahir', 'jekel', 'alamat_asal', 'nohp', 'domisili', 'jenis_pasien', 'bpjs', 'pekerjaan'];

        // Menambahkan header ke baris pertama
        $sheet->fromArray($headers, null, 'A1');

        // Menentukan style untuk header (warna latar belakang)
        $styleArray = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // Warna font putih
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50'], // Warna hijau
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        // Menerapkan style ke semua header
        $sheet->getStyle('A1:L1')->applyFromArray($styleArray);

        // Simpan dan berikan sebagai file download
        $writer = new Xlsx($spreadsheet);

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="Template_Pasien.xlsx"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }

    public function hapus($id)
    {
        Pasien::destroy($id);

        return redirect()->route('master.semuapasien')->with('toast_success', 'Data Berhasil dihapus');
    }
}
