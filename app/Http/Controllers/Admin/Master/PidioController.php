<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Pidio;
use Illuminate\Http\Request;

class PidioController extends Controller
{
    public  function index()
    {
        $pidio = Pidio::paginate(10);
        return view('admin.master.pidio.index', compact('pidio'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'vidio' => 'required|mimes:mp4,avi,mov,wmv', // Sesuaikan dengan jenis file video yang diterima
            'tgl' => 'required',

            ], [
            'judul.required' => 'Judul belum diisi',
            'vidio.required' => 'File video harus diunggah.',
            'vidio.mimes' => 'Format video yang diterima: mp4, avi, mov, wmv.',
        ]);

        $videoPath = $request->file('vidio')->store('vidio', 'public');

        $data = ([
            'judul' => $request->input('judul'),
            'tgl' => $request->input('tgl'),
            'vidio' => $videoPath,
        ]);
        Pidio::create($data);
        return redirect()->route('admin.pidio')->with('toast_success', 'Video berhasil diunggah!');
    }

    public function destroy($id)
    {
        Pidio::destroy($id);
        return redirect()->route('admin.pidio', 'id')->with('toast_success', 'Vidio berhasil dihapus!');
        
    }
}
