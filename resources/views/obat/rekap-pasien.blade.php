<x-admin.layout.terminal title="Apoteker | Data Pasien">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">

            <div class="col-md-12">
                <div class="card-title">
                    <h4 class="mt-4"><strong>Rekap Pasien Telah Diperiksa</strong></h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('apoteker.pasien-dapat-obat') }}" class="row g-3 mb-3">
                            <div class="col-md-3">
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="end_date" class="form-control"
                                    value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-3 d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fa fa-search"></i> Cari
                                </button>
                                <a href="{{ route('apoteker.pasien-dapat-obat') }}" class="btn btn-secondary w-100">
                                    <i class="fa fa-refresh"></i> Reset
                                </a>
                            </div>
                        </form>

                        <hr>
                        <form method="GET" action=""
                            class="d-flex justify-content-between align-items-center mb-3">
                            <input type="hidden" name="page" value="1"> {{-- Reset ke halaman 1 saat pencarian --}}
                            <div class="d-flex align-items-center">
                                <label for="entries" class="me-2">Tampilkan:</label>
                                <select name="entries" id="entries" class="form-select form-select-sm me-3"
                                    style="width: 80px;" onchange="this.form.submit()">
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
                                    placeholder="Cari Nama / No. Rm">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                            </div>
                        </form>
                        <div class="isian" style="overflow-x: scroll">
                            <table class="table table-striped table-bordered text-center"
                                style="white-space: nowrap; width: auto">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>No. RM</th>
                                        <th>NIK</th>
                                        <th>Nama Pasien</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Umur</th>
                                        <th>Poli</th>
                                        <th>Dokter</th>
                                        <th>Alamat Domisili</th>
                                        <th>Jenis Pasien</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center" style="text-transform: uppercase">
                                    @if (count($pasienObat) === 0)
                                        <tr>
                                            <td colspan="12" style="text-align: center">Tidak Ada Data Pasien</td>
                                        </tr>
                                    @else
                                        <?php $no = 1; ?>
                                        @foreach ($pasienObat as $item)
                                            @if ($item->status == 'S')
                                                <tr id="row_{{ $item->id }}">
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ date_format(date_create($item['created_at']), 'd-m-Y') }}
                                                    </td>
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
                                                        <button type="button" class="btn btn-success mb-1"
                                                            data-toggle="tooltip" data-bs-placement="top"
                                                            title="Success">
                                                            <i class="fa-solid fa-circle-check"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="pagination mt-3 d-flex justify-content-end">
                                {{ $pasienObat->appends(request()->input())->onEachSide(1)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    @endpush

</x-admin.layout.terminal>
