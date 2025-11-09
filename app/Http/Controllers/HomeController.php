<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Pidio;
use App\Models\Poli;
use App\Models\Poto;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        return view('pasien.index');
    }

    public function depan()
    {
        $poto = Cache::remember('poto_homepage', 60, function () {
            return Poto::latest()->paginate(5);
        });

        $pidio = Cache::remember('pidio_homepage', 60, function () {
            return Pidio::latest()->paginate(5);
        });

        $poli = Cache::remember('poli_all', 3600, function () {
            return Poli::all();
        });

        return view('index', compact('poto', 'pidio', 'poli'));
    }
}
