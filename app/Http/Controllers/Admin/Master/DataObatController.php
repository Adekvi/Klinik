<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Margin;
use App\Models\Obat;
use App\Models\RecordStok;
use App\Models\Resep;
use Illuminate\Http\Request;

class DataObatController extends Controller
{
    public function index(Request $request)
    {
        // Ambil jumlah entri per halaman dari request, default 10
        $entries = $request->input('entries', 10);

        // Ambil data obat dengan paginasi berdasarkan entries yang dipilih
        $obat = Resep::with('margin')->orderBy('id', 'desc')->paginate($entries);

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
                // ->orWhere('gol', 'like', '%'.$query.'%')
                // ->orWhere('sediaan', 'like', '%'.$query.'%')
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
