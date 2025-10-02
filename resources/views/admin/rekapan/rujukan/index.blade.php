@extends('admin.layout.dasbrod')
@section('title', 'Admin | Laporan Kunjungan KB')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="title">
                        <h5><strong>Laporan Rujukan ke Rumah sakit ( FKTRL)</strong></h5>
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
                                <table id="example" class="table mt-2 mb-2 table-striped table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="custom-th">No.</th>
                                            <th class="custom-th">No. Kunjungan</th>
                                            <th class="custom-th">Tanggal Pelayanan</th>
                                            <th class="custom-th">Tanggal Entri</th>
                                            <th class="custom-th">No. Kartu</th>
                                            <th class="custom-th">Nama Peserta</th>
                                            <th class="custom-th">Jenis Kelamin</th>
                                            <th class="custom-th">Diagnosa</th>
                                            <th class="custom-th">Dirujuk</th>
                                            <th class="custom-th">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @php $all = []; @endphp
                                        @foreach ($rujukan as $item)
                                            @php
                                                $soapData = json_decode($item->soap_p, true);
                                                $all = array_merge($all, array_keys($soapData));
                                            @endphp
                                        @endforeach
                                        @php $all = array_unique($all); @endphp

                                        @php
                                            $pasienCounts = [];
                                        @endphp

                                        @foreach ($rujukan as $item)
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
                                        @php
                                            $counter = 1;
                                        @endphp
                                        @if ($rujukan->count() > 0)
                                            @foreach ($rujukan as $item)
                                                <tr>
                                                    <td>{{ $counter++ }}</td>
                                                    <td>{{ $item->no_rm }}</td>
                                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                                    <td>{{ $item->pasien->nomor_bpjs ?? '-' }}</td>
                                                    <td>{{ $item->pasien->nama_pasien ?? '-' }}</td>
                                                    <td>{{ $item->pasien->jenis_kelamin ?? '-' }}</td>
                                                    <td>
                                                        @php
                                                            $soapData = json_decode($item->soap_p, true);
                                                            $diagnosa = isset($soapData['Diagnosa'])
                                                                ? $soapData['Diagnosa']
                                                                : '-';
                                                        @endphp
                                                        {{ $diagnosa }}
                                                    </td>
                                                    <td style="text-align: center;">
                                                        {{ $item->rujuk_rumahsakit ?? ' - ' }}
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                            data-bs-target="#hapuspoli{{ $item->id }}">
                                                            <i class="fas fa-trash"></i> Hapus</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10" class="text-center">Belum Ada Data</td>
                                            </tr>
                                        @endif
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
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalInput = document.getElementById('tanggal');
            const monthSelect = document.getElementById('month');
            const tahunSelect = document.getElementById('tahun');
            const filterByFullDate = document.getElementById('filter_by_full_date');
            const filterByMonthYear = document.getElementById('filter_by_month_year');
            const btnSearch = document.getElementById('btnSearch');
            const btnCetak = document.getElementById('btnCetak');

            // Tambahkan event listener untuk radio button 'Tanggal'
            filterByFullDate.addEventListener('change', function() {
                if (this.checked) {
                    tanggalInput.disabled = false;
                    monthSelect.disabled = true;
                    tahunSelect.disabled = true;
                }
            });

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
                fetch('/rekapan/rujukan/search', {
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
                // Panggil fungsi cetak tabel saat tombol cetak diklik
                cetakHasilFilter();
            });

            function updateTable(data) {
                const tableBody = document.querySelector('#example tbody');
                // Kosongkan tabel
                tableBody.innerHTML = '';

                // Periksa apakah data kosong atau null
                if (!data || data.length === 0) {
                    // Tambahkan pesan bahwa data tidak ada
                    const row = document.createElement('tr');
                    row.innerHTML = '<td colspan="20" style="text-align: center">Data tidak ada</td>';
                    tableBody.appendChild(row);
                    return; // Keluar dari fungsi setelah menambahkan pesan
                }
                // Jika ada data, tambahkan baris-baris baru berdasarkan data
                var no = 1;
                data.forEach(item => {
                    if (!item) return;

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${no++}</td>
                        <td>${item.tanggal}</td>
                        <td>${item.jam}</td>
                        <td>${item.no_rm}</td>
                        <td>${item.nama_pasien}</td>
                        <td>${item.jenis_pasien}</td>
                        <td>${item.tgllahir}</td>
                        <td>${item.nomor_bpjs}</td>
                        <td>${item.nik}</td>
                        <td>${item.noHP}</td>
                        <td>${item.pekerjaan}</td>
                        <td>${item.nama_kk}</td>
                        <td>${item.alamat_asal}</td>
                        <td>${item.keluhan_utama}</td>
                        <td>
                        Td : ${item.p_tensi} mmHg, <br>
                            N : ${item.p_nadi} x/m, <br>
                            R : ${item.p_rr} x/m, <br>
                            S : ${item.p_suhu} C, <br>
                            SpO2 :${item.spo2} %<br>
                            BB : ${item.p_bb} kg, <br>
                            TB : ${item.p_tb} cm, <br>
                        </td>
                        <td>
                            ${item.soap_a_primer}
                        </td>
                        <td>
                            ${item.soap_p}
                        </td>
                        <td style="text-align: center;">
                            ${item.rujuk ?? ' - '}
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger"  data-bs-toggle="modal" data-bs-target="#hapuspoli${item.id}">
                                <i class="fas fa-trash"></i> Hapus</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

            }


            function cetakHasilFilter() {
                // Data filter yang akan dikirim
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
                    // Jika tidak ada filter yang dipilih, kirim permintaan pencetakan tanpa data filter
                    searchData = {
                        type: 'no_filter'
                    };
                }
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                // Kirim data filter ke route pencetakan menggunakan AJAX
                fetch('/rekapan/rujukan/cetak', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken // Sesuaikan dengan cara Anda mendapatkan token CSRF
                        },
                        body: JSON.stringify(searchData),
                    })
                    .then(response => response.text())
                    .then(html => {
                        // Membuka jendela baru dan menuliskan HTML ke dalamnya untuk pencetakan
                        const newWindow = window.open('', '_blank');
                        newWindow.document.write(html);
                        newWindow.document.close();
                        newWindow.print(); // Melakukan pencetakan pada jendela baru
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
