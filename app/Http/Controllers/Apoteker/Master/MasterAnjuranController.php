<?php

namespace App\Http\Controllers\Apoteker\Master;

use App\Http\Controllers\Controller;
use App\Models\Anjuran;
use Illuminate\Http\Request;

class MasterAnjuranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = Anjuran::orderBy('id', 'asc');

        if ($search) {
            $query->where('kode_anjuran', 'LIKE', "%{$search}%")
                ->orWhere('golongan', 'LIKE', "%{$search}%");
        }

        // Paginasi dengan jumlah entri yang dipilih
        $anjuran = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);

        // Menjaga parameter pencarian tetap ada saat navigasi halaman
        $anjuran->appends(['search' => $search, 'entries' => $entries]);

        return view('obat.master.anjuranMinum.index', compact('anjuran', 'search', 'entries'));
    }

    public function updateStatus(Request $request)
    {
        $anjuranId = $request->input('id');
        $isChecked = $request->has('status');

        $anjuran = Anjuran::findOrFail($anjuranId);
        // dd($anjuran);
        $anjuran->status = $isChecked;
        $anjuran->save();

        return redirect()->back()->with('status', 'Status updated successfully');
    }

    public function tambah(Request $request)
    {
        $data = [
            'kode_anjuran' => $request->kode_anjuran,
            'golongan' => $request->golongan,
            'status' => $request->status,
        ];

        Anjuran::create($data);

        return redirect()->route('apoteker.master-anjuran')->with('success', 'Data berhasil ditambah!');
    }

    public function edit(Request $request, $id)
    {
        $data = [
            'kode_anjuran' => $request->kode_anjuran,
            'golongan' => $request->golongan,
            'status' => $request->status,
        ];

        Anjuran::findOrFail($id)->update($data);

        return redirect()->route('apoteker.master-anjuran')->with('success', 'Data berhasil diubah!');
    }

    public function hapus($id)
    {
        Anjuran::destroy($id);

        return redirect()->route('apoteker.master-anjuran')->with('success', 'Data berhasil dihapus!');
    }
}
