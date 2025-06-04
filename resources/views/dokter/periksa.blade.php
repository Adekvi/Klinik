@extends('admin.layout.dasbrod')
@section('title', 'Perawat | Rekap Pasien')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card-title">
                    <h4 class="mt-4"><strong>Rekap Pasien Telah Diperiksa</strong></h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="filter d-flex align-items-center">
                            <div class="me-3">
                                <label for="date">Pilih Tanggal:</label>
                                <input type="number" id="date" name="date" class="form-control" min="1"
                                    max="31">
                            </div>

                            <div class="me-3">
                                <label for="month">Pilih Bulan:</label>
                                <select id="month" name="month" class="form-control">
                                    <!-- Bulan akan diisi oleh JavaScript -->
                                </select>
                            </div>

                            <div class="me-3">
                                <label for="year">Pilih Tahun:</label>
                                <select id="year" name="year" class="form-control">
                                    <!-- Tahun akan diisi oleh JavaScript -->
                                </select>
                            </div>
                        </div>
                        <div class="shifts">
                            <h4>Total Pasien</h4>
                            <div class="row">
                                <div class="col-md-8">
                                    <table class="table table-bordered table-responsive w-100">
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="text-center">TOTAL PASIEN SUDAH DIPERIKSA
                                                </th>
                                                <th class="text-center">KET.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($groupedAntrian->isEmpty())
                                                <tr>
                                                    <td colspan="2" class="text-center">Belum ada data</td>
                                                </tr>
                                            @else
                                                @foreach ($groupedAntrian as $namapoli => $antrian)
                                                    @if ($namapoli === 'Umum')
                                                        <tr>
                                                            <td>Pasien Poli UMUM (Bpjs)</td>
                                                            <td id="poliUmumBpjsTotal" style="text-align: center">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pasien Poli UMUM (Umum)</td>
                                                            <td id="poliUmumUmumTotal" style="text-align: center">0</td>
                                                        </tr>
                                                    @elseif ($namapoli === 'Gigi')
                                                        <tr>
                                                            <td>Pasien Poli GIGI (Bpjs)</td>
                                                            <td id="poliGigiBpjsTotal" style="text-align: center">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pasien Poli GIGI (Umum)</td>
                                                            <td id="poliGigiUmumTotal" style="text-align: center">0</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-md-12 mt-4">
                <div class="card-title">
                    <h4><strong>Daftar Pasien Harian</strong></h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="isian" style="overflow-x: scroll">
                            <table class="table table-striped table-bordered" style="background-color: white">
                                <thead class="table-primary text-center" style="white-space: nowrap; width: auto">
                                    <tr>
                                        <th>No</th>
                                        <th>No. RM</th>
                                        <th>NIK</th>
                                        <th>Nama Pasien</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Umur</th>
                                        <th>Poli</th>
                                        <th>Dokter</th>
                                        <th>Alamat Domisili</th>
                                        <th>Jenis Pasien</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @if (empty($pasien))
                                        <tr>
                                            <td colspan="7" style="text-align: center">Tidak Ada Data Pasien</td>
                                        </tr>
                                    @else
                                        <?php $no = 1; ?>
                                        @foreach ($pasien as $item)
                                            @if ($item->status == 'M')
                                                <tr id="row_{{ $item->id }}" class="text-center">
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $item->booking->pasien->no_rm }}</td>
                                                    <td>{{ $item->booking->pasien->nik }}</td>
                                                    <td>{{ $item->booking->pasien->nama_pasien }}</td>
                                                    <td>{{ $item->booking->pasien->tgllahir }}</td>
                                                    <td>
                                                        <?php
                                                        // Parsing tanggal lahir dari data pasien menggunakan Carbon
                                                        $tgllahir = \Carbon\Carbon::parse($item->booking->pasien->tgllahir);
                                                        
                                                        // Menghitung umur dalam bulan dari tanggal lahir hingga saat ini
                                                        $umurDalamBulan = $tgllahir->diffInMonths(\Carbon\Carbon::now());
                                                        
                                                        // Mengubah umur ke dalam tahun dan bulan jika diperlukan
                                                        $tahun = floor($umurDalamBulan / 12); // Hitung tahun
                                                        $bulan = $umurDalamBulan % 12; // Sisa bulan setelah hitungan tahun
                                                        
                                                        // Menampilkan hasil dalam format "X tahun Y bulan"
                                                        echo $tahun . ' tahun ';
                                                        ?>
                                                    </td>
                                                    <td>{{ $item->poli->namapoli }}</td>
                                                    <td>{{ $item->dokter->nama_dokter }}</td>
                                                    <td>{{ $item->booking->pasien->domisili }}</td>
                                                    <td>{{ $item->booking->pasien->jenis_pasien }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info mb-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#asesmen{{ $item->id }}"
                                                            data-toggle="tooltip" data-bs-placement="top"
                                                            title="Riwayat Asesmen">
                                                            <i class="fas fa-info"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="pagination mt-3 d-flex justify-content-end">
                                {{ $pasien->appends(request()->input())->onEachSide(1)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

@endsection

@push('style')
    <style>
        /* TANGGAL PERIODE */
        .filter {
            display: flex;
            align-items: center;
        }

        .filter>div {
            margin-right: 10px;
            /* Memberi jarak antar elemen */
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        /* TAMPILAN REPORT */


        /* TAMPILAN SHIFT */
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .filter {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .table thead th {
            /* color: rgb(94, 94, 221); */
            text-align: left;
        }

        .table tbody {
            text-align: left;
        }
    </style>
@endpush

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const currentDay = now.getDate();
            const currentMonth = now.getMonth() + 1; // Bulan dimulai dari 0
            const currentYear = now.getFullYear();

            // Mengisi dropdown bulan
            const monthNames = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            const monthSelect = document.getElementById('month');
            monthNames.forEach((month, index) => {
                const option = document.createElement('option');
                option.value = index + 1; // Bulan dimulai dari 1
                option.textContent = month;
                if (index + 1 === currentMonth) {
                    option.selected = true; // Bulan saat ini dipilih
                }
                monthSelect.appendChild(option);
            });

            // Mengisi dropdown tahun
            const yearSelect = document.getElementById('year');
            for (let year = currentYear - 10; year <= currentYear + 10; year++) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                if (year === currentYear) {
                    option.selected = true; // Tahun saat ini dipilih
                }
                yearSelect.appendChild(option);
            }

            // Menentukan tanggal default dan max tanggal
            const dateInput = document.getElementById('date');
            dateInput.value = currentDay;
            dateInput.max = new Date(currentYear, currentMonth, 0)
                .getDate(); // Set max tanggal sesuai bulan dan tahun yang dipilih

            // Menangani perubahan pada bulan dan tahun untuk memperbarui max tanggal
            monthSelect.addEventListener('change', updateMaxDate);
            yearSelect.addEventListener('change', updateMaxDate);

            function updateMaxDate() {
                const selectedMonth = parseInt(monthSelect.value);
                const selectedYear = parseInt(yearSelect.value);
                const maxDate = new Date(selectedYear, selectedMonth, 0).getDate(); // Update max tanggal
                dateInput.max = maxDate; // Update max tanggal sesuai bulan dan tahun yang dipilih

                if (parseInt(dateInput.value) > maxDate) {
                    dateInput.value = maxDate; // Update nilai tanggal jika lebih dari max
                }
            }

            // Pastikan max tanggal sesuai dengan bulan dan tahun saat ini
            updateMaxDate();
        });
    </script>
@endpush
