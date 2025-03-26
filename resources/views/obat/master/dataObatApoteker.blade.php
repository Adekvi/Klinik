@extends('admin.layout.dasbrod')
@section('title', 'Apoteker | Master Data Obat')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h3 style="margin-bottom: 20px; justify-content: center; display: flex">
                            <strong>@yield('title')</strong>
                        </h3>
                        <div class="mb-1" style="display: flex; justify-content: space-between">
                            <div class="tambah">
                                <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                                    data-bs-target="#tambahobat"><i class="fas fa-plus"></i> Tambah Obat</button>
                            </div>
                            <div class="cari" style="display: flex; align-items: center; gap: 5px;">
                                <input type="text" name="search" id="search" class="form-control"
                                    placeholder="Cari..." style="width: 200px;">
                                <button type="button" class="btn btn-primary">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="tb-umum">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead class="table-primary text-center" style="white-space: nowrap">
                                    <tr>
                                        <th>NO</th>
                                        <th>NAMA OBAT</th>
                                        <th>HARGA POKOK</th>
                                        <th>HARGA JUAL</th>
                                        <th>OBAT MASUK</th>
                                        <th>OBAT KELUAR</th>
                                        <th>RETUR</th>
                                        <th>JUMLAH STOK</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody id="obat-table">
                                    @include('obat.master.table', ['obat' => $obat])
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="pagination d-flex justify-content-end mt-2">
                        {{ $obat->appends(request()->input())->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('obat.master.tambah')
    @include('obat.master.edit')
    @include('obat.master.hapus')
    @include('obat.master.infoStok')

@endsection

@push('style')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">

    <style>
        /* Alert */
        .swal2-container {
            z-index: 9999 !important;
        }

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
                    url: "{{ route('apoteker.obat.cari') }}",
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
