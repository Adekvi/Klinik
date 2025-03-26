<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\AntrianPerawat;
use App\Models\Booking;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\RmDa1;
use Illuminate\Http\Request;

class DataPasienController extends Controller
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

    public function store(Request $request)
    {
        $poli = $request->poli;
        // dd($poli);
        $data = [
            'no_rm' => $request->no_rm,
            'nik' => $request->nik,
            'nama_kk' => $request->nama_kk,
            'nama_pasien' => $request->nama_pasien,
            'tgllahir' => $request->tgllahir,
            'alamat' => $request->alamat,
            'noHP' => $request->noHP,
            'jenis_pasien' => $request->jenis_bayar,
            'bpjs' => $request->bpjs,
            'pekerjaan' => $request->pekerjaan,
        ];
        // dd($data);
        $pasien = Pasien::create($data);
        $IdPasien = $pasien->id;
        $PasienId = Pasien::find($IdPasien);
        // dd($PasienId);
        $bookingData = [
            'id_pasien' => $PasienId->id,
            'no_rm' => $request->no_rm,
        ];
        $booking = Booking::create($bookingData);
        $IdBooking = $booking->id;
        $BookingId = Booking::find($IdBooking);
        $antrian = [
            'id_booking' => $BookingId->id,
            'status' => 'D'
        ];
        AntrianPerawat::create($antrian);

        $bookingData['id'] = $BookingId->id;
        $dataPoli = [
            'id_pasien' => $PasienId->id,
            'id_booking' => $BookingId->id,
            'id_poli' => $poli,
        ];
        RmDa1::create($dataPoli);
        // return response()->json(['booking' => $bookingData, 'idBooking' => $IdBooking]);
        return redirect()->route('master.pasienumum', 'perawat.index')->with('toast_success', 'Data Pasien Berhasil ditambahkan');
    }
    public function delete($id)
    {
        Pasien::destroy($id);
        return redirect()->route('master.pasienumum', 'id')->with('toast_success', 'Data Berhasil dihapus');
    }

    // pasien BPJS
    public function bpjs(Request $request)
    {
        $poli = Poli::all();

        $search = $request->input('search');
        $entries = $request->input('entries', 10); // Default 10
        $page = $request->input('page', 1);

        // Query hanya pasien dengan jenis_pasien = 'Umum'
        $query = Pasien::where('jenis_pasien', 'Bpjs');

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

        return view('admin.master.pasienbpjs.index', compact('pasien', 'poli', 'search', 'entries'));
    }

    public function tambah(Request $request)
    {
        $poli = $request->poli;
        $data = [
            'no_rm' => $request->no_rm,
            'nik' => $request->nik,
            'nama_kk' => $request->nama_kk,
            'nama_pasien' => $request->nama_pasien,
            'tgllahir' => $request->tgllahir,
            'alamat' => $request->alamat,
            'noHP' => $request->noHP,
            'jenis_pasien' => $request->jenis_bayar,
            'bpjs' => $request->bpjs,
            'pekerjaan' => $request->pekerjaan,
        ];
        $pasien = Pasien::create($data);
        $IdPasien = $pasien->id;
        $PasienId = Pasien::find($IdPasien);
        // dd($PasienId);
        $bookingData = [
            'id_pasien' => $PasienId->id,
            'no_rm' => $request->no_rm,
        ];
        $booking = Booking::create($bookingData);
        $IdBooking = $booking->id;
        $BookingId = Booking::find($IdBooking);
        $antrian = [
            'id_booking' => $BookingId->id,
            'status' => 'D'
        ];
        AntrianPerawat::create($antrian);

        $bookingData['id'] = $BookingId->id;
        $dataPoli = [
            'id_pasien' => $PasienId->id,
            'id_booking' => $BookingId->id,
            'id_poli' => $poli,
        ];
        RmDa1::create($dataPoli);

        // $bookingData['id'] = $BookingId->id;
        return redirect()->route('master.pasienbpjs', 'perawat.index')->with('toast_success', 'Data Pasien Berhasil ditambahkan');
    }
    public function hapus($id)
    {
        Pasien::destroy($id);
        return redirect()->route('master.pasienbpjs', 'id')->with('toast_success', 'Data Berhasil dihapus');
    }
}
