<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TtdMedis extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nama',
        'foto',
    ];

    public function datadokter()
    {
        return $this->belongsTo(DataDokter::class, 'id');
    }
}
