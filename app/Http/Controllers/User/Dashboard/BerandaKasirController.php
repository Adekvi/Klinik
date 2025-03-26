<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AntrianPerawat;
use App\Models\Kasir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaKasirController extends Controller
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

    public function check(Request $request)
    {
        $kasir = Kasir::with(['booking', 'antrianPerawat', 'resep'])->get();

        $search = $request->input('search');
        $entries = $request->input('entries', 10); // Default 10
        $page = $request->input('page', 1);

        $query = AntrianPerawat::with(['booking.pasien', 'isian', 'rm', 'obat.soap', 'poli', 'pasien'])
            ->where('status', 'U')
            ->orderBy('urutan', 'asc');

        if ($search) {
            $query->whereHas('booking.pasien', function ($q) use ($search) {
                $q->where('nama_pasien', 'LIKE', "%{$search}%")
                    ->orWhere('no_rm', 'LIKE', "%{$search}%");
            });
        }

        // Paginasi dengan jumlah entri yang dipilih
        $antrianKasir = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);

        // Menjaga parameter pencarian tetap ada saat navigasi halaman
        $antrianKasir->appends(['search' => $search, 'entries' => $entries]);

        // dd($antrianKasir);
        // dd($kasir);

        return view('kasir.check.index', compact(
            'antrianKasir',
            'kasir',
            'search',
            'entries',
        ));
    }
}
