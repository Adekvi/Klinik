<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class StokObatApotekerController extends Controller
{
    public function obatMasuk(Request $request)
    {
        // Ambil input dari form (pencarian & jumlah data per halaman)
        $search = $request->input('search');
        $entries = $request->input('entries', 10); // default 10 baris per halaman

        // Query utama untuk data resep (obat masuk / retur)
        $apotek = Resep::with(['record' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->where(function ($query) {
                $query->where('masuk', '>', 0)   // hanya obat yang masuk
                    ->orWhere('retur', '>', 0); // atau obat yang diretur
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_obat', 'like', "%{$search}%")
                    ->orWhere('kode_obat', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
                });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($entries);

        // Data referensi semua obat (misalnya untuk dropdown atau relasi)
        $obat = Obat::with(['booking', 'antrianPerawat', 'soap.poli', 'resep'])->get();

        // Kirim ke view
        return view('obat.rekapObat.ObatMasuk', compact('apotek', 'obat', 'search', 'entries'));
    }

    public function searchObatMasuk(Request $request)
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

    public function obatKeluar(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = Obat::with(['booking.pasien', 'soap.poli', 'resep', 'antrianPerawat'])
            ->where('status', 'O')
            ->orderBy('id', 'desc');

        if($search){
           $query->whereHas('booking.pasien', function ($q) use ($search) {
                $q->where('obat_Ro_namaObatUpdate', 'LIKE', "%{$search}%")
                    ->orWhere('obat_Ro_jumlah', 'LIKE', "%{$search}%");
            }); 
        }

        $obat = $query->paginate($entries, ['*'], 'page', $page);
        $obat->appends(['search' => $search, 'entries' => $entries]);

        $resep = Resep::all();
        // dd($obat);
        return view('obat.rekapObat.ObatKeluar', compact(
            'entries',
            'search',
            'obat', 
            'resep'));
    }

    public function stokObat()
    {
        $obat = Obat::with(['booking', 'soap'])->get();
        $resep = Resep::all();
        // dd($obat);
        return view('obat.master.stok-Obat', compact('obat', 'resep'));
    }

    public function searchObatKeluar(Request $request)
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

    public function cetak(Request $request)
    {
        $type = $request->input('type');
        $searchData = $request->all();
        // dd($type);
        // Proses pencarian berdasarkan tipe dan kriteria pencarian
        if ($type === 'full_date') {
            $data = Obat::whereDate('created_at', $searchData['date'])->get();
        } elseif ($type === 'month_year') {
            $data = Obat::whereMonth('created_at', $searchData['month'])
                ->whereYear('created_at', $searchData['year'])
                ->get();
        } else {
            $data = Obat::all();
        }

        // Render view pencetakan ke dalam HTML
        $html = View::make('admin.obat.cetak', compact('data'))->render();

        // Kembalikan respons berupa HTML
        return $html;
    }
}
