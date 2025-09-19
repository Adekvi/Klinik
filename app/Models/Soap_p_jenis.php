<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soap_p_jenis extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jenis()
    {
        return $this->belongsTo(Jenisobat::class, 'jenis_id', 'id');
    }

    public function soap()
    {
        return $this->belongsTo(Soap::class, 'id_soap', 'id');
    }
}
