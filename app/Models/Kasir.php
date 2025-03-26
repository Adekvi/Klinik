<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id');
    }
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli', 'KdPoli');
    }
    public function dokter()
    {
        return $this->belongsTo(DataDokter::class, 'id_dokter', 'id');
    }
    public function rm()
    {
        return $this->belongsTo(RmDa1::class, 'id_rm', 'id');
    }
    public function isian()
    {
        return $this->belongsTo(IsianPerawat::class, 'id_isian', 'id');
    }
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat', 'id');
    }
    public function antrianPerawat()
    {
        return $this->hasMany(AntrianPerawat::class, 'id');
    }
    public function soap()
    {
        return $this->belongsTo(Soap::class, 'id');
    }
    public function resep()
    {
        return $this->belongsTo(Resep::class, 'id');
    }

    public function ppn()
    {
        return $this->belongsTo(ppnPajak::class, 'id');
    }
}
