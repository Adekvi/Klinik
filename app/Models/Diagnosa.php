<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function soap()
    {
        return $this->hasMany(Soap::class, 'id');
    }

    public function diagnosa_terbanyak()
    {
        return $this->hasMany(DiagnosaTerbanyak::class, 'id_diagnosa');
    }
}
