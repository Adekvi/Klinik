<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $fillable = [
        'id',
        'no_rm',
        'number',
        'nama_pasien',
        'nik',
        'nama_kk',
        'tgllahir',
        'jekel',
        'alamat_asal',
        'domisili',
        'noHP',
        'jenis_pasien',
        'bpjs',
        'pekerjaan',
        'kode_antrian',
        'kategori',
        'status',
    ];

    public function getUploadStatusAttribute()
    {
        $createdAt = Carbon::parse($this->created_at);
        return $createdAt->diffForHumans();
    }

    public function booking()
    {
        return $this->hasMany(Booking::class, 'id');
    }
    public function pasienSehat()
    {
        return $this->hasMany(PasienSehat::class, 'id');
    }
    public function rm_da()
    {
        return $this->hasMany(RmDa1::class, 'id');
    }
    public function isian()
    {
        return $this->hasMany(IsianPerawat::class, 'id');
    }
    public function soap()
    {
        return $this->hasMany(Soap::class, 'id');
    }
    public function obat()
    {
        return $this->hasMany(AntrianPerawat::class, 'id');
    }
    public function kasir()
    {
        return $this->hasMany(Kasir::class, 'id');
    }

    public function fisik()
    {
        return $this->hasMany(Fisik::class, 'id_pasien', 'id');
    }
}
