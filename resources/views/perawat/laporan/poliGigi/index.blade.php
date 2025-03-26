@extends('layout.ngarep')
@section('title', 'Perawat | Laporan Kunjungan Pasien')
@section('kontent')

<div class="breadcrumbs d-flex align-items-center" style="background-image: url('{{ asset('assetss/img/profil.jpg') }}');">
</div>

<div class="container-xxl flex-grow-1 container-p-y mt-4">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="pasien-bpjs">
                    <div class="title">
                        <h5>Poli Umum / <strong>Laporan Kunjungan Pasien BPJS</strong></h5>
                    </div>
                    <div class="card" style="width: 40%; margin-bottom: 20px">
                        <div class="card-body">
                            <h5>Filter Pencarian</h5>
                            <div class="form-check mb-2" style="display: flex; align-items: baseline">
                                <input class="form-check-input" type="radio" name="filter_option" id="filter_by_full_date">
                                <input type="date" name="tanggal" id="tanggal" class="form-control" style="width: 45%; margin-left: 20px">
                            </div>
                            <div class="form-check mb-2" style="display: flex; align-items: baseline">
                                <input class="form-check-input" type="radio" name="filter_option" id="filter_by_month_year">
                                <div class="month_year" style="display: flex; margin-left: 20px">
                                    <select name="month" id="month" class="form-control" style="width: 62%">
                                        <!-- Opsi bulan akan ditambahkan secara dinamis oleh JavaScript -->
                                    </select>
                                    <select name="tahun" id="tahun" class="form-control" style="width: 40%; margin-left: 5px">
                                        <!-- Opsi tahun akan ditambahkan secara dinamis oleh JavaScript -->
                                    </select>
                                </div>
                            </div>
                            <p style="font-size: 14px; margin-bottom: 0px"><span style="color: red">* </span>Pilih salah satu atau cetak semua data tanpa memilih</p>
                            <div class="button" style="display: flex; align-items: baseline">
                                <button type="button" id="btnSearch" class="btn btn-primary mt-3"><i class="fas fa-search"></i> Cari</button>
                                <button type="button" id="btnCetak" class="btn btn-warning mt-3" style="margin-left: 10px"><i class="fas fa-print"></i> Cetak</button>
                                <div class="dropdown" style="margin-left: 130px">
                                    <button class="btn btn-secondary dropdown-toggle" style="margin-top: -3px" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa-solid fa-file-excel"></i>
                                        Export
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ url('/pasien-bpjs/export-excel') }}">Export to Excel</a>
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
                                <table id="example" class="table mt-2 mb-2 table-striped table-bordered" style="width:100%">
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
                                    {{-- <tbody>
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
                                                    $statusPasien = ($pasienCounts[$pasienId] > 1) ? 'Lama' : 'Baru';
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
                                                    <td>Td : {{ $item->p_tensi }} mmHg, <br> N : {{ $item->p_nadi }} x/m, <br> R : {{ $item->p_rr }} x/m, <br> S : {{ $item->p_suhu }} C, <br> SpO2 : {{ $item->spo2 }} %, <br> BB : {{ $item->p_bb }} kg, <br> TB : {{ $item->p_tb }} cm</td>
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
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapuspoli{{ $item->id }}">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody> --}}
                                </table>                                
                            </div>
                       </div>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection