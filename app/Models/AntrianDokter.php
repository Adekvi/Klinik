<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntrianDokter extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function booking ()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id');
    }
    public function poli ()
    {
        return $this->belongsTo(Poli::class, 'id_poli','KdPoli');
    }
    public function rm ()
    {
        return $this->belongsTo(RmDa1::class, 'id_rm', 'id');
    }
    public function isian ()
    {
        return $this->belongsTo(IsianPerawat::class, 'id_isian', 'id');
    }

    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($antrianDokter) {
    //         $status = $antrianDokter->status;

    //         // Mendapatkan nomor antrian terakhir berdasarkan status
    //         $lastQueue = AntrianDokter::where('status', $status)->latest()->first();

    //         if ($lastQueue) {
    //             $lastNumber = $lastQueue->number + 1;
    //         } else {
    //             $lastNumber = 1;
    //         }

    //         // Menentukan kode_antrian berdasarkan status
    //         $kodeAntrianPrefix = 'A'; // Bisa disesuaikan dengan kebutuhan
    //         $antrianDokter->kode_antrian = $kodeAntrianPrefix . str_pad($lastNumber, 3, '0', STR_PAD_LEFT); // Mengubah panjang menjadi 3
    //         $antrianDokter->number = $lastNumber;
    //     });
    // }
    public static function boot()
    {
        parent::boot();

        static::creating(function ($antrianDokter) {
            // Mendapatkan nomor antrian terakhir untuk hari ini
            $lastQueueToday = AntrianDokter::whereDate('created_at', now())
                ->whereNotNull('number')
                ->latest()
                ->first();

            // Mendefinisikan hari besok
            $tomorrow = now()->addDay();

            // Mendapatkan nomor antrian terakhir untuk besok
            $lastQueueTomorrow = AntrianDokter::whereDate('created_at', $tomorrow)
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

            // Menentukan kode_antrian berdasarkan status
            $kodeAntrianPrefix = 'D'; // Bisa disesuaikan dengan kebutuhan
            $antrianDokter->kode_antrian = $kodeAntrianPrefix . str_pad($lastNumber, 3, '0', STR_PAD_LEFT); // Mengubah panjang menjadi 3
            $antrianDokter->number = $lastNumber;
        });
    }

}
