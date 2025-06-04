@extends('admin.layout.dasbrod')
@section('title', 'Admin | Laporan Kunjungan ANC')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="title">
                        <h5><strong>Laporan Kunjungan ANC</strong></h5>
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
                            <p style="font-size: 14px; margin-bottom: 0px"><span style="color: red">* </span>Pilih
                                salah satu atau cetak semua data tanpa memilih</p>
                            <div class="button" style="display: flex; align-items: baseline">
                                <button type="button" id="btnSearch" class="btn btn-primary mt-3"><i
                                        class="fas fa-search"></i> Cari</button>
                                <button type="button" id="btnCetak" class="btn btn-warning mt-3"
                                    style="margin-left: 10px"><i class="fas fa-print"></i> Cetak</button>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle"
                                        style="margin-top: -3px; margin-left: 10px" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa-solid fa-file-excel"></i>
                                        Export
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Export to Excel</a>
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
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                NO.</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                NO. REG</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                TANGGAL</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                NAMA BUMIL</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                UMUR</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                NAMA SUAMI</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                ALAMAT</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                KELUHAN</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                G P A</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                UK</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                TM</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                HPHT</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                HPL</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                TD</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                LILA</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                TB</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                BB</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                STATUS GIZI</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                REFLEK PATELA</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                DJJ</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                KEPALA (M/BM)</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                TBJ</th>
                                            <th class="custom-th" rowspan="24"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                PRESENTASI</th>
                                            <th class="custom-th" colspan="10" style="text-align: center">PEMERIKSAAN
                                                LABORAT</th>
                                            <th class="custom-th" rowspan="3"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                KONSELING</th>
                                            <th class="custom-th" rowspan="3"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                NO. HP</th>
                                            <th class="custom-th" rowspan="3"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                KETERANGAN</th>
                                            <th class="custom-th" rowspan="3"
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                AKSI</th>
                                        </tr>
                                        <tr>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                HB</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                HBSAG</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                GOLDA</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                GDS</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                VCT</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                SIFILIS</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                PU</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                INJEKSI TT</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                CATAT BUKU KIA</th>
                                            <th
                                                style="text-align: center; vertical-align: middle; white-space: nowrap; width: auto">
                                                FE (TAB)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>-</td>
                                        </tr>
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

            // Toggle input berdasarkan pilihan filter
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

            // Fungsi pencarian
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
                fetch('/rekapan/anc/search', {
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

            // Fungsi untuk mencetak hasil filter
            btnCetak.addEventListener('click', function() {
                cetakHasilFilter();
            });

            // Fungsi update tabel dengan data baru
            function updateTable(data) {
                const tableBody = document.querySelector('#example tbody');
                tableBody.innerHTML = ''; // Kosongkan tabel

                if (data.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = '<td colspan="19" style="text-align: center">Data tidak ada</td>';
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
                            <i class="fas fa-info"></i> Keterangan Penyakit</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapuspoli${item.id}">
                            <i class="fas fa-trash"></i> Hapus</button>
                    </td>
                `;
                        tableBody.appendChild(row);
                    });
                }
            }

            // Fungsi untuk pencetakan hasil filter
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
                fetch('/rekapan/anc/cetak', {
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
