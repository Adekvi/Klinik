<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function kasir()
    {
        return $this->hasMany(Kasir::class, 'id');
    }

    public function record()
    {
        return $this->hasMany(RecordStok::class, 'id_obat');
    }

    public function margin()
    {
        return $this->belongsTo(Margin::class, 'id_margin');
    }

    // margin dinamis untuk menentukan harga_jual pada tabel resep
    public function getHargaJualAttribute()
    {
        if ($this->margin && $this->harga_pokok) {
            // Hitung harga jual berdasarkan margin terkini
            return $this->harga_pokok * (1 + $this->margin->margin / 100);
        }

        return null; // Nilai default jika margin atau harga_pokok tidak tersedia
    }

    public function soap()
    {
        return $this->belongsToMany(Soap::class, 'soap_p_obats', 'obat_id', 'soap_id');
    }
    public function details()
    {
        return $this->hasMany(ResepDetail::class, 'resep_id');
    }
}
