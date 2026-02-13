<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Margin;
use App\Models\Obat;
use App\Models\RecordStok;
use App\Models\Resep;
use App\Models\ResepDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataObatController extends Controller
{
    public function index(Request $request)
    {
        // Ambil jumlah entri per halaman dari request, default 10
        $entries = $request->input('entries', 10);

        // Ambil data obat dengan paginasi berdasarkan entries yang dipilih
        $obat = Resep::with(['margin', 'details'])->orderBy('id', 'desc')->paginate($entries);

        // Ambil daftar obat dengan stok rendah
        $lowStockObat = Resep::where('stok', '<', 50)->get();

        // Ambil margin terakhir
        $margen = Margin::latest()->first();

        // Kirim nilai entries ke tampilan agar tetap dipilih di dropdown
        return view('admin.master.obat.index', compact('obat', 'lowStockObat', 'margen', 'entries'));
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

            return response()->json(view('admin.master.obat.table', compact('obat'))->render());
        }

        // Jika bukan permintaan AJAX, kembalikan tampilan normal
        return redirect()->route('master.obat');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_margin' => 'required|exists:margins,id',
            'no_faktur' => 'required',
            'nama_distributor' => 'required',
            'tanggal_terima.*' => 'required|date',
            'expired_date.*' => 'required|date',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {

            // Ambil margin
            $margen = Margin::find($request->id_margin);

            // Hitung harga jual
            $hargaJual = 0;
            if ($margen && $request->harga_pokok) {
                $hargaJual = $request->harga_pokok * (1 + $margen->margin / 100);
            }

            // Total stok dari hasil JS
            $stokAwal = $request->stok_awal ?? 0;

            // Simpan ke tabel reseps
            $resep = Resep::create([
                'id_margin'         => $request->id_margin,
                'golongan'          => $request->golongan,
                'jenis_sediaan'     => $request->jenis_sediaan,
                'nama_obat'         => $request->nama_obat,
                'harga_pokok'       => $request->harga_pokok,
                'harga_jual'        => $hargaJual,
                'stok_awal'         => $stokAwal,
                'masuk'             => $stokAwal,
                'keluar'            => 0,
                'retur'             => 0,
                'stok'              => $stokAwal,

                // Distributor & Faktur
                'no_faktur'         => $request->no_faktur,
                'nama_distributor'  => $request->nama_distributor,
                'hp_distributor'    => $request->hp_distributor,
                'alamat_distributor'=> $request->alamat_distributor,
            ]);

            // Simpan batch detail
            foreach ($request->expired_date as $key => $expired) {
                ResepDetail::create([
                    'resep_id'        => $resep->id,
                    'etd'             => $request->tanggal_terima[$key],
                    'expired_date'    => $expired,
                    'jumlah_expired'  => $request->jumlah[$key],
                ]);
            }

            // Simpan ke record stok
            RecordStok::create([
                'id_reseps'   => $resep->id,
                'stok_masuk'  => $stokAwal,
                'stok_keluar' => 0,
                'stok_retur'  => 0,
                'stok_total'  => $stokAwal,
            ]);

        });


        return redirect()->route('master.obat')->with('success', 'Data Obat Berhasil Ditambah');
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
                'id_obat' => $obat->id,
                'stok_masuk' => $stokMasuk,
                'stok_keluar' => $stokKeluar,
                'stok_retur' => $stokRetur,
                'stok_total' => $obat->stok,
            ]);

            return redirect()->route('master.obat')->with('success', 'Data Obat Baru Berhasil Ditambahkan');
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
            'id_obat' => $obat->id,
            'stok_masuk' => $stokMasuk,
            'stok_keluar' => $stokKeluar,
            'stok_retur' => $stokRetur,
            'stok_total' => $stokAkhir,
        ]);

        return redirect()->route('master.obat')->with('success', 'Data Obat Berhasil Diubah');
    }

    public function delete($id)
    {
        Resep::destroy($id);
        return redirect()->route('master.obat', 'id')->with('toast_success', 'Data Berhasil dihapus');
    }
}
