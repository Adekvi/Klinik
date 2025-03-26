<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\DataDokter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataUserController extends Controller
{
    public function index()
    {
        $user = User::with('dokter')->get();
        // dd($user);
        $dokter = DataDokter::with('poli')->get();
        return view('admin.master.user.index', compact('user', 'dokter'));
    }
    public function store(Request $request)
    {
        $data = $request->all();
        // Enkripsi password jika peran pengguna bukan 'patient'
        $password = $data['role'] === 'user' ? Hash::make($data['password']) : $data['password'];
        $dokter = DataDokter::where('id', $data['id_dokter'])->first()->toArray();
        // dd($data, $password, $dokter);
        $dataUser = [
            'name' => $dokter['nama_dokter'],
            'username' => $data['username'],
            'id_dokter' => $data['id_dokter'],
            'password' => $password,
            'role' => $data['role']
        ];
        // dd($dataUser);
        User::create($dataUser);
        return redirect()->route('master.user');
    }
    public function edit(Request $request, $id)
    {
        $data = $request->all();
        $password = $data['role'] === 'user' ? Hash::make($data['password']) : $data['password'];
        $user = User::where('id', $id)->first()->toArray();
        $dokter = DataDokter::where('id', $data['name'])->orWhere('nama_dokter', $data['name'])->first();
        // dd($data, $password, $user, $dokter);
        if (!empty($dokter['id'])) {
            $dataUser = [
                'name' => $dokter['nama_dokter'],
                'username' => $data['username'],
                'id_dokter' => $dokter['id'],
                'password' => $password,
                'role' => $data['role']
            ];
            User::where('id', $id)->update($dataUser);
        }else{
            $dataUser = [
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $password,
                'role' => $data['role']
            ];
            User::where('id', $id)->update($dataUser);
        }

        return redirect()->route('master.user');
    }
    public function destroy(Request $request, $id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('master.user');
    }
}
