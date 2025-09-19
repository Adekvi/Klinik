<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soap_p_anjuran extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function anjuran()
    {
        return $this->belongsTo(Anjuran::class, 'anjuran_id', 'id');
    }

    public function soap()
    {
        return $this->belongsTo(Soap::class, 'id_soap', 'id');
    }
}
