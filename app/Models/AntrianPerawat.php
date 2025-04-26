<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntrianPerawat extends Model
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
    public function dokter()
    {
        return $this->belongsTo(DataDokter::class, 'id_dokter', 'id');
    }
    public function rm()
    {
        return $this->belongsTo(RmDa1::class, 'id_rm', 'id');
    }
    public function isian()
    {
        return $this->belongsTo(IsianPerawat::class, 'id_isian', 'id');
    }
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat', 'id');
    }
    public function soap()
    {
        return $this->belongsTo(Soap::class, 'id_soap', 'id');
    }
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id');
    }
    public function fisik()
    {
        return $this->hasMany(Fisik::class, 'id');
    }
    public function kasir()
    {
        return $this->belongsTo(Kasir::class, 'id');
    }

    // Model AntrianPerawat
    public function ttd()
    {
        return $this->belongsTo(TtdMedis::class, 'id_ttd_medis'); // foreign key di AntrianPerawat
    }

    public function datadokter()
    {
        return $this->belongsTo(DataDokter::class, 'id');
    }
    public function ppn()
    {
        return $this->belongsTo(ppnPajak::class, 'id_ppnPajak');
    }
    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($antrianPerawat) {
    //         $status = $antrianPerawat->status;

    //         // Mendapatkan nomor antrian terakhir berdasarkan status
    //         $lastQueue = AntrianPerawat::where('status', $status)->latest()->first();

    //         if ($lastQueue) {
    //             $lastNumber = $lastQueue->number + 1;
    //         } else {
    //             $lastNumber = 1;
    //         }

    //         // Menentukan kode_antrian berdasarkan status
    //         $kodeAntrianPrefix = 'A'; // Bisa disesuaikan dengan kebutuhan
    //         $antrianPerawat->kode_antrian = $kodeAntrianPrefix . str_pad($lastNumber, 3, '0', STR_PAD_LEFT); // Mengubah panjang menjadi 3
    //         $antrianPerawat->number = $lastNumber;
    //     });
    // }
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
