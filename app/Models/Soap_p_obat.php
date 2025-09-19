<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soap_p_obat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reseps()
    {
        return $this->belongsTo(Resep::class, 'obat_id', 'id');
    }

    public function soap()
    {
        return $this->belongsTo(Soap::class, 'soap_id', 'id');
    }
}
