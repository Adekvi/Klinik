<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasienSehat extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function pasien ()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }
}
