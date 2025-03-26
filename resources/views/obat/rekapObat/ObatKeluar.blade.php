@extends('admin.layout.dasbrod')
@section('title', 'Apoteker | Rekap Obat Keluar')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="title text-start">
                <h4><strong>@yield('title')</strong></h4>
            </div>
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
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
                                    {{-- controler StokObat --}}
                                    @php $all = []; @endphp
                                    @foreach ($obat as $item)
                                        @php
                                            $soapData = json_decode($item->resep, true);
                                            // Pastikan $soapData adalah array sebelum melakukan array_keys
                                            if (is_array($soapData)) {
                                                $all = array_merge($all, array_keys($soapData));
                                            }
                                            // dd($soapData);
                                        @endphp
                                    @endforeach
                                    @php $all = array_unique($all); @endphp
                                    @foreach ($obat as $item)
                                        @php
                                            $namaObat = json_decode($item->obat_Ro_namaObatUpdate, true) ?? [];
                                            $aturan = json_decode($item->obat_Ro_jumlah, true) ?? [];
                                            // dd($obat);
                                        @endphp
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d-m-Y / H:i') }}
                                            </td>
                                            {{-- <td>{{ date_format(date_create($item->created_at), 'd-m-Y / H:i:s') }}</td> --}}
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
        <div class="modal fade" id="riwayat{{ $item['id'] }}" tabindex="-1"
            aria-labelledby="exampleModalLabelAsesmen{{ $item['id'] }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" style="display: contents">
                <div class="modal-content" style="margin-top: 20px; width: 95%; margin-left: 3%;">
                    <div class="modal-header bg-primary">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Rincian Obat Keluar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container" style="margin-top: -10px">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <h2><strong>{{ $item->booking->pasien->nama_pasien }}</strong></h2>
                                    <hr style="margin-top: -5px">
                                    <p style="font-size: 14px; margin-top: -5px">
                                        <strong>Sengonbugel RT.01/01, Mayong, Jepara</strong>
                                    </p>
                                    <hr style="margin-top: -5px">
                                    <p style="margin-top: -5px">
                                        <strong>
                                            {{ $item->booking->pasien->alamat_asal }},
                                            {{ $item->booking->pasien->tgllahir }}
                                            ({{ \Carbon\Carbon::parse($item->booking->pasien->tgllahir)->age }} Tahun)
                                        </strong>
                                    </p>
                                    <hr style="margin-top: -5px">
                                </div>
                                <div class="col-md-4">
                                    <div class="info-container">
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Tinggi Badan</label>
                                            <span>:</span>
                                            <p>{{ $item->soap->p_tb }} Cm</p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Berat Badan</label>
                                            <span>:</span>
                                            <p>{{ $item->soap->p_bb }} Kg</p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Jenis Kelamin</label>
                                            <span>:</span>
                                            <p>
                                                @if ($item->booking->pasien->jekel === 'P' ?? 'Perempuan')
                                                    Perempuan
                                                @elseif($item->booking->pasien->jekel === 'L' ?? 'Laki-laki')
                                                    Laki-laki
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" style="margin-top: -20px">
                                    <div class="info-container">
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Jenis Pasien</label>
                                            <span>:</span>
                                            <p>{{ $item->booking->pasien->jenis_pasien }}</p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">Poli</label>
                                            <span>:</span>
                                            <p>{{ $item->soap->poli->namapoli }}</p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">No NIK</label>
                                            <span>:</span>
                                            <p>{{ $item->booking->pasien->nik }}</p>
                                        </div>
                                        <div class="info-item">
                                            <label style="min-width: 100px;">No BPJS</label>
                                            <span>:</span>
                                            <p>
                                                @if (!empty($item->pasien->booking->bpjs))
                                                    {{ $item->pasien->booking->bpjs }}
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="table1">
                                <thead class="table-primary" style="text-align: center;">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Obat</th>
                                        <th>Aturan Minum</th>
                                        <th>Anjuran Minum</th>
                                        <th>Jenis Obat</th>
                                        <th>Jumlah</th>
                                        <th>Aturan Tambahan</th>
                                    </tr>
                                </thead>

                                <tbody style="text-align: center;">
                                    @php
                                        $jenengObat = json_decode($item->obat_Ro_namaObatUpdate, true) ?? [];
                                        $aturanNgombe = json_decode($item->obat_Ro_aturan, true) ?? [];
                                        $anjuranNgombe = json_decode($item->obat_Ro_anjuran, true) ?? [];
                                        $jenisNgombe = json_decode($item->obat_Ro_jenisObat, true) ?? [];
                                        $jumlahNgombe = json_decode($item->obat_Ro_jumlah, true) ?? [];
                                    @endphp
                                    <tr>
                                        <td>{{ date_format(date_create($item->created_at), 'Y-m-d / H:i:s') }}</td>
                                        <td style="text-align: left">
                                            @foreach ($jenengObat as $jeneng)
                                                <ul>
                                                    <li>{{ $jeneng }}</li>
                                                </ul>
                                            @endforeach
                                        </td>
                                        <td style="text-align: left">
                                            @foreach ($aturanNgombe as $tata)
                                                <ul>
                                                    <li>{{ $tata }}</li>
                                                </ul>
                                            @endforeach
                                        </td>
                                        <td style="text-align: left">
                                            @foreach ($anjuranNgombe as $anjur)
                                                <ul>
                                                    <li>{{ $anjur }}</li>
                                                </ul>
                                            @endforeach
                                        </td>
                                        <td style="text-align: left">
                                            @foreach ($jenisNgombe as $jenis)
                                                <ul>
                                                    <li>{{ $jenis }}</li>
                                                </ul>
                                            @endforeach
                                        </td>
                                        <td style="text-align: left">
                                            @foreach ($jumlahNgombe as $jmlh)
                                                <ul>
                                                    <li>{{ $jmlh }}</li>
                                                </ul>
                                            @endforeach
                                        </td>
                                        <td style="text-align: center">
                                            {{ $item->aturan_tambahan ?? '-' }}
                                        </td>
                                    </tr>
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

@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">

    <style>
        .info-container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 40px;
            gap: 1rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: 50px;
            flex: 1 1 200px;
            /* Adjust the flex-basis if needed */
        }

        .info-item label {
            font-weight: bold;
            margin-right: 0.5rem;
        }

        .info-item p {
            margin: 0;
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
                fetch('apoteker-cari-obatKeluar', {
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
