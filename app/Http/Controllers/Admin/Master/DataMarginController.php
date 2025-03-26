<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Margin;
use Illuminate\Http\Request;

class DataMarginController extends Controller
{
    public function index()
    {
        $potongan = Margin::all();

        return view('admin.master.margin.index', compact('potongan'));
    }

    public function tambah(Request $request)
    {
        $data = [
            'margin' => $request->margin,
            'keterangan' => $request->keterangan,
        ];

        Margin::create($data);

        return redirect()->route('master-margin')->with('success', 'Data Margin Berhasil Ditambahkan');
    }

    public function edit(Request $request, $id)
    {
        $data = [
            'margin' => $request->margin,
            'keterangan' => $request->keterangan,
        ];

        Margin::find($id)->update($data);

        return redirect()->route('master-margin')->with('success', 'Data Margin Berhasil Diubah');
    }

    public function hapus($id)
    {
        Margin::destroy($id);

        return redirect()->route('master-margin')->with('success', 'Data Margin Berhasil Dihapus');
    }
}
