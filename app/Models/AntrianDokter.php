<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntrianDokter extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id');
    }
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli', 'KdPoli');
    }
    public function rm()
    {
        return $this->belongsTo(RmDa1::class, 'id_rm', 'id');
    }
    public function isian()
    {
        return $this->belongsTo(IsianPerawat::class, 'id_isian', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($antrianPerawat) {
            // Mendapatkan nomor antrian terakhir untuk hari ini
            $lastQueueToday = AntrianPerawat::whereDate('created_at', now())
                ->whereNotNull('number')
                ->latest()
                ->first();

            // Mendefinisikan hari besok
            $tomorrow = now()->addDay();

            // Mendapatkan nomor antrian terakhir untuk besok
            $lastQueueTomorrow = AntrianPerawat::whereDate('created_at', $tomorrow)
                ->whereNotNull('number')
                ->latest()
                ->first();

            if ($lastQueueToday) {
                $lastNumber = $lastQueueToday->number + 1;
            } elseif ($lastQueueTomorrow) {
                $lastNumber = 1; // Reset nomor antrian untuk besok

                // Setel nomor antrian untuk besok menjadi 1
                $lastQueueTomorrow->update(['number' => $lastNumber]);
            } else {
                // Jika tidak ada nomor antrian hari ini atau besok, nomor antrian tetap berlanjut
                $lastNumber = 1;
            }

            // Menentukan kode_antrian berdasarkan id_poli
            $poli = $antrianPerawat->id_poli; // Anda perlu menyesuaikan ini dengan hubungan antara AntrianPerawat dan Poli
            $kodeAntrianPrefix = ($poli == 1) ? 'A' : 'B'; // Misalnya, Anda bisa menggunakan id poli tertentu untuk menentukan prefiks

            $antrianPerawat->kode_antrian = $kodeAntrianPrefix . str_pad($lastNumber, 3, '0', STR_PAD_LEFT); // Mengubah panjang menjadi 3
            $antrianPerawat->number = $lastNumber;
        });
    }
}
