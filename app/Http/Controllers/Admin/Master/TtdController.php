<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\DataDokter;
use App\Models\TtdMedis;
use Illuminate\Http\Request;

class TtdController extends Controller
{
    public function index()
    {
        $ttd = TtdMedis::all();
        $dokter = DataDokter::all();
        // dd($dokter);
        return view('admin.master.ttdMedis.index', compact('ttd', 'dokter'));
    }

    public function store(Request $request)
    {

        // Simpan gambar ke storage publik
        // Cek apakah ada file yang diunggah
        $fotoPath = $request->hasFile('foto') ? $request->file('foto')->store('ttd', 'public') : null;
        // $fotoPath = $request->file('foto')->store('ttd', 'public');

        $data = [
            'nama' => $request->nama,
            'foto' => $fotoPath,
        ];

        TtdMedis::create($data);
        return redirect()->route('master.ttd')->with('success', 'TTD berhasil di Uploud');
    }

    public function edit(Request $request, $id)
    {

        // Cek apakah ada file yang diunggah
        $fotoPath = $request->hasFile('foto') ? $request->file('foto')->store('ttd', 'public') : null;
        // $fotoPath = $request->file('foto')->store('ttd', 'public');

        $data = [
            'nama' => $request->nama,
            'foto' => $fotoPath
        ];
        TtdMedis::find($id)->update($data);
        return redirect()->route('master.ttd')->with('success', 'Foto Berhasil diubah');
    }

    public function destroy($id)
    {
        TtdMedis::destroy($id);
        return redirect()->route('master.ttd')->with('success', 'TTD berhasil Dihapus');
    }
}
