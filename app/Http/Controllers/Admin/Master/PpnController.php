<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\pajak_Ppn;
use App\Models\pajakPPN;
use App\Models\ppnPajak;
use Illuminate\Http\Request;

class PpnController extends Controller
{
    public function index()
    {
        $pajak = ppnPajak::all();

        return view('admin.master.ppn.index', compact('pajak'));
    }

    public function tambah(Request $request)
    {
        $data = [
            'namaPajak' => $request->namaPajak,
            'tarifPpn' => $request->tarifPpn,
        ];

        ppnPajak::create($data);

        return redirect()->route('admin.master.ppn.index')->with('toast_success', 'Data Berhasil disimpan');
    }

    public function updateStatus(Request $request)
    {
        $ppnId = $request->input('id');
        $isChecked = $request->has('status');

        $ppn = ppnPajak::findOrFail($ppnId);
        // dd($ppn);
        $ppn->status = $isChecked;
        $ppn->save();

        return redirect()->back()->with('status', 'Status updated successfully');
    }

    public function edit(Request $request, $id)
    {
        $data = [
            'namaPajak' => $request->namaPajak,
            'tarifPpn' => $request->tarifPpn,
        ];

        ppnPajak::find($id)->update($data);

        return redirect()->route('admin.master.ppn.index')->with('toast_success', 'Data Berhasil diubah');
    }

    public function hapus($id)
    {
        ppnPajak::destroy($id);

        return redirect()->route('admin.master.ppn.index')->with('toast_success', 'Data Berhasil dihapus');
    }
}
