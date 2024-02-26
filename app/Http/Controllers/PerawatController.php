<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerawatController extends Controller
{
    public function index ()
    {
        return view('perawat.index');
    }
}
