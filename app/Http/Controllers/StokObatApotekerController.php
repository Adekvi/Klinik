<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class StokObatApotekerController extends Controller
{
    // public function obatMasuk()
    // {
    //     $apotek = Resep::with('record')
    //         ->where('masuk', '>', 0)
    //         ->orWhere('retur', '>', 0) // Pastikan hanya obat yang ada stok masuknya
    //         ->orderBy('updated_at', 'desc') // Urutkan berdasarkan tanggal update terbaru
    //         ->paginate(10);
    //     // dd($apotek);
    //     $obat = Obat::with(['booking', 'antrianPerawat', 'soap.poli', 'resep'])->get();
    //     // dd($obat);
    //     return view('obat.rekapObat.ObatMasuk', compact('obat', 'apotek'));
    // }

    public function obatMasuk()
    {
        $apotek = Resep::with(['record' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
            ->where(function ($query) {
                $query->where('masuk', '>', 0)
                    ->orWhere('retur', '>', 0);
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        $obat = Obat::with(['booking', 'antrianPerawat', 'soap.poli', 'resep'])->get();

        return view('obat.rekapObat.ObatMasuk', compact('apotek', 'obat'));
    }


    // public function ubahStokMasuk(Request $request, $id)
    // {
    //     $apotek = Obat::find($id);
    //     $apotek->masuk = $request->input('stok_masuk');
    //     $apotek->save();
    //     return redirect()->route('apoteker.obat.masuk')->with('success', 'Stok obat berhasil diubah');
    // }

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

    public function obatKeluar()
    {
        $obat = Obat::with(['booking.pasien', 'soap.poli', 'resep', 'antrianPerawat'])
            ->where('status', 'O')
            ->get();
        $resep = Resep::all();
        // dd($obat);
        return view('obat.rekapObat.ObatKeluar', compact('obat', 'resep'));
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
