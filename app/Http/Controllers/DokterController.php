<?php

namespace App\Http\Controllers;

use App\Models\Diagnosa;
use App\Models\IsianPerawat;
use App\Models\RmDa1;
use App\Models\Soap;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        $anamnesis = RmDa1::with(['pasien', 'poli'])->get()->toArray();
        // dd($anamnesis);
       
        return view('dokter.index', compact('anamnesis'));
    }

    public function soap($id)
    {   
        $diagno = Diagnosa::paginate(10);
        $pasienid = RmDa1::with(['pasien', 'poli'])->where('id', '=', $id)->get()->toArray();
        $isian = IsianPerawat::with(['pasien', 'poli'])->where('pasien', '=', $id)->get()->toArray();
        $soap = Soap::with(['pasien.isian', 'poli','rm_da', 'diagnosa'])->where('rm_da', '=', $id)->get()->toArray();
        // dd($pasienid);

        return view('dokter.soap', compact('id','pasienid', 'diagno', 'soap'));
    }
    public function store(Request $request, $id)
    {   
        $data = $request->all();
        $anamnesis = RmDa1::with(['pasien', 'poli'])->where('id', '=',$id)->get()->toArray();
        // $diagno = Diagnosa::where('id', '=', $data['soap_a'])->get()->toArray();
        $data2 = [
            'pasien' => $anamnesis[0]['pasien']['id'],
            'poli' => $anamnesis[0]['poli']['KdPoli'],
            'rm_da' => $id,
            'profesi' => 'Dokter',
            'soap' => $data['soap_p'],
            'diagnosa' => $data['soap_a'],
            'resep' => $data['soap_p'],
            'keterangan' => $data['keterangan'],
            'edukasi' => $data['edukasi']
        ];
        // dd($data2);
        Soap::create($data2);
        return redirect()->route('dokter.soap', $id);
    }
    public function getDiagnosa(Request $request) 
    {
        $soap = [];
        if ($request->has('q')) {
            $search = $request->q;
            $soap = Diagnosa::select("kd_diagno", "nm_diagno")
            ->where('nm_diagno', 'LIKE', "%$search%")->get();
        }
        return response()->json($soap);
    }
}
