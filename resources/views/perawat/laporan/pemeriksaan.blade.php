<x-admin.layout.terminal title="Rekap Kunjungan Harian">

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-umum">
                    <div class="title">
                        <div class="judul d-flex justify-content-between align-items-center">
                            <h5><strong>
                                    Rekap Kunjungan Harian
                                </strong>
                            </h5>
                            <div class="date-time d-flex align-items-center gap-2 text-center">
                                <div class="tanggal text-muted" id="tanggal"></div>
                                <div class="jam text-muted" id="jam"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="judul">
                                    <h5 class="text-muted">
                                        <strong>
                                            Pilih Tanggal
                                        </strong>
                                    </h5>
                                </div>
                                <hr>
                                <div class="col-md-10">
                                    <div class="p-3">
                                        <h5 class="mb-3">Filter Rentang Tanggal</h5>
                                        <form method="GET" action="" class="row g-3 align-items-end">
                                            <div class="col-md-4">
                                                <label for="start_date">Tanggal Awal</label>
                                                <input type="date" name="start_date" id="start_date"
                                                    class="form-control" value="{{ request()->query('start_date') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="end_date">Tanggal Akhir</label>
                                                <input type="date" name="end_date" id="end_date"
                                                    class="form-control" value="{{ request()->query('end_date') }}">
                                            </div>
                                            <div class="col-md-4 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary"
                                                    style="margin-right: 10px">
                                                    <i class="fa fa-search me-1"></i> Tampilkan
                                                </button>
                                                <a href="{{ route('perawat.rekap.harian') }}"
                                                    class="btn btn-secondary ml-2">
                                                    <i class="fa-solid fa-arrow-rotate-right"></i> Reset
                                                </a>
                                            </div>
                                            <div class="button mb-3">
                                                <div class="dropdown">
                                                    <button class="btn btn-success dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa-solid fa-file-export"></i> Export
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item"
                                                            href="{{ route('perawat.laporan.export.excel', [
                                                                'start_date' => request()->query('start_date'),
                                                                'end_date' => request()->query('end_date'),
                                                            ]) }}">Export
                                                            to Excel</a>
                                                        {{-- <a class="dropdown-item"
                                                            href="{{ route('perawat.laporan.export.pdf', [
                                                                'start_date' => request()->query('start_date'),
                                                                'end_date' => request()->query('end_date'),
                                                            ]) }}">Export
                                                            to PDF</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('perawat.laporan.export.word', [
                                                                'start_date' => request()->query('start_date'),
                                                                'end_date' => request()->query('end_date'),
                                                            ]) }}">Export
                                                            to Word</a> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <h5 class="mb-3 text-muted">
                                <strong>
                                    Data Pasien
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
                                                <option value="10">10
                                                </option>
                                                <option value="25">25
                                                </option>
                                                <option value="50">50
                                                </option>
                                                <option value="100">100
                                                </option>
                                            </select>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <input type="text" name="search" value=""
                                                class="form-control form-control-sm me-2" style="width: 400px;"
                                                placeholder="Cari Nama Pasien / No. Rm">
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="table mt-2 mb-2 table-striped table-bordered"
                                    style="width:100%; white-space: nowrap;">
                                    <thead class="table-primary"
                                        style="align-items: center; text-align: center; vertical-align: middle;">
                                        <tr>
                                            <th class="custom-th" rowspan="24">NO.</th>
                                            <th class="custom-th" rowspan="24">TANGGAL</th>
                                            <th class="custom-th" rowspan="24">JAM DATANG</th>
                                            <th class="custom-th" rowspan="24">LAMA DAFTAR</th>
                                            <th class="custom-th" rowspan="24">JAM PERIKSA</th>
                                            <th class="custom-th" rowspan="24">LAMA PERIKSA</th>
                                            <th class="custom-th" rowspan="24">JAM SELESAI</th>
                                            <th class="custom-th" rowspan="24">NO. RM</th>
                                            <th class="custom-th" rowspan="24">NAMA PASIEN</th>
                                            <th class="custom-th" rowspan="24">JENIS PASIEN</th>
                                            <th class="custom-th" rowspan="24">TANGGAL LAHIR</th>
                                            <th class="custom-th" rowspan="24">NOMOR BPJS</th>
                                            <th class="custom-th" rowspan="24">JENIS PASIEN</th>
                                            <th class="custom-th" rowspan="24">HARGA</th>
                                            <th class="custom-th" rowspan="24">NOMOR NIK</th>
                                            <th class="custom-th" rowspan="24">NOMOR HP</th>
                                            <th class="custom-th" rowspan="24">PEKERJAAN</th>
                                            <th class="custom-th" rowspan="24">NAMA KK</th>
                                            <th class="custom-th" rowspan="24">ALAMAT</th>
                                            <th class="custom-th" rowspan="24">GDS</th>
                                            <th class="custom-th" rowspan="24">CHOLESTEROL</th>
                                            <th class="custom-th" rowspan="24">AU</th>
                                            <th class="custom-th" rowspan="24">HAMIL</th>
                                            <th class="custom-th" rowspan="24">KELUHAN (S)</th>
                                            <th class="custom-th" colspan="7" style="text-align: center">
                                                PEMERIKSAAN (O)
                                            </th>
                                            <th class="custom-th" colspan="2" style="text-align: center">DIAGNOSA
                                                (A)
                                                ICD
                                                X
                                            </th>
                                            <th class="custom-th" rowspan="24">TINDAKAN (P)</th>
                                            <th class="custom-th" rowspan="24">KETERANGAN</th>
                                            <th class="custom-th" rowspan="24">DOKTER JAGA</th>
                                            <th class="custom-th" rowspan="24">NIK</th>
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
                                        @if ($harian->isEmpty())
                                            <tr>
                                                <td colspan="38" class="text-center">Belum ada data</td>
                                            </tr>
                                        @else
                                            <?php
                                            // Fungsi untuk memformat harga ke dalam format Rupiah
                                            if (!function_exists('Rupiah')) {
                                                function Rupiah($angka)
                                                {
                                                    return '' . number_format($angka, 0, ',', '.');
                                                }
                                            }
                                            ?>
                                            @foreach ($harian as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}
                                                    </td>
                                                    <td>{{ $item->jam_datang }}</td>
                                                    <td>{{ $item->lama_daftar }}</td>
                                                    <td>{{ $item->jam_periksa }}</td>
                                                    <td>{{ $item->lama_periksa }}</td>
                                                    <td>{{ $item->jam_selesai }}</td>
                                                    <td>{{ $item->booking->pasien->no_rm ?? '-' }}</td>
                                                    <td>{{ $item->booking->pasien->nama_pasien ?? '-' }}</td>
                                                    <td>{{ $item->booking->pasien->status ?? '-' }}</td>
                                                    <td>{{ $item->booking->pasien->tgllahir ? \Carbon\Carbon::parse($item->booking->pasien->tgllahir)->format('d/m/Y') : '-' }}
                                                    </td>
                                                    <td>{{ $item->booking->pasien->bpjs ?? '-' }}</td>
                                                    <td>{{ $item->booking->pasien->jenis_pasien ?? '-' }}</td>
                                                    <td>Rp. {{ $item->harga_total }}</td>
                                                    <td>{{ $item->booking->pasien->nik ?? '-' }}</td>
                                                    <td>{{ $item->booking->pasien->noHP ?? '-' }}</td>
                                                    <td>{{ $item->booking->pasien->pekerjaan ?? '-' }}</td>
                                                    <td>{{ $item->booking->pasien->nama_kk ?? '-' }}</td>
                                                    <td>{{ $item->booking->pasien->alamat_asal ?? '-' }}</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>{{ $item->obat && $item->obat->soap ? $item->obat->soap->keluhan_utama : '-' }}
                                                    </td>
                                                    <td>{{ $item->obat && $item->obat->soap ? $item->obat->soap->p_tensi : '-' }}
                                                    </td>
                                                    <td>{{ $item->obat && $item->obat->soap ? $item->obat->soap->p_nadi : '-' }}
                                                    </td>
                                                    <td>{{ $item->obat && $item->obat->soap ? $item->obat->soap->p_rr : '-' }}
                                                    </td>
                                                    <td>{{ $item->obat && $item->obat->soap ? $item->obat->soap->p_suhu : '-' }}
                                                    </td>
                                                    <td>{{ $item->obat && $item->obat->soap ? $item->obat->soap->spo2 : '-' }}
                                                    </td>
                                                    <td>{{ $item->obat && $item->obat->soap ? $item->obat->soap->p_bb : '-' }}
                                                    </td>
                                                    <td>{{ $item->obat && $item->obat->soap ? $item->obat->soap->p_tb : '-' }}
                                                    </td>
                                                    <td>{{ $item->kd_diagno }}</td>
                                                    <td>{{ $item->nm_diagno }}</td>
                                                    <td>{{ $item->nama_obat }}</td>
                                                    <td>{{ $item->obat && $item->obat->soap ? $item->obat->soap->rujuk : '-' }}
                                                    </td>
                                                    <td>{{ $item->dokter->nama_dokter ?? '-' }}</td>
                                                    <td>{{ $item->dokter->nik ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center">
                                {{ $harian->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('style')
        <style>
            /* Alert */
            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    @endpush

    @push('script')
        <script>
            // jam dan tgl
            function updateClock() {
                var now = new Date();
                var tanggalElement =
                    document.getElementById('tanggal');
                var options = {
                    weekday: 'short',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                tanggalElement.innerHTML = '<h6>' + now.toLocaleDateString('id-ID', options) + '</h6>';

                var jamElement = document.getElementById('jam');
                var jamString = now.getHours().toString().padStart(2, '0') + ':' +
                    now.getMinutes().toString().padStart(2, '0') + ':' +
                    now.getSeconds().toString().padStart(2, '0');
                jamElement.innerHTML = '<h6>' + jamString + '</h6>';
            }
            setInterval(updateClock, 1000);
            updateClock();
        </script>
    @endpush

</x-admin.layout.terminal>
