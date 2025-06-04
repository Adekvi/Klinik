<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }
    public function soap()
    {
        return $this->hasMany(Soap::class, 'id_booking', 'id');
    }
    public function rm_da()
    {
        return $this->hasMany(RmDa1::class, 'id');
    }
    public function isian()
    {
        return $this->hasMany(IsianPerawat::class, 'id');
    }
    public function antrianPerawat()
    {
        return $this->hasMany(AntrianPerawat::class, 'id');
    }
    public function antrianDokter()
    {
        return $this->hasMany(AntrianDokter::class, 'id');
    }
    // public function soap()
    // {
    //     return $this->hasMany(Soap::class, 'id');
    // }
    public function obat()
    {
        return $this->hasMany(Obat::class, 'id');
    }
    public function kasir()
    {
        return $this->hasMany(Kasir::class, 'id');
    }

    public function fisik()
    {
        return $this->hasMany(Fisik::class, 'id_booking', 'id');
    }
}
