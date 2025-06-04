<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fisik extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dokter()
    {
        return $this->belongsTo(DataDokter::class, 'id_dokter', 'id');
    }

    // Booking.php
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id');
    }

    public function rm()
    {
        return $this->belongsTo(RmDa1::class, 'id_rm', 'id');
    }

    public function isian()
    {
        return $this->belongsTo(IsianPerawat::class, 'id_isian', 'id');
    }

    public function antrianDokter()
    {
        return $this->belongsTo(AntrianPerawat::class, 'id');
    }

    public function soap()
    {
        return $this->hasMany(Soap::class, 'id');
    }
}
