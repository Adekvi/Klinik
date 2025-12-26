<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmKehamilan extends Model
{
    use HasFactory;

    protected $table = 'rm_kehamilans';

    protected $fillable = [
        'id_pasien',
        'id_booking',
        'id_antrian_perawat',
        'id_isian_perawat',
        'id_rm',

        // Subyektif
        'kontrasepsi',
        'kontrasepsi_lainnya',
        'riwayat_kehamilan',
        'status_psikososial',

        // Kehamilan sekarang
        'hpht',
        'usia_kehamilan',
        'riwayat_menstruasi',

        // Objektif
        'status_generalis',
        'status_kebidanan',
        'status_gizi',
    ];

    protected $casts = [
        'kontrasepsi' => 'array',
        'riwayat_kehamilan' => 'array',
        'status_psikososial' => 'array',
        'riwayat_menstruasi' => 'array',
        'status_generalis' => 'array',
        'status_kebidanan' => 'array',
        'status_gizi' => 'array',
        'hpht' => 'date',
    ];

    /* ================= RELATION ================= */

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking');
    }

    public function antrianPerawat()
    {
        return $this->belongsTo(AntrianPerawat::class, 'id_antrian_perawat');
    }
}
