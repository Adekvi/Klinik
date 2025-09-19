<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aturan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function soap()
    {
        return $this->belongsToMany(Soap::class, 'soap_p_aturans', 'aturan_id', 'soap_id');
    }
}
