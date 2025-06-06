<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordStok extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function resep()
    {
        return $this->belongsTo(Resep::class, 'id_obat', 'id');
    }
}
