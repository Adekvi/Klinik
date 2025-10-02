<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'KdPoli';

    public function dokter()
    {
        return $this->hasMany(DataDokter::class, 'id');
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
    public function antrianDokter()
    {
        return $this->hasMany(AntrianDokter::class, 'id');
    }
    public function antrianPerawat()
    {
        return $this->hasMany(AntrianPerawat::class, 'id');
    }
    public function kasir()
    {
        return $this->hasMany(Kasir::class, 'id');
    }
    public function obat()
    {
        return $this->hasMany(Obat::class, 'id');
    }
    public function kunjungan()
    {
        return $this->hasMany(Kunjpasien::class, 'id');
    }
}
