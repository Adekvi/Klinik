@extends('admin.layout.dasbrod')
@section('title', 'Rekap Kunjungan Harian')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-umum">
                    <div class="title">
                        <h5><strong>Rekap Kunjungan Harian</strong></h5>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="" class="d-flex justify-content-between align-items-center mb-3">
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
                                        placeholder="Cari Nama / NIK / No. Rm">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table id="example" class="table mt-2 mb-2 table-striped table-bordered"
                                    style="width:100%; white-space: nowrap">
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
                                            <th class="custom-th" colspan="2" style="text-align: center">DIAGNOSA (A) ICD
                                                X
                                            </th>
                                            <th class="custom-th" rowspan="24">TINDAKAN (P)</th>
                                            <th class="custom-th" rowspan="24">KETERANGAN</th>
                                            <th class="custom-th" rowspan="24">DOKTER JAGA</th>
                                            <th class="custom-th" rowspan="24">NIK</th>
                                            <th class="custom-th" rowspan="24">AKSI</th>
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
                                    <tbody>
                                        @if ($rekap->isEmpty())
                                            <tr>
                                                <td colspan="31" class="text-center">Belum ada data</td>
                                            </tr>
                                        @else
                                            @foreach ($rekap as $index => $item)
                                                @if ($item->status == 'M')
                                                    <tr>
                                                        <td>{{ $rekap->firstItem() + $index }}</td>
                                                        {{-- Tanggal --}}
                                                        <td>{{ date_format(date_create($item->booking->created_at), 'd/m/Y') }}
                                                        </td>
                                                        {{-- Jam Datang --}}
                                                        <td>{{ date_format(date_create($item->booking->created_at), 'H:i:s') }}
                                                        </td>
                                                        {{-- Lama Daftar --}}
                                                        <td>{{ date_format(date_create($item->booking->created_at), 'H:i:s') }}
                                                            - {{ date_format(date_create($item->booking->rm), 'H:i:s') }}
                                                        </td>
                                                        {{-- Jam Periksa --}}
                                                        <td></td>
                                                        <td>{{ $item->booking->pasien->no_rm }}</td>
                                                        <td>{{ $item->booking->pasien->nama_pasien }}</td>
                                                        <td>{{ $item->booking->pasien->nik }}</td>
                                                        <td>{{ $item->booking->pasien->jenis_pasien ?? '-' }}</td>
                                                        <td>{{ $item->booking->pasien->tgllahir }}</td>
                                                        <td>{{ $item->booking->pasien->no_hp ?? '-' }}</td>
                                                        <td>{{ $item->booking->pasien->pekerjaan }}</td>
                                                        <td>{{ $item->booking->pasien->nama_kk }}</td>
                                                        <td>{{ $item->booking->pasien->alamat_asal }}</td>
                                                        <td>{{ $item->rm->a_keluhan_utama }}</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primaty">Aksi</button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="halaman d-flex justify-content-end mt-3">
                                {{ $rekap->appends(request()->only(['search', 'entries']))->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
