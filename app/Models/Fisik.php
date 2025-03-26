<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fisik extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_dokter',
        'id_pasien',
        'depan',
        'samping',
        'belakang',
        'gigi',
        'tanggal',
        'no_gigi',
        'keterangan',
    ];

    // AntrianDokter.php
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking');
    }

    // Booking.php
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }

    public function antrianDokter()
    {
        return $this->belongsTo(AntrianDokter::class, 'id');
    }
}
