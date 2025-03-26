<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDokter extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class, 'id');
    }
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli', 'KdPoli');
    }
    public function antrianPerawat()
    {
        return $this->hasMany(AntrianPerawat::class, 'id');
    }
    public function rmda()
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
    public function ttdMedis()
    {
        return $this->hasMany(TtdMedis::class, 'id');
    }
    public function kasir()
    {
        return $this->hasMany(Kasir::class, 'id');
    }
}
