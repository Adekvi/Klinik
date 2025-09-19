@extends('admin.layout.dasbrod')
@section('title', 'Apoteker | Master Data Obat')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y mt-4">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 class="text-muted mb-3">
                            <strong>@yield('title')</strong>
                        </h5>
                        <h5 style="margin-bottom: 20px"><strong>Uploud Data Obat</strong></h5>
                        <form action="{{ route('resep.import') }}" method="POST" enctype="multipart/form-data"
                            id="uploadForm">
                            @csrf
                            <div class="d-flex align-items-end">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Upload File Excel</label>
                                        <p style="font-size: 15px; font-style: italic; color: red">
                                            *Silahkan masukkan data obat terbaru dengan format xlsx, xls, csv. <br>
                                            *Silahkan donwload file excelnya untuk menyesuaikan format kolomnya! <br>
                                        </p>
                                        <input type="file" name="file" id="file" class="form-control" required>
                                    </div>
                                </div>
                                <div class="ms-2">
                                    <button type="submit" class="btn btn-primary" id="uploadButton">
                                        <i class="fa-solid fa-upload"></i> Upload</button>
                                    <a href="{{ route('resep.downloadTemplate') }}" class="btn btn-success ms-2">
                                        <i class="fa-solid fa-file-excel"></i> Download Format Excel
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- Animasi Loading -->
                        <div id="loading" class="mt-3 text-primary d-none">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Mengunggah...</span>
                            </div>
                            <span class="ms-2">Mengunggah file, mohon tunggu...</span>
                        </div>

                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="d-flex justify-content-between align-items-center">
                                <strong>Data Obat baru diunggah</strong>
                                <span class="text-muted" style="font-size: 17px">
                                    <i class="fa-solid fa-circle-info text-success"></i> {{ $uploadStatus }}</span>
                            </h5>
                            <hr>

                            @if ($obatUploud->count() > 0)
                                <form method="GET" action="{{ route('apoteker.master.obat') }}"
                                    class="d-flex justify-content-between align-items-center mb-3">
                                    <input type="hidden" name="recent_page" value="1"> {{-- Reset ke halaman 1 saat pencarian --}}
                                    <div class="d-flex align-items-center">
                                        <label for="entries" class="me-2">Tampilkan:</label>
                                        <select name="entries" id="entries" class="form-select form-select-sm me-3"
                                            style="width: 80px;" onchange="this.form.submit()">
                                            <option value="10" {{ request('entries', 10) == 10 ? 'selected' : '' }}>10
                                            </option>
                                            <option value="25" {{ request('entries', 10) == 25 ? 'selected' : '' }}>25
                                            </option>
                                            <option value="50" {{ request('entries', 10) == 50 ? 'selected' : '' }}>50
                                            </option>
                                            <option value="100" {{ request('entries', 10) == 100 ? 'selected' : '' }}>100
                                            </option>
                                        </select>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            class="form-control form-control-sm me-2" style="width: 400px;"
                                            placeholder="Cari Obat">
                                        <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                                    </div>
                                </form>

                                <div class="table-responsive mb-2">
                                    <table id="example" class="table table-striped table-bordered"
                                        style="width:100%; margin-top: 10px;">
                                        <thead class="table-primary" style="text-align: center; white-space: nowrap">
                                            <tr>
                                                <th>NO</th>
                                                <th>GOLONGAN</th>
                                                <th>JENIS SEDIAAN</th>
                                                <th>NAMA OBAT</th>
                                                <th>HARGA BELI</th>
                                                <th>HARGA JUAL</th>
                                                <th>OBAT MASUK</th>
                                                <th>OBAT KELUAR</th>
                                                <th>RETUR</th>
                                                <th>JUMLAH STOK</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                            if (!function_exists('Rupiah')) {
                                                function Rupiah($angka)
                                                {
                                                    return 'Rp ' . number_format($angka, 0, ',', '.');
                                                }
                                            }
                                            ?>
                                            @foreach ($obatUploud as $index => $record)
                                                <tr>
                                                    <td>{{ $obatUploud->firstItem() + $index }}</td>
                                                    <td>{{ !empty($record->golongan) ? $record->golongan : '-' }}</td>
                                                    <td>{{ !empty($record->jenis_sediaan) ? $record->jenis_sediaan : '-' }}
                                                    </td>
                                                    <td>{{ !empty($record->nama_obat) ? $record->nama_obat : '-' }}</td>
                                                    <td>{{ !empty(Rupiah($record->harga_pokok)) ? Rupiah($record->harga_pokok) : '-' }}
                                                    </td>
                                                    <td>{{ !empty(Rupiah($record->harga_jual)) ? Rupiah($record->harga_jual) : '-' }}
                                                    </td>
                                                    <td>{{ !empty($record->stok_awal) ? $record->stok_awal : '-' }}</td>
                                                    <td>{{ !empty($record->masuk) ? $record->masuk : '-' }}</td>
                                                    <td>{{ !empty($record->keluar) ? $record->noHP : '-' }}</td>
                                                    <td>{{ !empty($record->stok) ? $record->stok : '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="page d-flex justify-content-end">
                                    {{ $obatUploud->appends(request()->only(['search', 'entries']))->links() }}
                                </div>
                            @else
                                {{-- Pesan jika tidak ada data dalam 24 jam terakhir --}}
                                <div class="alert alert-warning mt-3 text-center">
                                    <h5 class="mt-3 mb-3">
                                        <strong>
                                            <i class="fa-solid fa-bell"></i> Belum ada data obat yang diunggah dalam 24 jam
                                            terakhir.
                                        </strong>
                                    </h5>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr>
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h5>
                                    <strong>Data Semua Obat</strong>
                                </h5>
                                <hr>
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
                                                <th>GOLONGAN</th>
                                                <th>JENIS SEDIAAN</th>
                                                <th>NAMA OBAT</th>
                                                <th>HARGA BELI</th>
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
        </div>
    </div>

    @include('obat.master.tambah')
    @include('obat.master.edit')
    @include('obat.master.hapus')
    {{-- @include('obat.master.infoStok') --}}

@endsection

@push('style')
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

        document.getElementById('uploadForm').addEventListener('submit', function() {
            // Nonaktifkan tombol upload agar tidak diklik berulang
            document.getElementById('uploadButton').disabled = true;

            // Tampilkan animasi loading
            document.getElementById('loading').classList.remove('d-none');
        });

        // Simulasi notifikasi sukses setelah upload (Opsional)
        setTimeout(() => {
            document.getElementById('loading').classList.add('d-none');
            document.getElementById('notifSuccess').classList.remove('d-none');
        }, 5000); // Simulasi 5 detik setelah upload dimulai
    </script>
@endpush
