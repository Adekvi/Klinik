<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Tindakan;
use Illuminate\Http\Request;

class TindakanController extends Controller
{
    public function index(){

        $tindakan = Tindakan::all();
        return view('admin.master.tindakan.index', compact('tindakan'));
    }

    public function store(Request $request){
        $data = [
            'tindakan' => $request->tindakan,
            'tarif' => $request->tarif,
            'keterangan' => $request->keterangan,
        ];

        Tindakan::create($data);

        return redirect()->route('tindakan.index')->with('success', 'Tindakan Berhasil Ditambah');

    }

    public function edit(Request $request, $id){
        $data = [
            'tindakan' => $request->tindakan,
            'tarif' => $request->tarif,
            'keterangan' => $request->keterangan,
        ];

        Tindakan::find($id)->update($data);

        return redirect()->route('tindakan.index')->with('success', 'Tindakan Berhasil Diubah');

    }

    public function hapus($id){

        Tindakan::destroy($id);
        return redirect()->route('tindakan.index')->with('success', 'Tindakan Berhasil Dihapus');
    }
}
