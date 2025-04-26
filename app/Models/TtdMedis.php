<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TtdMedis extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'id',
    //     'id_medis',
    //     'nama',
    //     'foto',
    // ];

    protected $guarded = [];

    public function datadokter()
    {
        return $this->belongsTo(DataDokter::class, 'id');
    }

    public function rm()
    {
        return $this->hasMany(RmDa1::class, 'id_ttd_medis');
    }

    // Model TtdMedis
    public function antrianPerawat()
    {
        return $this->hasMany(AntrianPerawat::class, 'id_ttd_medis'); // foreign key di AntrianPerawat
    }
}
