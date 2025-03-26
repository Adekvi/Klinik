<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pidio extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'tgl',
        'vidio'
    ];
}
