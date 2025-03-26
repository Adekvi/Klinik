<?php

namespace App\Http\Controllers\Admin\Kunjungan;

use App\Http\Controllers\Controller;
use App\Models\PasienSehat;
use App\Models\Sehat;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class SehatController extends Controller
{
    public function index()
    {
        $sehat = PasienSehat::with('pasien')->orderBy('id', 'desc')->paginate(10);
        // dd($sehat);
        return view('admin.pasien-sehat.index', compact('sehat'));
    }
    public function eksporToPcare(Request $request)
    {
        $dataId = $request->all();
        $dataSehat = PasienSehat::with('pasien')->where('id', $dataId)->get()->toArray();
        // dd($dataSehat);
    }

    public function store(Request $request)
    {

        $data = [
            'id_pasien' => $request->id_pasien,
            'nama_pasien' => $request->nama_pasien,
            'noKartu' => $request->noKartu,
            'tgl_kunjungan' => $request->tgl_kunjungan,
            'kegiatan' => $request->kegiatan,
            'status' => $request->status,
        ];

        PasienSehat::create($data);
        return redirect()->route('perawat.index')->with('success', 'Pasien Sehat Berhasil Ditambahkan');
    }
}
