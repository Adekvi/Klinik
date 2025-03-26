<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\DataDokter;
use App\Models\User;
use Illuminate\Http\Request;

class AksesController extends Controller
{
    public function index(){

        $akses = User::where('role', 'user')->get();

        dd($akses);
        return view('admin.master.kelolaakses.index', compact('akses'));
    }
}
