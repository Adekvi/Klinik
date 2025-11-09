<x-admin.layout.terminal title="Perawat | Laporan Kunjungan Poli Gigi">

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    {{-- <div class="btn-group" style="margin-bottom: 10px">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Pilih Pasien
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('laporan/poliGigi/pasienUmum') }}">Pasien Umum</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ url('laporan/poliGigi/pasienBpjs') }}">Pasien BPJS</a>
                            </li>
                        </ul>
                    </div> --}}
                    <div class="title">
                        <h5>Poli Gigi/<strong>Laporan Kunjungan Pasien BPJS</strong></h5>
                    </div>
                    <div class="card mb-4" style="width: 40%">
                        <div class="card-body">
                            <h5>Filter Pencarian</h5>
                            <form id="filterForm" method="GET" action="{{ route('perawat.laporan.poliUmum.bpjs') }}">
                                <div class="form-check mb-2" style="display: flex; align-items: baseline">
                                    <input class="form-check-input" type="radio" name="filter_option"
                                        value="full_date" id="filter_by_full_date">
                                    <label class="form-check-label" for="filter_by_full_date"></label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                                        style="width: 45%; margin-left: 20px">
                                </div>
                                <div class="form-check mb-2" style="display: flex; align-items: baseline">
                                    <input class="form-check-input" type="radio" name="filter_option"
                                        value="month_year" id="filter_by_month_year">
                                    <label class="form-check-label" for="filter_by_month_year"></label>
                                    <div class="month_year" style="display: flex; margin-left: 20px">
                                        <select name="month" id="month" class="form-control" style="width: 50%">
                                            <option value="">Bulan</option>
                                            @php
                                                $months = [
                                                    1 => 'Januari',
                                                    2 => 'Februari',
                                                    3 => 'Maret',
                                                    4 => 'April',
                                                    5 => 'Mei',
                                                    6 => 'Juni',
                                                    7 => 'Juli',
                                                    8 => 'Agustus',
                                                    9 => 'September',
                                                    10 => 'Oktober',
                                                    11 => 'November',
                                                    12 => 'Desember',
                                                ];
                                                $selectedMonth = $month
                                                    ? (int) $month
                                                    : (old('month')
                                                        ? (int) old('month')
                                                        : '');
                                                foreach ($months as $key => $monthName) {
                                                    $selected = $key == $selectedMonth ? 'selected' : '';
                                                    echo "<option value='$key' $selected>$monthName</option>";
                                                }
                                            @endphp
                                        </select>
                                        <select name="tahun" id="tahun" class="form-control"
                                            style="width: 50%; margin-left: 5px">
                                            <option value="">Tahun</option>
                                            @php
                                                $currentYear = date('Y');
                                                for ($year = $currentYear; $year >= $currentYear - 5; $year--) {
                                                    $selected = old('tahun') == $year ? 'selected' : '';
                                                    echo "<option value='$year' $selected>$year</option>";
                                                }
                                            @endphp
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" id="btnSearch" class="btn btn-info mt-3"><i
                                            class="fas fa-search"></i> Cari</button>
                                </div>
                                <hr>
                                <p style="font-size: 14px; margin-bottom: 0px"><span style="color: red">* </span>Pilih
                                    salah
                                    satu atau cetak semua data tanpa memilih</p>
                                <div class="button"
                                    style="display: flex; align-items: baseline; justify-content: space-between">
                                    <a href="{{ route('perawat.laporan.poliUmum.bpjs') }}"
                                        class="btn btn-secondary ml-2 mt-2">
                                        <i class="fa-solid fa-arrow-rotate-right"></i> Reset
                                    </a>
                                    <button type="button" id="btnCetak" class="btn btn-outline-warning mt-3"><i
                                            class="fas fa-print"></i> Cetak</button>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="fa-solid fa-file-excel"></i>
                                            Export
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item"
                                                href="{{ route('export-pasienBpjs-Umum', request()->query()) }}">Export
                                                to
                                                Excel</a>
                                            {{-- <a class="dropdown-item" href="#">Export to PDF</a>
                                            <a class="dropdown-item" href="#">Export to Word</a> --}}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3 text-muted">
                                <strong>
                                    <li>Data Pasien</li>
                                </strong>
                            </h5>
                            <div class="sortir">
                                <div class="row">
                                    <form method="GET" action=""
                                        class="d-flex justify-content-between align-items-center mb-3">
                                        <input type="hidden" name="page" value="1"> {{-- Reset ke halaman 1 saat pencarian --}}
                                        <div class="d-flex align-items-center">
                                            <label for="entries" class="me-2">Tampilkan:</label>
                                            <select name="entries" id="entries"
                                                class="form-select form-select-sm me-3" style="width: 80px;"
                                                onchange="this.form.submit()">
                                                <option value="10" {{ $entries == 10 ? 'selected' : '' }}>10
                                                </option>
                                                <option value="25" {{ $entries == 25 ? 'selected' : '' }}>25
                                                </option>
                                                <option value="50" {{ $entries == 50 ? 'selected' : '' }}>50
                                                </option>
                                                <option value="100" {{ $entries == 100 ? 'selected' : '' }}>100
                                                </option>
                                            </select>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <input type="text" name="search" value="{{ $search }}"
                                                class="form-control form-control-sm me-2" style="width: 400px;"
                                                placeholder="Cari Nama Pasien / No. Rm">
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table mt-2 mb-2 table-striped table-bordered"
                                    style="width:100%; white-space: nowrap;">
                                    <thead class="table-primary"
                                        style="align-items: center; text-align: center; vertical-align: middle;">
                                        <tr>
                                            <th class="custom-th" rowspan="14">NO.</th>
                                            <th class="custom-th" rowspan="14">TANGGAL</th>
                                            <th class="custom-th" rowspan="14">JAM</th>
                                            <th class="custom-th" rowspan="14">NO. RM</th>
                                            <th class="custom-th" rowspan="14">NAMA PASIEN</th>
                                            <th class="custom-th" rowspan="14">JENIS PASIEN</th>
                                            <th class="custom-th" rowspan="14">TANGGAL LAHIR</th>
                                            <th class="custom-th" rowspan="14">NOMOR BPJS</th>
                                            <th class="custom-th" rowspan="14">NOMOR NIK</th>
                                            <th class="custom-th" rowspan="14">NOMOR HP</th>
                                            <th class="custom-th" rowspan="14">PEKERJAAN</th>
                                            <th class="custom-th" rowspan="14">NAMA KK</th>
                                            <th class="custom-th" rowspan="14">ALAMAT</th>
                                            <th class="custom-th" rowspan="14">KELUHAN (S)</th>
                                            <th class="custom-th" colspan="7" style="text-align: center">
                                                PEMERIKSAAN (O)
                                            </th>
                                            <th class="custom-th" colspan="2" style="text-align: center">DIAGNOSA
                                                (A)
                                                ICD X
                                            </th>
                                            <th class="custom-th" rowspan="14">TINDAKAN (P)</th>
                                            <th class="custom-th" rowspan="14">KETERANGAN</th>
                                        </tr>
                                        <tr>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                TD</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                Nadi</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                RR</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                Suhu</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                Sp02</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                BB</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                TB</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                KODE icd 10</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                DISKRIPSI</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center" style="text-transform: uppercase">
                                        @php $all = []; @endphp
                                        @foreach ($gigiBpjs as $item)
                                            @php
                                                $soapData = json_decode($item->soap_p, true);
                                                $all = array_merge($all, array_keys($soapData));
                                            @endphp
                                        @endforeach
                                        @php $all = array_unique($all); @endphp

                                        @php
                                            $pasienCounts = [];
                                        @endphp

                                        @foreach ($gigiBpjs as $item)
                                            @if ($item->pasien->jenis_pasien == 'Bpjs')
                                                @php
                                                    $pasienId = $item->pasien->id;
                                                    if (!isset($pasienCounts[$pasienId])) {
                                                        $pasienCounts[$pasienId] = 1;
                                                    } else {
                                                        $pasienCounts[$pasienId]++;
                                                    }
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if (count($gigiBpjs) == 0)
                                            <tr>
                                                <td colspan="18" style="text-align: center">Tidak Ada Data</td>
                                            </tr>
                                        @else
                                            @foreach ($gigiBpjs as $index => $item)
                                                @if ($item->pasien->jenis_pasien == 'Bpjs')
                                                    <tr>
                                                        <td>{{ $gigiBpjs->firstItem() + $index }}</td>
                                                        <td>{{ date_format(date_create($item->created_at), 'd-m-Y') }}
                                                        </td>
                                                        <td>{{ date_format(date_create($item->created_at), 'H:i:s') }}
                                                        </td>
                                                        <td>{{ $item->pasien->no_rm }}</td>
                                                        <td>{{ $item->pasien->nama_pasien }}</td>
                                                        <td>{{ $item->pasien->status }}</td>
                                                        <td>{{ $item->pasien->bpjs ?? '-' }}</td>
                                                        <td>{{ date_format(date_create($item->pasien->tgllahir), 'd-m-Y') }}
                                                        </td>
                                                        <td>{{ $item->pasien->nik ?? '-' }}</td>
                                                        <td>{{ $item->pasien->noHP ?? '-' }}</td>
                                                        <td>{{ $item->pasien->pekerjaan ?? '-' }}</td>
                                                        <td>{{ $item->pasien->nama_kk ?? '-' }}</td>
                                                        <td>{{ $item->pasien->alamat_asal ?? '-' }}</td>
                                                        <td>{{ $item->keluhan_utama ?? '-' }}</td>
                                                        <td>{{ $item->p_tensi ?? '-' }} mmHg</td>
                                                        <td>{{ $item->p_nadi }} x/m</td>
                                                        <td>{{ $item->p_rr }} x/m</td>
                                                        <td>{{ $item->p_suhu }} C</td>
                                                        <td>{{ $item->spo2 }} %</td>
                                                        <td>{{ $item->p_bb }} Kg</td>
                                                        <td>{{ $item->p_tb }} Cm</td>
                                                        <td>{{ $item->kd_diagno }}</td>
                                                        <td class="text-start">{{ $item->nm_diagno }}</td>
                                                        <td class="text-start">
                                                            @php
                                                                $resep = json_decode($item->soap_p, true);
                                                                // Pastikan $resep adalah array sebelum memproses
                                                                if (is_array($resep)) {
                                                                    foreach ($resep as $value) {
                                                                        echo '- ' . $value . '<br>';
                                                                    }
                                                                } else {
                                                                    echo '- Tidak ada resep';
                                                                }
                                                            @endphp
                                                        </td>
                                                        @if ($item->rujuk != null)
                                                            <td>{{ $item->rujuk }}</td>
                                                        @else
                                                            <td style="text-align: center">-</td>
                                                        @endif
                                                        <td>
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#hapuspoli{{ $item['id'] }}">
                                                                <i class="fas fa-trash"></i> Hapus</button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="halaman d-flex justify-content-end">
                                {{ $gigiBpjs->appends(request()->only(['search', 'entries', 'filter_option', 'tanggal', 'month', 'tahun']))->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('style')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
        <style>
            .custom-th {
                min-width: 80px;
                /* Atur lebar minimum */
                max-width: 200px;
                /* Atur lebar maksimum */
                white-space: nowrap;
                /* Mencegah teks untuk melipat jika panjang */
                overflow: hidden;
                /* Menyembunyikan teks yang melebihi lebar maksimum */
                text-overflow: ellipsis;
                /* Menampilkan elipsis (...) jika teks melebihi lebar maksimum */
            }

            .filter-section {
                margin-bottom: 20px;
            }

            .hidden {
                display: none;
            }
        </style>
    @endpush

    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
        <script>
            $(document).ready(function() {
                // Sembunyikan input month dan tahun jika filter tanggal dipilih
                $('input[name="filter_option"]').change(function() {
                    if ($('#filter_by_full_date').is(':checked')) {
                        $('#tanggal').prop('disabled', false);
                        $('.month_year select').prop('disabled', true);
                    } else if ($('#filter_by_month_year').is(':checked')) {
                        $('#tanggal').prop('disabled', true);
                        $('.month_year select').prop('disabled', false);
                    } else {
                        $('#tanggal, .month_year select').prop('disabled', false);
                    }
                });

                // Set default state berdasarkan input yang ada
                var filterOption = '{{ $filterOption ?? '' }}';
                if (filterOption === 'full_date') {
                    $('#filter_by_full_date').prop('checked', true);
                    $('#tanggal').prop('disabled', false);
                    $('#tanggal').val('{{ $tanggal ?? '' }}');
                    $('.month_year select').prop('disabled', true);
                } else if (filterOption === 'month_year') {
                    $('#filter_by_month_year').prop('checked', true);
                    $('#tanggal').prop('disabled', true);
                    $('.month_year select').prop('disabled', false);
                    var monthValue = '{{ $month ?? '' }}';
                    var yearValue = '{{ $tahun ?? '' }}';
                    if (monthValue) {
                        $('#month').val(monthValue); // Set nilai berdasarkan $month
                    }
                    if (yearValue) {
                        $('#tahun').val(yearValue); // Set nilai berdasarkan $tahun
                    }
                    // Verifikasi dan log untuk debugging
                    console.log('Month Value Set:', monthValue, 'Selected Text:', $('#month option:selected').text());
                }

                // Handle tombol Cetak
                $('#btnCetak').click(function() {
                    window.print();
                });
            });
        </script>
    @endpush

</x-admin.layout.terminal>
