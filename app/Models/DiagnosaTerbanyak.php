<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosaTerbanyak extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function diagno()
    {
        return $this->belongsTo(Diagnosa::class, 'id_diagnosa');
    }
}
