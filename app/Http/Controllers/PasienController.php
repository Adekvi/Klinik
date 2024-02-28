<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index ()
    {
        return view('pasien.index');
    }
    public function store (Request $request)
    {
        $data = [
            'no_rm' => $request->no_rm,
            'nik' => $request->nik,
            'nama_kk' => $request->nama_kk,
            'nama_pasien' => $request->nama_pasien,
            'tgllahir' => $request->tgllahir,
            'alamat' => $request->alamat,
            'noHP' => $request->noHP,
            'jenis_bayar' => $request->jenis_bayar,
            'bpjs' => $request->bpjs,
            'status' => $request->status,
        ];
        Pasien::create($data);
        return redirect()->route('perawat.index');
    }
    
    public function destroy($id)
    {
        Pasien::destroy($id);
        return redirect()->route('perawat.index', 'id');
    }
}
