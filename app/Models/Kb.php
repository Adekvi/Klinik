<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kb extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function isian()
    {
        return $this->belongsTo(IsianPerawat::class, 'id');
    }
}
