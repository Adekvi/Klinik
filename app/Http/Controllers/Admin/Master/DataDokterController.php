<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\DataDokter;
use App\Models\Poli;
use Illuminate\Http\Request;

class DataDokterController extends Controller
{
    public function index()
    {
        $poli = Poli::all();
        $dokter = DataDokter::with('poli')->get();
        // dd($dokter);
        return view('admin.master.datadokter.index', compact('poli', 'dokter'));
    }
    
    public function store(Request $request)
    {
        $data = $request->all();

        if (!empty($data['poli'])) {
            $dokter = [
                'id_poli' => $data['poli'],
                'nama_dokter' => $data['dokter'],
                'nik' => $data['nik'],
                'tarif' => $data['tarif'],
                'profesi' => $data['profesi'],
                'status' => 0
            ];
            DataDokter::create($dokter);
        } else {
            $dokter = [
                'nama_dokter' => $data['dokter'],
                'nik' => $data['nik'],
                'tarif' => $data['tarif'],
                'profesi' => $data['profesi'],
                'status' => 0
            ];
            DataDokter::create($dokter);
        }
        return redirect()->route('master.datadokter');
    }
    public function edit(Request $request, $id)
    {
        $data = $request->all();

        // Jika memilih tanpa poli, set id_poli menjadi null atau 0 sesuai dengan kebutuhan
        $idPoli = $data['poli'] == '0' ? null : $data['poli']; // Mengatur poli menjadi null jika 0

        $update = [
            'id_poli' => $idPoli, // Set id_poli menjadi null jika "Tidak ada Poli"
            'nama_dokter' => $data['dokter'],
            'nik' => $data['nik'],
            'tarif' => $data['tarif'],
            'profesi' => $data['profesi']
        ];

        DataDokter::where('id', $id)->update($update);
        return redirect()->route('master.datadokter');
    }

    public function destroy($id)
    {
        DataDokter::where('id', $id)->delete();
        return redirect()->route('master.datadokter');
    }
    
    public function updateStatus(Request $request)
    {
        $doctorId = $request->input('id');
        $isChecked = $request->has('status');

        $doctor = DataDokter::findOrFail($doctorId);
        // dd($doctor);
        $doctor->status = $isChecked;
        $doctor->save();

        return redirect()->back()->with('status', 'Status updated successfully');
    }
}
