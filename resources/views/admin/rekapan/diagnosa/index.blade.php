@extends('admin.layout.dasbrod')
@section('title', 'Admin | Daftar 30 Diagnosa Terbanyak')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="title">
                        <h5><strong>Daftar 30 Diagnosa Terbayak</strong></h5>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <div class="card" style="width: 100%; margin-bottom: 20px">
                                <div class="card-body">
                                    <h5>Filter Pencarian</h5>
                                    <div class="form-check mb-2" style="display: flex; align-items: center;">
                                        <input class="form-check-input" type="radio" name="filter_option"
                                            id="filter_by_month_year">
                                        <label for="filter_by_month_year"
                                            style="margin-left: 10px;"><strong>Bulan</strong></label>
                                        <div class="month_year"
                                            style="display: flex; margin-left: 42px; align-items: center;">
                                            <select name="month" id="month" class="form-control" style="width: 62%;">
                                            </select>
                                            <select name="tahun" id="tahun" class="form-control"
                                                style="width: 40%; margin-left: 5px;">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-check mb-2" style="display: flex; align-items: center;">
                                        <input class="form-check-input" type="radio" name="filter_option"
                                            id="filter_by_indicator">
                                        <label for="filter_by_indicator"
                                            style="margin-left: 10px;"><strong>Indikator</strong></label>
                                        <select name="indikator" id="indikator" class="form-control"
                                            style="width: 40%; margin-left: 20px;">
                                            <option value="Semua">Semua</option>
                                            <option value="Kunjungan">Kunjungan</option>
                                            <option value="Rujukan">Rujukan</option>
                                        </select>
                                    </div>
                                    <p style="font-size: 14px; margin-bottom: -10px"><span style="color: red">* </span>Pilih
                                        salah satu atau cetak semua data tanpa memilih</p>
                                    </p>
                                    <div class="button" style="display: flex; align-items: baseline">
                                        <button type="button" id="btnSearch" class="btn btn-primary mt-3"><i
                                                class="fas fa-search"></i> Cari</button>
                                        <button type="button" id="btnCetak" class="btn btn-warning mt-3"
                                            style="margin-left: 10px"><i class="fas fa-print"></i> Cetak</button>
                                        {{-- <button type="button" id="btnCetak" class="btn btn-success mt-3" style="margin-left: 130px"><i class="fa-solid fa-file-export"></i> Export</button> --}}
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle"
                                                style="margin-top: -3px; margin-left: 10px" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-file-excel"></i>
                                                Export
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ url('/export-diagnosa-excel') }}">Export
                                                    to Excel</a>
                                                <a class="dropdown-item" href="{{ url('/export-diagnoses-pdf') }}">Export to
                                                    PDF</a>
                                                <a class="dropdown-item" href="#">Export to Word</a>
                                            </div>
                                        </div>
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
                                    <thead class="table-primary">
                                        <tr>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle">NO</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle">PENYAKIT
                                            </th>
                                            <th colspan="3" style="text-align: center">JUMLAH KASUS BARU</th>
                                        </tr>
                                        <tr>
                                            <th>LAKI-LAKI</th>
                                            <th>PEREMPUAN</th>
                                            <th>JUMLAH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($groupedDiagnoses as $index => $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item['diagnosa'] }}</td>
                                                <td>{{ $item['laki_laki'] }}</td>
                                                <td>{{ $item['perempuan'] }}</td>
                                                <td>{{ $item['jumlah'] }}</td>
                                            </tr>
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
            const monthSelect = document.getElementById('month');
            const tahunSelect = document.getElementById('tahun');
            const filterByFullDate = document.getElementById('filter_by_full_date');
            const filterByMonthYear = document.getElementById('filter_by_month_year');
            const btnSearch = document.getElementById('btnSearch');
            const btnCetak = document.getElementById('btnCetak');

            // Isi opsi bulan dan tahun secara dinamis
            const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                "Oktober", "November", "Desember"
            ];
            months.forEach((month, index) => {
                let option = document.createElement('option');
                option.value = index + 1;
                option.text = month;
                monthSelect.appendChild(option);
            });

            const currentYear = new Date().getFullYear();
            for (let year = currentYear; year >= 2000; year--) {
                let option = document.createElement('option');
                option.value = year;
                option.text = year;
                tahunSelect.appendChild(option);
            }

            // Tambahkan event listener untuk radio button 'Tanggal'
            if (filterByFullDate) {
                filterByFullDate.addEventListener('change', function() {
                    if (this.checked) {
                        tanggalInput.disabled = false;
                        monthSelect.disabled = true;
                        tahunSelect.disabled = true;
                    }
                });
            }

            // Tambahkan event listener untuk radio button 'Bulan dan Tahun'
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
                } else if (filterByFullDate && filterByFullDate.checked) {
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
                fetch('/rekapan/diagnosa/search', {
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

            function updateTable(data) {
                const tableBody = document.querySelector('#example tbody');
                tableBody.innerHTML = '';

                if (data.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = '<td colspan="6" style="text-align: center">Data tidak ada</td>';
                    tableBody.appendChild(row);
                } else {
                    data.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${item.tanggal}</td>
                        <td>${item.no_rm}</td>
                        <td>${item.nama_pasien}</td>
                        <td>${item.jenis_pasien}</td>
                        <td>${item.nama_poli}</td>
                        <td>
                            <button type="button" class="btn btn-info mb-1" data-bs-toggle="modal" data-bs-target="#riwayat${item.id}">
                                <i class="fas fa-info"></i> Keterangan Diagnosa</button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapuspoli${item.id}">
                                <i class="fas fa-trash"></i> Hapus</button>
                        </td>
                    `;
                        tableBody.appendChild(row);
                    });
                }
            }

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
                } else if (filterByFullDate && filterByFullDate.checked) {
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
                fetch('/rekapan/diagnosa/cetak', {
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
                        newWindow.document.write(html);
                        newWindow.document.close();
                        newWindow.print();
                    })
                    .catch(error => {
                        console.error('Terjadi kesalahan saat mencetak:', error);
                    });
            }
        });
    </script>
@endpush
