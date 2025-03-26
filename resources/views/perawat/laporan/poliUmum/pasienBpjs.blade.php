@extends('admin.layout.dasbrod')
@section('title', 'Perawat | Laporan Kunjungan Poli Umum')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="btn-group" style="margin-bottom: 10px">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Pilih Pasien
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('laporan-perawat-pasienUmum') }}">Pasien Umum</a></li>
                            <li><a class="dropdown-item" href="{{ url('laporan-perawat-pasienBpjs') }}">Pasien BPJS</a></li>
                        </ul>
                    </div>
                    <div class="title">
                        <h5>Poli Umum/<strong>Laporan Kunjungan Pasien BPJS</strong></h5>
                    </div>
                    <div class="card" style="width: 40%; margin-bottom: 20px">
                        <div class="card-body">
                            <h5>Filter Pencarian</h5>
                            <div class="form-check mb-2" style="display: flex; align-items: baseline">
                                <input class="form-check-input" type="radio" name="filter_option"
                                    id="filter_by_full_date">
                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                    style="width: 45%; margin-left: 20px">
                            </div>
                            <div class="form-check mb-2" style="display: flex; align-items: baseline">
                                <input class="form-check-input" type="radio" name="filter_option"
                                    id="filter_by_month_year">
                                <div class="month_year" style="display: flex; margin-left: 20px">
                                    <select name="month" id="month" class="form-control" style="width: 62%">
                                        <!-- Opsi bulan akan ditambahkan secara dinamis oleh JavaScript -->
                                    </select>
                                    <select name="tahun" id="tahun" class="form-control"
                                        style="width: 40%; margin-left: 5px">
                                        <!-- Opsi tahun akan ditambahkan secara dinamis oleh JavaScript -->
                                    </select>
                                </div>
                            </div>
                            <p style="font-size: 14px; margin-bottom: 0px"><span style="color: red">* </span>Pilih salah
                                satu atau cetak semua data tanpa memilih</p>
                            <div class="button" style="display: flex; align-items: baseline">
                                <button type="button" id="btnSearch" class="btn btn-outline-info mt-3"><i
                                        class="fas fa-search"></i> Cari</button>
                                <button type="button" id="btnCetak" class="btn btn-outline-warning mt-3"
                                    style="margin-left: 10px"><i class="fas fa-print"></i> Cetak</button>
                                <div class="dropdown" style="margin-left: 10px">
                                    <button class="btn btn-outline-secondary dropdown-toggle" style="margin-top: -3px"
                                        type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa-solid fa-file-excel"></i>
                                        Export
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ url('export-UmumPasienBpjs') }}">Export to
                                            Excel</a>
                                        <a class="dropdown-item" href="#">Export to PDF</a>
                                        <a class="dropdown-item" href="#">Export to Word</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table mt-2 mb-2 table-striped table-bordered"
                                    style="width:100%">
                                    <thead class="table-primary" style="align-items: center">
                                        <tr>
                                            <th class="custom-th">NO.</th>
                                            <th class="custom-th">TANGGAL</th>
                                            <th class="custom-th">JAM</th>
                                            <th class="custom-th">NO. RM</th>
                                            <th class="custom-th">NAMA PASIEN</th>
                                            <th class="custom-th">JENIS PASIEN</th>
                                            <th class="custom-th">TANGGAL LAHIR</th>
                                            <th class="custom-th">NOMOR BPJS</th>
                                            <th class="custom-th">NOMOR NIK</th>
                                            <th class="custom-th">NOMOR HP</th>
                                            <th class="custom-th">PEKERJAAN</th>
                                            <th class="custom-th">NAMA KK</th>
                                            <th class="custom-th">ALAMAT</th>
                                            <th class="custom-th">KELUHAN (S)</th>
                                            <th class="custom-th">PEMERIKSAAN (O)</th>
                                            <th class="custom-th">DIAGNOSA (A)</th>
                                            <th class="custom-th">TINDAKAN (P)</th>
                                            <th class="custom-th">KETERANGAN</th>
                                            <th class="custom-th">AKSI</th>
                                        </tr>
                                    </thead>
                                    {{-- {{ dd($umumBpjs) }} --}}
                                    <tbody>
                                        @php
                                            $pasienCounts = [];
                                        @endphp

                                        @foreach ($umumBpjs as $item)
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

                                        @php $counter = 1; @endphp

                                        @foreach ($umumBpjs as $item)
                                            @if ($item->pasien->jenis_pasien == 'Bpjs')
                                                @php
                                                    $pasienId = $item->pasien->id;
                                                    $statusPasien = $pasienCounts[$pasienId] > 1 ? 'Lama' : 'Baru';
                                                @endphp
                                                <tr>
                                                    <td>{{ $counter++ }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                                    <td>{{ date('H:i:s', strtotime($item->created_at)) }}</td>
                                                    <td>{{ $item->pasien->no_rm }}</td>
                                                    <td>{{ $item->pasien->nama_pasien }}</td>
                                                    <td>{{ $statusPasien }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($item->pasien->tgllahir)) }}</td>
                                                    <td>{{ $item->pasien->bpjs }}</td>
                                                    <td>{{ $item->pasien->nik }}</td>
                                                    <td>{{ $item->pasien->noHP }}</td>
                                                    <td>{{ $item->pasien->pekerjaan }}</td>
                                                    <td>{{ $item->pasien->nama_kk }}</td>
                                                    <td>{{ $item->pasien->alamat_asal }}</td>
                                                    <td>{{ $item->keluhan_utama }}</td>
                                                    <td>Td : {{ $item->p_tensi }} mmHg, <br> N : {{ $item->p_nadi }} x/m,
                                                        <br> R : {{ $item->p_rr }} x/m, <br> S : {{ $item->p_suhu }} C,
                                                        <br> SpO2 : {{ $item->spo2 }} %, <br> BB : {{ $item->p_bb }}
                                                        kg, <br> TB : {{ $item->p_tb }} cm
                                                    </td>
                                                    <td>
                                                        @php
                                                            $diagnosa = json_decode($item->soap_a_primer, true);
                                                        @endphp
                                                        @foreach ($diagnosa as $diagno)
                                                            - {{ $diagno }} <br>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @php
                                                            $resep = json_decode($item->soap_p, true);
                                                        @endphp
                                                        @foreach ($resep as $key => $value)
                                                            - {{ $key }} <br>
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $item->rujuk ?? '-' }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#hapuspoli{{ $item->id }}">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

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
    </style>
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>

    <script>
        new DataTable('#example');
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalInput = document.getElementById('tanggal');
            const monthSelect = document.getElementById('month');
            const tahunSelect = document.getElementById('tahun');
            const filterByFullDate = document.getElementById('filter_by_full_date');
            const filterByMonthYear = document.getElementById('filter_by_month_year');
            const btnSearch = document.getElementById('btnSearch');
            const btnCetak = document.getElementById('btnCetak');

            // Pastikan elemen input tidak disabled di awal
            tanggalInput.disabled = true;
            monthSelect.disabled = true;
            tahunSelect.disabled = true;

            filterByFullDate.addEventListener('change', function() {
                if (this.checked) {
                    tanggalInput.disabled = false;
                    monthSelect.disabled = true;
                    tahunSelect.disabled = true;
                }
            });

            filterByMonthYear.addEventListener('change', function() {
                if (this.checked) {
                    tanggalInput.disabled = true;
                    monthSelect.disabled = false;
                    tahunSelect.disabled = false;
                }
            });

            btnSearch.addEventListener('click', function() {
                let searchData;
                if (filterByMonthYear.checked) {
                    const selectedMonth = monthSelect.value;
                    const selectedYear = tahunSelect.value;
                    searchData = {
                        type: 'month_year',
                        month: selectedMonth,
                        year: selectedYear
                    };
                } else if (filterByFullDate.checked) {
                    const selectedDate = tanggalInput.value;
                    searchData = {
                        type: 'full_date',
                        date: selectedDate
                    };
                } else {
                    console.log('Harap pilih opsi pencarian terlebih dahulu');
                    return;
                }

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch('perawat/cariPasienBpjs', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(searchData),
                    })
                    .then(response => response.json())
                    .then(data => {
                        updateTable(data);
                    })
                    .catch(error => {
                        console.error('Terjadi kesalahan saat melakukan pencarian:', error);
                    });
            });

            btnCetak.addEventListener('click', function() {
                cetakHasilFilter();
            });

            function cetakHasilFilter() {
                let searchData;
                if (filterByMonthYear.checked) {
                    const selectedMonth = monthSelect.value;
                    const selectedYear = tahunSelect.value;
                    searchData = {
                        type: 'month_year',
                        month: selectedMonth,
                        year: selectedYear
                    };
                } else if (filterByFullDate.checked) {
                    const selectedDate = tanggalInput.value;
                    searchData = {
                        type: 'full_date',
                        date: selectedDate
                    };
                } else {
                    searchData = {
                        type: 'no_filter'
                    };
                }

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch('/perawat/bpjs/cetak', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(searchData),
                    })
                    .then(response => response.text())
                    .then(html => {
                        const newWindow = window.open('', '_blank');
                        if (newWindow) {
                            newWindow.document.write(html);
                            newWindow.document.close();
                            newWindow.focus();
                            newWindow.print();
                        } else {
                            alert(
                                'Pop-up blocker mencegah membuka tab baru. Harap izinkan pop-up untuk situs ini.'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Terjadi kesalahan saat mencetak:', error);
                    });
            }

            // Dapatkan tahun saat ini
            const currentYear = new Date().getFullYear();
            const startYear = currentYear - 10;
            const endYear = currentYear;

            // Buat opsi tahun secara dinamis
            for (let year = endYear; year >= startYear; year--) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                tahunSelect.appendChild(option);
            }

            // Buat opsi bulan secara dinamis
            const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                "Oktober", "November", "Desember"
            ];
            months.forEach((month, index) => {
                const option = document.createElement('option');
                option.value = index + 1;
                option.textContent = month;
                monthSelect.appendChild(option);
            });
        });
    </script>
@endpush
