@extends('admin.layout.dasbrod')
@section('title', 'Admin | Poli Umum')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y mt-4">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="pasien-umum">
                <div class="title">
                    <h5>Poli Umum / <strong>Pasien Umum</strong></h5>
                </div>
                <div class="tb-umum">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tanggal Kunjungan</th>
                                <th>No. RM</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Lahir</th>
                                <th>Dokter</th>
                                <th>Keluhan</th>
                                <th>Aksi</th>
                                {{-- <th>Dokter Periksa</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($booking as $item)
                            @if ($item['pasien']['jenis_pasien'] == 'Umum')
                            <tr>
                                <td>{{date_format(date_create($item['created_at']), 'H:i:s/Y-m-d')
                                }}</td>
                                <td>{{ $item['pasien']['no_rm'] }}</td>
                                <td>{{ $item['pasien']['nama_pasien'] }}</td>
                                <td>{{ $item['pasien']['tgllahir'] }}</td>
                                <td>{{ $item['dokter']['nama_dokter'] }}</td>
                                <td>{{ $item['keluhan_utama'] }}</td>
                                <td>
                                    <button type="button" class="btn btn-info mb-1" data-bs-toggle="modal" data-bs-target="#riwayat{{ $item['id'] }}">
                                        <i class="fas fa-info"></i> Riwayat</button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapuspoli{{ $item['id'] }}">
                                        <i class="fas fa-trash"></i> Hapus</button>
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


{{-- TAMPIL MODAL RIWAYAT 2 --}}
@php
$allSoapPatients = [];
@endphp
@if (!empty($booking))
@foreach ($booking as $item)
    @php
        $soapData = json_decode($item['soap_p'], true);
        $allSoapPatients = array_merge($allSoapPatients, array_keys($soapData));
    @endphp
@endforeach
@endif

@php
$allSoapPatients = array_unique($allSoapPatients);
// dd($allSoapPatients);
@endphp
@if (!empty($booking))
@foreach ($booking as $assmen)
    <div class="modal fade" id="riwayat{{ $assmen->id }}" tabindex="-1" aria-labelledby="exampleModalLabelAsesmen{{ $assmen->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" style="display: contents">
        <div class="modal-content" style="margin-top: 20px; width: 95%; margin-left: 3%;">
            <div class="modal-header bg-primary">
            <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Detail Asesmen Tanggal : 20-04-2024</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead class="table-primary" style="text-align: center;">
                            <tr>
                                <th>TGL DAN JAM</th>
                                <th>PROFESI</th>
                                <th>ASESMEN</th>
                                <th>EDUKASI</th>
                            </tr>
                        </thead>

                        <tbody style="text-align: center;">
                                    <tr>
                                        <td>{{ date_format(date_create($assmen['created_at']), 'Y-m-d/H:i:s') }}</td>
                                        <td>{{ $assmen['nama_dokter'] }}</td>
                                        <td style="text-align: left">
                                            <table class="table">
                                                <thead>
                                                    <tr style="text-align: center; font-weight: bold">
                                                        <td>S</td>
                                                        <td>O</td>
                                                        <td>A</td>
                                                        <td>P</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $assmen['keluhan_utama'] }} </td>
                                                        <td>
                                                            <ul>
                                                                <li>Tensi : {{ $assmen['p_tensi'] }} / mmHg</li>
                                                                <li>RR : {{ $assmen['p_rr'] }} / minute</li>
                                                                <li>Nadi : {{ $assmen['p_nadi'] }} / minute</li>
                                                                <li>Suhu : {{ $assmen['p_suhu'] }} °c</li>
                                                                <li>TB : {{ $assmen['p_tb'] }} / cm</li>
                                                                <li>BB : {{ $assmen['p_bb'] }} / kg</li>
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            @php
                                                            $diagnosaPrimer = json_decode($assmen['soap_a_primer'], true);
                                                            $diagnosaPrimer = array_values($diagnosaPrimer); // menghapus kunci asosiatif
                                                            $diagnosaSekunder = json_decode($assmen['soap_a_sekunder'], true);
                                                            $diagnosaSekunder = array_values($diagnosaSekunder); // menghapus kunci asosiatif
                                                            // dd($diagnosaPrimer);
                                                            @endphp
                                                            @foreach ($diagnosaPrimer as $diag)
                                                                <ul>
                                                                    <li>{{ $diag }}</li>
                                                                </ul>
                                                            @endforeach
                                                            @foreach ($diagnosaSekunder as $diagn)
                                                                <ul>
                                                                    <li>{{ $diagn }}</li>
                                                                </ul>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                        <p style="font-weight: bold; margin-bottom: -0px">Resep :</p>
                                                        @foreach ($allSoapPatients as $patientName)
                                                        @if (isset(json_decode($assmen['soap_p'], true)[$patientName]))
                                                        - {{ $patientName }} <br>
                                                            @endif
                                                        @endforeach

                                                        <p style="font-weight: bold; margin-bottom: -0px">Keterangan :</p>
                                                        @foreach ($allSoapPatients as $patientName)
                                                            @if (isset(json_decode($assmen['soap_p'], true)[$patientName]))
                                                                - {{ json_decode($assmen['soap_p'], true)[$patientName] }} <br>
                                                            @endif
                                                        @endforeach
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </td>
                                        <td>{{ $assmen['edukasi'] }}</td>
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
@endif


{{-- Modal Hapus --}}
@foreach ($booking as $item)
    <div class="modal fade" id="hapuspoli{{ $item['id']}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pasienbaru" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white">Hapus Poli</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('admin/hapus/gigi-bpjs/'. $item['id'] ) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <h5 class="mt-2 mb-3">Apakah Anda ingin menghapus data ini?</h5>
                            <button type="submit" class="btn btn-danger ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Hapus</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@endsection
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
</script>
@endpush
