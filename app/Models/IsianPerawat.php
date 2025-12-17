<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsianPerawat extends Model
{
    protected $guarded = [];

    public function soap()
    {
        return $this->hasMany(Soap::class, 'id');
    }
    public function antrianDokter()
    {
        return $this->hasMany(AntrianDokter::class, 'id');
    }
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id');
    }
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli', 'KdPoli');
    }
    public function dokter()
    {
        return $this->belongsTo(DataDokter::class, 'id_dokter', 'id');
    }
    public function rm_da()
    {
        return $this->belongsTo(RmDa1::class, 'id_rm', 'id');
    }
    public function antrian()
    {
        return $this->belongsTo(AntrianPerawat::class, 'id_booking', 'id_booking');
    }
    public function ttdMedis()
    {
        return $this->belongsTo(TtdMedis::class, 'id');
    }
    public function kasir()
    {
        return $this->hasMany(Kasir::class, 'id');
    }
    public function obat()
    {
        return $this->hasMany(Obat::class, 'id');
    }
    public function fisik()
    {
        return $this->hasMany(Fisik::class, 'id_isian', 'id');
    }
}
