<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soap extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function pasien () 
    {
        return $this->belongsTo(Pasien::class, 'pasien', 'id');
    }
    public function poli () 
    {
        return $this->belongsTo(Poli::class, 'poli','KdPoli');
    }
    public function rm_da () 
    {
        return $this->belongsTo(RmDa1::class, 'rm_da','id');
    }
    public function diagnosa () 
    {
        return $this->belongsTo(Diagnosa::class, 'diagnosa', 'id');
    }
    public function resep () 
    {
        return $this->belongsTo(Resep::class, 'resep','id');
    }
}
