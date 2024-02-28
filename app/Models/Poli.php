<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $guarded = [];

    public function rm_da () 
    {
        return $this->hasMany(RmDa1::class, 'id');
    }
    public function isian () 
    {
        return $this->hasMany(IsianPerawat::class, 'id');
    }
}
