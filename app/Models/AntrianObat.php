<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntrianObat extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function soap ()
    {
        return $this->belongsTo(Soap::class, 'id_soap','id');
    }
    public function booking ()
    {
        return $this->belongsTo(Booking::class, 'id_booking','id');
    }
    public function obat ()
    {
        return $this->belongsTo(Obat::class, 'id_obat','id');
    }
}
