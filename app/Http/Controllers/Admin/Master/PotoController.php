<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Poto;
use Illuminate\Http\Request;

class PotoController extends Controller
{
    public  function index()
    {
        $poto = Poto::paginate(10);
        return view('admin.master.poto.index', compact('poto'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'tgl' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Simpan gambar ke storage publik
        $fotoPath = $request->file('foto')->store('foto', 'public');

        // Buat data baru
        $data = [
            'judul' => $request->input('judul'),
            'tgl' => $request->input('tgl'),
            'foto' => $fotoPath,
        ];

        // Simpan data ke database
        Poto::create($data);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.poto')->with('toast_success', 'Foto berhasil diunggah!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tgl' => 'required',
            'judul' => 'required',
        ]);

        $fotoPath = $request->file('foto')->store('foto', 'public');

        $data = [
            'tgl' => $request->tgl,
            'judul' => $request->linkmaps,
            'foto' => $fotoPath,
        ];

        Poto::find($id)->update($data);
        return redirect()->route('admin.poto', 'id')->with('toast_success', 'Foto berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Poto::destroy($id);
        return redirect()->route('admin.poto', 'id')->with('toast_success', 'Foto berhasil dihapus!');
    }
}
