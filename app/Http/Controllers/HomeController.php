<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Pidio;
use App\Models\Poli;
use App\Models\Poto;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('pasien.index');
    }

    public function depan()
    {
        $poto = Poto::paginate(5);
        $pidio = Pidio::paginate(5);
        $poli = Poli::all();
        return view('index', compact('poto', 'pidio', 'poli'));
    }
}
