<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Exports\PemeriksaanHarianExport;
use App\Http\Controllers\Controller;
use App\Models\AntrianPerawat;
use App\Models\Diagnosa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class BerandaPerawatController extends Controller
{
    public function index()
    {
        // Mengecek apakah pengguna sudah login
        if (Auth::check()) {
            // Menyimpan status aktif di session jika login
            session(['perawat_active' => true]);
        } else {
            // Menyimpan status tidak aktif di session jika tidak login
            session(['perawat_active' => false]);
        }

        return view('dashboard');
    }

    public function pemeriksaan(Request $request)
    {
        try {
            // $coba = AntrianPerawat::where('status', 'WB')->get();

            // dd($coba);
            // Ambil input tanggal dari request
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');

            // Inisialisasi query
            $query = AntrianPerawat::with(['booking.pasien', 'obat.soap', 'poli', 'dokter', 'rm', 'isian'])
                ->where('status', 'WB')
                ->orderBy('id', 'asc');

            // dd($query);

            // Filter berdasarkan rentang tanggal
            if ($startDate && $endDate) {
                try {
                    $start = Carbon::parse($startDate)->startOfDay();
                    $end = Carbon::parse($endDate)->endOfDay();
                    if ($end->lt($start)) {
                        return redirect()->back()->with('error', 'Tanggal akhir tidak boleh lebih awal dari tanggal awal.');
                    }
                    $query->whereBetween('created_at', [$start, $end]);
                } catch (\Exception $e) {
                    Log::error('Format tanggal tidak valid: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Format tanggal tidak valid.');
                }
            } else {
                $query->whereDate('created_at', Carbon::today());
            }

            // Paginate hasil query
            $harian = $query->paginate(10);

            // Proses data untuk diagnosa, obat, dan waktu
            $harian->getCollection()->transform(function ($item) {
                // Inisialisasi array untuk kode dan nama diagnosa
                $kdDiagnosa = [];
                $nmDiagnosa = [];

                // Proses diagnosa
                if ($item->obat && $item->obat->soap) {
                    $soap = $item->obat->soap;
                    try {
                        $primer = json_decode($soap->soap_a_primer, true);
                        if (is_array($primer) && !empty($primer)) {
                            foreach ($primer as $nama) {
                                $nama = trim($nama);
                                $diagnosa = Diagnosa::where('nm_diagno', 'LIKE', "%{$nama}%")->first();
                                if ($diagnosa) {
                                    $kdDiagnosa[] = $diagnosa->kd_diagno;
                                    $nmDiagnosa[] = $diagnosa->nm_diagno;
                                } else {
                                    Log::warning("Diagnosa primer tidak ditemukan: {$nama}");
                                    $kdDiagnosa[] = 'Tidak Ditemukan';
                                    $nmDiagnosa[] = $nama;
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error("Gagal parse soap_a_primer: {$soap->soap_a_primer}", ['error' => $e->getMessage()]);
                    }

                    try {
                        $sekunder = json_decode($soap->soap_a_sekunder, true);
                        if (is_array($sekunder) && !empty($sekunder)) {
                            foreach ($sekunder as $nama) {
                                $nama = trim($nama);
                                $diagnosa = Diagnosa::where('nm_diagno', 'LIKE', "%{$nama}%")->first();
                                if ($diagnosa) {
                                    $kdDiagnosa[] = $diagnosa->kd_diagno;
                                    $nmDiagnosa[] = $diagnosa->nm_diagno;
                                } else {
                                    Log::warning("Diagnosa sekunder tidak ditemukan: {$nama}");
                                    $kdDiagnosa[] = 'Tidak Ditemukan';
                                    $nmDiagnosa[] = $nama;
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error("Gagal parse soap_a_sekunder: {$soap->soap_a_sekunder}", ['error' => $e->getMessage()]);
                    }
                }

                $item->kd_diagno = !empty($kdDiagnosa) ? implode(', ', $kdDiagnosa) : 'Tidak ada diagnosa';
                $item->nm_diagno = !empty($nmDiagnosa) ? implode(', ', $nmDiagnosa) : 'Tidak ada diagnosa';

                // Proses data obat
                if ($item->obat) {
                    try {
                        $namaObat = json_decode($item->obat->obat_Ro_namaObatUpdate, true);
                        $item->nama_obat = (is_array($namaObat) && !empty($namaObat)) ? trim($namaObat[0]) : 'Tidak ada obat';
                    } catch (\Exception $e) {
                        Log::error("Gagal parse obat_Ro_namaObatUpdate: {$item->obat->obat_Ro_namaObatUpdate}", ['error' => $e->getMessage()]);
                        $item->nama_obat = 'Tidak ada obat';
                    }

                    try {
                        $hargaTotal = json_decode($item->obat->obat_Ro_hargaTotal, true);
                        $item->harga_total = (is_array($hargaTotal) && !empty($hargaTotal)) ? trim($hargaTotal[0]) : '0';
                    } catch (\Exception $e) {
                        Log::error("Gagal parse obat_Ro_hargaTotal: {$item->obat->obat_Ro_hargaTotal}", ['error' => $e->getMessage()]);
                        $item->harga_total = '0';
                    }
                } else {
                    $item->nama_obat = 'Tidak ada obat';
                    $item->harga_total = '0';
                }

                // Proses waktu
                $jamDatang = $item->created_at ? Carbon::parse($item->created_at) : Carbon::now();
                $item->jam_datang = $jamDatang->format('H:i');
                $item->lama_daftar = '00:05';
                $jamPeriksa = $jamDatang->copy()->addMinutes(5);
                $item->jam_periksa = $jamPeriksa->format('H:i');
                $item->lama_periksa = '00:15';
                $jamSelesai = $jamPeriksa->copy()->addMinutes(15);
                $item->jam_selesai = $jamSelesai->format('H:i');

                return $item;
            });

            // dd($harian);

            return view('perawat.laporan.pemeriksaan', compact('harian'));
        } catch (\Exception $e) {
            Log::error('Error mengambil data pemeriksaan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil data: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        if (!$startDate || !$endDate) {
            return redirect()->back()->with('error', 'Tanggal awal dan akhir harus diisi.');
        }

        try {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
            if ($end->lt($start)) {
                return redirect()->back()->with('error', 'Tanggal akhir tidak boleh lebih awal dari tanggal awal.');
            }

            return Excel::download(new PemeriksaanHarianExport($start, $end), 'laporan_pemeriksaan_umum_dan_gigi_' . $start->format('dmY') . '-' . $end->format('dmY') . '.xlsx');
        } catch (\Exception $e) {
            Log::error('Error ekspor Excel: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengekspor ke Excel: ' . $e->getMessage());
        }
    }

    // public function exportPdf(Request $request)
    // {
    //     $startDate = $request->query('start_date');
    //     $endDate = $request->query('end_date');

    //     if (!$startDate || !$endDate) {
    //         return redirect()->back()->with('error', 'Tanggal awal dan akhir harus diisi.');
    //     }

    //     try {
    //         $start = Carbon::parse($startDate)->startOfDay();
    //         $end = Carbon::parse($endDate)->endOfDay();
    //         if ($end->lt($start)) {
    //             return redirect()->back()->with('error', 'Tanggal akhir tidak boleh lebih awal dari tanggal awal.');
    //         }

    //         $data = $this->getProcessedData($start, $end);
    //         $pdf = PDF::loadView('perawat.laporan.pemeriksaan_pdf', ['harian' => $data])
    //             ->setPaper('a4', 'landscape');
    //         return $pdf->download('pemeriksaan_' . $start->format('Ymd') . '_' . $end->format('Ymd') . '.pdf');
    //     } catch (\Exception $e) {
    //         Log::error('Error ekspor PDF: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'Gagal mengekspor ke PDF: ' . $e->getMessage());
    //     }
    // }

    // public function exportWord(Request $request)
    // {
    //     $startDate = $request->query('start_date');
    //     $endDate = $request->query('end_date');

    //     if (!$startDate || !$endDate) {
    //         return redirect()->back()->with('error', 'Tanggal awal dan akhir harus diisi.');
    //     }

    //     try {
    //         $start = Carbon::parse($startDate)->startOfDay();
    //         $end = Carbon::parse($endDate)->endOfDay();
    //         if ($end->lt($start)) {
    //             return redirect()->back()->with('error', 'Tanggal akhir tidak boleh lebih awal dari tanggal awal.');
    //         }

    //         $data = $this->getProcessedData($start, $end);
    //         $phpWord = new PhpWord();
    //         $section = $phpWord->addSection();
    //         $section->addTitle('Laporan Pemeriksaan', 1);
    //         $section->addText('Periode: ' . $start->format('d-m-Y') . ' s/d ' . $end->format('d-m-Y'));

    //         $table = $section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80]);
    //         $table->addRow();
    //         $headers = [
    //             'No',
    //             'Tanggal',
    //             'Jam Datang',
    //             'Lama Daftar',
    //             'Jam Periksa',
    //             'Lama Periksa',
    //             'Jam Selesai',
    //             'No. RM',
    //             'Nama Pasien',
    //             'Status',
    //             'Tgl Lahir',
    //             'BPJS',
    //             'Jenis Pasien',
    //             'Total Harga',
    //             'NIK',
    //             'No HP',
    //             'Pekerjaan',
    //             'Nama KK',
    //             'Alamat Asal',
    //             'Col 20',
    //             'Col 21',
    //             'Col 22',
    //             'Col 23',
    //             'Keluhan Utama',
    //             'Tensi',
    //             'Nadi',
    //             'RR',
    //             'Suhu',
    //             'SpO2',
    //             'BB',
    //             'TB',
    //             'Kode Diagnosa',
    //             'Nama Diagnosa',
    //             'Nama Obat',
    //             'Rujuk',
    //             'Nama Dokter',
    //             'NIK Dokter'
    //         ];
    //         foreach ($headers as $header) {
    //             $table->addCell(2000)->addText($header, ['bold' => true]);
    //         }

    //         foreach ($data as $index => $item) {
    //             $table->addRow();
    //             $table->addCell(2000)->addText($index + 1);
    //             $table->addCell(2000)->addText(Carbon::parse($item->created_at)->format('d-m-Y'));
    //             $table->addCell(2000)->addText($item->jam_datang);
    //             $table->addCell(2000)->addText($item->lama_daftar);
    //             $table->addCell(2000)->addText($item->jam_periksa);
    //             $table->addCell(2000)->addText($item->lama_periksa);
    //             $table->addCell(2000)->addText($item->jam_selesai);
    //             $table->addCell(2000)->addText($item->booking->pasien->no_rm);
    //             $table->addCell(2000)->addText($item->booking->pasien->nama_pasien);
    //             $table->addCell(2000)->addText($item->booking->pasien->status);
    //             $table->addCell(2000)->addText(Carbon::parse($item->booking->pasien->tgllahir)->format('d/m/Y'));
    //             $table->addCell(2000)->addText($item->booking->pasien->bpjs ?? '-');
    //             $table->addCell(2000)->addText($item->booking->pasien->jenis_pasien);
    //             $table->addCell(2000)->addText('Rp ' . number_format($item->harga_total, 0, ',', '.'));
    //             $table->addCell(2000)->addText($item->booking->pasien->nik);
    //             $table->addCell(2000)->addText($item->booking->pasien->noHP);
    //             $table->addCell(2000)->addText($item->booking->pasien->pekerjaan);
    //             $table->addCell(2000)->addText($item->booking->pasien->nama_kk);
    //             $table->addCell(2000)->addText($item->booking->pasien->alamat_asal);
    //             $table->addCell(2000)->addText('-');
    //             $table->addCell(2000)->addText('-');
    //             $table->addCell(2000)->addText('-');
    //             $table->addCell(2000)->addText('-');
    //             $table->addCell(2000)->addText($item->obat->soap->keluhan_utama ?? '-');
    //             $table->addCell(2000)->addText($item->obat->soap->p_tensi ?? '-');
    //             $table->addCell(2000)->addText($item->obat->soap->p_nadi ?? '-');
    //             $table->addCell(2000)->addText($item->obat->soap->p_rr ?? '-');
    //             $table->addCell(2000)->addText($item->obat->soap->p_suhu ?? '-');
    //             $table->addCell(2000)->addText($item->obat->soap->spo2 ?? '-');
    //             $table->addCell(2000)->addText($item->obat->soap->p_bb ?? '-');
    //             $table->addCell(2000)->addText($item->obat->soap->p_tb ?? '-');
    //             $table->addCell(2000)->addText($item->kd_diagno);
    //             $table->addCell(2000)->addText($item->nm_diagno);
    //             $table->addCell(2000)->addText($item->nama_obat);
    //             $table->addCell(2000)->addText($item->obat->soap->rujuk ?? '-');
    //             $table->addCell(2000)->addText($item->datadokter->nama_dokter ?? '-');
    //             $table->addCell(2000)->addText($item->datadokter->nik ?? '-');
    //         }

    //         $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    //         $fileName = 'pemeriksaan_' . $start->format('Ymd') . '_' . $end->format('Ymd') . '.docx';
    //         $tempFile = storage_path('app/public/' . $fileName);
    //         $objWriter->save($tempFile);

    //         return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    //     } catch (\Exception $e) {
    //         Log::error('Error ekspor Word: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'Gagal mengekspor ke Word: ' . $e->getMessage());
    //     }
    // }

    protected function getProcessedData($start, $end)
    {
        $query = AntrianPerawat::with(['booking.pasien', 'obat.soap', 'poli', 'rm', 'isian', 'datadokter'])
            ->where('status', 'WB')
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('id', 'asc');

        $data = $query->get();

        return $data->map(function ($item) {
            $kdDiagnosa = [];
            $nmDiagnosa = [];

            if ($item->obat && $item->obat->soap) {
                $soap = $item->obat->soap;
                try {
                    $primer = json_decode($soap->soap_a_primer, true);
                    if (is_array($primer) && !empty($primer)) {
                        foreach ($primer as $nama) {
                            $nama = trim($nama);
                            $diagnosa = Diagnosa::where('nm_diagno', 'LIKE', "%{$nama}%")->first();
                            if ($diagnosa) {
                                $kdDiagnosa[] = $diagnosa->kd_diagno;
                                $nmDiagnosa[] = $diagnosa->nm_diagno;
                            } else {
                                Log::warning("Diagnosa primer tidak ditemukan: {$nama}");
                                $kdDiagnosa[] = 'Tidak Ditemukan';
                                $nmDiagnosa[] = $nama;
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error("Gagal parse soap_a_primer: {$soap->soap_a_primer}", ['error' => $e->getMessage()]);
                }

                try {
                    $sekunder = json_decode($soap->soap_a_sekunder, true);
                    if (is_array($sekunder) && !empty($sekunder)) {
                        foreach ($sekunder as $nama) {
                            $nama = trim($nama);
                            $diagnosa = Diagnosa::where('nm_diagno', 'LIKE', "%{$nama}%")->first();
                            if ($diagnosa) {
                                $kdDiagnosa[] = $diagnosa->kd_diagno;
                                $nmDiagnosa[] = $diagnosa->nm_diagno;
                            } else {
                                Log::warning("Diagnosa sekunder tidak ditemukan: {$nama}");
                                $kdDiagnosa[] = 'Tidak Ditemukan';
                                $nmDiagnosa[] = $nama;
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error("Gagal parse soap_a_sekunder: {$soap->soap_a_sekunder}", ['error' => $e->getMessage()]);
                }
            }

            $item->kd_diagno = !empty($kdDiagnosa) ? implode(', ', $kdDiagnosa) : 'Tidak ada diagnosa';
            $item->nm_diagno = !empty($nmDiagnosa) ? implode(', ', $nmDiagnosa) : 'Tidak ada diagnosa';

            if ($item->obat) {
                try {
                    $namaObat = json_decode($item->obat->obat_Ro_namaObatUpdate, true);
                    $item->nama_obat = (is_array($namaObat) && !empty($namaObat)) ? trim($namaObat[0]) : 'Tidak ada obat';
                } catch (\Exception $e) {
                    Log::error("Gagal parse obat_Ro_namaObatUpdate: {$item->obat->obat_Ro_namaObatUpdate}", ['error' => $e->getMessage()]);
                    $item->nama_obat = 'Tidak ada obat';
                }

                try {
                    $hargaTotal = json_decode($item->obat->obat_Ro_hargaTotal, true);
                    $item->harga_total = (is_array($hargaTotal) && !empty($hargaTotal)) ? trim($hargaTotal[0]) : '0';
                } catch (\Exception $e) {
                    Log::error("Gagal parse obat_Ro_hargaTotal: {$item->obat->obat_Ro_hargaTotal}", ['error' => $e->getMessage()]);
                    $item->harga_total = '0';
                }
            } else {
                $item->nama_obat = 'Tidak ada obat';
                $item->harga_total = '0';
            }

            $jamDatang = $item->created_at ? Carbon::parse($item->created_at) : Carbon::now();
            $item->jam_datang = $jamDatang->format('H:i');
            $item->lama_daftar = '00:05';
            $jamPeriksa = $jamDatang->copy()->addMinutes(5);
            $item->jam_periksa = $jamPeriksa->format('H:i');
            $item->lama_periksa = '00:15';
            $jamSelesai = $jamPeriksa->copy()->addMinutes(15);
            $item->jam_selesai = $jamSelesai->format('H:i');

            return $item;
        });
    }
}
