<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Aturan;
use Illuminate\Http\Request;

class DataAturanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = Aturan::orderBy('id', 'asc');

        if ($search) {
            $query->where('aturan_minum', 'LIKE', "%{$search}%")
                ->orWhere('takaran', 'LIKE', "%{$search}%")
                ->orWhere('keterangan', 'LIKE', "%{$search}%");
        }

        // Paginasi dengan jumlah entri yang dipilih
        $aturan = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);

        // Menjaga parameter pencarian tetap ada saat navigasi halaman
        $aturan->appends(['search' => $search, 'entries' => $entries]);

        // dd($aturan);

        return view('admin.master.dataaturan.index', compact('aturan', 'entries', 'search'));
    }

    public function updateStatus(Request $request)
    {
        $aturanId = $request->input('id');
        $isChecked = $request->has('status');

        $aturan = Aturan::findOrFail($aturanId);
        
        // Simpan sebagai string Aktif / Nonaktif
        $aturan->status = $isChecked ? 'Aktif' : 'Nonaktif';
        $aturan->save();

        return redirect()->back()->with('status', 'Status updated successfully');
    }

    public function tambah(Request $request)
    {
        $data = [
            'aturan_minum' => $request->aturan_minum,
            'takaran' => $request->takaran,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ];

        Aturan::create($data);

        return redirect()->route('master-aturan')->with('success', 'Data berhasil ditambah!');
    }

    public function edit(Request $request, $id)
    {
        $data = [
            'aturan_minum' => $request->aturan_minum,
            'takaran' => $request->takaran,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ];

        Aturan::findOrFail($id)->update($data);

        return redirect()->route('master-aturan')->with('success', 'Data berhasil diubah!');
    }

    public function hapus($id)
    {
        Aturan::destroy($id);

        return redirect()->route('master-aturan')->with('success', 'Data berhasil dihapus!');
    }
}
