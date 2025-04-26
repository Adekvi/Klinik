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
        $dokter = DataDokter::where('profesi', 'Perawat')->get();
        // dd($dokter);
        return view('admin.master.ttdMedis.index', compact('ttd', 'dokter'));
    }

    public function updateStatus(Request $request)
    {
        $ttd_medis = $request->input('id');
        $isChecked = $request->has('status');

        $medis = TtdMedis::findOrFail($ttd_medis);
        // dd($medis);
        $medis->status = $isChecked;
        $medis->save();

        return redirect()->back()->with('status', 'Status updated successfully');
    }

    public function store(Request $request)
    {

        $fotoPath = $request->hasFile('foto')
            ? $request->file('foto')->store('ttd', 'public')
            : null;

        $dokter = DataDokter::find($request->id_medis); // cari nama dokter dari id

        $data = [
            'id_medis' => $dokter->id,
            'nama' => $dokter->nama_dokter,
            'foto' => $fotoPath,
            'status' => true,
        ];

        TtdMedis::create($data);

        return redirect()->route('master.ttd')->with('success', 'TTD berhasil di-upload');
    }

    public function edit(Request $request, $id)
    {

        $fotoPath = $request->hasFile('foto')
            ? $request->file('foto')->store('ttd', 'public')
            : null;

        $dokter = DataDokter::find($request->id_medis); // cari nama dokter dari id

        $data = [
            'id_medis' => $dokter->id,
            'nama' => $dokter->nama_dokter,
            'foto' => $fotoPath,
            'status' => true,
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
