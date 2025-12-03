<x-admin.layout.terminal title="Admin | Rekap Obat Keluar">

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="title">
                        <h5><strong>Obat Keluar</strong></h5>
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
                            <div class="button" style="display: flex; align-items: baseline">
                                <button type="button" id="btnSearch" class="btn btn-primary mt-3"><i
                                        class="fas fa-search"></i> Cari</button>
                                <button type="button" id="btnCetak" class="btn btn-warning mt-3"
                                    style="margin-left: 10px"><i class="fas fa-download"></i> Unduh</button>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Tanggal</th>
                                        <th>Nama Obat</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $all = []; @endphp
                                    @foreach ($obat as $item)
                                        @php
                                            $soapData = json_decode($item->resep, true);
                                            // Pastikan $soapData adalah array sebelum melakukan array_keys
                                            if (is_array($soapData)) {
                                                $all = array_merge($all, array_keys($soapData));
                                            }
                                        @endphp
                                    @endforeach
                                    @php $all = array_unique($all); @endphp
                                    @foreach ($obat as $item)
                                        @php
                                            $namaObat = json_decode($item->obat_Ro_namaObatUpdate, true) ?? [];
                                            $aturan = json_decode($item->obat_Ro_jumlah, true) ?? [];
                                        @endphp
                                        <tr>
                                            <td>{{ date_format(date_create($item->created_at), 'd-m-Y / H:i') }}</td>
                                            <td>
                                                @foreach ($namaObat as $key => $resep)
                                                    <ul>
                                                        <li>{{ $resep }}</li>
                                                    </ul>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($aturan as $jumlah)
                                                    <ul>
                                                        <li>{{ $jumlah }}</li>
                                                    </ul>
                                                @endforeach
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#hapuspoli{{ $item['id'] }}">
                                                    <i class="fas fa-trash"></i> Hapus</button>
                                            </td>
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

    {{-- TAMPIL MODAL RIWAYAT 2 --}}
    @foreach ($obat as $item)
        <div class="modal fade" id="riwayat{{ $item->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabelAsesmen{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" style="display: contents">
                <div class="modal-content" style="margin-top: 20px; width: 95%; margin-left: 3%;">
                    <div class="modal-header bg-primary">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Rincian Obat</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table" id="table1">
                                <thead class="table-primary" style="text-align: center;">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Obat</th>
                                        <th>Aturan Minum</th>
                                        <th>Anjuran Minum</th>
                                        <th>Jumlah</th>
                                        <th>Aturan Tambahan</th>
                                    </tr>
                                </thead>

                                <tbody style="text-align: center;">
                                    {{-- @php
                                $resep = json_decode($item->resep, true);
                                $resepP = array_values($resep);
                                $aturan = json_decode($item->aturan_minum, true);
                                $tatacara = array_values($aturan);
                                $jumlah = json_decode($item->jumlah, true);
                                $total = array_values($jumlah);
                            @endphp
                            <tr>
                                <td>{{ date_format(date_create($item->created_at), 'Y-m-d / H:i:s') }}</td>
                                <td style="text-align: left">
                                    @foreach ($resepP as $res)
                                    <ul>
                                        <li>{{ $res }}</li>
                                    </ul>
                                    @endforeach
                                </td>
                                <td style="text-align: left">
                                    @foreach ($tatacara as $caratata)
                                    <ul>
                                        <li>{{ $caratata }}</li>
                                    </ul>
                                    @endforeach
                                </td>
                                <td style="text-align: left">
                                    @foreach ($jumlah as $jum)
                                    <ul>
                                        <li>{{ $jum }}</li>
                                    </ul>
                                    @endforeach
                                </td>
                                <td style="text-align: center">
                                    {{ $item->aturan_tambahan }}
                                </td>
                            </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @push('style')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
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
                    fetch('/search-obat', {
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

                    // Tambahkan baris-baris baru berdasarkan data
                    data.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${item.tanggal}</td>
                        <td>${item.no_rm}</td>
                        <td>${item.nama_pasien}</td>
                        <td>${item.jenis_pasien}</td>
                        <td>${item.nama_poli}</td>
                        <td>
                            <button type="button" class="btn btn-info mb-1"  data-bs-toggle="modal" data-bs-target="#riwayat${item.id}">
                                <i class="fas fa-info"></i> Keterangan Obat</button>
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
                    fetch('/cetak', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken // Sesuaikan dengan cara Anda mendapatkan token CSRF
                            },
                            body: JSON.stringify(searchData),
                        })
                        .then(response => response.blob())
                        .then(blob => {
                            const url = window.URL.createObjectURL(new Blob([blob]));
                            const link = document.createElement('a');
                            link.href = url;
                            link.setAttribute('download', 'Rekap Obat.pdf'); // Nama file untuk diunduh
                            document.body.appendChild(link);
                            link.click();
                            link.parentNode.removeChild(link);
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

</x-admin.layout.terminal>
