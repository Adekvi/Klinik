<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $fillable = [
        'no_rm',
        'nik',
        'nama_kk',
        'nama_pasien',
        'tgllahir',
        'alamat',
        'noHP',
        'jenis_bayar',
        'bpjs',
        'status'
    ];


    public function rm_da () 
    {
        return $this->hasMany(RmDa1::class, 'id');
    }
    public function isian () 
    {
        return $this->hasMany(IsianPerawat::class, 'id');
    }
}
