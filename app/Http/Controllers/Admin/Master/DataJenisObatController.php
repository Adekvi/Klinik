<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Jenisobat;
use Illuminate\Http\Request;

class DataJenisObatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = Jenisobat::orderBy('id', 'asc');

        if ($search) {
            $query->where('jenis', 'LIKE', "%{$search}%")
                ->orWhere('golongan', 'LIKE', "%{$search}%")
                ->orWhere('keterangan', 'LIKE', "%{$search}%");
        }

        // Paginasi dengan jumlah entri yang dipilih
        $jenis = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);

        // Menjaga parameter pencarian tetap ada saat navigasi halaman
        $jenis->appends(['search' => $search, 'entries' => $entries]);

        // dd($jenis);

        return view('admin.master.datajenis.index', compact('jenis', 'entries', 'search'));
    }

    public function updateStatus(Request $request)
    {
        $jenisId = $request->input('id');
        $isChecked = $request->has('status');

        $jenis = Jenisobat::findOrFail($jenisId);
        // dd($jenis);
        $jenis->status = $isChecked;
        $jenis->save();

        return redirect()->back()->with('status', 'Status updated successfully');
    }

    public function tambah(Request $request)
    {
        $data = [
            'jenis' => $request->jenis,
            'golongan' => $request->golongan,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ];

        Jenisobat::create($data);

        return redirect()->route('master-jenis')->with('success', 'Data berhasil ditambah!');
    }

    public function edit(Request $request, $id)
    {
        $data = [
            'jenis' => $request->jenis,
            'golongan' => $request->golongan,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ];

        Jenisobat::findOrFail($id)->update($data);

        return redirect()->route('master-jenis')->with('success', 'Data berhasil diubah!');
    }

    public function hapus($id)
    {
        Jenisobat::destroy($id);

        return redirect()->route('master-jenis')->with('success', 'Data berhasil dihapus!');
    }
}
