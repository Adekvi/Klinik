<?php

namespace App\Http\Controllers\Admin\Kunjungan;

use App\Http\Controllers\Controller;
use App\Models\AntrianPerawat;
use App\Models\Booking;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\RmDa1;
use App\Models\Soap;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    public function pasienUmum()
    {
        $poli = Poli::all();
        $booking = Soap::with(['pasien', 'poli', 'dokter', 'rm', 'isian'])->where('id_poli', 1)->get();
        // dd($book);
        $diagnosaPrimer = [];
        $diagnosaSekunder = [];
        $resep = [];

        if (!empty($booking)) {
            $diagnosaPrimer = json_decode($booking[0]['soap_a_primer'], true);
            $diagnosaSekunder = json_decode($booking[0]['soap_a_sekunder'], true);
            $resep = json_decode($booking[0]['soap_p'], true);
        }

        return view('admin.pasien-umum', compact('booking', 'poli','diagnosaPrimer', 'diagnosaSekunder', 'resep'));
    }
    public function pasienBpjs()
    {
        // $booking = RmDa1::with(['pasien', 'booking', 'isian', 'soap'])->where('id_poli', 1)->get()->toArray();
        $poli = Poli::all();
        $booking = Soap::with(['pasien', 'poli', 'dokter', 'rm', 'isian'])->where('id_poli', 1)->get();
        // dd($book);
        $diagnosaPrimer = [];
        $diagnosaSekunder = [];
        $resep = [];

        if (!empty($booking)) {
            $diagnosaPrimer = json_decode($booking[0]['soap_a_primer'], true);
            $diagnosaSekunder = json_decode($booking[0]['soap_a_sekunder'], true);
            $resep = json_decode($booking[0]['soap_p'], true);
        }
        return view('admin.pasien-bpjs', compact('booking', 'poli','diagnosaPrimer', 'diagnosaSekunder', 'resep'));
    }
    public function gigiUmum()
    {
        // $booking = RmDa1::with(['pasien', 'booking', 'isian', 'soap'])->where('id_poli', 1)->get()->toArray();
        $poli = Poli::all();
        $booking = Soap::with(['pasien', 'poli', 'dokter', 'rm', 'isian'])->where('id_poli', 2)->get();
        // dd($book);
        $diagnosaPrimer = [];
        $diagnosaSekunder = [];
        $resep = [];

        // if (!empty($booking)) {
        //     $diagnosaPrimer = json_decode($booking[0]['soap_a_primer'], true);
        //     $diagnosaSekunder = json_decode($booking[0]['soap_a_sekunder'], true);
        //     $resep = json_decode($booking[0]['soap_p'], true);
        // }
        return view('admin.gigi-umum', compact('booking', 'poli','diagnosaPrimer', 'diagnosaSekunder', 'resep'));
    }
    public function gigiBpjs()
    {
        // $booking = RmDa1::with(['pasien', 'booking', 'isian', 'soap'])->where('id_poli', 1)->get()->toArray();
        $poli = Poli::all();
        $booking = Soap::with(['pasien', 'poli', 'dokter', 'rm', 'isian'])->where('id_poli', 2)->get();
        // dd($book);
        $diagnosaPrimer = [];
        $diagnosaSekunder = [];
        $resep = [];

        // if (!empty($booking)) {
        //     $diagnosaPrimer = json_decode($booking[0]['soap_a_primer'], true);
        //     $diagnosaSekunder = json_decode($booking[0]['soap_a_sekunder'], true);
        //     $resep = json_decode($booking[0]['soap_p'], true);
        // };
        return view('admin.gigi-bpjs', compact('booking', 'poli','diagnosaPrimer', 'diagnosaSekunder', 'resep'));
    }
    public function delete($id)
    {
        RmDa1::destroy($id);
        return redirect()->route('admin.gigi-bpjs', 'id')->with('toast_success', 'Data Berhasil dihapus');
    }
}
