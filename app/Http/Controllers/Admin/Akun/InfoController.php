<?php

namespace App\Http\Controllers\Admin\Akun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
