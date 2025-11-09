<?php

namespace App\Http\Controllers;

use App\Imports\ResepImport;
use App\Models\Margin;
use App\Models\Obat;
use App\Models\RecordStok;
use App\Models\Resep;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApotekerObatController extends Controller
{
    public function masterObat(Request $request)
    {
        $obat = Resep::orderBy('id', 'desc')->paginate(10);
        // Pencarian & jumlah entri untuk data semua pasien
        $search = $request->input('search');
        $entries = $request->input('entries', 10); // Default 10
        $page = $request->input('page', 1);

        // dd($obat);

        $query = Resep::where('created_at', '>=', now()->subDay()); // Data dalam 24 jam terakhir

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('golongan', 'LIKE', "%{$search}%")
                    ->orWhere('jenis_sediaan', 'LIKE', "%{$search}%")
                    ->orWhere('nama_obat', 'LIKE', "%{$search}%")
                    ->orWhere('harga_pokok', 'LIKE', "%{$search}%")
                    ->orWhere('harga_jual', 'LIKE', "%{$search}%")
                    ->orWhere('stok_awal', 'LIKE', "%{$search}%")
                    ->orWhere('masuk', 'LIKE', "%{$search}%")
                    ->orWhere('keluar', 'LIKE', "%{$search}%")
                    ->orWhere('stok', 'LIKE', "%{$search}%");
            });
        }

        $obatUploud = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $obatUploud->appends(['search' => $search, 'entries' => $entries]);

        $lastUploadTime = $obatUploud->max('created_at');

        $uploadStatus = $lastUploadTime
            ? Carbon::parse($lastUploadTime)->diffForHumans()
            : 'Belum ada data yang diunggah';

        $apotek = Obat::with(['Booking', 'antrianPerawat', 'soap.poli', 'resep'])
            ->paginate(10);

        $lowStockObat = Resep::where('stok', '<', 50)->get();

        $margen = Margin::latest()->first(); // Ambil margin terakhir

        return view('obat.master.dataobat.dataObatApoteker', compact('obat', 'apotek', 'lowStockObat', 'margen', 'search', 'entries', 'obatUploud', 'lastUploadTime', 'uploadStatus'));
    }

    public function uploudObat(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            $activeMargin = Margin::first();
            if (!$activeMargin) {
                throw new \Exception('Tidak ada margin aktif yang ditemukan. Harap atur margin aktif terlebih dahulu.');
            }

            Log::info('File berhasil diupload:', [$request->file('file')->getClientOriginalName()]);

            $import = new ResepImport();
            Excel::import($import, $request->file('file'));

            $uploadedCount = count($import->getUploadedRecords());
            Log::info("Jumlah data yang berhasil diunggah: $uploadedCount");

            if ($uploadedCount > 0) {
                return redirect()->route('apoteker.master.obat')
                    ->with('success', "Data obat berhasil diunggah! ($uploadedCount data baru ditambahkan)");
            } else {
                return redirect()->back()
                    ->with('import_error', 'Tidak ada data yang berhasil diimpor.');
            }
        } catch (\Exception $e) {
            Log::error('Import Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('import_error', 'Gagal mengunggah data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menentukan header kolom
        $headers = ['golongan', 'jenis_sediaan', 'nama_obat', 'harga_pokok', 'harga_jual', 'stok_awal', 'masuk', 'keluar', 'retur', 'stok'];

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
        $sheet->getStyle('A1:J1')->applyFromArray($styleArray);

        // Simpan dan berikan sebagai file download
        $writer = new Xlsx($spreadsheet);

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="Template_Obat.xlsx"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->input('query');
            $obat = Resep::where('nama_obat', 'like', '%' . $query . '%')
                ->orWhere('golongan', 'like', '%' . $query . '%')
                ->orWhere('jenis_sediaan', 'like', '%' . $query . '%')
                ->orWhere('stok', 'like', '%' . $query . '%')
                ->orWhere('harga_jual', 'like', '%' . $query . '%')
                ->orWhere('harga_pokok', 'like', '%' . $query . '%')
                ->orWhere('masuk', 'like', '%' . $query . '%')
                ->orWhere('keluar', 'like', '%' . $query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return response()->json(view('obat.master.table', compact('obat'))->render());
        }

        // Jika bukan permintaan AJAX, kembalikan tampilan normal
        return redirect()->route('apoteker.master.obat');
    }

    public function tambah(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'id_margin' => 'required|exists:margins,id',
        ]);

        // Ambil data stok dari input
        $stokAwal = $request->stok_awal;
        $stokMasuk = $request->masuk ?? 0;
        $stokKeluar = $request->keluar ?? 0;
        $stokRetur = $request->retur ?? 0;

        // Hitung stok akhir
        $stokAkhir = $stokAwal + $stokMasuk - $stokKeluar + $stokRetur;

        // Ambil margin berdasarkan id_margin yang dipilih
        $margen = Margin::find($request->id_margin); // Pastikan id_margin dikirimkan dalam request

        // Hitung harga jual berdasarkan margin dan harga pokok
        $hargaJual = 0;
        if ($margen && $request->harga_pokok) {
            // Hitung harga jual berdasarkan margin dan harga pokok
            $hargaJual = $request->harga_pokok * (1 + $margen->margin / 100);
        }

        // Data untuk tabel Resep
        $data = [
            'golongan' => $request->golongan,
            'jenis_sediaan' => $request->jenis_sediaan,
            'nama_obat' => $request->nama_obat,
            'harga_pokok' => $request->harga_pokok,
            'harga_jual' => $hargaJual, // Simpan harga jual yang telah dihitung
            'id_margin' => $request->id_margin, // Simpan id_margin untuk relasi
            'stok_awal' => $stokAwal,
            'masuk' => $stokMasuk,
            'keluar' => $stokKeluar,
            'retur' => $stokRetur,
            'stok' => $stokAkhir,
        ];

        // dd($data);

        // Simpan data obat baru ke tabel Resep
        $obat = Resep::create($data);

        // Simpan log stok awal ke tabel RecordStok
        RecordStok::create([
            'id_reseps' => $obat->id,
            'stok_masuk' => $stokMasuk,
            'stok_keluar' => $stokKeluar,
            'stok_retur' => $stokRetur,
            'stok_total' => $stokAkhir,
        ]);

        return redirect()->route('apoteker.master.obat')->with('success', 'Data Obat Berhasil Ditambah');
    }

    public function edit(Request $request, $id)
    {
        // Ambil data stok dari input
        $stokMasuk = $request->masuk ?? 0;
        $stokKeluar = $request->keluar ?? 0;
        $stokRetur = $request->retur ?? 0;

        // Cari data obat berdasarkan ID
        $obat = Resep::find($id);

        if (!$obat) {
            // Jika obat tidak ditemukan, tambahkan obat baru
            $data = [
                'golongan' => $request->golongan,
                'jenis_sediaan' => $request->jenis_sediaan,
                'nama_obat' => $request->nama_obat,
                'harga_pokok' => $request->harga_pokok,
                'harga_jual' => $request->harga_jual,
                'stok_awal' => $request->stok_awal ?? 0,
                'masuk' => $stokMasuk,
                'keluar' => $stokKeluar,
                'retur' => $stokRetur,
                'stok' => ($request->stok_awal ?? 0) + $stokMasuk - $stokKeluar + $stokRetur,
            ];

            // Simpan data obat baru
            $obat = Resep::create($data);

            // Simpan log perubahan stok
            RecordStok::create([
                'id_respes' => $obat->id,
                'stok_masuk' => $stokMasuk,
                'stok_keluar' => $stokKeluar,
                'stok_retur' => $stokRetur,
                'stok_total' => $obat->stok,
            ]);

            return redirect()->route('apoteker.master.obat')->with('success', 'Data Obat Baru Berhasil Ditambahkan');
        }

        // Jika obat ditemukan, perbarui data dan hitung stok akhir
        $stokTerakhir = $obat->stok;

        $obat->masuk += $stokMasuk;
        $obat->retur += $stokRetur;
        $stokAkhir = $stokTerakhir + $stokMasuk - $stokKeluar + $stokRetur;

        // Update data obat di database
        $obat->update([
            'golongan' => $request->golongan,
            'jenis_sediaan' => $request->jenis_sediaan,
            'nama_obat' => $request->nama_obat,
            'harga_pokok' => $request->harga_pokok,
            'harga_jual' => $request->harga_jual,
            'stok_awal' => $obat->stok_awal, // Tidak diubah
            'masuk' => $obat->masuk,
            'keluar' => $stokKeluar,
            'retur' => $obat->retur,
            'stok' => $stokAkhir,
        ]);

        // Simpan log perubahan stok
        RecordStok::create([
            'id_reseps' => $obat->id,
            'stok_masuk' => $stokMasuk,
            'stok_keluar' => $stokKeluar,
            'stok_retur' => $stokRetur,
            'stok_total' => $stokAkhir,
        ]);

        return redirect()->route('apoteker.master.obat')->with('success', 'Data Obat Berhasil Diubah');
    }

    public function hapus($id)
    {
        Resep::destroy($id);
        return redirect()->route('apoteker.master.obat', 'id')->with('success', 'Data Berhasil dihapus');
    }
}
