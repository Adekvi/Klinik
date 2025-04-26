@extends('admin.layout.dasbrod')
@section('title', 'Admin | Data Tenaga Medis')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="datadokter">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Data Tenaga Medis</strong></h5>
                        <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#tambahdokter"><i class="bi bi-plus-lg"></i>Tambah Tenaga Medis</button>
                    </div>
                    <div class="table-responsive">
                        <div class="tb-umum">
                            <table class="table table-striped table-bordered" style="white-space: nowrap">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Poli</th>
                                        <th>Nik</th>
                                        <th>Nama Tenaga Medis</th>
                                        <th>Profesi</th>
                                        <th>Tarif Jasa</th>
                                        <th>Status Akun</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!function_exists('Rupiah')) {
                                        function Rupiah($angka)
                                        {
                                            return 'Rp ' . number_format($angka, 2, ',', '.');
                                        }
                                    }
                                    ?>
                                    @foreach ($dokter as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            @if (!empty($item->poli->namapoli))
                                                <td>{{ $item->poli->namapoli }}</td>
                                            @else
                                                <td style="text-align: center"> - </td>
                                            @endif
                                            @if (!empty($item->nik))
                                                <td>{{ $item->nik }}</td>
                                            @else
                                                <td style="text-align: center"> - </td>
                                            @endif
                                            <td>{{ $item->nama_dokter }}</td>
                                            <td>{{ $item->profesi }}</td>
                                            @if (!empty($item->tarif))
                                                <td>{{ Rupiah($item->tarif) }}</td>
                                            @else
                                                <td style="text-align: center"> - </td>
                                            @endif
                                            <td>
                                                <form method="POST" action="{{ url('updateStatus-dokter') }}">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                                    <div class="piket">
                                                        <input type="checkbox" name="status"
                                                            id="status_{{ $item->id }}" onchange="this.form.submit()"
                                                            @if ($item->status) checked @endif>
                                                        <label for="status_{{ $item->id }}" class="button"></label>

                                                        <!-- Status text berada di bawah tombol toggle -->
                                                        <div class="status-text">
                                                            <span
                                                                id="statusText">{{ $item->status ? 'Aktif' : 'Non-Aktif' }}</span>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="aksi d-flex">
                                                    <button class="btn btn-primary"
                                                        data-bs-target="#editdokter{{ $item->id }}"
                                                        data-bs-toggle="modal"><i class="fas fa-info"></i> Edit</button>
                                                    <button type="button" class="btn btn-danger mx-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#hapusdokter{{ $item->id }}"><i
                                                            class="fas fa-trash"></i> Hapus</button>
                                                </div>
                                            </td>
                                            @include('admin.master.datadokter.modaledit')
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
    @include('admin.master.datadokter.modaltambah')
    @include('admin.master.datadokter.modaledit')
    @include('admin.master.datadokter.modalhapus')
@endsection
@push('style')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">
    <style>
        /* Menyusun elemen dengan flexbox secara vertikal */
        .piket {
            display: flex;
            flex-direction: column;
            /* Menyusun elemen secara vertikal */
            align-items: center;
            /* Menyusun elemen di tengah secara horizontal */
        }

        /* Tampilan tombol */
        .button {
            width: 55px;
            height: 25px;
            background-color: #d2d2d2;
            border-radius: 200px;
            cursor: pointer;
            position: relative;
        }

        .button::before {
            position: absolute;
            content: "";
            width: 15px;
            height: 15px;
            background-color: #fff;
            border-radius: 200px;
            margin: 5px;
            transition: 0.2s;
        }

        input:checked+.button {
            background-color: blue;
        }

        input:checked+.button::before {
            transform: translateX(30px);
        }

        /* Menyembunyikan input checkbox */
        input {
            display: none;
        }

        /* Status text berada di bawah tombol */
        .status-text {
            margin-top: 10px;
            /* Memberikan jarak antara tombol dan status text */
            font-weight: bold;
            color: #333;
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

        // Validasi Nik
        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');
            const nikError = document.getElementById('nik-error');

            nikInput.addEventListener('input', function() {
                const nik = nikInput.value;

                // Validasi panjang NIK dan memastikan hanya angka
                if (nik.length === 16 && /^\d+$/.test(nik)) {
                    nikInput.classList.remove('is-invalid');
                    nikError.style.display = 'none';
                } else {
                    nikInput.classList.add('is-invalid');
                    nikError.style.display = 'block';
                }
            });
        });
    </script>
@endpush
