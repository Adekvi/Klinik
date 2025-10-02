<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjpasien extends Model
{
    use HasFactory;

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
}
