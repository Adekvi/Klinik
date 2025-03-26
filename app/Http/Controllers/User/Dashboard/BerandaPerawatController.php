<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaPerawatController extends Controller
{
    public function index()
    {
        // Mengecek apakah pengguna sudah login
        if (Auth::check()) {
            // Menyimpan status aktif di session jika login
            session(['perawat_active' => true]);
        } else {
            // Menyimpan status tidak aktif di session jika tidak login
            session(['perawat_active' => false]);
        }

        return view('dashboard');
    }
}
