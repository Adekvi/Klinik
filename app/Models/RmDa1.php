<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmDa1 extends Model
{
    protected $guarded = [];

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
    public function soap()
    {
        return $this->hasMany(Soap::class, 'id');
    }
    public function isian()
    {
        return $this->hasMany(IsianPerawat::class, 'id');
    }
    public function antrianDokter()
    {
        return $this->hasMany(AntrianDokter::class, 'id');
    }
    public function antrianPerawat()
    {
        return $this->hasMany(AntrianPerawat::class, 'id');
    }

    public function ttd()
    {
        return $this->belongsTo(TtdMedis::class, 'id_ttd_medis');
    }

    public function kasir()
    {
        return $this->hasMany(Kasir::class, 'id');
    }
}
