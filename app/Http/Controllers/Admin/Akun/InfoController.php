<?php

namespace App\Http\Controllers\Admin\Akun;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class InfoController extends Controller
{
    public function index()
    {
        // Ambil informasi user-agent
        $userAgent = request()->header('User-Agent');

        // Gunakan library atau parsing untuk mendapatkan informasi perangkat
        $deviceInfo = $this->getDeviceInfo($userAgent);

        return view('admin.profil.info', compact('deviceInfo'));
    }

    public function controlUser(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        // Mulai query
        $query = User::whereIn('role', ['perawat', 'dokter', 'kasir', 'apoteker']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%")
                    ->orWhere('role', 'LIKE', "%{$search}%");
            });
        }

        // Baru di paginate setelah filtering selesai
        $akses = $query->orderBy('id', 'asc')->paginate($entries, ['*'], 'page', $page);
        $akses->appends([
            'search' => $search,
            'entries' => $entries,
            'page' => $page,
        ]);

        // Loop untuk kasih status online ke tiap user
        foreach ($akses as $user) {
            $user->is_online = Cache::has('user-is-online-' . $user->id);
            $user->last_seen = Cache::get('user-is-online-' . $user->id);
        }

        return view('admin.master.kelolaakses.index', compact('akses'));
    }

    // Fungsi untuk mem-parsing informasi perangkat dari user-agent
    private function getDeviceInfo($userAgent)
    {
        // Cek dan parsing user-agent untuk informasi perangkat dan sistem operasi
        if (preg_match('/mobile/i', $userAgent)) {
            $device = 'Mobile';
        } else {
            $device = 'Desktop';
        }

        if (preg_match('/Windows/i', $userAgent)) {
            $os = 'Windows';
        } elseif (preg_match('/Macintosh/i', $userAgent)) {
            $os = 'MacOS';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $os = 'Android';
        } elseif (preg_match('/iPhone/i', $userAgent)) {
            $os = 'iOS';
        } else {
            $os = 'Unknown';
        }

        return [
            'device' => $device,
            'os' => $os,
            'userAgent' => $userAgent,
        ];
    }
}
