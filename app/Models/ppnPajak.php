<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ppnPajak extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function antrianPerawat()
    {
        return $this->hasMany(AntrianPerawat::class, 'id');
    }
    public function kasir()
    {
        return $this->hasMany(Kasir::class, 'id');
    }
}
