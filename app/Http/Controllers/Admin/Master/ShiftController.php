<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shift = Shift::all();

        // dd($shift);

        return view('admin.master.datashift.index', compact('shift'));
    }

    public function updateStatus(Request $request)
    {
        $shift = Shift::findOrFail($request->id);
        $shift->status = $request->has('status') ? 'Aktif' : 'Nonaktif';
        $shift->save();

        return redirect()->back()->with('status', 'Status updated successfully');
    }

    public function tambah(Request $request)
    {
        $data = [
            'nama_shift' => $request->nama_shift,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $request->status,
        ];

        Shift::create($data);

        return redirect()->route('master-shift')->with('toast_success', 'Data berhasil disimpan');
    }

    public function edit(Request $request, $id)
    {
        $data = [
            'nama_shift' => $request->nama_shift,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $request->status,
        ];

        // dd($data);

        Shift::findOrFail($id)->update($data);

        return redirect()->route('master-shift')->with('toast_success', 'Data berhasil diubah');
    }

    public function hapus($id)
    {
        Shift::destroy($id);

        return redirect()->route('master-shift')->with('toast_success', 'Data berhasil dihapus');
    }
}
