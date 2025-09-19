<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anjuran extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function soap()
    {
        return $this->belongsToMany(Soap::class, 'soap_p_anjurans', 'anjuran_id', 'soap_id');
    }

    public function obat()
    {
        return $this->hasMany(Obat::class, 'id_anjuran', 'id');
    }
}
