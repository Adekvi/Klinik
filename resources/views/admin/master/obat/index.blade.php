@extends('admin.layout.dasbrod')
@section('title', 'Admin | Data Obat')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Data Obat</strong></h5>
                        <div class="mb-1" style="display: flex; justify-content: space-between">
                            <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#tambahobat"><i class="bi bi-plus-lg"></i> Tambah Obat</button>
                        </div>
                    </div>

                    <div class="page d-flex" style="justify-content: space-between">
                        <form method="GET" action="{{ route('master.obat') }}"
                            class="d-flex justify-content-between align-items-center mb-3">
                            <input type="hidden" name="page" value="1"> {{-- Reset ke halaman 1 saat pencarian --}}
                            <div class="d-flex align-items-center">
                                <label for="entries" class="me-2">Tampilkan:</label>
                                <select name="entries" id="entries" class="form-select form-select-sm me-3"
                                    style="width: 80px;" onchange="this.form.submit()">
                                    <option value="10" {{ request('entries', 10) == 10 ? 'selected' : '' }}>10
                                    </option>
                                    <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25
                                    </option>
                                    <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50
                                    </option>
                                    <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100
                                    </option>
                                </select>
                            </div>
                        </form>

                        <div class="cari mb-2">
                            <input type="text" name="search" id="search" class="form-control" placeholder="Cari..."
                                style="width: 100%">
                        </div>
                    </div>

                    <div class="tb-umum">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-primary text-center" style="white-space: nowrap">
                                <tr>
                                    <th>NO</th>
                                    <th>NAMA OBAT</th>
                                    <th>HARGA POKOK</th>
                                    <th>HARGA JUAL</th>
                                    <th>MASUK</th>
                                    <th>KELUAR</th>
                                    <th>RETUR</th>
                                    <th>STOK OBAT</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="obat-table">
                                @include('admin.master.obat.table', ['obat' => $obat])
                            </tbody>
                        </table>
                        <div class="halaman d-flex justify-content-end">
                            {{ $obat->appends(['entries' => $entries])->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.master.obat.modaltambah')
    @include('admin.master.obat.modaledit')
    @include('admin.master.obat.modalhapus')
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">

    <style>
        #stok_warning {
            background-color: #ffe5e5;
            border: 1px solid red;
            padding: 10px;
            border-radius: 5px;
        }

        .tooltip-icon {
            position: relative;
            cursor: pointer;
        }

        .tooltip-icon:hover::after {
            content: 'Stok berada di bawah 50! Segera tambahkan stok.';
            position: absolute;
            background-color: #f8d7da;
            color: #721c24;
            padding: 5px;
            border-radius: 5px;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
            font-size: 12px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }

        .swal2-container {
            z-index: 9999 !important;
        }
    </style>
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // new DataTable('#example');
        $(document).ready(function() {
            $('#search').on('input', function() {
                var query = $(this).val();
                $.ajax({
                    url: "{{ route('obat.search') }}",
                    method: "GET",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#obat-table').html(data);
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            @if ($lowStockObat->isNotEmpty())
                Swal.fire({
                    title: 'Peringatan Stok Rendah!',
                    html: `
                    <div style="text-align: left;">
                        <strong>*Obat dengan stok di bawah 50 :</strong>
                        <ul style="list-style: none; padding: 0; margin-top: 10px">
                            @foreach ($lowStockObat as $item)
                                <li style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                    <label style="flex: 1; word-wrap: break-word; margin-right: 10px;">{{ $item->nama_obat }}</label>
                                    <span style="min-width: 50px; text-align: right;">:</span>
                                    <strong style="min-width: 100px; text-align: right;">{{ $item->stok }}</strong>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                `,
                    icon: 'warning',
                    confirmButtonText: 'Tutup',
                    customClass: {
                        popup: 'swal-wide'
                    }
                });
            @endif
        });
    </script>
@endpush
