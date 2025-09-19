<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soap_p_aturan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function aturan()
    {
        return $this->belongsTo(Aturan::class, 'aturan_id', 'id');
    }

    public function soap()
    {
        return $this->belongsTo(Soap::class, 'id_soap', 'id');
    }
}
