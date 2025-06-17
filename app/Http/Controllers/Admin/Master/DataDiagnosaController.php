<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Diagnosa;
use Illuminate\Http\Request;

class DataDiagnosaController extends Controller
{
    public function index(Request $request)
    {
        $entries = $request->input('entries', 10);

        $diagnosa = Diagnosa::orderBy('id', 'asc')->paginate($entries);
        // Ubah angka 10 sesuai dengan jumlah data yang ingin ditampilkan per halaman
        // dd($diagnosa);
        return view('admin.master.diagnosa.index', compact('diagnosa', 'entries'));
    }
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->input('query');
            $diagnosa = Diagnosa::where('kd_diagno', 'like', '%' . $query . '%')
                ->orWhere('nm_diagno', 'like', '%' . $query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return response()->json(view('admin.master.diagnosa.table', compact('diagnosa'))->render());
        }

        // Jika bukan permintaan AJAX, kembalikan tampilan normal
        return redirect()->route('diagnosa.index');
    }
    public function store(Request $request)
    {
        $data = [
            'kd_diagno' => $request->kd_diagno,
            'nm_diagno' => $request->nm_diagno,
        ];
        Diagnosa::create($data);
        return redirect()->route('master.diagnosa')->with('toast_success', 'Data Diagnosa Berhasil ditambah');
    }
    public function edit(Request $request, $id)
    {
        $data = [
            'kd_diagno' => $request->kd_diagno,
            'nm_diagno' => $request->nm_diagno,
        ];
        Diagnosa::find($id)->update($data);
        return redirect()->route('master.diagnosa')->with('toast_success', 'Data Diagnosa Berhasil diubah');
    }
    public function delete($id)
    {
        Diagnosa::destroy($id);
        return redirect()->route('master.diagnosa', 'id')->with('toast_success', 'Data Berhasil dihapus');
    }
}
