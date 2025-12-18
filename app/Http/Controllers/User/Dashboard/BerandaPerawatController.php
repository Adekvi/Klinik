<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Exports\PemeriksaanHarianExport;
use App\Http\Controllers\Controller;
use App\Models\AntrianPerawat;
use App\Models\Diagnosa;
use Carbon\Carbon;
use Carbon\CarbonInterface;
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

        $auth = Auth::user()->id_dokter;
        
        $totalPasien = AntrianPerawat::where('status', 'P')
            ->where('id_dokter', $auth)
            ->count();

        $today = Carbon::today();
        $BelumDilayani = AntrianPerawat::where('status', 'M')
            ->where('id_dokter', $auth)
            ->whereDate('created_at', $today)
            ->count();

        $pasienBpjs = AntrianPerawat::where('status', 'P')
            ->where('id_dokter', $auth)
             ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'BPJS');
                });
            })
            ->count();

        $pasienUmum = AntrianPerawat::where('status', 'P')
            ->where('id_dokter', $auth)
             ->whereHas('booking', function ($query) {
                $query->whereHas('pasien', function ($query) {
                    $query->where('jenis_pasien', 'Umum');
                });
            })
            ->count();

        // dd($pasienUmum);

        return view('dashboard', compact(
            'totalPasien',
            'BelumDilayani',
            'pasienBpjs',
            'pasienUmum',
        ));
    }

    public function profil()
    {
        $profil = Auth::user();

        return view('admin.profil.myprofil', compact('profil'));
    }

    public function pemeriksaan(Request $request)
    {
        try {
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');

            // Inisialisasi query
            $query = AntrianPerawat::with(['booking.pasien', 'obat.soap', 'poli', 'dokter', 'rm', 'isian'])
                ->where('status', 'WB')
                ->orderBy('id', 'asc');

            // Tentukan rentang tanggal default (minggu berjalan: Senin hingga hari ini)
            $defaultStart = Carbon::now()->startOfWeek(CarbonInterface::MONDAY)->startOfDay();
            $defaultEnd = Carbon::now()->endOfDay();

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
                // Default ke rentang 1 minggu (Senin hingga hari ini)
                $start = $defaultStart;
                $end = $defaultEnd;
                $query->whereBetween('created_at', [$defaultStart, $defaultEnd]);
            }

            // Paginate hasil query
            $harian = $query->paginate(10);

            // Proses data untuk diagnosa, obat, dan waktu
            $harian->getCollection()->transform(function ($item) {
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

            // Data untuk notifikasi ekspor mingguan
            $exportStart = $defaultStart->format('Y-m-d');
            $exportEnd = $defaultEnd->format('Y-m-d');
            $exportNotification = "Data minggu ini ({$defaultStart->format('d M Y')} - {$defaultEnd->format('d M Y')}) tersedia untuk diekspor. Silakan ekspor laporan mingguan.";

            return view('perawat.laporan.pemeriksaan', compact('harian', 'exportNotification', 'exportStart', 'exportEnd'));
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
