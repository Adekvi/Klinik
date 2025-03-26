<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id');
    }
    public function soap()
    {
        return $this->belongsTo(Soap::class, 'id_soap', 'id');
    }
    public function resep()
    {
        return $this->belongsTo(Resep::class, 'id');
    }
    public function antrianPerawat()
    {
        return $this->hasMany(AntrianPerawat::class, 'id');
    }
    public function kasir()
    {
        return $this->hasMany(Kasir::class, 'id_obat', 'id');
    }
    public function isian()
    {
        return $this->belongsTo(IsianPerawat::class, 'id_isian', 'id');
    }
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli', 'KdPoli');
    }
}
