<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;
use View;

class DataPoliController extends Controller
{
    public function index()
    {
        $poli = Poli::all();
        View::share('poli', $poli);
        return view('admin.master.datapoli.index', compact('poli'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'namapoli' => 'required'
        ]);

        $data = [
            'namapoli' => $request->namapoli
        ];
        Poli::create($data);
        return redirect()->route('master.datapoli')->with('toast_success', 'Data Poli ditambahkan');
    }
    public function edit(Request $request, $id)
    {
        $request->validate([
            'namapoli' => 'required'
        ]);

        $data = [
            'namapoli' => $request->namapoli
        ];
        Poli::find($id)->update($data);
        return redirect()->route('master.datapoli')->with('toast_success', 'Data Poli Berhasil diubah');
    }
    public function delete($KdPoli)
    {
        Poli::destroy($KdPoli);
        return redirect()->route('master.datapoli', 'KdPoli')->with('toast_success', 'Data Berhasil dihapus');
    }
}
