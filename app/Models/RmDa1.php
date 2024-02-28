<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmDa1 extends Model
{
    protected $guarded = [];

    public function pasien () 
    {
        return $this->belongsTo(Pasien::class, 'pasien', 'id');
    }
    public function poli () 
    {
        return $this->belongsTo(Poli::class, 'poli','KdPoli');
    }
    public function soap () 
    {
        return $this->hasMany(Soap::class, 'id');
    }
}
