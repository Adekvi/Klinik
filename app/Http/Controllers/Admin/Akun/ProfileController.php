<?php

namespace App\Http\Controllers\Admin\Akun;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $profil = Auth::user();
        // dd($profil);

        return view('admin.profil.myprofil', compact('profil'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ];

        // Password jika diisi
        if ($request->filled('password')) {
            $data['password'] = $request->password;
            // $data['password'] = bcrypt($request->password);
        }

        // Upload foto
        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if ($user->foto && file_exists(storage_path('app/public/profile/' . $user->foto))) {
                unlink(storage_path('app/public/profile/' . $user->foto));
            }

            // Simpan foto baru
            $originalName = $request->file('foto')->getClientOriginalName();
            $fotoPath = $request->file('foto')->storeAs('profile', $originalName, 'public');

            // Simpan path ke DB
            $data['foto'] = $fotoPath;
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

}
