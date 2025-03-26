<?php

namespace App\Http\Controllers\Admin\Obat;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\Resep;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ObatController extends Controller
{

    public function obatKeluar()
    {
        $obat = Obat::with('booking.pasien', 'soap')->where('status', 'O')->get();
        $resep = Resep::all();
        // dd($obat);
        return view('admin.obat-Keluar', compact('obat', 'resep'));
    }

    public function stokObat()
    {
        $obat = Obat::with('booking', 'soap')->get();
        $resep = Resep::all();
        // dd($obat);
        return view('admin.stok-Obat', compact('obat', 'resep'));
    }

    public function search(Request $request)
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
