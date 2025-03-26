<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Margin extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function resep()
    {
        return $this->hasMany(Resep::class, 'id_margin');
    }

    protected static function booted()
    {
        static::updated(function ($margin) {
            // Perbarui harga jual di tabel Resep
            Resep::where('id_margin', $margin->id)->get()->each(function ($resep) use ($margin) {
                $resep->harga_jual = $resep->harga_pokok * (1 + $margin->margin / 100);
                $resep->save();
            });
        });
    }
}
