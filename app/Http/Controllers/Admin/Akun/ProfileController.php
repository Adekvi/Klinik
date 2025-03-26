<?php

namespace App\Http\Controllers\Admin\Akun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $profil = Auth::user();

        return view('admin.profil.myprofil', compact('profil'));
    }
}
