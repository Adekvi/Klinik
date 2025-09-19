<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenisobat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function soap()
    {
        return $this->belongsToMany(Soap::class, 'soap_p_jenis', 'jenis_id', 'soap_id');
    }
}
