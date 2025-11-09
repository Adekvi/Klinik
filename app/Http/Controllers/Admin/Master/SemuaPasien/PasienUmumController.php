<?php

namespace App\Http\Controllers\Admin\Master\SemuaPasien;

use App\Http\Controllers\Controller;
use App\Models\AntrianPerawat;
use App\Models\Booking;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\RmDa1;
use Illuminate\Http\Request;

class PasienUmumController extends Controller
{
    public function umum(Request $request)
    {
        $poli = Poli::all();

        $search = $request->input('search');
        $entries = $request->input('entries', 10); // Default 10
        $page = $request->input('page', 1);

        // Query hanya pasien dengan jenis_pasien = 'Umum'
        $query = Pasien::where('jenis_pasien', 'Umum');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_pasien', 'LIKE', "%{$search}%")
                    ->orWhere('nik', 'LIKE', "%{$search}%")
                    ->orWhere('no_rm', 'LIKE', "%{$search}%");
            });
        }

        // Paginasi dengan jumlah entri yang dipilih
        $pasien = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);

        // Menjaga parameter pencarian tetap ada saat navigasi halaman
        $pasien->appends(['search' => $search, 'entries' => $entries]);

        return view('admin.master.pasienumum.index', compact('pasien', 'poli', 'search', 'entries'));
    }

    public function edit(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        // Ambil data lama, lalu hanya update yang diubah
        $data = [
            'no_rm' => $pasien->no_rm, // tetap pakai data lama
            'number' => $pasien->number, // tetap pakai data lama
            'nama_pasien' => $request->nama_pasien ?? $pasien->nama_pasien,
            'nik' => $request->nik ?? $pasien->nik,
            'nama_kk' => $request->nama_kk ?? $pasien->nama_kk,
            'tgllahir' => $request->tgllahir ?? $pasien->tgllahir,
            'jekel' => $request->jekel ?? $pasien->jekel,
            'alamat_asal' => $request->alamat_asal ?? $pasien->alamat_asal,
            'noHP' => $request->noHP ?? $pasien->noHP,
            'domisili' => $request->domisili ?? $pasien->domisili,
            'jenis_pasien' => $pasien->jenis_pasien, // tetap
            'bpjs' => $pasien->bpjs, // tetap
            'pekerjaan' => $request->pekerjaan ?? $pasien->pekerjaan,
        ];

        // dd($data);

        // update ke database
        $pasien->update($data);

        return redirect()->route('master.pasienumum')->with('toast_success', 'Data Pasien Berhasil diubah');
    }
    
    public function delete($id)
    {
        Pasien::destroy($id);
        return redirect()->route('master.pasienumum', 'id')->with('toast_success', 'Data Berhasil dihapus');
    }
}
